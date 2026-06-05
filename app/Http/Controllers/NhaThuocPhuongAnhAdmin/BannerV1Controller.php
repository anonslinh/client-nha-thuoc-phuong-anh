<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\BannerV1;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannerV1Controller extends Controller
{
    public function index(Request $request)
    {
        $q = BannerV1::query()->orderBy('sort_order')->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where('title', 'like', "%{$key}%");
        }

        if ($request->filled('type_hide')) {
            $q->where('type_hide', $request->type_hide);
        }

        $listData = $q->paginate(12);

        return view('admin.catalog_v1.banners.index', compact('listData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sort_order' => 'required|integer',
        ]);

        $data = [
            'type_hide' => $request->type_hide ?? 1,
            'sort_order' => $request->sort_order ?? 0,
            'title' => $request->title,
            'content' => $request->content,
            'link_web' => $request->link_web,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->saveUploaded($request->file('image'), 'upload/catalog/banners');
        } else {
            $data['image'] = $request->get('image');
        }

        BannerV1::create($data);

        return redirect()->back()->with('success', 'Thêm banner thành công');
    }

    public function update(Request $request, $id)
    {
        $row = BannerV1::findOrFail($id);

        $request->validate([
            'sort_order' => 'required|integer',
        ]);

        $data = [
            'type_hide' => $request->type_hide ?? 1,
            'sort_order' => $request->sort_order ?? 0,
            'title' => $request->title,
            'content' => $request->content,
            'link_web' => $request->link_web,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->saveUploaded($request->file('image'), 'upload/catalog/banners');
        } else {
            if ($request->filled('image')) {
                $data['image'] = $request->get('image');
            }
        }

        $row->update($data);

        return redirect()->back()->with('success', 'Cập nhật banner thành công');
    }

    public function destroy($id)
    {
        BannerV1::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Xóa banner thành công');
    }

    public function show($id)
    {
        $item = BannerV1::findOrFail($id);
        return view('admin.catalog_v1.banners.show', compact('item'));
    }

    private function saveUploaded($file, $folder)
    {
        $folderPath = public_path($folder);

        if (!is_dir($folderPath)) {
            if (!mkdir($folderPath, 0775, true) && !is_dir($folderPath)) {
                throw new \Exception('Không tạo được thư mục: ' . $folderPath);
            }
        }

        if (!is_writable($folderPath)) {
            throw new \Exception('Thư mục không có quyền ghi: ' . $folderPath);
        }

        $name = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($folderPath, $name);

        return $folder . '/' . $name;
    }
}