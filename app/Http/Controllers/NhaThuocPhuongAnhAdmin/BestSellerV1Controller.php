<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\BestSellerV1;
use App\Models\ProductV1;
use Illuminate\Http\Request;

class BestSellerV1Controller extends Controller
{
    public function index(Request $request)
    {
        $q = BestSellerV1::query()->orderBy('sort_order')->orderBy('id','desc');

        $listData = $q->paginate(20);

        // load product info
        $productIds = $listData->pluck('product_id')->all();
        $productsMap = [];
        if (!empty($productIds)) {
            $productsMap = ProductV1::whereIn('id', $productIds)->get()->keyBy('id');
        }

        return view('admin.catalog_v1.best_sellers.index', compact('listData','productsMap'));
    }

    // Thêm 1 record thủ công (optional)
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        BestSellerV1::updateOrCreate(
            ['product_id' => $request->product_id],
            [
                'sale_price' => $request->sale_price,
                'unit' => $request->unit,
                'sort_order' => $request->sort_order ?? 0,
                'status' => $request->status ?? 1,
            ]
        );

        return redirect()->back()->with('success','Thêm sản phẩm bán chạy thành công');
    }

    public function update(Request $request, $id)
    {
        $row = BestSellerV1::findOrFail($id);

        $row->update([
            'sale_price' => $request->sale_price,
            'unit' => $request->unit,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success','Cập nhật sản phẩm bán chạy thành công');
    }

    public function destroy($id)
    {
        BestSellerV1::where('id', $id)->delete();
        return redirect()->back()->with('success','Xóa sản phẩm bán chạy thành công');
    }

    // Trang chọn sản phẩm từ product_v1 để thêm vào best seller
    public function attachPage(Request $request)
    {
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

        $exists = BestSellerV1::pluck('product_id')->all();
        $existMap = array_fill_keys($exists, true);

        return view('admin.catalog_v1.best_sellers.attach', compact('listData','existMap'));
    }

    // Bulk add selected (only checked)
    public function attachStore(Request $request)
    {
        $productIds = $request->get('product_ids', []);
        $data = $request->get('items', []); // items[product_id][sale_price|unit|sort_order]

        if (!is_array($productIds) || count($productIds) === 0) {
            return redirect()->back()->with('error','Vui lòng chọn ít nhất 1 sản phẩm.');
        }

        $created = 0;
        $updated = 0;

        foreach ($productIds as $pid) {
            $pid = (int)$pid;
            $salePrice = $data[$pid]['sale_price'] ?? null;
            $unit = $data[$pid]['unit'] ?? null;
            $sort = $data[$pid]['sort_order'] ?? 0;

            // cho phép null nhưng thực tế nên nhập giá + unit
            if ($salePrice === null || $unit === null || $unit === '') continue;

            $row = BestSellerV1::where('product_id', $pid)->first();
            if ($row) {
                $row->update([
                    'sale_price' => $salePrice,
                    'unit' => $unit,
                    'sort_order' => (int)$sort,
                    'status' => 1,
                ]);
                $updated++;
            } else {
                BestSellerV1::create([
                    'product_id' => $pid,
                    'sale_price' => $salePrice,
                    'unit' => $unit,
                    'sort_order' => (int)$sort,
                    'status' => 1,
                ]);
                $created++;
            }
        }

        return redirect()->back()->with('success',"Đã thêm {$created} sản phẩm, cập nhật {$updated} sản phẩm bán chạy.");
    }
}