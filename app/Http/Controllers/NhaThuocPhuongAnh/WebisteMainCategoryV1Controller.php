<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use App\Models\MainCategoryV1;
use App\Models\CategoryV1;
use App\Models\ProductV1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebisteMainCategoryV1Controller extends Controller
{
    public function show(Request $request, $id)
    {
        $mainCategory = MainCategoryV1::query()->findOrFail($id);

        $subCategories = CategoryV1::query()
            ->where('id_main_category_v1', $mainCategory->id)
            ->where('status', 1)
            ->orderByRaw('sort_order IS NULL, sort_order ASC, id ASC')
            ->get();

        $subCategoryIds = $subCategories->pluck('id')->map(fn($item) => (int) $item)->toArray();

        $selectedCategoryId = (int) $request->get('category_id', 0);
        if (!in_array($selectedCategoryId, $subCategoryIds, true)) {
            $selectedCategoryId = 0;
        }

        $price = (string) $request->get('price', '');
        $sort = (string) $request->get('sort', 'popular');
        $keyword = trim((string) $request->get('keyword', ''));

        $productsQuery = $this->buildBaseProductQuery($subCategoryIds);

        if ($selectedCategoryId > 0) {
            $productsQuery->where('id_category', $selectedCategoryId);
        }

        $this->applyPriceFilter($productsQuery, $price);
        $this->applyKeywordFilter($productsQuery, $keyword);
        $this->applySort($productsQuery, $sort);

        $products = $productsQuery
            ->selectRaw("
                product_v1.*,
                CASE
                    WHEN price_sale IS NOT NULL AND price_sale > 0 THEN price_sale
                    ELSE price
                END as display_price,
                CASE
                    WHEN price_sale IS NOT NULL AND price_sale > 0 AND price_sale < price THEN price
                    ELSE NULL
                END as original_price
            ")
            ->paginate(20)
            ->withQueryString();

        $productCounts = collect();

        if (!empty($subCategoryIds)) {
            $productCounts = $this->buildBaseProductQuery($subCategoryIds)
                ->select('id_category', DB::raw('COUNT(*) as total'))
                ->groupBy('id_category')
                ->pluck('total', 'id_category');
        }

        $subCategories = $subCategories->map(function ($item) use ($productCounts) {
            $item->image_url = $this->formatImageUrl($item->img);
            $item->total_products = (int) ($productCounts[$item->id] ?? 0);
            return $item;
        });

        $products->getCollection()->transform(function ($item) {
            $item->image_url = $this->formatImageUrl($item->img_avatar);
            $item->display_price = (float) ($item->display_price ?? 0);
            $item->original_price = !is_null($item->original_price) ? (float) $item->original_price : null;
            return $item;
        });

        $priceOptions = [
            'under_100k' => 'Dưới 100.000đ',
            '100k_300k' => '100.000đ đến 300.000đ',
            '300k_500k' => '300.000đ đến 500.000đ',
            'over_500k' => 'Trên 500.000đ',
        ];

        return view('website.main-category-v1.show', compact(
            'mainCategory',
            'subCategories',
            'products',
            'selectedCategoryId',
            'price',
            'sort',
            'keyword',
            'priceOptions'
        ));
    }

    protected function buildBaseProductQuery(array $subCategoryIds)
    {
        $query = ProductV1::query();

        if (empty($subCategoryIds)) {
            return $query->whereRaw('1 = 0');
        }

        return $query
            ->whereIn('id_category', $subCategoryIds)
            ->where(function ($q) {
                $q->whereNull('is_active')->orWhere('is_active', 1);
            })
            ->where(function ($q) {
                $q->whereNull('status')->orWhere('status', 1);
            });
    }

    protected function applyPriceFilter($query, string $price): void
    {
        $priceExpression = '(CASE WHEN price_sale IS NOT NULL AND price_sale > 0 THEN price_sale ELSE price END)';

        switch ($price) {
            case 'under_100k':
                $query->whereRaw("$priceExpression < ?", [100000]);
                break;

            case '100k_300k':
                $query->whereRaw("$priceExpression >= ? AND $priceExpression <= ?", [100000, 300000]);
                break;

            case '300k_500k':
                $query->whereRaw("$priceExpression > ? AND $priceExpression <= ?", [300000, 500000]);
                break;

            case 'over_500k':
                $query->whereRaw("$priceExpression > ?", [500000]);
                break;
        }
    }

    protected function applyKeywordFilter($query, string $keyword): void
    {
        if ($keyword === '') {
            return;
        }

        $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('full_name', 'like', '%' . $keyword . '%');
        });
    }

    protected function applySort($query, string $sort): void
    {
        $priceExpression = '(CASE WHEN price_sale IS NOT NULL AND price_sale > 0 THEN price_sale ELSE price END)';

        switch ($sort) {
            case 'price_asc':
                $query->orderByRaw("$priceExpression ASC")->orderByDesc('id');
                break;

            case 'price_desc':
                $query->orderByRaw("$priceExpression DESC")->orderByDesc('id');
                break;

            case 'popular':
            default:
                $query->orderByDesc('id');
                break;
        }
    }

    protected function formatImageUrl(?string $path): string
    {
        if (!$path) {
            return asset('assets/images/no-image.png');
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}