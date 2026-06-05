<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\ImageRoom;
use App\Models\Utility;
use App\Models\Menu;
use App\Models\RoomDayStatus;
use Illuminate\Http\Request;

class RoomClientController extends Controller
{
    // Danh sách phòng hiển thị cho người dùng
    public function index()
    {
        // $rooms = Room::query()
        //     ->where('is_active', 1)
        //     ->where('status', 1)
        //     ->orderByDesc('id')
        //     ->paginate(9);
        $rooms = Room::where('status', 1)
             ->where('is_active', 1)
            ->where('status', 1)
            ->orderByDesc('id')
            ->paginate(10);

        return view('client.rooms.index', compact('rooms'));
    }

    // Chi tiết phòng theo code_url (SEO)
    public function show(string $code_url)
    {
        $room = Room::where('code_url', $code_url)
            ->where('is_active', 1)
            ->firstOrFail();

        $images     = ImageRoom::where('id_room', $room->id)->where('status', 1)->orderBy('sort_order')->get();
        $utilities  = Utility::where('id_room', $room->id)->where('status', 1)->get();
        $menus      = Menu::where('id_room', $room->id)->where('status', 1)->get();

        return view('client.rooms.detail', compact('room', 'images', 'utilities', 'menus'));
    }
    public function availability(Request $request)
    {

        $data = $request->validate([
            'month'    => ['required','regex:/^\d{4}-\d{2}$/'], // YYYY-MM
        ]);

        $month = $data['month'];
        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end   = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        // room type
        $rooms = Room::query()
            ->select('id','name','number_rooms')
            ->orderBy('id','asc')
            ->get();

        $roomIds = $rooms->pluck('id')->all();

        $rows = RoomDayStatus::query()
            ->select('id','room_id','date','status','price','total_qty','hold_qty','booked_qty')
            ->whereIn('room_id', $roomIds)
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->get();

        // map: room_id -> date -> row
        $map = [];
        foreach ($rows as $r) {
            $d = Carbon::parse($r->date)->toDateString();
            $total  = (int)($r->total_qty ?? 0);
            $booked = (int)($r->booked_qty ?? 0);
            $hold   = (int)($r->hold_qty ?? 0);
            $remain = max($total - $booked - $hold, 0);

            $map[$r->room_id][$d] = [
                'status' => $r->status ?? 'open',
                'price'  => $r->price,
                'total'  => $total,
                'booked' => $booked,
                'hold'   => $hold,
                'remain' => $remain,
            ];
        }

        // list ngày trong tháng
        $days = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $days[] = $cursor->toDateString();
            $cursor->addDay();
        }

        // nếu ngày nào chưa seed thì coi như open + total = rooms.number_rooms, booked=0
        $roomsOut = [];
        foreach ($rooms as $room) {
            $roomOut = [
                'id' => $room->id,
                'name' => $room->name,
                'default_total' => (int)($room->number_rooms ?? 0),
                'days' => [],
            ];

            foreach ($days as $d) {
                $cell = $map[$room->id][$d] ?? null;

                if (!$cell) {
                    $total = (int)($room->number_rooms ?? 0);
                    $cell = [
                        'status' => 'open',
                        'price'  => null,
                        'total'  => $total,
                        'booked' => 0,
                        'hold'   => 0,
                        'remain' => $total,
                    ];
                }

                $roomOut['days'][$d] = $cell;
            }

            $roomsOut[] = $roomOut;
        }

        return response()->json([
            'month' => $month,
            'start' => $start->toDateString(),
            'end'   => $end->toDateString(),
            'days'  => $days,
            'rooms' => $roomsOut,
        ]);
    }
}
