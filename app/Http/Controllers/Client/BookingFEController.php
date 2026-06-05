<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room; // đổi đúng model phòng của bạn nếu tên khác
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingFEController extends Controller
{
    /**
     * API kiểm tra phòng trống:
     * - JS sẽ gọi: /api/bookings/check?room_id=...&check_in=YYYY-MM-DD&check_out=YYYY-MM-DD&qty=...
     * - Trả về JSON { ok: true/false, message: "...", available: n }
     */
    public function check(Request $request)
    {
        // 1) Validate dữ liệu query
        $data = $request->validate([
            'room_id'   => ['required', 'integer'],
            'check_in'  => ['required', 'date_format:Y-m-d'],
            'check_out' => ['required', 'date_format:Y-m-d', 'after:check_in'],
            'qty'       => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $roomId  = (int)$data['room_id'];
        $qtyNeed = (int)$data['qty'];

        // 2) Parse ngày chuẩn (tránh lỗi format)
        $checkIn  = Carbon::createFromFormat('Y-m-d', $data['check_in'])->startOfDay();
        $checkOut = Carbon::createFromFormat('Y-m-d', $data['check_out'])->startOfDay();

        // 3) Lấy số lượng phòng tổng (number_rooms) từ bảng rooms
        //    Nếu field của bạn tên khác, đổi lại ở đây.
        $room = Room::find($roomId);
        if (!$room) {
            return response()->json([
                'ok' => false,
                'message' => 'Không tìm thấy phòng.',
                'available' => 0,
            ], 200);
        }

        $totalRooms = (int)($room->number_rooms ?? 0);

        // 4) Tính số phòng đã được đặt trong khoảng thời gian overlap
        //    Overlap rule: booking.check_in_date < request.check_out AND booking.check_out_date > request.check_in
        //    Status tính vào: pending/confirmed (loại cancelled/rejected nếu có)
        $bookedQty = $this->sumBookedQty($roomId, $checkIn->toDateString(), $checkOut->toDateString());

        $available = max(0, $totalRooms - $bookedQty);

        if ($available >= $qtyNeed) {
            return response()->json([
                'ok' => true,
                'available' => $available,
                'message' => "✅ Còn trống {$available} phòng. Bạn có thể đặt {$qtyNeed} phòng trong khoảng ngày đã chọn.",
            ], 200);
        }

        return response()->json([
            'ok' => false,
            'available' => $available,
            'message' => "❌ Không đủ phòng trống. Hiện chỉ còn {$available} phòng trong khoảng ngày đã chọn.",
        ], 200);
    }

    /**
     * Lưu booking:
     * - Validate
     * - Check phòng trống lại lần nữa (để tránh trường hợp 2 người đặt cùng lúc)
     * - Lưu vào bookings (và nếu có bảng booking_rooms thì insert chi tiết)
     */
    public function store(Request $request)
    {
        // 1) Validate form submit
        $data = $request->validate([
            'room_id'       => ['required', 'integer'],
            'check_in_date' => ['required', 'date_format:Y-m-d'],
            'check_out_date'=> ['required', 'date_format:Y-m-d', 'after:check_in_date'],
            'qty'           => ['required', 'integer', 'min:1', 'max:10'],

            'customer_name' => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:30'],
            'email'         => ['nullable', 'email', 'max:255'],
            'adults'        => ['required', 'integer', 'min:1', 'max:10'],
            'children'      => ['nullable', 'integer', 'min:0', 'max:10'],
            'note'          => ['nullable', 'string'],
        ]);

        $roomId  = (int)$data['room_id'];
        $qtyNeed = (int)$data['qty'];

        // 2) Parse ngày chuẩn
        $checkIn  = Carbon::createFromFormat('Y-m-d', $data['check_in_date'])->startOfDay();
        $checkOut = Carbon::createFromFormat('Y-m-d', $data['check_out_date'])->startOfDay();

        // 3) Check phòng tồn tại
        $room = Room::find($roomId);
        if (!$room) {
            return back()->withErrors(['room_id' => 'Không tìm thấy phòng.'])->withInput();
        }

        // 4) Check phòng trống lại lần nữa (server-side)
        $totalRooms = (int)($room->number_rooms ?? 0);
        $bookedQty  = $this->sumBookedQty($roomId, $checkIn->toDateString(), $checkOut->toDateString());
        $available  = max(0, $totalRooms - $bookedQty);

        if ($available < $qtyNeed) {
            return back()
                ->withErrors(['qty' => "Không đủ phòng trống. Hiện chỉ còn {$available} phòng trong khoảng ngày đã chọn."])
                ->withInput();
        }

        // 5) Tạo code booking
        $code = 'BK-' . now()->format('ymd') . '-' . strtoupper(Str::random(5));

        // 6) Lưu booking
        DB::beginTransaction();
        try {
            $booking = new Booking();
            $booking->code = $code;
            $booking->customer_name = $data['customer_name'];
            $booking->phone = $data['phone'];
            $booking->email = $data['email'] ?? null;

            $booking->check_in_date = $checkIn->toDateString();
            $booking->check_out_date = $checkOut->toDateString();
            $booking->adults = (int)$data['adults'];
            $booking->children = (int)($data['children'] ?? 0);

            $booking->status = 'pending';
            $booking->payment_status = 'unpaid';
            $booking->deposit_amount = 0;
            $booking->total_amount = 0;
            $booking->paid_amount = 0;

            // Nếu bảng bookings của bạn có cột room_id/qty thì fill luôn.
            // Nếu không có thì mình nhét vào note để admin vẫn thấy (không mất dữ liệu).
            $note = (string)($data['note'] ?? '');

            if (Schema::hasColumn('bookings', 'room_id')) {
                $booking->room_id = $roomId;
            } else {
                $note = "[room_id={$roomId}] " . $note;
            }

            if (Schema::hasColumn('bookings', 'qty')) {
                $booking->qty = $qtyNeed;
            } else {
                $note = "[qty={$qtyNeed}] " . $note;
            }

            $booking->note = trim($note) ?: null;

            $booking->save();

            // Nếu bạn có bảng booking_rooms (chi tiết phòng theo booking) thì insert để admin quản lý chuẩn
            // booking_rooms: id, booking_id, room_id, qty, created_at, updated_at
            if (Schema::hasTable('booking_rooms')) {
                DB::table('booking_rooms')->insert([
                    'booking_id' => $booking->id,
                    'room_id'    => $roomId,
                    'qty'        => $qtyNeed,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return back()->with('success', '✅ Đã gửi yêu cầu đặt phòng. Chúng tôi sẽ liên hệ xác nhận sớm nhất!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['system' => 'Lỗi hệ thống khi tạo booking: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Tính tổng số phòng đã bị booking trong khoảng thời gian overlap.
     * Ưu tiên:
     *  - Nếu bookings có room_id + qty => sum qty theo bookings
     *  - Nếu có booking_rooms => join và sum qty
     *  - Fallback: nếu không có qty => mỗi booking tính 1
     */
    private function sumBookedQty(int $roomId, string $checkIn, string $checkOut): int
    {
        // overlap: check_in_date < $checkOut AND check_out_date > $checkIn
        $statusCount = ['pending', 'confirmed']; // bạn có status khác thì add thêm

        // Case 1: bookings có room_id
        if (Schema::hasColumn('bookings', 'room_id')) {
            $q = Booking::query()
                ->where('room_id', $roomId)
                ->whereIn('status', $statusCount)
                ->whereDate('check_in_date', '<', $checkOut)
                ->whereDate('check_out_date', '>', $checkIn);

            // Nếu có cột qty thì sum qty, không có thì mỗi record = 1
            if (Schema::hasColumn('bookings', 'qty')) {
                return (int)$q->sum('qty');
            }

            return (int)$q->count();
        }

        // Case 2: có booking_rooms
        if (Schema::hasTable('booking_rooms')) {
            $sum = DB::table('booking_rooms')
                ->join('bookings', 'bookings.id', '=', 'booking_rooms.booking_id')
                ->where('booking_rooms.room_id', $roomId)
                ->whereIn('bookings.status', $statusCount)
                ->whereDate('bookings.check_in_date', '<', $checkOut)
                ->whereDate('bookings.check_out_date', '>', $checkIn)
                ->sum('booking_rooms.qty');

            return (int)$sum;
        }

        // Case 3: không có dữ liệu để sum theo phòng => an toàn trả 0 (để không block user)
        return 0;
    }
}
