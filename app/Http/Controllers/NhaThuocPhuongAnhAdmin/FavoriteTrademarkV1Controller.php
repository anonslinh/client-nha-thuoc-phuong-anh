<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\FavoriteTrademarkV1;
use App\Models\TrademarkV1;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FavoriteTrademarkV1Controller extends Controller
{
    public function index(Request $request)
    {
        $listData = FavoriteTrademarkV1::query()
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->paginate(20);

        $ids = $listData->pluck('trademark_id')->all();
        $trademarksMap = [];
        if (!empty($ids)) {
            $trademarksMap = TrademarkV1::whereIn('id', $ids)->get()->keyBy('id');
        }

        return view('admin.catalog_v1.favorite_trademarks.index', compact('listData','trademarksMap'));
    }

    public function update(Request $request, $id)
    {
        $row = FavoriteTrademarkV1::findOrFail($id);

        $data = $request->only(['short_desc','sort_order','status']);

        // upload featured_image (nullable)
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->saveUploaded($request->file('featured_image'), 'upload/catalog/favorite-trademarks');
        } else {
            // cho phép dán link nếu muốn
            if ($request->filled('featured_image')) {
                $data['featured_image'] = $request->get('featured_image');
            }
        }

        $row->update($data);

        return redirect()->back()->with('success', 'Cập nhật thương hiệu yêu thích thành công');
    }

    public function destroy($id)
    {
        FavoriteTrademarkV1::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Xóa thương hiệu yêu thích thành công');
    }

    // Trang chọn thương hiệu từ trademark_v1
    public function attachPage(Request $request)
    {
        $q = TrademarkV1::query()->orderBy('sort_order')->orderBy('id','desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where('name','like',"%{$key}%");
        }

        $listData = $q->paginate(50);

        $exists = FavoriteTrademarkV1::pluck('trademark_id')->all();
        $existMap = array_fill_keys($exists, true);

        return view('admin.catalog_v1.favorite_trademarks.attach', compact('listData','existMap'));
    }

    // Bulk add selected trademarks
    public function attachStore(Request $request)
    {
        $ids = $request->get('trademark_ids', []);
        $data = $request->get('items', []); // items[trademark_id][short_desc|sort_order]

        if (!is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('error','Vui lòng chọn ít nhất 1 thương hiệu.');
        }

        $created = 0;
        $updated = 0;

        foreach ($ids as $tid) {
            $tid = (int)$tid;
            $short = $data[$tid]['short_desc'] ?? null;
            $sort = $data[$tid]['sort_order'] ?? 0;

            $row = FavoriteTrademarkV1::where('trademark_id', $tid)->first();

            if ($row) {
                $row->update([
                    'short_desc' => $short,
                    'sort_order' => (int)$sort,
                    'status' => 1,
                ]);
                $updated++;
            } else {
                FavoriteTrademarkV1::create([
                    'trademark_id' => $tid,
                    'featured_image' => null, // upload sau trong màn index (hoặc bổ sung upload tại đây nếu muốn)
                    'short_desc' => $short,
                    'sort_order' => (int)$sort,
                    'status' => 1,
                ]);
                $created++;
            }
        }

        return redirect()->back()->with('success',"Đã thêm {$created} thương hiệu, cập nhật {$updated} thương hiệu yêu thích.");
    }

    private function saveUploaded($file, $folder)
    {
        $folderPath = public_path($folder);
        if (!is_dir($folderPath)) @mkdir($folderPath, 0777, true);

        $name = time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();
        $file->move($folderPath, $name);

        return $folder.'/'.$name;
    }
}