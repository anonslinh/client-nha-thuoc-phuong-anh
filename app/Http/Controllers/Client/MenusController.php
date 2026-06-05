<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenusController extends Controller
{
    /**
     * Danh sách thực đơn + filter + paginate
     */
    public function listDataMenus(Request $r)
    {
        $query = Menu::query()
            ->when($r->room_id, fn($q) => $q->where('id_room', (int)$r->room_id))
            ->when($r->filled('status'), fn($q) => $q->where('status', (int)$r->status))
            ->when($r->filled('kw'), fn($q) => $q->where('name', 'like', '%'.$r->kw.'%'))
            ->orderByDesc('id');

        $listData = $query->paginate(12);

        // danh sách phòng cho select
        $rooms = Room::orderBy('name')->get(['id','name']);

        return view('menus.index', compact('listData', 'rooms'));
    }

    /**
     * Tạo mới món trong thực đơn
     * - Upload ảnh vào public/upload/banner
     * - Cho phép nhập URL ảnh nếu không upload file
     */
    public function storeMenu(Request $r)
    {
        $validated = $r->validate([
            'id_room'    => ['required','integer','exists:rooms,id'], // bỏ exists nếu muốn “thoáng”
            'name'       => ['required','string','max:255'],
            'image'      => ['nullable','image','max:5120'],
            'image_url'  => ['nullable','string','max:500'],
            'short_desc' => ['nullable','string','max:255'],
            'status'     => ['required','integer','in:0,1'],
        ]);

        $uploadDir = public_path('upload/banner');
        if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }
        if (!is_writable($uploadDir)) {
            return back()->with('error', 'Thư mục upload/banner không có quyền ghi.');
        }

        $imagePath = $validated['image_url'] ?? null;

        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move($uploadDir, $nameFile);
            $imagePath = 'upload/banner/'.$nameFile; // lưu đường dẫn tương đối
        }

        Menu::create([
            'id_room'    => (int)$validated['id_room'],
            'name'       => $validated['name'],
            'image'      => $imagePath,
            'short_desc' => $validated['short_desc'] ?? null,
            'status'     => (int)$validated['status'],
        ]);

        return back()->with('success', 'Thêm món thực đơn thành công');
    }

    /**
     * Cập nhật món thực đơn
     */
    public function updateMenu(Request $r, $id)
    {
        $menu = Menu::find($id);
        if (!$menu) return back()->with('error','Không tìm thấy dữ liệu');

        $validated = $r->validate([
            'id_room'    => ['required','integer','exists:rooms,id'],
            'name'       => ['required','string','max:255'],
            'image'      => ['nullable','image','max:5120'],
            'image_url'  => ['nullable','string','max:500'],
            'short_desc' => ['nullable','string','max:255'],
            'status'     => ['required','integer','in:0,1'],
        ]);

        $uploadDir = public_path('upload/banner');
        if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }
        if (!is_writable($uploadDir)) {
            return back()->with('error', 'Thư mục upload/banner không có quyền ghi.');
        }

        $newImage = $validated['image_url'] ?? $menu->image;

        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move($uploadDir, $nameFile);

            // xóa ảnh cũ nếu là file local
            if (!empty($menu->image) && str_starts_with($menu->image, 'upload/banner/')) {
                $old = public_path($menu->image);
                if (file_exists($old)) @unlink($old);
            }
            $newImage = 'upload/banner/'.$nameFile;
        }

        $menu->update([
            'id_room'    => (int)$validated['id_room'],
            'name'       => $validated['name'],
            'image'      => $newImage,
            'short_desc' => $validated['short_desc'] ?? null,
            'status'     => (int)$validated['status'],
        ]);

        return back()->with('success', 'Cập nhật món thực đơn thành công');
    }

    /**
     * Xoá món thực đơn
     */
    public function deleteMenu($id)
    {
        $menu = Menu::find($id);
        if (!$menu) return back()->with('error','Không tìm thấy dữ liệu');

        if (!empty($menu->image) && str_starts_with($menu->image, 'upload/banner/')) {
            $old = public_path($menu->image);
            if (file_exists($old)) @unlink($old);
        }

        $menu->delete();
        return back()->with('success','Đã xoá món thực đơn');
    }
}
