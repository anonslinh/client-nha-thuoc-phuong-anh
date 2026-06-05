<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\ImageRoom;
use App\Models\Utility;
use App\Models\Service;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomsController extends Controller
{
    /**
     * Danh sách phòng + filter + paginate
     */
    public function listDataRooms(Request $r)
    {
        $q = Room::query()
            ->when($r->filled('kw'), fn($q) => $q->where('name', 'like', '%'.$r->kw.'%'))
            ->when($r->filled('type'), fn($q) => $q->where('type', (int)$r->type))
            ->when($r->filled('is_active'), fn($q) => $q->where('is_active', (int)$r->is_active))
            ->when($r->filled('status'), fn($q) => $q->where('status', (int)$r->status))
            ->orderByDesc('id');

        $listData = $q->paginate(12);

        return view('rooms.index', compact('listData'));
    }

    /**
     * Tạo mới phòng
     * - Upload ảnh avatar/banner vào public/upload/banner/
     * - Nếu không nhập code_url, tự sinh từ name: 1986hotels-{slug(name)} (tránh trùng bằng logic)
     */
    public function storeRoom(Request $r)
    {
        try{
            $validated = $r->validate([
                'name'         => ['required', 'string', 'max:255'],
                'price'        => ['required', 'integer', 'min:0'],
                'price_listed' => ['required', 'integer', 'min:0'],
                'img_avatar'   => ['nullable', 'image', 'max:5120'],
                'img_banner'   => ['nullable', 'image', 'max:5120'],
                'link_video'   => ['nullable', 'string', 'max:255'],
                'note_services'=> ['nullable', 'string', 'max:255'],
                'type'         => ['required', 'integer', 'in:1,2,3'],
                'description'  => ['nullable', 'string'],
                'is_active'    => ['required', 'integer', 'in:0,1'],
                'status'       => ['required', 'integer', 'in:0,1'],
                'code_url'     => ['nullable', 'string', 'max:255'],
                'number_rooms' => ['required','integer','min:0'],
            ]);

            $uploadDir = public_path('upload/banner');
            if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }

            // Handle images
            $avatarPath = null;
            if ($r->hasFile('img_avatar')) {
                $file = $r->file('img_avatar');
                $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->move($uploadDir, $nameFile);
                $avatarPath = 'upload/banner/'.$nameFile;
            }

            $bannerPath = null;
            if ($r->hasFile('img_banner')) {
                $file = $r->file('img_banner');
                $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->move($uploadDir, $nameFile);
                $bannerPath = 'upload/banner/'.$nameFile;
            }
            // code_url
            $codeUrl = $validated['code_url'] ?? null;
            if (empty($codeUrl)) {
                $prefix = '1986hotels';
                $base = Str::slug($validated['name']);
                $candidate = $prefix.'-'.$base;
                $i = 2;
                while (Room::where('code_url', $candidate)->exists()) {
                    $candidate = $prefix.'-'.$base.'-'.$i; $i++;
                }
                $codeUrl = $candidate;
            }

            Room::create([
                'name'          => $validated['name'],
                'price'         => (int)$validated['price'],
                'price_listed'  => (int)$validated['price_listed'],
                'img_avatar'    => $avatarPath,
                'img_banner'    => $bannerPath,
                'link_video'    => $validated['link_video'] ?? null,
                'note_services' => $validated['note_services'] ?? null,
                'type'          => (int)$validated['type'],
                'description'   => $validated['description'] ?? null,
                'number_rooms'  => (int)$validated['number_rooms'], // <--- thêm
                'is_active'     => (int)$validated['is_active'],
                'status'        => (int)$validated['status'],
                'code_url'      => $codeUrl,
            ]);

            return back()->with('success', 'Thêm phòng thành công');
        }catch (\Exception $exception){
            dd($exception);
        }
    }

    /**
     * Cập nhật phòng
     * - Nếu upload ảnh mới -> move file mới + xóa file cũ (nếu là file local trong upload/banner/)
     */
    public function updateRoom(Request $r, $id)
    {
        $room = Room::find($id);
        if (!$room) return back()->with('error', 'Không tìm thấy phòng');

        $validated = $r->validate([
            'name'         => ['required', 'string', 'max:255'],
            'price'        => ['required', 'integer', 'min:0'],
            'price_listed' => ['required', 'integer', 'min:0'],
            'img_avatar'   => ['nullable', 'image', 'max:5120'],
            'img_banner'   => ['nullable', 'image', 'max:5120'],
            'link_video'   => ['nullable', 'string', 'max:255'],
            'note_services'=> ['nullable', 'string', 'max:255'],
            'type'         => ['required', 'integer', 'in:1,2,3'],
            'description'  => ['nullable', 'string'],
            'is_active'    => ['required', 'integer', 'in:0,1'],
            'status'       => ['required', 'integer', 'in:0,1'],
            'code_url'     => ['nullable', 'string', 'max:255'],
            'number_rooms' => ['required','integer','min:0'],
        ]);

        $uploadDir = public_path('upload/banner');
        if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }

        // avatar
        if ($r->hasFile('img_avatar')) {
            $file = $r->file('img_avatar');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move($uploadDir, $nameFile);

            if (!empty($room->img_avatar) && str_starts_with($room->img_avatar, 'upload/banner/')) {
                $old = public_path($room->img_avatar);
                if (file_exists($old)) @unlink($old);
            }
            $room->img_avatar = 'upload/banner/'.$nameFile;
        }

        // banner
        if ($r->hasFile('img_banner')) {
            $file = $r->file('img_banner');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move($uploadDir, $nameFile);

            if (!empty($room->img_banner) && str_starts_with($room->img_banner, 'upload/banner/')) {
                $old = public_path($room->img_banner);
                if (file_exists($old)) @unlink($old);
            }
            $room->img_banner = 'upload/banner/'.$nameFile;
        }

        // code_url: nếu nhập tay thì dùng; nếu bỏ trống -> giữ giá trị cũ (không tự sinh lại, tránh đổi URL SEO ngoài ý muốn)
        if (!empty($validated['code_url'])) {
            $candidate = Str::slug($validated['code_url']);
            if ($candidate !== $room->code_url) {
                $i = 2; $base = $candidate;
                while (Room::where('code_url', $candidate)->where('id', '!=', $room->id)->exists()) {
                    $candidate = $base.'-'.$i; $i++;
                }
                $room->code_url = $candidate;
            }
        }
        $room->name          = $validated['name'];
        $room->price         = (int)$validated['price'];
        $room->price_listed  = (int)$validated['price_listed'];
        $room->link_video    = $validated['link_video'] ?? null;
        $room->note_services = $validated['note_services'] ?? null;
        $room->type          = (int)$validated['type'];
        $room->description   = $validated['description'] ?? null;
        $room->is_active     = (int)$validated['is_active'];
        $room->status        = (int)$validated['status'];
        $room->code_url      = $candidate;
        $room->number_rooms = (int)$validated['number_rooms']; // <---
        $room->save();

        return back()->with('success', 'Cập nhật phòng thành công');
    }

    /**
     * Xoá phòng
     * - Xóa file ảnh avatar/banner nếu là local trong upload/banner/
     * - (tuỳ chọn) Xóa dữ liệu con: images_room/utilities/service/menus
     */
    public function deleteRoom($id)
    {
        $room = Room::find($id);
        if (!$room) return back()->with('error', 'Không tìm thấy phòng');

        // Xóa file ảnh
        foreach (['img_avatar','img_banner'] as $f) {
            if (!empty($room->{$f}) && str_starts_with($room->{$f}, 'upload/banner/')) {
                $p = public_path($room->{$f});
                if (file_exists($p)) @unlink($p);
            }
        }

        // Tuỳ chọn: dọn dữ liệu con (không FK)
        ImageRoom::where('id_room', $room->id)->delete();
        Utility::where('id_room', $room->id)->delete();
        Service::where('id_room', $room->id)->delete();
        Menu::where('id_room', $room->id)->delete();

        $room->delete();

        return back()->with('success', 'Đã xoá phòng');
    }
}
