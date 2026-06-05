<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Utility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UtilitiesController extends Controller
{
    /**
     * Danh sách tiện ích + filter + paginate
     */
    public function listDataUtilities(Request $r)
    {
        $query = Utility::query()
            ->when($r->room_id, fn($q) => $q->where('id_room', (int)$r->room_id))
            ->when($r->filled('status'), fn($q) => $q->where('status', (int)$r->status))
            ->when($r->filled('kw'), fn($q) => $q->where('name', 'like', '%'.$r->kw.'%'))
            ->orderByDesc('id');

        $listData = $query->paginate(12);

        $rooms = Room::orderBy('name')->get(['id','name']);

        return view('utilities.index', compact('listData', 'rooms'));
    }

    /**
     * Tạo tiện ích
     * - Upload icon vào public/upload/banner (hoặc cho phép nhập URL icon)
     */
    public function storeUtility(Request $r)
    {
        $validated = $r->validate([
            'id_room'    => ['required','integer','exists:rooms,id'], // bỏ 'exists' nếu muốn thoáng
            'name'       => ['required','string','max:255'],
            'icon_file'  => ['nullable','image','max:5120'],
            'icon_url'   => ['nullable','string','max:500'],
            'short_desc' => ['nullable','string','max:255'],
            'status'     => ['required','integer','in:0,1'],
        ]);

        $uploadDir = public_path('upload/banner');
        if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }
        if (!is_writable($uploadDir)) {
            return back()->with('error', 'Thư mục upload/banner không có quyền ghi.');
        }

        $iconPath = $validated['icon_url'] ?? null;

        if ($r->hasFile('icon_file')) {
            $file = $r->file('icon_file');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move($uploadDir, $nameFile);
            $iconPath = 'upload/banner/'.$nameFile;
        }

        Utility::create([
            'id_room'    => (int)$validated['id_room'],
            'name'       => $validated['name'],
            'icon'       => $iconPath,
            'short_desc' => $validated['short_desc'] ?? null,
            'status'     => (int)$validated['status'],
        ]);

        return back()->with('success', 'Thêm tiện ích thành công');
    }

    /**
     * Cập nhật tiện ích
     */
    public function updateUtility(Request $r, $id)
    {
        $util = Utility::find($id);
        if (!$util) return back()->with('error','Không tìm thấy dữ liệu');

        $validated = $r->validate([
            'id_room'    => ['required','integer','exists:rooms,id'],
            'name'       => ['required','string','max:255'],
            'icon_file'  => ['nullable','image','max:5120'],
            'icon_url'   => ['nullable','string','max:500'],
            'short_desc' => ['nullable','string','max:255'],
            'status'     => ['required','integer','in:0,1'],
        ]);

        $uploadDir = public_path('upload/banner');
        if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }
        if (!is_writable($uploadDir)) {
            return back()->with('error', 'Thư mục upload/banner không có quyền ghi.');
        }

        $newIcon = $validated['icon_url'] ?? $util->icon;

        if ($r->hasFile('icon_file')) {
            $file = $r->file('icon_file');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move($uploadDir, $nameFile);

            if (!empty($util->icon) && str_starts_with($util->icon, 'upload/banner/')) {
                $old = public_path($util->icon);
                if (file_exists($old)) @unlink($old);
            }
            $newIcon = 'upload/banner/'.$nameFile;
        }

        $util->update([
            'id_room'    => (int)$validated['id_room'],
            'name'       => $validated['name'],
            'icon'       => $newIcon,
            'short_desc' => $validated['short_desc'] ?? null,
            'status'     => (int)$validated['status'],
        ]);

        return back()->with('success','Cập nhật tiện ích thành công');
    }

    /**
     * Xoá tiện ích
     */
    public function deleteUtility($id)
    {
        $util = Utility::find($id);
        if (!$util) return back()->with('error','Không tìm thấy dữ liệu');

        if (!empty($util->icon) && str_starts_with($util->icon, 'upload/banner/')) {
            $old = public_path($util->icon);
            if (file_exists($old)) @unlink($old);
        }

        $util->delete();
        return back()->with('success','Đã xoá tiện ích');
    }
}
