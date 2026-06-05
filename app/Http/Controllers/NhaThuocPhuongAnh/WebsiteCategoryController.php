<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use App\Models\CategoryV1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebsiteCategoryController extends Controller
{
    public function show(Request $request, $id)
    {
        $category = CategoryV1::query()
            ->where('status', 1)
            ->findOrFail($id);

        $search = trim((string) $request->get('q', ''));
        $sort = $request->get('sort', 'newest');

        $productQuery = DB::table('product_v1 as p')
            ->where('p.status', 1)
            ->where('p.is_active', 1)
            ->where('p.id_category', $category->id);

        if (!empty($search)) {
            $productQuery->where(function ($q) use ($search) {
                $q->where('p.name', 'like', '%' . $search . '%')
                    ->orWhere('p.full_name', 'like', '%' . $search . '%')
                    ->orWhere('p.code_product_kiovet', 'like', '%' . $search . '%');
            });
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

                // nếu sau này có route chi tiết sản phẩm thì thay vào đây
                $product->url = 'javascript:void(0)';

                return $product;
            })
        );

        $relatedCategories = CategoryV1::query()
            ->where('status', 1)
            ->where('id', '<>', $category->id)
            ->when(!empty($category->id_main_category_v1), function ($q) use ($category) {
                $q->where('id_main_category_v1', $category->id_main_category_v1);
            })
            ->orderByRaw('CASE WHEN sort_order IS NULL THEN 1 ELSE 0 END')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->limit(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => $this->resolveImageUrl($item->img),
                    'url' => route('website.category.show', $item->id),
                ];
            });

        $category->image_url = $this->resolveImageUrl($category->img, 'images/no-image.png');

        return view('website.category.show', compact(
            'category',
            'products',
            'relatedCategories',
            'search',
            'sort'
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