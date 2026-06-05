<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use App\Models\SeasonDiseaseCategoryProductV1;
use App\Models\SeasonDiseaseCategoryV1;
use Illuminate\Support\Str;

class SeasonDiseaseWebsiteController extends Controller
{
    public function show($id)
    {
        $seasonDisease = SeasonDiseaseCategoryV1::query()
            ->where('status', 1)
            ->findOrFail($id);

        $products = SeasonDiseaseCategoryProductV1::query()
            ->from('season_disease_category_products_v1 as scp')
            ->join('product_v1 as p', 'p.id', '=', 'scp.product_id')
            ->where('scp.status', 1)
            ->where('p.status', 1)
            ->where('p.is_active', 1)
            ->where('scp.category_id', $seasonDisease->id)
            ->orderBy('scp.sort_order', 'asc')
            ->select([
                'p.id',
                'p.name',
                'p.full_name',
                'p.img_avatar',
                'p.price',
                'p.price_sale',
                'scp.sale_price as season_sale_price',
                'scp.unit as season_unit',
                'scp.sort_order',
            ])
            ->get()
            ->map(function ($product) {
                $displayPrice = (float) ($product->season_sale_price ?? $product->price_sale ?? $product->price ?? 0);
                $originalPrice = (float) ($product->price ?? 0);

                return [
                    'id' => $product->id,
                    'name' => $product->full_name ?: $product->name,
                    'image' => $this->resolveImageUrl($product->img_avatar, 'images/no-image.png'),
                    'display_price' => $displayPrice,
                    'original_price' => $originalPrice > $displayPrice ? $originalPrice : null,
                    'unit_name' => $product->season_unit ?: 'Hộp',
                    'url' => 'javascript:void(0)', // thay bằng route chi tiết sản phẩm nếu bạn đã có
                ];
            })
            ->values();

        $seasonDisease->avatar_url = $this->resolveImageUrl($seasonDisease->avatar, 'images/no-image.png');
        $seasonDisease->banner_url = $this->resolveImageUrl($seasonDisease->banner, 'images/no-image.png');

        return view('website.season-disease.show', compact(
            'seasonDisease',
            'products'
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