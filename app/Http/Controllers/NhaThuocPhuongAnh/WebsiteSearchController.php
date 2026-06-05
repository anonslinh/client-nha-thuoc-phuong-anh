<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use App\Models\CategoryV1;
use App\Models\TrademarkV1;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebsiteSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->get('q', ''));
        $sort = $request->get('sort', 'relevance');
        $hasQuery = $query !== '';

        $matchedCategories = collect();
        $matchedTrademarks = collect();
        $popularCategories = collect();
        $popularTrademarks = collect();

        if ($hasQuery) {
            $matchedCategories = $this->getMatchedCategories($query);
            $matchedTrademarks = $this->getMatchedTrademarks($query);
            $products = $this->searchProducts($query, $sort);
        } else {
            $products = $this->emptyPaginator($request);
            $popularCategories = $this->getPopularCategories();
            $popularTrademarks = $this->getPopularTrademarks();
        }

        $seoTitle = $hasQuery
            ? 'Kết quả tìm kiếm "' . $query . '" | Nhà thuốc Phương Anh'
            : 'Tìm kiếm sản phẩm | Nhà thuốc Phương Anh';

        $seoDescription = $hasQuery
            ? 'Kết quả tìm kiếm cho từ khóa "' . $query . '" tại Nhà thuốc Phương Anh.'
            : 'Tìm kiếm sản phẩm, danh mục và thương hiệu tại Nhà thuốc Phương Anh.';

        return view('website.search_key.index', compact(
            'query',
            'sort',
            'hasQuery',
            'products',
            'matchedCategories',
            'matchedTrademarks',
            'popularCategories',
            'popularTrademarks',
            'seoTitle',
            'seoDescription'
        ));
    }

    private function searchProducts(string $query, string $sort): LengthAwarePaginator
    {
        $like = '%' . $query . '%';
        $prefix = $query . '%';

        $productQuery = DB::table('product_v1 as p')
            ->leftJoin('category_v1 as c', 'c.id', '=', 'p.id_category')
            ->leftJoin('trademark_v1 as t', 't.id', '=', 'p.id_trade_mark')
            ->where('p.status', 1)
            ->where('p.is_active', 1)
            ->where(function ($q) use ($like) {
                $q->where('p.name', 'like', $like)
                    ->orWhere('p.full_name', 'like', $like)
                    ->orWhere('p.code_product_kiovet', 'like', $like)
                    ->orWhere('p.description', 'like', $like)
                    ->orWhere('c.name', 'like', $like)
                    ->orWhere('t.name', 'like', $like);
            })
            ->select([
                'p.id',
                'p.id_category',
                'p.id_trade_mark',
                'p.name',
                'p.full_name',
                'p.img_avatar',
                'p.description',
                'p.price',
                'p.price_sale',
                'p.code_product_kiovet',
                'c.name as category_name',
                't.name as trademark_name',
            ]);

        if ($sort === 'price_asc') {
            $productQuery->orderByRaw('CASE WHEN p.price_sale IS NULL OR p.price_sale = 0 THEN p.price ELSE p.price_sale END ASC')
                ->orderBy('p.id', 'desc');
        } elseif ($sort === 'price_desc') {
            $productQuery->orderByRaw('CASE WHEN p.price_sale IS NULL OR p.price_sale = 0 THEN p.price ELSE p.price_sale END DESC')
                ->orderBy('p.id', 'desc');
        } elseif ($sort === 'newest') {
            $productQuery->orderBy('p.id', 'desc');
        } else {
            $productQuery->orderByRaw(
                "CASE
                    WHEN p.full_name = ? OR p.name = ? THEN 100
                    WHEN p.full_name LIKE ? OR p.name LIKE ? THEN 90
                    WHEN p.full_name LIKE ? OR p.name LIKE ? THEN 80
                    WHEN p.code_product_kiovet LIKE ? THEN 70
                    WHEN t.name LIKE ? THEN 55
                    WHEN c.name LIKE ? THEN 50
                    WHEN p.description LIKE ? THEN 20
                    ELSE 0
                END DESC",
                [
                    $query, $query,
                    $prefix, $prefix,
                    $like, $like,
                    $like,
                    $like,
                    $like,
                    $like,
                ]
            )->orderBy('p.id', 'desc');
        }

        $products = $productQuery
            ->paginate(20)
            ->withQueryString();

        $products->setCollection(
            $products->getCollection()->map(function ($product) {
                $displayPrice = (float) ($product->price_sale ?: $product->price ?: 0);
                $originalPrice = (float) ($product->price ?: 0);

                $product->image_url = $this->resolveImageUrl($product->img_avatar, 'images/no-image.png');
                $product->display_name = $product->full_name ?: $product->name;
                $product->short_description = Str::limit(trim(strip_tags((string) $product->description)), 110);
                $product->display_price = $displayPrice;
                $product->original_price = $originalPrice > $displayPrice ? $originalPrice : null;
                $product->category_url = !empty($product->id_category)
                    ? route('website.category.show', $product->id_category)
                    : 'javascript:void(0)';
                $product->trademark_url = !empty($product->id_trade_mark)
                    ? route('website.trademark.show', $product->id_trade_mark)
                    : 'javascript:void(0)';
                $product->url = route('website.product-v1.show', $product->id);

                return $product;
            })
        );

        return $products;
    }

    private function getMatchedCategories(string $query)
    {
        $like = '%' . $query . '%';
        $prefix = $query . '%';

        return CategoryV1::query()
            ->from('category_v1 as c')
            ->leftJoin('product_v1 as p', function ($join) {
                $join->on('p.id_category', '=', 'c.id')
                    ->where('p.status', 1)
                    ->where('p.is_active', 1);
            })
            ->where('c.status', 1)
            ->where(function ($q) use ($like) {
                $q->where('c.name', 'like', $like)
                    ->orWhere('c.description', 'like', $like);
            })
            ->groupBy('c.id', 'c.name', 'c.description', 'c.img', 'c.sort_order')
            ->orderByRaw(
                "CASE
                    WHEN c.name = ? THEN 100
                    WHEN c.name LIKE ? THEN 80
                    WHEN c.name LIKE ? THEN 60
                    ELSE 0
                END DESC",
                [$query, $prefix, $like]
            )
            ->orderByRaw('COUNT(p.id) DESC')
            ->limit(8)
            ->select([
                'c.id',
                'c.name',
                'c.description',
                'c.img',
                DB::raw('COUNT(p.id) as product_count'),
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'image' => $this->resolveImageUrl($item->img),
                    'product_count' => (int) $item->product_count,
                    'url' => route('website.category.show', $item->id),
                ];
            });
    }

    private function getMatchedTrademarks(string $query)
    {
        $like = '%' . $query . '%';
        $prefix = $query . '%';

        return TrademarkV1::query()
            ->from('trademark_v1 as t')
            ->leftJoin('product_v1 as p', function ($join) {
                $join->on('p.id_trade_mark', '=', 't.id')
                    ->where('p.status', 1)
                    ->where('p.is_active', 1);
            })
            ->where('t.status', 1)
            ->where(function ($q) use ($like) {
                $q->where('t.name', 'like', $like)
                    ->orWhere('t.description', 'like', $like)
                    ->orWhere('t.note', 'like', $like);
            })
            ->groupBy('t.id', 't.name', 't.description', 't.img', 't.sort_order')
            ->orderByRaw(
                "CASE
                    WHEN t.name = ? THEN 100
                    WHEN t.name LIKE ? THEN 80
                    WHEN t.name LIKE ? THEN 60
                    ELSE 0
                END DESC",
                [$query, $prefix, $like]
            )
            ->orderByRaw('COUNT(p.id) DESC')
            ->limit(8)
            ->select([
                't.id',
                't.name',
                't.description',
                't.img',
                DB::raw('COUNT(p.id) as product_count'),
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'image' => $this->resolveImageUrl($item->img),
                    'product_count' => (int) $item->product_count,
                    'url' => route('website.trademark.show', $item->id),
                ];
            });
    }

    private function getPopularCategories()
    {
        return CategoryV1::query()
            ->from('category_v1 as c')
            ->leftJoin('product_v1 as p', function ($join) {
                $join->on('p.id_category', '=', 'c.id')
                    ->where('p.status', 1)
                    ->where('p.is_active', 1);
            })
            ->where('c.status', 1)
            ->groupBy('c.id', 'c.name', 'c.description', 'c.img', 'c.sort_order')
            ->orderByRaw('COUNT(p.id) DESC')
            ->orderByRaw('CASE WHEN c.sort_order IS NULL THEN 1 ELSE 0 END')
            ->orderBy('c.sort_order', 'asc')
            ->limit(8)
            ->select([
                'c.id',
                'c.name',
                'c.description',
                'c.img',
                DB::raw('COUNT(p.id) as product_count'),
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => $this->resolveImageUrl($item->img),
                    'product_count' => (int) $item->product_count,
                    'url' => route('website.category.show', $item->id),
                ];
            });
    }

    private function getPopularTrademarks()
    {
        return TrademarkV1::query()
            ->from('trademark_v1 as t')
            ->leftJoin('product_v1 as p', function ($join) {
                $join->on('p.id_trade_mark', '=', 't.id')
                    ->where('p.status', 1)
                    ->where('p.is_active', 1);
            })
            ->where('t.status', 1)
            ->groupBy('t.id', 't.name', 't.description', 't.img', 't.sort_order')
            ->orderByRaw('COUNT(p.id) DESC')
            ->orderByRaw('CASE WHEN t.sort_order IS NULL THEN 1 ELSE 0 END')
            ->orderBy('t.sort_order', 'asc')
            ->limit(8)
            ->select([
                't.id',
                't.name',
                't.description',
                't.img',
                DB::raw('COUNT(p.id) as product_count'),
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => $this->resolveImageUrl($item->img),
                    'product_count' => (int) $item->product_count,
                    'url' => route('website.trademark.show', $item->id),
                ];
            });
    }

    private function emptyPaginator(Request $request): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            collect(),
            0,
            20,
            LengthAwarePaginator::resolveCurrentPage(),
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }

    private function resolveImageUrl($path, $default = null)
    {
        if (!empty($path)) {
            if (Str::startsWith($path, ['http://', 'https://', '//'])) {
                return $path;
            }

            return asset(ltrim($path, '/'));
        }

        return $default ? asset(ltrim($default, '/')) : asset('images/no-image.png');
    }
}