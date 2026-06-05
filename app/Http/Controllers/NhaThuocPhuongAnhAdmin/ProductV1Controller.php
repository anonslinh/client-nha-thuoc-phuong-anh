<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\AccountBranches;
use App\Models\CategoryV1;
use App\Models\ImageProductV1;
use App\Models\ProductV1;
use App\Models\TrademarkV1;
use App\Services\KiotVietService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ProductV1Controller extends Controller
{
    const PAGE_SIZE = 50;

    public function index(Request $request)
    {
        $q = ProductV1::query()->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);
            $q->where(function ($qq) use ($key) {
                $qq->where('name', 'like', "%{$key}%")
                    ->orWhere('full_name', 'like', "%{$key}%")
                    ->orWhere('code_product_kiovet', 'like', "%{$key}%");
            });
        }

        $listData = $q->paginate(20);

        $categories = CategoryV1::orderBy('sort_order')->get();
        $trademarks = TrademarkV1::orderBy('sort_order')->get();

        return view('admin.catalog_v1.products.index', compact('listData', 'categories', 'trademarks'));
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'id_category', 'id_trade_mark', 'name', 'full_name', 'description',
            'price', 'price_sale', 'is_active', 'status'
        ]);

        if ($request->hasFile('img_avatar')) {
            $data['img_avatar'] = $this->saveUploaded($request->file('img_avatar'), 'upload/products');
        }

        $product = ProductV1::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $this->saveUploaded($file, 'upload/products/gallery');
                ImageProductV1::create([
                    'id_product_v1' => $product->id,
                    'link_img' => $path,
                    'status' => 1
                ]);
            }
        }

        return redirect()->back()->with('success', 'Thêm mới sản phẩm thành công');
    }

    public function update(Request $request, $id)
    {
        $product = ProductV1::findOrFail($id);

        $data = $request->only([
            'id_category', 'id_trade_mark', 'name', 'full_name', 'description',
            'price', 'price_sale', 'is_active', 'status'
        ]);

        if ($request->hasFile('img_avatar')) {
            $data['img_avatar'] = $this->saveUploaded($request->file('img_avatar'), 'upload/products');
        }

        $product->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $this->saveUploaded($file, 'upload/products/gallery');
                ImageProductV1::create([
                    'id_product_v1' => $product->id,
                    'link_img' => $path,
                    'status' => 1
                ]);
            }
        }

        return redirect()->back()->with('success', 'Cập nhật sản phẩm thành công');
    }

    public function destroy($id)
    {
        ProductV1::where('id', $id)->delete();
        ImageProductV1::where('id_product_v1', $id)->delete();
        return redirect()->back()->with('success', 'Xóa sản phẩm thành công');
    }

    /**
     * Trang list sản phẩm KiotViet để chọn import
     * - Categories API trả: categoryId/categoryName
     * - Filter product theo categoryId
     */
    public function kiotviet(Request $request, KiotVietService $kiot)
    {
        // 1) Load accounts
        $accounts = AccountBranches::query()
            ->select(['id', 'code', 'retailer'])
            ->orderBy('id', 'desc')
            ->get();

        $account_code = $request->get('account_code') ?: optional($accounts->first())->code;

        if (!$account_code) {
            return redirect()->back()->with('error', 'Chưa có AccountBranches để lấy token KiotViet.');
        }

        // 2) Get token
        $token = $kiot->getAccessTokenAllBranches($account_code);

        if (!is_object($token) || empty($token->access_token) || empty($token->retailer)) {
            return redirect()->back()->with('error', 'Không lấy được token KiotViet. Kiểm tra AccountBranches/PersonalAccessTokens.');
        }

        $headers = [
            'Retailer' => $token->retailer,
            'Authorization' => 'Bearer ' . $token->access_token,
            'Content-Type' => 'application/json',
        ];

        // 3) Filters
        $page = max((int)$request->get('page', 1), 1);

        // categoryId đúng theo API categories của Kiot
        $categoryId = $request->get('categoryId');

        // trademark filter param: tradeMarkId (Kiot dùng tradeMarkId)
        $tradeMarkId = $request->get('tradeMarkId');

        $name = trim((string)$request->get('name', ''));

        // trạng thái đồng bộ: all|synced|unsynced
        $sync_status = $request->get('sync_status', 'unsynced');

        // 4) Load categories từ Kiot (loop để lấy đủ nếu nhiều page)
        $categories = $this->fetchAllKiot($headers, $kiot->urlKiotviet()['url_category'], 100, function ($row) {
            return isset($row['categoryId']) && isset($row['categoryName']);
        });

        // 5) Load trademarks từ Kiot (loop)
        $trademarks = $this->fetchAllKiot($headers, $kiot->urlKiotviet()['url_trademark'], 100, function ($row) {
            return isset($row['tradeMarkId']) || isset($row['id']);
        });

        // 6) Products from Kiot (pageSize=50)
        $params = [
            'includeTotal' => 'true',
            'pageSize' => self::PAGE_SIZE,
            'currentItem' => ($page - 1) * self::PAGE_SIZE,
            'orderDirection' => 'Desc',
        ];
        if (!empty($categoryId)) $params['categoryId'] = $categoryId;
        if (!empty($tradeMarkId)) $params['tradeMarkId'] = $tradeMarkId;
        if ($name !== '') $params['name'] = $name;

        $url = $kiot->urlKiotviet()['url_list_product'] . http_build_query($params);
        $res = Http::withHeaders($headers)->get($url);
        $json = $res->json();

        $items = $json['data'] ?? [];
        $total = (int)($json['total'] ?? 0);

        // 7) map synced
        $kiotIds = collect($items)->pluck('id')->filter()->values()->all();
        $synced = ProductV1::whereIn('id_product_kiotviet', $kiotIds)->pluck('id_product_kiotviet')->flip();

        $items = collect($items)->map(function ($p) use ($synced) {
            $p['_synced'] = isset($synced[$p['id'] ?? -1]);
            return $p;
        });

        if ($sync_status === 'synced') $items = $items->where('_synced', true)->values();
        if ($sync_status === 'unsynced') $items = $items->where('_synced', false)->values();

        // paginator manual
        $listData = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            self::PAGE_SIZE,
            $page,
            ['path' => url()->current(), 'query' => $request->query()]
        );

        return view('admin.catalog_v1.products.kiotviet', compact(
            'accounts',
            'account_code',
            'listData',
            'total',
            'categories',
            'trademarks',
            'sync_status'
        ));
    }
    /**
     * Detail Product v1
     */
    public function show($id)
    {
        $product = ProductV1::findOrFail($id);

        $categories = CategoryV1::orderBy('sort_order')->get();
        $trademarks = TrademarkV1::orderBy('sort_order')->get();
        $gallery = ImageProductV1::where('id_product_v1', $id)->orderBy('id', 'desc')->get();

        return view('admin.catalog_v1.products.show', compact(
            'product',
            'categories',
            'trademarks',
            'gallery'
        ));
    }
    /**
     * Import selected Kiot products => product_v1 + images_product_v1
     */
    public function kiotvietImport(Request $request, KiotVietService $kiot)
    {
        $account_code = $request->get('account_code');
        $ids = $request->get('kiot_ids', []);

        if (!$account_code) {
            return redirect()->back()->with('error', 'Thiếu account_code.');
        }
        if (!is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm.');
        }

        // ✅ Chỉ lấy đúng IDs user tick
        $selectedIds = array_values(array_unique(array_filter(array_map(function ($v) {
            return is_numeric($v) ? (int)$v : null;
        }, $ids))));

        if (count($selectedIds) === 0) {
            return redirect()->back()->with('error', 'Danh sách sản phẩm chọn không hợp lệ.');
        }

        $token = $kiot->getAccessTokenAllBranches($account_code);
        if (!is_object($token) || empty($token->access_token) || empty($token->retailer)) {
            return redirect()->back()->with('error', 'Không lấy được token KiotViet. Kiểm tra AccountBranches/PersonalAccessTokens.');
        }

        $headers = [
            'Retailer' => $token->retailer,
            'Authorization' => 'Bearer ' . $token->access_token,
            'Content-Type' => 'application/json',
        ];

        // ====== 1) FAST PATH: thử gọi ids=... (nếu Kiot support)
        $found = [];
        $remaining = array_fill_keys($selectedIds, true);

        $params = [
            'includeTotal' => 'false',
            'pageSize' => 100,
            'currentItem' => 0,
            'ids' => implode(',', $selectedIds),
        ];
        $url = $kiot->urlKiotviet()['url_list_product'] . http_build_query($params);
        $res = Http::withHeaders($headers)->get($url);
        $items = $res->json()['data'] ?? [];

        foreach ($items as $p) {
            $pid = $p['id'] ?? null;
            if ($pid !== null && isset($remaining[(int)$pid])) {
                $found[(int)$pid] = $p;
                unset($remaining[(int)$pid]);
            }
        }

        // ====== 2) FALLBACK: nếu Kiot ignore ids -> quét page cho đến khi tìm đủ
        if (!empty($remaining)) {
            $pageSize = 100;
            $currentItem = 0;
            $totalGuard = null;

            while (!empty($remaining)) {
                $params2 = [
                    'includeTotal' => 'true',
                    'pageSize' => $pageSize,
                    'currentItem' => $currentItem,
                    'orderDirection' => 'Desc',
                ];

                $url2 = $kiot->urlKiotviet()['url_list_product'] . http_build_query($params2);
                $res2 = Http::withHeaders($headers)->get($url2);
                $json2 = $res2->json();

                $rows = $json2['data'] ?? [];
                if (!is_array($rows) || count($rows) === 0) break;

                if ($totalGuard === null && isset($json2['total'])) {
                    $totalGuard = (int)$json2['total'];
                }

                foreach ($rows as $p) {
                    $pid = $p['id'] ?? null;
                    if ($pid !== null && isset($remaining[(int)$pid])) {
                        $found[(int)$pid] = $p;
                        unset($remaining[(int)$pid]);
                    }
                }

                $currentItem += $pageSize;

                if ($totalGuard !== null && $currentItem >= $totalGuard) break;
                if ($currentItem > 20000) break; // safety guard
            }
        }

        if (empty($found)) {
            return redirect()->back()->with('error', 'Không tìm thấy dữ liệu sản phẩm từ KiotViet theo danh sách đã chọn.');
        }

        $created = 0;
        $skipped = 0;

        // ✅ Import đúng những sản phẩm user tick (theo $found)
        foreach ($selectedIds as $idKiot) {
            if (!isset($found[$idKiot])) continue;
            $p = $found[$idKiot];

            if (ProductV1::where('id_product_kiotviet', $idKiot)->exists()) {
                $skipped++;
                continue;
            }

            $images = $p['images'] ?? [];
            $avatar = (is_array($images) && isset($images[0])) ? $images[0] : null;

            $product = ProductV1::create([
                'id_category' => null,
                'id_trade_mark' => null,

                'id_product_kiotviet' => $idKiot,
                'code_product_kiovet' => $p['code'] ?? null,

                'name' => $p['name'] ?? null,
                'full_name' => $p['fullName'] ?? null,
                'img_avatar' => $avatar,
                'description' => $p['description'] ?? null,

                'price' => $p['basePrice'] ?? null,
                'price_sale' => null,

                'is_active' => isset($p['isActive']) ? (bool)$p['isActive'] : null,
                'status' => 1,
            ]);

            if (is_array($images)) {
                foreach ($images as $imgUrl) {
                    ImageProductV1::create([
                        'id_product_v1' => $product->id,
                        'link_img' => $imgUrl,
                        'status' => 1
                    ]);
                }
            }

            $created++;
        }

        // Nếu có id chọn nhưng không tìm thấy (hiếm), báo để biết
        if (!empty($remaining)) {
            $miss = implode(',', array_keys($remaining));
            return redirect()->back()->with('error', "Đã import {$created} SP. Một số ID không tìm thấy từ Kiot: {$miss}");
        }

        return redirect()->back()->with('success', "Import KiotViet xong: {$created} sản phẩm. Bỏ qua: {$skipped} (đã tồn tại).");
    }

    private function saveUploaded($file, $folder)
    {
        $folderPath = public_path($folder);
        if (!is_dir($folderPath)) {
            @mkdir($folderPath, 0777, true);
        }
        $name = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($folderPath, $name);
        return $folder . '/' . $name;
    }

    /**
     * Helper: fetch all pages for Kiot list endpoints that use:
     * - pageSize
     * - currentItem (offset)
     */
    private function fetchAllKiot(array $headers, string $baseUrl, int $pageSize = 100, callable $validRow = null): array
    {
        $currentItem = 0;
        $all = [];

        while (true) {
            $url = $baseUrl . http_build_query([
                'includeTotal' => 'true',
                'pageSize' => $pageSize,
                'currentItem' => $currentItem,
                'orderDirection' => 'Desc',
            ]);

            $res = Http::withHeaders($headers)->get($url);
            $json = $res->json();
            $rows = $json['data'] ?? [];

            if (!is_array($rows) || count($rows) === 0) {
                break;
            }

            foreach ($rows as $row) {
                if ($validRow && !$validRow($row)) continue;
                $all[] = $row;
            }

            $currentItem += $pageSize;

            // tránh vòng lặp vô hạn nếu API trả total nhỏ
            if (isset($json['total']) && $currentItem >= (int)$json['total']) {
                break;
            }
        }

        return $all;
    }
}