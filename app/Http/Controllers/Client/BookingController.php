<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\Room;
use App\Models\RoomDayStatus;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function listData(Request $request)
    {
        $q = Booking::query()->with(['bookingRooms.room']);

        if ($request->filled('status')) {
            $q->where('status', $request->get('status'));
        }

        if ($request->filled('kw')) {
            $kw = trim($request->get('kw'));
            $q->where(function ($qq) use ($kw) {
                $qq->where('code', 'like', "%{$kw}%")
                   ->orWhere('customer_name', 'like', "%{$kw}%")
                   ->orWhere('phone', 'like', "%{$kw}%");
            });
        }

        $listData = $q->orderByDesc('id')->paginate(20);

        $rooms = Room::query()->orderBy('id','desc')->get();

        return view('client.booking.bookings.index', compact('listData','rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'  => ['required','string','max:255'],
            'phone'          => ['required','string','max:30'],
            'email'          => ['nullable','email','max:255'],
            'check_in_date'  => ['required','date'],
            'check_out_date' => ['required','date'],
            'adults'         => ['nullable','integer','min:1','max:20'],
            'children'       => ['nullable','integer','min:0','max:20'],
            'room_ids'       => ['required','array','min:1'],
            'room_ids.*'     => ['integer'],
            'note'           => ['nullable','string'],
            'status'         => ['nullable','in:pending,confirmed'],
        ]);

        $checkIn  = Carbon::parse($data['check_in_date'])->startOfDay();
        $checkOut = Carbon::parse($data['check_out_date'])->startOfDay();

        if ($checkOut->lte($checkIn)) {
            return back()->with('error', 'Check-out phải sau check-in.');
        }

        $roomIds = array_values(array_unique($data['room_ids']));
        $nightsDates = $this->nightDates($checkIn, $checkOut);

        // đảm bảo lịch có row (nếu thiếu thì tạo open) => tránh lỗi “chưa seed”
        $this->ensureCalendarRows($roomIds, $nightsDates);

        // kiểm tra trống
        $notAvailable = $this->findNotAvailableRooms($roomIds, $nightsDates);
        if (!empty($notAvailable)) {
            return back()->with('error', 'Có phòng không trống trong khoảng ngày đã chọn: ' . implode(', ', $notAvailable));
        }

        $status = $data['status'] ?? 'pending';

        $booking = null;

        DB::transaction(function () use (&$booking, $data, $roomIds, $status) {
            $code = 'BK' . now()->format('Ymd') . strtoupper(Str::random(6));

            $booking = Booking::create([
                'code'          => $code,
                'customer_name' => $data['customer_name'],
                'phone'         => $data['phone'],
                'email'         => $data['email'] ?? null,
                'check_in_date' => $data['check_in_date'],
                'check_out_date'=> $data['check_out_date'],
                'adults'        => $data['adults'] ?? 1,
                'children'      => $data['children'] ?? 0,
                'status'        => 'pending',
                'payment_status'=> 'unpaid',
                'note'          => $data['note'] ?? null,
            ]);

            foreach ($roomIds as $rid) {
                BookingRoom::create([
                    'booking_id' => $booking->id,
                    'room_id'    => $rid,
                ]);
            }

            // nếu admin tạo và confirm luôn
            if ($status === 'confirmed') {
                // confirm bên ngoài transaction này cũng được,
                // nhưng mình confirm ngay tại đây cho “atomic”.
                // (gọi method confirm logic nội bộ)
            }
        });

        if ($status === 'confirmed') {
            // gọi confirm thật sự (transaction + lock)
            return $this->confirm($request, $booking->id);
        }

        return back()->with('success', 'Đã tạo booking ' . $booking->code . ' (Pending).');
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::with(['bookingRooms'])->findOrFail($id);

        $data = $request->validate([
            'customer_name'  => ['required','string','max:255'],
            'phone'          => ['required','string','max:30'],
            'email'          => ['nullable','email','max:255'],
            'adults'         => ['nullable','integer','min:1','max:20'],
            'children'       => ['nullable','integer','min:0','max:20'],
            'payment_status' => ['nullable','in:unpaid,partial,paid,refunded'],
            'note'           => ['nullable','string'],
            'status'         => ['nullable','in:pending,confirmed,checked_in,checked_out,cancelled,no_show'],
        ]);

        // tránh sửa bừa status: confirm/cancel có route riêng để xử lý lịch
        if (isset($data['status']) && in_array($data['status'], ['confirmed','cancelled'], true)) {
            unset($data['status']);
        }

        $booking->update([
            'customer_name'  => $data['customer_name'],
            'phone'          => $data['phone'],
            'email'          => $data['email'] ?? null,
            'adults'         => $data['adults'] ?? $booking->adults,
            'children'       => $data['children'] ?? $booking->children,
            'payment_status' => $data['payment_status'] ?? $booking->payment_status,
            'note'           => $data['note'] ?? null,
        ]);

        // status khác (checked_in/out/no_show) cho phép update nhanh
        if ($request->filled('status') && in_array($request->get('status'), ['checked_in','checked_out','no_show'], true)) {
            $booking->status = $request->get('status');
            $booking->save();
        }

        return back()->with('success', 'Đã cập nhật booking ' . $booking->code);
    }

    public function confirm(Request $request, $id)
    {
        $booking = Booking::with(['bookingRooms.room'])->findOrFail($id);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking không ở trạng thái Pending để confirm.');
        }

        $checkIn  = Carbon::parse($booking->check_in_date)->startOfDay();
        $checkOut = Carbon::parse($booking->check_out_date)->startOfDay();
        if ($checkOut->lte($checkIn)) return back()->with('error', 'Ngày không hợp lệ.');

        $dates = [];
        $period = CarbonPeriod::create($checkIn, '1 day', $checkOut->copy()->subDay());
        foreach ($period as $d) $dates[] = $d->toDateString();

        try {
            DB::transaction(function () use ($booking, $dates) {

                // lock inventory rows theo từng room type trong booking
                foreach ($booking->bookingRooms as $br) {
                    $roomId = (int)$br->room_id;
                    $qty    = max(1, (int)($br->qty ?? 1));

                    // đảm bảo row tồn tại (nếu user chưa seed)
                    $rowsToInsert = [];
                    foreach ($dates as $date) {
                        $exists = RoomDayStatus::query()
                            ->where('room_id', $roomId)
                            ->where('date', $date)
                            ->exists();

                        if (!$exists) {
                            $total = (int)($br->room->number_rooms ?? 0);
                            $rowsToInsert[] = [
                                'room_id'    => $roomId,
                                'date'       => $date,
                                'status'     => 'open',
                                'price'      => null,
                                'total_qty'  => $total,
                                'hold_qty'   => 0,
                                'booked_qty' => 0,
                                'booking_id' => null,
                                'note'       => null,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }
                    if (!empty($rowsToInsert)) {
                        DB::table('room_day_statuses')->insertOrIgnore($rowsToInsert);
                    }

                    // lock rows
                    $rows = RoomDayStatus::query()
                        ->where('room_id', $roomId)
                        ->whereIn('date', $dates)
                        ->lockForUpdate()
                        ->get()
                        ->keyBy(fn($x) => $x->date->toDateString());

                    // kiểm tra còn trống từng ngày
                    foreach ($dates as $date) {
                        $row = $rows->get($date);
                        if (!$row) throw new \RuntimeException("Thiếu lịch ngày {$date}");

                        if ($row->status !== 'open') {
                            throw new \RuntimeException("Ngày {$date} không mở bán (status={$row->status})");
                        }

                        $remain = (int)$row->total_qty - (int)$row->booked_qty - (int)$row->hold_qty;
                        if ($remain < $qty) {
                            throw new \RuntimeException("Ngày {$date} không đủ phòng. Còn {$remain}, cần {$qty}");
                        }
                    }

                    // update booked_qty
                    RoomDayStatus::query()
                        ->where('room_id', $roomId)
                        ->whereIn('date', $dates)
                        ->update([
                            'booked_qty' => DB::raw("booked_qty + {$qty}"),
                            'updated_at' => now(),
                        ]);
                }

                $booking->status = 'confirmed';
                $booking->save();
            });

            return back()->with('success', 'Đã CONFIRM booking ' . $booking->code);

        } catch (\Throwable $e) {
            return back()->with('error', 'Không thể confirm: ' . $e->getMessage());
        }
    }

    public function cancel(Request $request, $id)
    {
        $booking = Booking::with(['bookingRooms.room'])->findOrFail($id);

        if (!in_array($booking->status, ['pending','confirmed'], true)) {
            return back()->with('error', 'Chỉ hủy được booking Pending/Confirmed.');
        }

        $checkIn  = Carbon::parse($booking->check_in_date)->startOfDay();
        $checkOut = Carbon::parse($booking->check_out_date)->startOfDay();
        if ($checkOut->lte($checkIn)) return back()->with('error', 'Ngày không hợp lệ.');

        $dates = [];
        $period = CarbonPeriod::create($checkIn, '1 day', $checkOut->copy()->subDay());
        foreach ($period as $d) $dates[] = $d->toDateString();

        DB::transaction(function () use ($booking, $dates) {

            if ($booking->status === 'confirmed') {
                foreach ($booking->bookingRooms as $br) {
                    $roomId = (int)$br->room_id;
                    $qty    = max(1, (int)($br->qty ?? 1));

                    // lock rows
                    $rows = RoomDayStatus::query()
                        ->where('room_id', $roomId)
                        ->whereIn('date', $dates)
                        ->lockForUpdate()
                        ->get();

                    // giảm booked_qty nhưng không âm
                    RoomDayStatus::query()
                        ->where('room_id', $roomId)
                        ->whereIn('date', $dates)
                        ->update([
                            'booked_qty' => DB::raw("GREATEST(booked_qty - {$qty}, 0)"),
                            'updated_at' => now(),
                        ]);
                }
            }

            $booking->status = 'cancelled';
            $booking->save();
        });

        return back()->with('success', 'Đã HỦY booking ' . $booking->code);
    }

    public function delete($id)
    {
        $booking = Booking::findOrFail($id);

        if (!in_array($booking->status, ['pending','cancelled'], true)) {
            return back()->with('error', 'Chỉ xóa booking Pending/Cancelled.');
        }

        $booking->delete();

        return back()->with('success', 'Đã xóa booking.');
    }

    // ===== Helpers =====

    private function nightDates(Carbon $checkIn, Carbon $checkOut): array
    {
        $end = $checkOut->copy()->subDay();
        $dates = [];

        $period = CarbonPeriod::create($checkIn, '1 day', $end);
        foreach ($period as $d) {
            $dates[] = $d->toDateString();
        }
        return $dates;
    }

    private function ensureCalendarRows(array $roomIds, array $dates): void
    {
        $rows = [];
        foreach ($roomIds as $rid) {
            foreach ($dates as $d) {
                $rows[] = [
                    'room_id'    => $rid,
                    'date'       => $d,
                    'status'     => 'open',
                    'price'      => null,
                    'booking_id' => null,
                    'note'       => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        DB::table('room_day_statuses')->insertOrIgnore($rows);
    }

    private function findNotAvailableRooms(array $roomIds, array $dates): array
    {
        $bad = [];

        foreach ($roomIds as $rid) {
            $cntOpen = RoomDayStatus::query()
                ->where('room_id', $rid)
                ->whereIn('date', $dates)
                ->where('status', 'open')
                ->count();

            if ($cntOpen !== count($dates)) {
                $roomName = Room::query()->where('id', $rid)->value('name') ?? ('Room#'.$rid);
                $bad[] = $roomName;
            }
        }

        return $bad;
    }
    
}
