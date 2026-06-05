<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use App\Models\ImageProductV1;
use App\Models\ProductV1;
use App\Models\SearchKeywordProductV1;
use App\Models\SearchKeywordV1;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keywords = SearchKeywordV1::query()
            ->where('type', 1)
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->paginate(24);

        return view('website.search.index', compact('keywords'));
    }

    public function keywordDetail($id)
    {
        $keyword = SearchKeywordV1::query()
            ->where('type', 1)
            ->findOrFail($id);

        $relatedKeywords = $this->extractRelatedKeywords($keyword);
        $searchTerms = $this->buildSearchTerms($keyword, $relatedKeywords);

        // 1) Sản phẩm ưu tiên đã cấu hình ở admin
        $priorityMaps = SearchKeywordProductV1::query()
            ->where('keyword_id', $keyword->id)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->get();

        $priorityProductIds = $priorityMaps->pluck('product_id')->filter()->unique()->values()->all();

        $priorityProducts = collect();

        if (!empty($priorityProductIds)) {
            $priorityProducts = $this->baseProductQuery()
                ->whereIn('id', $priorityProductIds)
                ->get()
                ->sortBy(function ($item) use ($priorityProductIds) {
                    return array_search($item->id, $priorityProductIds);
                })
                ->values()
                ->map(function ($product) {
                    return $this->transformProduct($product);
                });
        }

        // 2) Sản phẩm liên quan tìm theo từ khóa
        $searchProducts = $this->buildSearchProductsQuery($searchTerms, $priorityProductIds)
            ->paginate(20)
            ->withQueryString();

        $searchProducts->getCollection()->transform(function ($product) {
            return $this->transformProduct($product);
        });

        return view('website.search.keyword-detail', [
            'keyword' => $keyword,
            'relatedKeywords' => $relatedKeywords,
            'searchTerms' => $searchTerms,
            'priorityProducts' => $priorityProducts,
            'searchProducts' => $searchProducts,
        ]);
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

    private function buildSearchProductsQuery(array $searchTerms, array $excludeIds = []): Builder
    {
        $query = $this->baseProductQuery();

        if (empty($searchTerms)) {
            return $query->whereRaw('1 = 0');
        }

        $query->where(function (Builder $q) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $q->orWhere('name', 'like', "%{$term}%")
                    ->orWhere('full_name', 'like', "%{$term}%")
                    ->orWhere('code_product_kiovet', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            }
        });

        if (!empty($excludeIds)) {
            $query->whereNotIn('id', $excludeIds);
        }

        $mainTerm = $searchTerms[0] ?? null;

        if ($mainTerm) {
            $query->orderByRaw(
                "CASE
                    WHEN name = ? THEN 0
                    WHEN full_name = ? THEN 1
                    WHEN name LIKE ? THEN 2
                    WHEN full_name LIKE ? THEN 3
                    ELSE 4
                END",
                [
                    $mainTerm,
                    $mainTerm,
                    "%{$mainTerm}%",
                    "%{$mainTerm}%"
                ]
            );
        }

        return $query->orderBy('id', 'desc');
    }

    private function buildSearchTerms(SearchKeywordV1 $keyword, array $relatedKeywords = []): array
    {
        $terms = [];

        if (!empty($keyword->key_search)) {
            $terms[] = trim((string) $keyword->key_search);
        }

        foreach ($relatedKeywords as $item) {
            $item = trim((string) $item);
            if ($item !== '') {
                $terms[] = $item;
            }
        }

        return array_values(array_unique(array_filter($terms)));
    }

    private function extractRelatedKeywords(SearchKeywordV1 $keyword): array
    {
        $related = $keyword->related_keywords ?? [];

        if (is_string($related)) {
            $decoded = json_decode($related, true);
            $related = is_array($decoded) ? $decoded : [];
        }

        if (!is_array($related)) {
            return [];
        }

        return array_values(array_unique(array_filter(array_map(function ($item) {
            return trim((string) $item);
        }, $related))));
    }

    private function transformProduct(ProductV1 $product): ProductV1
    {
        $product->image_url = $this->resolveProductImage($product);

        $price = !is_null($product->price) ? (float) $product->price : null;
        $priceSale = !is_null($product->price_sale) ? (float) $product->price_sale : null;

        $product->display_price = $priceSale && $priceSale > 0 ? $priceSale : ($price ?? 0);
        $product->original_price = ($price && $priceSale && $priceSale > 0 && $priceSale < $price) ? $price : null;

        return $product;
    }

    private function resolveProductImage(ProductV1 $product): string
    {
        if (!empty($product->img_avatar)) {
            return $this->normalizeAssetPath($product->img_avatar);
        }

        $firstGalleryImage = ImageProductV1::query()
            ->where('id_product_v1', $product->id)
            ->where('status', 1)
            ->orderBy('id')
            ->value('link_img');

        if (!empty($firstGalleryImage)) {
            return $this->normalizeAssetPath($firstGalleryImage);
        }

        return asset('images/no-image.png');
    }

    private function normalizeAssetPath(?string $path): string
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