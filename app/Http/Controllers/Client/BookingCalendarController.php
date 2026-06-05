<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomDayStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingCalendarController extends Controller
{
    public function listData(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = now()->format('Y-m');
        }

        $rooms = Room::query()->orderByDesc('id')->get();
        $roomId = $request->get('room_id');

        if (!$roomId && $rooms->count() > 0) {
            $roomId = $rooms->first()->id;
        }

        $first = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $startGrid = $first->copy()->startOfWeek(Carbon::MONDAY);
        $endGrid   = $first->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $items = collect();
        if ($roomId) {
            $q = RoomDayStatus::query()
                ->with('booking')
                ->where('room_id', $roomId)
                ->whereBetween('date', [$startGrid->toDateString(), $endGrid->toDateString()]);

            if ($request->filled('status')) {
                $q->where('status', $request->get('status'));
            }

            $items = $q->get()->keyBy(function ($x) {
                return $x->date->toDateString();
            });
        }

        $roomSelected = $rooms->firstWhere('id', (int)$roomId);

        return view('client.booking.calendar.index', [
            'rooms'        => $rooms,
            'roomId'       => $roomId,
            'roomSelected' => $roomSelected,
            'month'        => $month,
            'startGrid'    => $startGrid,
            'endGrid'      => $endGrid,
            'items'        => $items, // keyBy date
        ]);
    }

    public function seedMonth(Request $request)
    {
        $data = $request->validate([
            'month'   => ['required','regex:/^\d{4}-\d{2}$/'],
            'room_id' => ['nullable','integer'],
        ]);

        $month  = $data['month'];
        $roomId = $data['room_id'] ?? null;

        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end   = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $roomsQ = Room::query()->select('id','number_rooms');
        if ($roomId) $roomsQ->where('id', $roomId);
        $rooms = $roomsQ->get();

        if ($rooms->isEmpty()) {
            return back()->with('error', 'Không có phòng để tạo lịch.');
        }

        $rows = [];
        foreach ($rooms as $r) {
            $cursor = $start->copy();
            while ($cursor->lte($end)) {
                $rows[] = [
                    'room_id'    => $r->id,
                    'date'       => $cursor->toDateString(),
                    'status'     => 'open',
                    'price'      => null,

                    // inventory theo ngày
                    'total_qty'  => (int)($r->number_rooms ?? 0),
                    'hold_qty'   => 0,
                    'booked_qty' => 0,

                    // legacy field vẫn để (không dùng nữa)
                    'booking_id' => null,
                    'note'       => null,

                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $cursor->addDay();
            }
        }

        // chỉ tạo những ngày chưa có
        DB::table('room_day_statuses')->insertOrIgnore($rows);

        // backfill total_qty cho các dòng đã tồn tại nhưng total_qty = 0 (nếu trước đây seed theo kiểu cũ)
        foreach ($rooms as $r) {
            RoomDayStatus::query()
                ->where('room_id', $r->id)
                ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
                ->where('total_qty', 0)
                ->update(['total_qty' => (int)($r->number_rooms ?? 0)]);
        }

        return back()->with('success', "Đã tạo lịch tháng {$month} + set total_qty theo rooms.number_rooms.");
    }

    public function bulkUpdate(Request $request)
    {
        $data = $request->validate([
            'room_id'    => ['nullable','integer'],
            'date_from'  => ['required','date'],
            'date_to'    => ['required','date'],

            'status'     => ['nullable','in:open,closed,maintenance'],
            'price'      => ['nullable','numeric','min:0'],
            'total_qty'  => ['nullable','integer','min:0'],

            'note'       => ['nullable','string','max:255'],
        ]);

        $from = Carbon::parse($data['date_from'])->toDateString();
        $to   = Carbon::parse($data['date_to'])->toDateString();
        if ($to < $from) return back()->with('error', 'Khoảng ngày không hợp lệ.');

        $q = RoomDayStatus::query()->whereBetween('date', [$from, $to]);

        if (!empty($data['room_id'])) {
            $q->where('room_id', $data['room_id']);
        }

        // An toàn: không cho giảm total_qty < booked_qty
        if (array_key_exists('total_qty', $data) && $data['total_qty'] !== null) {
            $bad = (clone $q)->where('booked_qty', '>', (int)$data['total_qty'])->count();
            if ($bad > 0) {
                return back()->with('error', 'Có ngày booked_qty > total_qty mới. Hãy tăng total_qty hoặc giảm booking.');
            }
        }

        $upd = [];
        if (!empty($data['status'])) $upd['status'] = $data['status'];
        if (array_key_exists('price', $data)) $upd['price'] = $data['price'];
        if (array_key_exists('total_qty', $data) && $data['total_qty'] !== null) $upd['total_qty'] = (int)$data['total_qty'];
        if (array_key_exists('note', $data)) $upd['note'] = $data['note'];

        if (empty($upd)) return back()->with('error', 'Bạn chưa chọn nội dung cập nhật.');

        $q->update($upd);

        return back()->with('success', 'Cập nhật hàng loạt thành công.');
    }

    public function update(Request $request, $id)
    {
        $item = RoomDayStatus::findOrFail($id);

        $data = $request->validate([
            'status'    => ['required','in:open,closed,maintenance'],
            'price'     => ['nullable','numeric','min:0'],
            'total_qty' => ['required','integer','min:0'],
            'note'      => ['nullable','string','max:255'],
        ]);

        if ((int)$data['total_qty'] < (int)$item->booked_qty) {
            return back()->with('error', 'total_qty không thể nhỏ hơn booked_qty.');
        }

        $item->update($data);

        return back()->with('success', 'Đã cập nhật lịch ngày ' . $item->date->format('d/m/Y'));
    }

    public function delete($id)
    {
        $item = RoomDayStatus::findOrFail($id);

        if ((int)$item->booked_qty > 0) {
            return back()->with('error', 'Ngày này đã có booking, không thể xóa.');
        }

        $item->delete();
        return back()->with('success', 'Đã xóa cấu hình ngày.');
    }
}
