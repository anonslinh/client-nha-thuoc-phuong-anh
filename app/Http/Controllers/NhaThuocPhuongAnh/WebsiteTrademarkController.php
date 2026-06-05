<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebsiteTrademarkController extends Controller
{
    public function show(Request $request, $id)
    {
        $trademark = DB::table('trademark_v1 as t')
            ->leftJoin('favorite_trademarks_v1 as ft', function ($join) {
                $join->on('ft.trademark_id', '=', 't.id')
                    ->where('ft.status', 1);
            })
            ->where('t.status', 1)
            ->where('t.id', $id)
            ->select([
                't.id',
                't.name',
                't.description',
                't.note',
                't.img',
                't.banner',
                't.sort_order',
                'ft.featured_image',
                'ft.short_desc',
                'ft.sort_order as favorite_sort_order',
            ])
            ->first();

        abort_if(!$trademark, 404);

        $search = trim((string) $request->get('q', ''));
        $sort = $request->get('sort', 'newest');
        $minPrice = $request->filled('min_price') ? (float) $request->get('min_price') : null;
        $maxPrice = $request->filled('max_price') ? (float) $request->get('max_price') : null;
        $viewMode = $request->get('view', '4');

        $productQuery = DB::table('product_v1 as p')
            ->where('p.status', 1)
            ->where('p.is_active', 1)
            ->where('p.id_trade_mark', $trademark->id);

        if (!empty($search)) {
            $productQuery->where(function ($q) use ($search) {
                $q->where('p.name', 'like', '%' . $search . '%')
                    ->orWhere('p.full_name', 'like', '%' . $search . '%')
                    ->orWhere('p.code_product_kiovet', 'like', '%' . $search . '%');
            });
        }

        if ($minPrice !== null) {
            $productQuery->whereRaw(
                '(CASE WHEN p.price_sale IS NULL OR p.price_sale = 0 THEN p.price ELSE p.price_sale END) >= ?',
                [$minPrice]
            );
        }

        if ($maxPrice !== null) {
            $productQuery->whereRaw(
                '(CASE WHEN p.price_sale IS NULL OR p.price_sale = 0 THEN p.price ELSE p.price_sale END) <= ?',
                [$maxPrice]
            );
        }

        switch ($sort) {
            case 'price_asc':
                $productQuery->orderByRaw('CASE WHEN p.price_sale IS NULL OR p.price_sale = 0 THEN p.price ELSE p.price_sale END ASC');
                break;

            case 'price_desc':
                $productQuery->orderByRaw('CASE WHEN p.price_sale IS NULL OR p.price_sale = 0 THEN p.price ELSE p.price_sale END DESC');
                break;

            case 'name_asc':
                $productQuery->orderBy('p.name', 'asc');
                break;

            case 'name_desc':
                $productQuery->orderBy('p.name', 'desc');
                break;

            case 'newest':
            default:
                $productQuery->orderBy('p.id', 'desc');
                break;
        }

        $products = $productQuery
            ->select([
                'p.id',
                'p.id_category',
                'p.name',
                'p.full_name',
                'p.img_avatar',
                'p.description',
                'p.price',
                'p.price_sale',
                'p.code_product_kiovet',
            ])
            ->paginate(16)
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
                $product->url = 'javascript:void(0)'; // thay bằng route chi tiết sản phẩm nếu bạn đã có

                return $product;
            })
        );

        $topCategoriesInBrand = DB::table('product_v1 as p')
            ->join('category_v1 as c', 'c.id', '=', 'p.id_category')
            ->where('p.status', 1)
            ->where('p.is_active', 1)
            ->where('p.id_trade_mark', $trademark->id)
            ->where('c.status', 1)
            ->groupBy('c.id', 'c.name')
            ->orderByRaw('COUNT(p.id) DESC')
            ->limit(6)
            ->select([
                'c.id',
                'c.name',
                DB::raw('COUNT(p.id) as total_products'),
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'total_products' => (int) $item->total_products,
                    'url' => route('website.category.show', $item->id),
                ];
            });

        $relatedTrademarks = DB::table('favorite_trademarks_v1 as ft')
            ->join('trademark_v1 as t', 't.id', '=', 'ft.trademark_id')
            ->where('ft.status', 1)
            ->where('t.status', 1)
            ->where('t.id', '<>', $trademark->id)
            ->orderByRaw('CASE WHEN ft.sort_order IS NULL THEN 1 ELSE 0 END')
            ->orderBy('ft.sort_order', 'asc')
            ->orderBy('ft.id', 'asc')
            ->limit(8)
            ->select([
                't.id',
                't.name',
                't.img',
                'ft.short_desc',
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => $this->resolveImageUrl($item->img, 'images/no-image.png'),
                    'short_desc' => $item->short_desc,
                    'url' => route('website.trademark.show', $item->id),
                ];
            });

        $totalProducts = DB::table('product_v1')
            ->where('status', 1)
            ->where('is_active', 1)
            ->where('id_trade_mark', $trademark->id)
            ->count();

        $trademark->logo_url = $this->resolveImageUrl($trademark->img, 'images/no-image.png');
        $trademark->banner_url = $this->resolveImageUrl(
            $trademark->banner ?: $trademark->featured_image,
            'images/no-image.png'
        );
        $trademark->featured_image_url = $this->resolveImageUrl(
            $trademark->featured_image ?: $trademark->banner,
            'images/no-image.png'
        );

        $seoTitle = $trademark->name . ' | Thương hiệu tại Nhà thuốc Phương Anh';
        $seoDescription = !empty($trademark->short_desc)
            ? Str::limit(strip_tags($trademark->short_desc), 160)
            : (!empty($trademark->description)
                ? Str::limit(strip_tags($trademark->description), 160)
                : 'Khám phá thương hiệu ' . $trademark->name . ' cùng danh sách sản phẩm nổi bật tại Nhà thuốc Phương Anh.');
        $seoImage = $trademark->banner_url;
        $canonicalUrl = route('website.trademark.show', $trademark->id);

        return view('website.trademark.show', compact(
            'trademark',
            'products',
            'topCategoriesInBrand',
            'relatedTrademarks',
            'totalProducts',
            'search',
            'sort',
            'minPrice',
            'maxPrice',
            'viewMode',
            'seoTitle',
            'seoDescription',
            'seoImage',
            'canonicalUrl'
        ));
    }

    private function resolveImageUrl($path, $default = null)
    {
        if (!empty($path)) {
            if (Str::startsWith($path, ['http://', 'https://', '//'])) {
                return $path;
            }

            return asset(ltrim($path, '/'));
        }

        return $default ? asset(ltrim($default, '/')) : '';
    }
}