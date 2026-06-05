<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class BookingClientFEController extends Controller
{
    /**
     * API check tồn phòng theo khoảng ngày (AJAX).
     * Trả về ok=true nếu tất cả ngày trong [check_in, check_out) đều còn đủ qty.
     */
    public function checkAvailability(Request $request)
    {
        $data = $request->validate([
            'room_id'   => ['required', 'integer', 'exists:rooms,id'],
            'check_in'  => ['required', 'date_format:Y-m-d'],
            'check_out' => ['required', 'date_format:Y-m-d', 'after:check_in'],
            'qty'       => ['required', 'integer', 'min:1', 'max:50'],
        ]);

        $roomId   = (int) $data['room_id'];
        $checkIn  = Carbon::createFromFormat('Y-m-d', $data['check_in'])->startOfDay();
        $checkOut = Carbon::createFromFormat('Y-m-d', $data['check_out'])->startOfDay();
        $qty      = (int) $data['qty'];

        $minRemain = null;
        $badDays = [];

        // duyệt từng ngày trong khoảng [check_in, check_out)
        $cursor = $checkIn->copy();
        while ($cursor->lt($checkOut)) {
            $date = $cursor->format('Y-m-d');

            $remain = $this->remainForDate($roomId, $date);
            $minRemain = is_null($minRemain) ? $remain : min($minRemain, $remain);

            if ($remain < $qty) {
                $badDays[] = $date;
            }

            $cursor->addDay();
        }

        if (!empty($badDays)) {
            return response()->json([
                'ok' => false,
                'message' => 'Một số ngày không đủ phòng: ' . implode(', ', array_slice($badDays, 0, 8)) . (count($badDays) > 8 ? '...' : ''),
                'min_remain' => $minRemain ?? 0,
            ], 200);
        }

        return response()->json([
            'ok' => true,
            'message' => '✅ Khoảng ngày đã chọn còn đủ phòng.',
            'min_remain' => $minRemain ?? 0,
        ], 200);
    }

    /**
     * Nhận form đặt phòng từ trang chi tiết phòng.
     * - Validate dữ liệu
     * - Check tồn phòng theo từng ngày
     * - Tạo booking status=pending để admin xử lý
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'       => ['required', 'integer', 'exists:rooms,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:30'],
            'email'         => ['nullable', 'email', 'max:255'],

            'check_in_date'  => ['required', 'date_format:Y-m-d'],
            'check_out_date' => ['required', 'date_format:Y-m-d', 'after:check_in_date'],

            'qty'      => ['required', 'integer', 'min:1', 'max:50'],
            'adults'   => ['nullable', 'integer', 'min:0', 'max:20'],
            'children' => ['nullable', 'integer', 'min:0', 'max:20'],
            'note'     => ['nullable', 'string'],
        ]);

        $roomId   = (int) $data['room_id'];
        $checkIn  = Carbon::createFromFormat('Y-m-d', $data['check_in_date'])->startOfDay();
        $checkOut = Carbon::createFromFormat('Y-m-d', $data['check_out_date'])->startOfDay();
        $qty      = (int) $data['qty'];

        return DB::transaction(function () use ($data, $roomId, $checkIn, $checkOut, $qty) {

            // 1) Re-check tồn phòng để tránh overbook
            $badDays = [];
            $cursor = $checkIn->copy();
            while ($cursor->lt($checkOut)) {
                $date = $cursor->format('Y-m-d');
                $remain = $this->remainForDate($roomId, $date);

                if ($remain < $qty) {
                    $badDays[] = $date;
                }
                $cursor->addDay();
            }

            if (!empty($badDays)) {
                throw ValidationException::withMessages([
                    'check_in_date' => 'Không đủ phòng trong các ngày: ' . implode(', ', array_slice($badDays, 0, 8)) . (count($badDays) > 8 ? '...' : ''),
                ]);
            }

            // 2) Tạo mã booking (đơn giản, dễ tra)
            $code = $this->generateCode();

            // 3) Tạo booking
            // NOTE: booking của bạn có các cột theo ảnh. Mình thêm room_id + qty qua migration bên dưới.
            $booking = Booking::create([
                'code'          => $code,
                'customer_name' => $data['customer_name'],
                'phone'         => $data['phone'],
                'email'         => $data['email'] ?? null,

                'check_in_date'  => $checkIn->format('Y-m-d'),
                'check_out_date' => $checkOut->format('Y-m-d'),

                'adults'   => (int)($data['adults'] ?? 0),
                'children' => (int)($data['children'] ?? 0),

                'status'         => 'pending', // admin sẽ confirm/cancel
                'payment_status' => 'unpaid',

                'deposit_amount' => 0,
                'total_amount'   => 0,
                'paid_amount'    => 0,

                'note' => $data['note'] ?? null,

                // NEW
                'room_id' => $roomId,
                'qty'     => $qty,
            ]);

            // 4) Redirect sang trang success
            return redirect()->route('client.bookings.success', $booking->code);
        });
    }

    /**
     * Trang success tối thiểu.
     */
    public function success(string $code)
    {
        $booking = Booking::where('code', $code)->firstOrFail();
        return view('client.bookings.success', compact('booking'));
    }

    /**
     * Tính remain theo 1 ngày:
     * remain = total_for_day - sum(qty) của booking pending+confirmed đang overlap ngày đó
     *
     * total_for_day:
     * - nếu có bảng cấu hình theo ngày (room_daily_stocks) thì lấy total + status
     * - nếu không có thì lấy rooms.number_rooms làm mặc định
     */
    private function remainForDate(int $roomId, string $dateYmd): int
    {
        $room = Room::findOrFail($roomId);

        // total mặc định từ bảng rooms
        $total = (int) ($room->number_rooms ?? 0);
        $status = 'open';

        // Nếu bạn đã có bảng cấu hình theo ngày rồi (tên khác), bạn map lại tại đây.
        // Mình demo 1 bảng tên room_daily_stocks: room_id, date, total_rooms, status(open/closed)
        if (Schema::hasTable('room_daily_stocks')) {
            $row = DB::table('room_daily_stocks')
                ->where('room_id', $roomId)
                ->where('date', $dateYmd)
                ->first();

            if ($row) {
                $total  = (int) ($row->total_rooms ?? $total);
                $status = (string) ($row->status ?? 'open');
            }
        }

        if ($status !== 'open') {
            return 0; // đóng bán ngày này
        }

        // sum qty booking overlap date
        // overlap rule: check_in <= date < check_out
        $blocked = Booking::query()
            ->where('room_id', $roomId)
            ->whereIn('status', ['pending', 'confirmed']) // pending cũng chặn để tránh overbook
            ->whereDate('check_in_date', '<=', $dateYmd)
            ->whereDate('check_out_date', '>', $dateYmd)
            ->sum('qty');

        $remain = $total - (int)$blocked;
        return max(0, $remain);
    }

    private function generateCode(): string
    {
        // BK240115-XXXX
        $prefix = 'BK' . now()->format('ymd') . '-';
        $rand = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        return $prefix . $rand;
    }
}
