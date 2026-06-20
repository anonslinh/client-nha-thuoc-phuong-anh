<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\CategoryKiotSyncV1;
use App\Models\CategoryV1;
use App\Models\ImageProductV1;
use App\Models\MainCategoryV1;
use App\Models\PersonalAccessTokens;
use App\Models\ProductV1;
use App\Services\KiotVietService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CategoryV1Controller extends Controller
{
    public function index(Request $request)
    {
        $q = CategoryV1::query()
            ->orderBy('sort_order')
            ->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where('name', 'like', "%{$key}%");
        }

        if ($request->filled('id_main_category_v1')) {
            $q->where('id_main_category_v1', $request->id_main_category_v1);
        }

        $listData = $q->paginate(20);

        $mainCategories = MainCategoryV1::query()
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->get();

        $productCountMap = [];
        $syncCountMap = [];
        $ids = $listData->pluck('id')->all();

        if (!empty($ids)) {
            $productCountMap = ProductV1::query()
                ->selectRaw('id_category, COUNT(*) as c')
                ->whereIn('id_category', $ids)
                ->groupBy('id_category')
                ->pluck('c', 'id_category')
                ->toArray();

            $syncCountMap = CategoryKiotSyncV1::query()
                ->selectRaw('id_category_v1, COUNT(*) as c')
                ->whereIn('id_category_v1', $ids)
                ->where('status', 1)
                ->groupBy('id_category_v1')
                ->pluck('c', 'id_category_v1')
                ->toArray();
        }

        return view('admin.catalog_v1.categories.index', compact(
            'listData',
            'mainCategories',
            'productCountMap',
            'syncCountMap'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sort_order' => 'required|integer',
        ]);

        $data = [
            'id_main_category_v1' => $request->id_main_category_v1 ?: null,
            'name' => $request->name,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ];

        if ($request->hasFile('img')) {
            $data['img'] = $this->saveUploaded($request->file('img'), 'upload/catalog/categories');
        } else {
            $data['img'] = $request->get('img');
        }

        CategoryV1::create($data);

        return redirect()->back()->with('success', 'Thêm danh mục thành công');
    }

    public function update(Request $request, $id)
    {
        $row = CategoryV1::findOrFail($id);

        $request->validate([
            'sort_order' => 'required|integer',
        ]);

        $data = [
            'id_main_category_v1' => $request->id_main_category_v1 ?: null,
            'name' => $request->name,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ];

        if ($request->hasFile('img')) {
            $data['img'] = $this->saveUploaded($request->file('img'), 'upload/catalog/categories');
        } else {
            if ($request->filled('img')) {
                $data['img'] = $request->get('img');
            }
        }

        $row->update($data);

        return redirect()->back()->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy($id)
    {
        ProductV1::where('id_category', $id)->update([
            'id_category' => null
        ]);

        CategoryKiotSyncV1::where('id_category_v1', $id)->delete();
        CategoryV1::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa danh mục thành công');
    }

    public function products(Request $request, $id)
    {
        $category = CategoryV1::findOrFail($id);

        $q = ProductV1::query()
            ->where('id_category', $id)
            ->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where(function ($qq) use ($key) {
                $qq->where('name', 'like', "%{$key}%")
                    ->orWhere('full_name', 'like', "%{$key}%")
                    ->orWhere('code_product_kiovet', 'like', "%{$key}%");
            });
        }

        $listData = $q->paginate(18);

        $syncMaps = CategoryKiotSyncV1::where('id_category_v1', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.catalog_v1.categories.products', compact('category', 'listData', 'syncMaps'));
    }

    public function attachProductsPage(Request $request, $id)
    {
        $category = CategoryV1::findOrFail($id);

        $q = ProductV1::query()->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where(function ($qq) use ($key) {
                $qq->where('name', 'like', "%{$key}%")
                    ->orWhere('full_name', 'like', "%{$key}%")
                    ->orWhere('code_product_kiovet', 'like', "%{$key}%");
            });
        }

        $listData = $q->paginate(24);

        return view('admin.catalog_v1.categories.attach-products', compact('category', 'listData'));
    }

    public function attachProductsStore(Request $request, $id)
    {
        $category = CategoryV1::findOrFail($id);

        $productIds = $request->get('product_ids', []);

        if (!is_array($productIds) || count($productIds) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm.');
        }

        ProductV1::whereIn('id', $productIds)->update([
            'id_category' => $category->id
        ]);

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào danh mục thành công');
    }

    public function detachProducts(Request $request, $id)
    {
        $category = CategoryV1::findOrFail($id);

        $productIds = $request->get('product_ids', []);

        if (!is_array($productIds) || count($productIds) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm để gỡ.');
        }

        ProductV1::where('id_category', $category->id)
            ->whereIn('id', $productIds)
            ->update([
                'id_category' => null
            ]);

        return redirect()->back()->with('success', 'Đã gỡ sản phẩm khỏi danh mục');
    }

    public function attachKiotPage(Request $request, $id, KiotVietService $kiot)
    {
        $category = CategoryV1::findOrFail($id);

        $headers = $this->getKiotHeaders($request, $kiot);

        $pageSize = 100;
        $page = max((int)$request->get('page', 1), 1);
        $currentItem = ($page - 1) * $pageSize;

        $response = $this->kiotHttp($headers)->get(
            $kiot->urlKiotviet()['url_category'] . http_build_query([
                'includeTotal' => 'true',
                'pageSize' => $pageSize,
                'currentItem' => $currentItem,
                'orderDirection' => 'Desc',
            ])
        );

        $json = $response->json();
        $items = collect($json['data'] ?? []);
        $total = (int)($json['total'] ?? $items->count());

        $listData = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $pageSize,
            $page,
            [
                'path' => url()->current(),
                'query' => $request->query()
            ]
        );

        $selectedMap = CategoryKiotSyncV1::query()
            ->where('id_category_v1', $category->id)
            ->where('status', 1)
            ->pluck('kiot_category_id')
            ->map(fn($item) => (string)$item)
            ->toArray();

        return view('admin.catalog_v1.categories.attach-kiot', compact(
            'category',
            'listData',
            'selectedMap'
        ));
    }

    public function attachKiotStore(Request $request, $id, KiotVietService $kiot)
    {
        $category = CategoryV1::findOrFail($id);

        $selectedKiotCategoryIds = $request->get('kiot_category_ids', []);
        if (!is_array($selectedKiotCategoryIds)) {
            $selectedKiotCategoryIds = [];
        }

        $selectedKiotCategoryIds = collect($selectedKiotCategoryIds)
            ->filter()
            ->map(fn($item) => (string)$item)
            ->unique()
            ->values()
            ->all();

        $headers = $this->getKiotHeaders($request, $kiot);

        // Lấy toàn bộ danh mục Kiot để map tên
        $categoryNamesMap = [];
        $allCategories = $this->kiotHttp($headers)->get(
            $kiot->urlKiotviet()['url_category'] . http_build_query([
                'includeTotal' => 'false',
                'pageSize' => 500,
                'currentItem' => 0,
                'orderDirection' => 'Desc',
            ])
        )->json()['data'] ?? [];

        foreach ($allCategories as $item) {
            $cid = $item['categoryId'] ?? null;
            if ($cid) {
                $categoryNamesMap[(string)$cid] = $item['categoryName'] ?? null;
            }
        }

        // Lấy mapping cũ
        $existingMaps = CategoryKiotSyncV1::query()
            ->where('id_category_v1', $category->id)
            ->get()
            ->keyBy(function ($row) {
                return (string)$row->kiot_category_id;
            });

        // 1) Tắt các mapping cũ không còn được chọn
        if ($existingMaps->count() > 0) {
            foreach ($existingMaps as $kiotCategoryId => $map) {
                if (!in_array((string)$kiotCategoryId, $selectedKiotCategoryIds, true)) {
                    $map->update([
                        'status' => 0,
                    ]);
                }
            }
        }

        // 2) Bật / tạo mới các mapping đang được chọn
        foreach ($selectedKiotCategoryIds as $kiotCategoryId) {
            CategoryKiotSyncV1::updateOrCreate(
                [
                    'id_category_v1' => $category->id,
                    'kiot_category_id' => $kiotCategoryId
                ],
                [
                    'kiot_category_name' => $categoryNamesMap[(string)$kiotCategoryId] ?? null,
                    'status' => 1,
                ]
            );
        }

        // 3) Nếu không chọn gì thì chỉ lưu cấu hình rỗng, không sync
        if (count($selectedKiotCategoryIds) === 0) {
            return redirect()->back()->with(
                'success',
                "Đã cập nhật cấu hình Kiot cho danh mục '{$category->name}'. Hiện tại không còn danh mục Kiot nào được map."
            );
        }

        // 4) Sync lại toàn bộ sản phẩm theo mapping mới
        $result = $this->syncMappedKiotCategories($category, $headers, $kiot, $selectedKiotCategoryIds);

        return redirect()->back()->with(
            'success',
            "Đã lưu cấu hình Kiot và đồng bộ lại cho danh mục '{$category->name}'. Tạo mới: {$result['created']}, cập nhật: {$result['updated']}, bỏ qua: {$result['skipped']}"
        );
    }

    public function syncCategoryKiot(Request $request, $id, KiotVietService $kiot)
    {
        $category = CategoryV1::findOrFail($id);

        $headers = $this->getKiotHeaders($request, $kiot);

        $result = $this->syncMappedKiotCategories($category, $headers, $kiot);

        return redirect()->back()->with(
            'success',
            "Đồng bộ lại KiotViet cho danh mục '{$category->name}' xong. Tạo mới: {$result['created']}, cập nhật: {$result['updated']}, bỏ qua: {$result['skipped']}"
        );
    }

    public function syncAllKiot(Request $request, KiotVietService $kiot)
    {
        $headers = $this->getKiotHeaders($request, $kiot);

        $categories = CategoryV1::query()
            ->whereIn('id', CategoryKiotSyncV1::query()->where('status', 1)->pluck('id_category_v1'))
            ->get();

        $totalCreated = 0;
        $totalUpdated = 0;
        $totalSkipped = 0;
        $totalCategories = 0;

        foreach ($categories as $category) {
            $result = $this->syncMappedKiotCategories($category, $headers, $kiot);
            $totalCreated += $result['created'];
            $totalUpdated += $result['updated'];
            $totalSkipped += $result['skipped'];
            $totalCategories++;
        }

        return redirect()->back()->with(
            'success',
            "Đồng bộ tất cả danh mục Kiot xong. Danh mục xử lý: {$totalCategories}, tạo mới: {$totalCreated}, cập nhật: {$totalUpdated}, bỏ qua: {$totalSkipped}"
        );
    }

    private function syncMappedKiotCategories(CategoryV1 $category, array $headers, KiotVietService $kiot, ?array $onlyKiotCategoryIds = null): array
    {
        $mapsQuery = CategoryKiotSyncV1::query()
            ->where('id_category_v1', $category->id)
            ->where('status', 1);

        if (is_array($onlyKiotCategoryIds) && count($onlyKiotCategoryIds) > 0) {
            $mapsQuery->whereIn('kiot_category_id', $onlyKiotCategoryIds);
        }

        $maps = $mapsQuery->get();

        $created = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($maps as $map) {
            $currentItem = 0;
            $pageSize = 100;

            do {
                $response = $this->kiotHttp($headers)->get(
                    $kiot->urlKiotviet()['url_list_product'] . http_build_query([
                        'includeTotal' => 'false',
                        'pageSize' => $pageSize,
                        'currentItem' => $currentItem,
                        'orderDirection' => 'Desc',
                        'categoryId' => $map->kiot_category_id,
                    ])
                );

                $items = $response->json()['data'] ?? [];

                foreach ($items as $p) {
                    $syncType = $this->upsertKiotProduct($category, $p, $headers, $kiot);

                    if ($syncType === 'created') {
                        $created++;
                    } elseif ($syncType === 'updated') {
                        $updated++;
                    } else {
                        $skipped++;
                    }
                }

                $currentItem += $pageSize;
            } while (count($items) === $pageSize);

            $map->update([
                'last_synced_at' => Carbon::now()
            ]);
        }

        return [
            'created' => $created,
            'updated' => $updated,
            'skipped' => $skipped,
        ];
    }

    private function upsertKiotProduct(CategoryV1 $category, array $p, array $headers, KiotVietService $kiot): string
    {
        $kiotId = $p['id'] ?? null;

        if (!$kiotId) {
            return 'skipped';
        }

        $images = $p['images'] ?? [];
        $avatar = is_array($images) && isset($images[0]) ? $images[0] : null;

        $quantityStock = null;

        $productCode = $p['code'] ?? null;
        if (!empty($productCode)) {
            try {
                $detailResponse = $this->kiotHttp($headers)->get(
                    $kiot->urlKiotviet()['url_detail_product'] . $productCode
                );

                $detailData = $detailResponse->json();

                if (is_array($detailData) && empty($detailData['responseStatus'])) {
                    $quantityStock = $this->extractKiotStockFromDetail($detailData);
                }
            } catch (\Throwable $e) {
                $quantityStock = null;
            }
        }

        $product = ProductV1::where('id_product_kiotviet', $kiotId)->first();

        if ($product) {
            $product->update([
                'id_category' => $category->id,
                'code_product_kiovet' => $p['code'] ?? $product->code_product_kiovet,
                'name' => $p['name'] ?? $product->name,
                'full_name' => $p['fullName'] ?? $product->full_name,
                'img_avatar' => $avatar ?: $product->img_avatar,
                'description' => $p['description'] ?? $product->description,
                'price' => $p['basePrice'] ?? $product->price,
                'quantity_stock' => !is_null($quantityStock) ? $quantityStock : $product->quantity_stock,
                'is_active' => (bool)($p['isActive'] ?? $product->is_active),
                'status' => 1,
            ]);

            if (is_array($images) && count($images) > 0) {
                ImageProductV1::where('id_product_v1', $product->id)->delete();

                foreach ($images as $imgUrl) {
                    ImageProductV1::create([
                        'id_product_v1' => $product->id,
                        'link_img' => $imgUrl,
                        'status' => 1,
                    ]);
                }
            }

            return 'updated';
        }

        $product = ProductV1::create([
            'id_category' => $category->id,
            'id_trade_mark' => null,
            'id_product_kiotviet' => $kiotId,
            'code_product_kiovet' => $p['code'] ?? null,
            'name' => $p['name'] ?? null,
            'full_name' => $p['fullName'] ?? null,
            'img_avatar' => $avatar,
            'description' => $p['description'] ?? null,
            'price' => $p['basePrice'] ?? null,
            'price_sale' => null,
            'quantity_stock' => $quantityStock,
            'is_active' => (bool)($p['isActive'] ?? true),
            'status' => 1,
        ]);

        if (is_array($images)) {
            foreach ($images as $imgUrl) {
                ImageProductV1::create([
                    'id_product_v1' => $product->id,
                    'link_img' => $imgUrl,
                    'status' => 1,
                ]);
            }
        }

        return 'created';
    }

    private function extractKiotStock(array $productData): ?float
    {
        $possibleKeys = [
            'onHand',
            'onHandQuantity',
            'quantity',
            'inventory',
            'stock',
            'baseOnHand',
        ];

        foreach ($possibleKeys as $key) {
            if (isset($productData[$key]) && is_numeric($productData[$key])) {
                return (float)$productData[$key];
            }
        }

        return null;
    }

    private function getKiotHeaders(Request $request, KiotVietService $kiot): array
    {
        $accessTokenCode = $request->get('access_token_code')
            ?: env('KIOTVIET_ACCESS_TOKEN_CODE')
            ?: PersonalAccessTokens::whereNotNull('retailer')->value('access_token_code');

        if (!$accessTokenCode) {
            throw new \Exception('Thiếu KIOTVIET_ACCESS_TOKEN_CODE hoặc chưa có token KiotViet.');
        }

        $token = $kiot->getAccessTokenAllBranches($accessTokenCode);

        return [
            'Retailer' => $token->retailer,
            'Authorization' => 'Bearer ' . $token->access_token,
            'Content-Type' => 'application/json',
        ];
    }

    private function kiotHttp(array $headers)
    {
        $request = Http::withHeaders($headers);

        $verifySsl = filter_var(
            env('KIOTVIET_SSL_VERIFY', !app()->environment('local')),
            FILTER_VALIDATE_BOOLEAN
        );

        return $verifySsl ? $request : $request->withoutVerifying();
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
    private function extractKiotStockFromDetail(array $detailData): ?float
    {
        $inventories = $detailData['inventories'] ?? null;

        if (!is_array($inventories) || count($inventories) === 0) {
            return null;
        }

        $total = 0;

        foreach ($inventories as $inventory) {
            $onHand = $inventory['onHand'] ?? null;

            if (is_numeric($onHand)) {
                $total += (float)$onHand;
            }
        }

        return $total;
    }
}
