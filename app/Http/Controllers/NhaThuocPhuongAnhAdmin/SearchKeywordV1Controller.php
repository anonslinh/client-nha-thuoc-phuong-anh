<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\ProductV1;
use App\Models\SearchKeywordProductV1;
use App\Models\SearchKeywordV1;
use Illuminate\Http\Request;

class SearchKeywordV1Controller extends Controller
{
  public function index(Request $request)
  {
    $q = SearchKeywordV1::query()->orderBy('sort_order')->orderBy('id','desc');

    if ($request->filled('key_search')) {
      $key = trim($request->key_search);
      $q->where('key_search','like',"%{$key}%");
    }

    $listData = $q->paginate(20);

    // count products per keyword (không N+1)
    $ids = $listData->pluck('id')->all();
    $countMap = [];
    if (!empty($ids)) {
      $countMap = SearchKeywordProductV1::query()
        ->selectRaw('keyword_id, COUNT(*) as c')
        ->whereIn('keyword_id', $ids)
        ->groupBy('keyword_id')
        ->pluck('c','keyword_id')
        ->toArray();
    }

    return view('admin.catalog_v1.search_keywords.index', compact('listData','countMap'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'key_search' => 'required|string|max:255',
      'sort_order' => 'required|integer',
    ]);

    $related = $this->normalizeRelated($request->related_keywords);

    SearchKeywordV1::create([
      'key_search' => trim($request->key_search),
      'related_keywords' => $related ? json_encode($related, JSON_UNESCAPED_UNICODE) : null,
      'type' => $request->type ?? 1,
      'sort_order' => $request->sort_order ?? 0,
    ]);

    return redirect()->back()->with('success','Thêm từ khóa thành công');
  }

  public function update(Request $request, $id)
  {
    $row = SearchKeywordV1::findOrFail($id);

    $request->validate([
      'key_search' => 'required|string|max:255',
      'sort_order' => 'required|integer',
    ]);

    $related = $this->normalizeRelated($request->related_keywords);

    $row->update([
      'key_search' => trim($request->key_search),
      'related_keywords' => $related ? json_encode($related, JSON_UNESCAPED_UNICODE) : null,
      'type' => $request->type ?? 1,
      'sort_order' => $request->sort_order ?? 0,
    ]);

    return redirect()->back()->with('success','Cập nhật từ khóa thành công');
  }

  public function destroy($id)
  {
    SearchKeywordProductV1::where('keyword_id', $id)->delete();
    SearchKeywordV1::where('id', $id)->delete();
    return redirect()->back()->with('success','Xóa từ khóa thành công');
  }

  // ===== CẤU HÌNH SẢN PHẨM ƯU TIÊN =====

  public function products(Request $request, $id)
  {
    $keyword = SearchKeywordV1::findOrFail($id);

    $maps = SearchKeywordProductV1::query()
      ->where('keyword_id', $id)
      ->orderBy('sort_order')
      ->orderBy('id','desc')
      ->get();

    $productIds = $maps->pluck('product_id')->all();
    $productsMap = [];
    if (!empty($productIds)) {
      $productsMap = ProductV1::whereIn('id', $productIds)->get()->keyBy('id');
    }

    return view('admin.catalog_v1.search_keywords.products', compact('keyword','maps','productsMap'));
  }

  public function attachPage(Request $request, $id)
  {
    $keyword = SearchKeywordV1::findOrFail($id);

    $q = ProductV1::query()->orderBy('id','desc');

    if ($request->filled('key_search')) {
      $key = trim($request->key_search);
      $q->where(function($qq) use ($key){
        $qq->where('name','like',"%{$key}%")
           ->orWhere('full_name','like',"%{$key}%")
           ->orWhere('code_product_kiovet','like',"%{$key}%");
      });
    }

    $listData = $q->paginate(50);

    $exists = SearchKeywordProductV1::where('keyword_id', $id)->pluck('product_id')->all();
    $existMap = array_fill_keys($exists, true);

    return view('admin.catalog_v1.search_keywords.attach', compact('keyword','listData','existMap'));
  }

  // bulk add only checked + sort_order
  public function attachProducts(Request $request, $id)
  {
    $keyword = SearchKeywordV1::findOrFail($id);

    $productIds = $request->get('product_ids', []);
    $items = $request->get('items', []); // items[product_id][sort_order]

    if (!is_array($productIds) || count($productIds) === 0) {
      return redirect()->back()->with('error','Vui lòng chọn ít nhất 1 sản phẩm.');
    }

    $created = 0;
    $updated = 0;

    foreach ($productIds as $pid) {
      $pid = (int)$pid;
      $sort = $items[$pid]['sort_order'] ?? 0;

      $row = SearchKeywordProductV1::where('keyword_id',$id)->where('product_id',$pid)->first();
      if ($row) {
        $row->update(['sort_order' => (int)$sort, 'status' => 1]);
        $updated++;
      } else {
        SearchKeywordProductV1::create([
          'keyword_id' => $id,
          'product_id' => $pid,
          'sort_order' => (int)$sort,
          'status' => 1,
        ]);
        $created++;
      }
    }

    return redirect()->back()->with('success',"Đã thêm {$created} SP, cập nhật {$updated} SP ưu tiên.");
  }

  public function detachProducts(Request $request, $id)
  {
    $ids = $request->get('map_ids', []);
    if (!is_array($ids) || count($ids) === 0) {
      return redirect()->back()->with('error','Vui lòng chọn ít nhất 1 sản phẩm để gỡ.');
    }

    SearchKeywordProductV1::where('keyword_id',$id)->whereIn('id',$ids)->delete();
    return redirect()->back()->with('success','Đã gỡ sản phẩm khỏi danh sách ưu tiên');
  }

  public function updateMapItem(Request $request, $id, $map_id)
  {
    $row = SearchKeywordProductV1::where('keyword_id',$id)->where('id',$map_id)->firstOrFail();

    $row->update([
      'sort_order' => (int)($request->sort_order ?? 0),
      'status' => $request->status ?? 1,
    ]);

    return redirect()->back()->with('success','Cập nhật sản phẩm ưu tiên thành công');
  }

  // ===== Helper normalize related keywords =====
  private function normalizeRelated($input): array
  {
    if ($input === null) return [];

    $input = trim((string)$input);
    if ($input === '') return [];

    // nếu user dán JSON array
    if (str_starts_with($input, '[')) {
      $arr = json_decode($input, true);
      if (is_array($arr)) {
        $arr = array_map(fn($x)=>trim((string)$x), $arr);
        $arr = array_values(array_unique(array_filter($arr)));
        return $arr;
      }
    }

    // mặc định: tách theo xuống dòng hoặc dấu phẩy
    $input = str_replace(["\r\n","\r"], "\n", $input);
    $parts = preg_split('/[\n,]+/', $input);

    $parts = array_map(fn($x)=>trim((string)$x), $parts);
    $parts = array_values(array_unique(array_filter($parts)));

    return $parts;
  }
}