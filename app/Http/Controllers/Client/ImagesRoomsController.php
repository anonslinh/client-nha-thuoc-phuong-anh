<?php

namespace App\Http\Controllers\Client;

use App\Models\ImageRoom;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ImagesRoomsController extends Controller
{
    /**
     * Danh sách ảnh phòng (có phân trang)
     */
    public function listDataImagesRoom(Request $r)
    {
        // Lọc đơn giản: theo room_id, status
        $query = ImageRoom::query()
            ->when($r->room_id, fn($q) => $q->where('id_room', (int)$r->room_id))
            ->when($r->filled('status'), fn($q) => $q->where('status', (int)$r->status))
            ->orderByDesc('id');

        $listData = $query->paginate(12);

        // Lấy danh sách phòng để select
        $rooms = Room::orderBy('name')->get(['id', 'name']);
        return view('images_room.index', compact('listData', 'rooms'));
    }

    /**
     * Tạo mới ảnh phòng
     */
    public function storeImagesRoom(Request $r)
    {
        $validated = $r->validate([
            'id_room'     => ['required', 'integer', 'exists:rooms,id'], // bỏ 'exists' nếu bạn muốn thoáng
            'image'       => ['nullable', 'image', 'max:5120'],          // 5MB
            'link_image'  => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer'],
            'is_featured' => ['nullable', 'in:0,1'],
            'status'      => ['nullable', 'in:0,1'],
        ]);

        // Tạo thư mục nếu chưa có
        $uploadDir = public_path('upload/banner');
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0775, true);
        }

        $link = $validated['link_image'] ?? null;

        // Nếu có upload file → ưu tiên file
        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $nameFile = time() . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $nameFile);
            // Lưu đường dẫn tương đối như banner
            $link = 'upload/banner/' . $nameFile;
        }

        \App\Models\ImageRoom::create([
            'id_room'     => (int)$validated['id_room'],
            'link_image'  => $link,
            'sort_order'  => (int)($validated['sort_order'] ?? 0),
            'is_featured' => (int)($validated['is_featured'] ?? 0),
            'status'      => (int)($validated['status'] ?? 1),
        ]);

        return back()->with('success', 'Thêm ảnh phòng thành công');
    }


    /**
     * Cập nhật ảnh phòng
     */
    public function updateImagesRoom(Request $r, $id)
    {
        $img = \App\Models\ImageRoom::find($id);
        if (empty($img)) {
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }

        $validated = $r->validate([
            'id_room'     => ['required', 'integer', 'exists:rooms,id'], // bỏ 'exists' nếu muốn
            'image'       => ['nullable', 'image', 'max:5120'],
            'link_image'  => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer'],
            'is_featured' => ['nullable', 'in:0,1'],
            'status'      => ['nullable', 'in:0,1'],
        ]);

        $uploadDir = public_path('upload/banner');
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0775, true);
        }

        $newLink = $validated['link_image'] ?? $img->link_image;

        if ($r->hasFile('image')) {
            // Upload file mới
            $file = $r->file('image');
            $nameFile = time() . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $nameFile);

            // Xóa file cũ nếu là file local trong thư mục banner
            if (!empty($img->link_image) && str_starts_with($img->link_image, 'upload/banner/')) {
                $oldPath = public_path($img->link_image);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // Lưu đường dẫn mới dạng tương đối
            $newLink = 'upload/banner/' . $nameFile;
        }

        $img->id_room     = (int)$validated['id_room'];
        $img->link_image  = $newLink;
        $img->sort_order  = (int)($validated['sort_order'] ?? $img->sort_order);
        $img->is_featured = (int)($validated['is_featured'] ?? $img->is_featured);
        $img->status      = (int)($validated['status'] ?? $img->status);
        $img->save();

        return back()->with(['success' => 'Cập nhật ảnh phòng thành công']);
    }


    /**
     * Xoá ảnh phòng
     */
    public function deleteImagesRoom($id)
    {
        $img = \App\Models\ImageRoom::find($id);
        if (empty($img)) {
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }

        // Nếu là file local dưới upload/banner thì xoá file vật lý
        if (!empty($img->link_image) && str_starts_with($img->link_image, 'upload/banner/')) {
            $oldPath = public_path($img->link_image);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        $img->delete();
        return back()->with(['success' => 'Đã xoá ảnh phòng']);
    }

}
