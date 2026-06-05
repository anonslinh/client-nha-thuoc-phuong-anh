<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use App\Models\BannerV1;
use App\Models\ImageProductV1;
use App\Models\ProductV1;
use App\Models\TextSeoHeader;
use App\Models\TextSeoHeaderProduct;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TextSeoHeaderClientController extends Controller
{
    public function index()
    {
        // ===== TEXT SEO HEADER =====
        $textSeoHeaders = TextSeoHeader::query()
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($item) {
                $item->banner_url = $this->normalizeAssetUrl($item->banner);
                $item->detail_url = route('website.text_seo_header.show', $item->id);
                return $item;
            });
        // Tin lớn ở trên cùng
        $topSeoHeader = $textSeoHeaders->first();

        // 2 tin bên phải
        $sideSeoHeaders = $textSeoHeaders->skip(1)->take(2)->values();

        // ===== BANNER SLIDER =====
        $banners = BannerV1::query()
            ->where('type_hide', 1)
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($item) {
                $item->image_url = $this->normalizeAssetUrl($item->image);
                $item->detail_url = !empty($item->link_web) ? $item->link_web : 'javascript:void(0)';
                return $item;
            });

        return view('website.home.index', compact(
            'topSeoHeader',
            'sideSeoHeaders',
            'banners'
        ));
    }

    public function textSeoHeaderDetail($id)
    {
        $item = TextSeoHeader::query()->findOrFail($id);

        $products = collect();

        if ((int)$item->has_product_list === 1) {
            $maps = TextSeoHeaderProduct::query()
                ->where('header_id', $item->id)
                ->where('status', 1)
                ->orderBy('sort_order')
                ->orderBy('id', 'desc')
                ->get();

            $productIds = $maps->pluck('product_id')->filter()->unique()->values()->all();

            if (!empty($productIds)) {
                $products = $this->baseProductQuery()
                    ->whereIn('id', $productIds)
                    ->get()
                    ->sortBy(function ($product) use ($productIds) {
                        return array_search($product->id, $productIds);
                    })
                    ->values()
                    ->map(function ($product) {
                        return $this->transformProduct($product);
                    });
            }
        }

        $otherSeoHeaders = TextSeoHeader::query()
            ->where('id', '<>', $item->id)
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->take(3)
            ->get()
            ->map(function ($seo) {
                $seo->banner_url = $this->normalizeAssetUrl($seo->banner);
                $seo->detail_url = route('website.text_seo_header.show', $seo->id);
                return $seo;
            });

        $item->banner_url = $this->normalizeAssetUrl($item->banner);

        return view('website.text-seo-header.show', compact(
            'item',
            'products',
            'otherSeoHeaders'
        ));
    }

    private function baseProductQuery(): Builder
    {
        return ProductV1::query()
            ->where('status', 1)
            ->where(function (Builder $q) {
                $q->whereNull('is_active')
                    ->orWhere('is_active', 1)
                    ->orWhere('is_active', '1');
            });
    }

    private function transformProduct(ProductV1 $product): ProductV1
    {
        $product->image_url = $this->resolveProductImage($product);

        $price = !is_null($product->price) ? (float)$product->price : null;
        $priceSale = !is_null($product->price_sale) ? (float)$product->price_sale : null;

        $product->display_price = $priceSale && $priceSale > 0 ? $priceSale : ($price ?? 0);
        $product->original_price = ($price && $priceSale && $priceSale > 0 && $priceSale < $price) ? $price : null;

        return $product;
    }

    private function resolveProductImage(ProductV1 $product): string
    {
        if (!empty($product->img_avatar)) {
            return $this->normalizeAssetUrl($product->img_avatar);
        }

        $galleryImage = ImageProductV1::query()
            ->where('id_product_v1', $product->id)
            ->where('status', 1)
            ->orderBy('id')
            ->value('link_img');

        if (!empty($galleryImage)) {
            return $this->normalizeAssetUrl($galleryImage);
        }

        return asset('images/no-image.png');
    }

    private function normalizeAssetUrl(?string $path): string
    {
        if (empty($path)) {
            return asset('images/no-image.png');
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}