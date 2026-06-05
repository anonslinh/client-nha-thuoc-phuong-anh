<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\SearchKeywordProductV1;
use App\Models\SearchKeywordV1;

use App\Models\SeasonDiseaseCategoryProductV1;
use App\Models\SeasonDiseaseCategoryV1;

use App\Models\TextSeoHeader;
use App\Models\BannerV1;
use App\Models\MainCategoryV1;

use App\Models\HealthArticleCategoryV1;
use App\Models\HealthArticleV1;

use App\Models\CategoryV1;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\TrademarkV1;
use Carbon\Carbon;

class HomeWebsiteController extends Controller
{
    public function index()
    {
        $headerSearchKeywords = $this->getHeaderSearchKeywords();

        // các section khác của home
        $bannerHero = [];
        $flashSaleProducts = $this->getFlashSaleProducts();
        $bestSellerProducts = $this->getBestSellerProducts();
        $bestCategories = $this->getBestCategories();
        $favoriteBrands = $this->getFavoriteBrands();
        $rewardSection = [];
        $seasonDiseases = $this->getSeasonDiseases();
        $healthArticles = [];
        $sickCustomers = [];
        $healthCornerList = $this->getHealthCornerList();
        $listSick = $this->getListSick();
        // Danh mục tổng
        $listMainCategory = MainCategoryV1::query()
            ->orderByRaw('sort_order IS NULL, sort_order ASC, id ASC')
            ->limit(9)
            ->get();
        
        // Phần header
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
        // dd(json_decode($textSeoHeaders));
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
        //dd("Website mở dữ liệu vào 10:00 AM - 30/3/2026. Rất mong quý khách hàng thông cảm và tiếp tục ủng hộ Nhà thuốc Phương Anh!");
        return view('website.home.index', compact(
            'headerSearchKeywords',
            'bannerHero',
            'flashSaleProducts',
            'bestSellerProducts',
            'bestCategories',
            'favoriteBrands',
            'rewardSection',
            'seasonDiseases',
            'healthArticles',
            'sickCustomers',
            'topSeoHeader',
            'sideSeoHeaders',
            'banners',
            'listMainCategory',
            'healthCornerList',
            'listSick'
        ));
    }

    private function getHeaderSearchKeywords()
    {
        return SearchKeywordV1::query()
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->get();
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

    private function getSeasonDiseases()
{
    $categories = SeasonDiseaseCategoryV1::query()
        ->where('status', 1)
        ->orderBy('sort_order', 'asc')
        ->get();

    if ($categories->isEmpty()) {
        return collect();
    }

    $categoryIds = $categories->pluck('id')->toArray();

    $productsByCategory = SeasonDiseaseCategoryProductV1::query()
        ->from('season_disease_category_products_v1 as scp')
        ->join('product_v1 as p', 'p.id', '=', 'scp.product_id')
        ->where('p.is_active', 1)
        ->where('p.status', 1)
        ->where('scp.status', 1)
        ->whereIn('scp.category_id', $categoryIds)
        ->orderBy('scp.sort_order', 'asc')
        ->select([
            'scp.category_id',
            'scp.sale_price as season_sale_price',
            'scp.unit as season_unit',
            'scp.sort_order as season_sort_order',
            'p.*',
        ])
        ->get()
        ->groupBy('category_id');

    return $categories->map(function ($category, $index) use ($productsByCategory) {
        $products = collect($productsByCategory->get($category->id, collect()))
            ->map(function ($product) {
                $salePrice = (float) ($product->season_sale_price ?? $product->price_sale ?? $product->price ?? 0);
                $originalPrice = (float) ($product->price ?? 0);
                $unitName = $product->season_unit ?: 'Hộp';

                return [
                    'id' => $product->id,
                    'name' => $product->name ?? 'Sản phẩm',
                    'slug' => null,
                    'url' => 'javascript:void(0)',
                    'image' => $this->resolveImageUrl($product->img_avatar, 'images/no-image.png'),
                    'display_price' => $salePrice,
                    'original_price' => $originalPrice > $salePrice ? $originalPrice : null,
                    'unit_name' => $unitName,
                ];
            })
            ->values();

        return [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
            'panel_id' => 'season-' . \Illuminate\Support\Str::slug($category->name),
            'title' => !empty($category->description) ? $category->description : $category->name,
            'content' => $category->content,
            'avatar' => $this->resolveImageUrl($category->avatar),
            'banner' => $this->resolveImageUrl($category->banner),
            'products' => $products,
            'is_active' => $index === 0
        ];
    });
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
    private function getHealthCornerList()
    {
        $categories = HealthArticleCategoryV1::query()
            ->where('status', 1)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get([
                'id',
                'name',
                'sort_order',
            ]);

        if ($categories->isEmpty()) {
            return collect();
        }

        $categoryIds = $categories->pluck('id')->all();

        $articlesGrouped = HealthArticleV1::query()
            ->where('status', 1)
            ->whereIn('id_category', $categoryIds)
            ->orderByDesc('posted_at')
            ->orderByDesc('id')
            ->get([
                'id',
                'id_category',
                'title',
                'short_description',
                'avatar',
                'banner',
                'content',
                'posted_at',
                'created_at',
            ])
            ->groupBy('id_category');

        return $categories->map(function ($category) use ($articlesGrouped) {
            $articles = collect($articlesGrouped->get($category->id, collect()))
                ->take(5)
                ->values();

            $featured = $articles->first();
            $subItems = $articles->slice(1, 4)->values();

            return (object) [
                'id' => $category->id,
                'name' => $category->name,
                'featured' => $featured,
                'items' => $subItems,
                'total' => $articles->count(),
            ];
        })->filter(function ($item) {
            return !empty($item->featured);
        })->values();
    }

    //Góc sức khoẻ
    public function healthCornerIndex(Request $request)
    {
        $categories = HealthArticleCategoryV1::query()
            ->where('status', 1)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get([
                'id',
                'name',
                'sort_order',
            ]);

        abort_if($categories->isEmpty(), 404);

        $categoryCounts = HealthArticleV1::query()
            ->selectRaw('id_category, COUNT(*) as total')
            ->where('status', 1)
            ->whereIn('id_category', $categories->pluck('id'))
            ->groupBy('id_category')
            ->pluck('total', 'id_category')
            ->toArray();

        $selectedCategoryId = (int) $request->get('category', $categories->first()->id);

        if (!$categories->pluck('id')->contains($selectedCategoryId)) {
            $selectedCategoryId = $categories->first()->id;
        }

        $selectedCategory = $categories->firstWhere('id', $selectedCategoryId);

        $featuredArticle = HealthArticleV1::query()
            ->where('status', 1)
            ->where('id_category', $selectedCategory->id)
            ->orderByDesc('posted_at')
            ->orderByDesc('id')
            ->first([
                'id',
                'id_category',
                'title',
                'short_description',
                'avatar',
                'banner',
                'content',
                'posted_at',
                'created_at',
            ]);

        $articlesQuery = HealthArticleV1::query()
            ->where('status', 1)
            ->where('id_category', $selectedCategory->id);

        if ($featuredArticle) {
            $articlesQuery->where('id', '!=', $featuredArticle->id);
        }

        $articles = $articlesQuery
            ->orderByDesc('posted_at')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $latestArticles = HealthArticleV1::query()
            ->where('status', 1)
            ->when($featuredArticle, function ($q) use ($featuredArticle) {
                $q->where('id', '!=', $featuredArticle->id);
            })
            ->orderByDesc('posted_at')
            ->orderByDesc('id')
            ->limit(6)
            ->get([
                'id',
                'id_category',
                'title',
                'short_description',
                'avatar',
                'banner',
                'posted_at',
            ]);

        return view('website.health_corner.index', compact(
            'categories',
            'categoryCounts',
            'selectedCategory',
            'featuredArticle',
            'articles',
            'latestArticles'
        ));
    }

    public function healthCornerShow($category, $article)
    {
        $category = HealthArticleCategoryV1::query()
            ->where('status', 1)
            ->findOrFail($category);

        $article = HealthArticleV1::query()
            ->where('status', 1)
            ->where('id_category', $category->id)
            ->findOrFail($article);

        $categories = HealthArticleCategoryV1::query()
            ->where('status', 1)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get([
                'id',
                'name',
                'sort_order',
            ]);

        $categoryCounts = HealthArticleV1::query()
            ->selectRaw('id_category, COUNT(*) as total')
            ->where('status', 1)
            ->whereIn('id_category', $categories->pluck('id'))
            ->groupBy('id_category')
            ->pluck('total', 'id_category')
            ->toArray();

        $relatedArticles = HealthArticleV1::query()
            ->where('status', 1)
            ->where('id_category', $category->id)
            ->where('id', '!=', $article->id)
            ->orderByDesc('posted_at')
            ->orderByDesc('id')
            ->limit(6)
            ->get([
                'id',
                'id_category',
                'title',
                'short_description',
                'avatar',
                'banner',
                'posted_at',
            ]);

        $latestArticles = HealthArticleV1::query()
            ->where('status', 1)
            ->where('id', '!=', $article->id)
            ->orderByDesc('posted_at')
            ->orderByDesc('id')
            ->limit(6)
            ->get([
                'id',
                'id_category',
                'title',
                'short_description',
                'avatar',
                'banner',
                'posted_at',
            ]);

        $articleDescription = $article->short_description
            ?: Str::limit(trim(strip_tags($article->content)), 180);

        return view('website.health_corner.show', compact(
            'category',
            'article',
            'categories',
            'categoryCounts',
            'relatedArticles',
            'latestArticles',
            'articleDescription'
        ));
    }

    // Phần danh mục nổi bật
    private function getBestCategories()
    {
        return CategoryV1::query()
            ->from('category_v1 as c')
            ->leftJoin('product_v1 as p', function ($join) {
                $join->on('p.id_category', '=', 'c.id')
                    ->where('p.status', 1)
                    ->where('p.is_active', 1);
            })
            ->where('c.status', 1)
            ->groupBy(
                'c.id',
                'c.name',
                'c.description',
                'c.img',
                'c.sort_order'
            )
            ->orderByRaw('CASE WHEN c.sort_order IS NULL THEN 1 ELSE 0 END')
            ->orderBy('c.sort_order', 'asc')
            ->orderBy('c.id', 'asc')
            ->limit(12)
            ->select([
                'c.id',
                'c.name',
                'c.description',
                'c.img',
                'c.sort_order',
                DB::raw('COUNT(p.id) as product_count'),
            ])
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'image' => $this->resolveImageUrl($category->img),
                    'product_count' => (int) $category->product_count,
                    'url' => route('website.category.show', $category->id), // nếu sau này có route danh mục thì thay vào đây
                ];
            });
    }
    public function nearBranches()
    {
        $branches = DB::table('branches')
            ->join('local_branch', 'branches.id', '=', 'local_branch.branch_id')
            ->where('branches.is_active', 1)
            ->whereNotNull('local_branch.lat')
            ->whereNotNull('local_branch.lng')
            ->select(
                'branches.id',
                'branches.branch_name',
                'branches.address',
                'branches.location_name',
                'branches.ward_name',
                'branches.contact_number',
                'branches.email',
                'branches.account_code',
                'local_branch.lat',
                'local_branch.lng',
                'local_branch.google_map_link'
            )
            ->orderBy('branches.branch_name')
            ->get()
            ->map(function ($item) {
                $item->full_address = collect([
                    $item->address,
                    $item->ward_name,
                    $item->location_name,   
                ])->filter()->implode(', ');

                $item->google_maps_direction = 'https://www.google.com/maps/dir/?api=1&destination='
                    . $item->lat . ',' . $item->lng;

                $item->google_maps_pin = 'https://www.google.com/maps/search/?api=1&query='
                    . $item->lat . ',' . $item->lng;

                return $item;
            })
            ->values();
        return view('website.branch.near-branches', compact('branches'));
    }
    private function getBestSellerProducts()
{
    if (!Schema::hasTable('product_v1')) {
        return collect();
    }

    $query = DB::table('product_v1 as p')
        ->where('p.is_active', 1);

    if (Schema::hasColumn('product_v1', 'status')) {
        $query->where('p.status', 1);
    }

    $products = $query
        ->orderByRaw('CASE WHEN p.price_sale IS NOT NULL AND p.price_sale > 0 THEN 0 ELSE 1 END')
        ->orderByDesc('p.id')
        ->limit(12)
        ->select(
            'p.id',
            'p.id_category',
            'p.name',
            'p.full_name',
            'p.img_avatar',
            'p.description',
            'p.price',
            'p.price_sale'
        )
        ->get();

    return $products->map(function ($item) {
        $name = $item->full_name ?: $item->name ?: 'Sản phẩm';

        $salePrice = (float) ($item->price_sale ?? 0);
        $originalPrice = (float) ($item->price ?? 0);

        $displayPrice = $salePrice > 0 ? $salePrice : $originalPrice;

        $image = $item->img_avatar;
        if ($image && !Str::startsWith($image, ['http://', 'https://'])) {
            $image = asset($image);
        }
        if (!$image) {
            $image = asset('phuonganh/img/best-1-placeholder.jpg');
        }

        $discountPercent = null;
        if ($originalPrice > 0 && $salePrice > 0 && $originalPrice > $salePrice) {
            $discountPercent = round((($originalPrice - $salePrice) / $originalPrice) * 100);
        }

        return (object) [
            'id' => $item->id,
            'name' => $name,
            'image' => $image,
            'sale_price' => $displayPrice,
            'original_price' => $originalPrice,
            'discount_percent' => $discountPercent,
            'unit_label' => '',
            'product_url' => url('/san-pham/' . $item->id),
        ];
    })->values();
}
    
private function getFlashSaleProducts()
{
    $emptyResult = (object) [
        'sessions' => collect(),
        'active_session' => null,
        'active_session_id' => null,
    ];

    if (
        !Schema::hasTable('flash_sales_v1') ||
        !Schema::hasTable('flash_sale_items_v1') ||
        !Schema::hasTable('product_v1')
    ) {
        return $emptyResult;
    }

    $now = Carbon::now();
    $today = $now->toDateString();

    $rawSessions = DB::table('flash_sales_v1')
        ->where('status', 1)
        ->whereDate('sale_date', '>=', $today)
        ->orderBy('sale_date')
        ->orderBy('start_time')
        ->limit(15)
        ->get([
            'id',
            'sale_date',
            'start_time',
            'end_time',
            'title',
        ]);

    if ($rawSessions->isEmpty()) {
        $rawSessions = DB::table('flash_sales_v1')
            ->where('status', 1)
            ->orderByDesc('sale_date')
            ->orderByDesc('start_time')
            ->limit(7)
            ->get([
                'id',
                'sale_date',
                'start_time',
                'end_time',
                'title',
            ]);
    }

    if ($rawSessions->isEmpty()) {
        return $emptyResult;
    }

    $sessionIds = $rawSessions->pluck('id')->all();

    $itemQuery = DB::table('flash_sale_items_v1 as fsi')
        ->join('product_v1 as p', 'fsi.product_id', '=', 'p.id')
        ->whereIn('fsi.flash_sale_id', $sessionIds)
        ->where('fsi.status', 1)
        ->where('p.is_active', 1);

    if (Schema::hasColumn('product_v1', 'status')) {
        $itemQuery->where('p.status', 1);
    }

    $groupedItems = $itemQuery
        ->orderByDesc('fsi.sold')
        ->orderByDesc('fsi.id')
        ->select(
            'fsi.id',
            'fsi.flash_sale_id',
            'fsi.product_id',
            'fsi.item_name',
            'fsi.item_image',
            'fsi.flash_price',
            'fsi.quantity',
            'fsi.sold',

            'p.name',
            'p.full_name',
            'p.img_avatar',
            'p.description',
            'p.price',
            'p.price_sale'
        )
        ->get()
        ->groupBy('flash_sale_id');

    $sessions = $rawSessions->map(function ($session) use ($groupedItems, $now) {
        $startAt = Carbon::parse($session->sale_date . ' ' . $session->start_time);
        $endAt = Carbon::parse($session->sale_date . ' ' . $session->end_time);

        if ($now->between($startAt, $endAt)) {
            $statusKey = 'active';
            $statusLabel = 'Đang diễn ra';
            $statusClass = 'lc-flashsale-tab-status--active';
        } elseif ($now->lt($startAt)) {
            $statusKey = 'upcoming';
            $statusLabel = 'Sắp diễn ra';
            $statusClass = 'lc-flashsale-tab-status--upcoming';
        } else {
            $statusKey = 'ended';
            $statusLabel = 'Đã kết thúc';
            $statusClass = 'lc-flashsale-tab-status--ended';
        }

        $products = collect($groupedItems->get($session->id, collect()))->map(function ($item) {
            /**
             * Ưu tiên tên riêng của item Flash Sale.
             * Nếu rỗng thì lấy tên sản phẩm gốc.
             */
            $name = $item->item_name
                ?: ($item->full_name ?: ($item->name ?: 'Sản phẩm'));

            /**
             * Giá nền để tính giảm giá:
             * Ưu tiên price_sale nếu có, không thì lấy price.
             */
            $normalPrice = (float) (
                ($item->price_sale && $item->price_sale > 0)
                    ? $item->price_sale
                    : $item->price
            );

            $flashPrice = (float) ($item->flash_price ?? 0);
            $displayFlashPrice = $flashPrice > 0 ? $flashPrice : $normalPrice;

            $originalPrice = $normalPrice > $displayFlashPrice ? $normalPrice : 0;

            $discountPercent = null;
            if ($originalPrice > 0 && $displayFlashPrice > 0 && $originalPrice > $displayFlashPrice) {
                $discountPercent = round((($originalPrice - $displayFlashPrice) / $originalPrice) * 100);
            }

            /**
             * Ưu tiên ảnh riêng của item Flash Sale.
             * Nếu rỗng thì lấy ảnh sản phẩm gốc.
             */
            $image = $item->item_image ?: $item->img_avatar;

            if ($image && !Str::startsWith($image, ['http://', 'https://'])) {
                $image = asset($image);
            }

            if (!$image) {
                $image = asset('phuonganh/img/fl1.jpg');
            }

            $quantity = (int) ($item->quantity ?? 0);
            $sold = (int) ($item->sold ?? 0);
            $remaining = max($quantity - $sold, 0);

            $progressPercent = null;
            if ($quantity > 0) {
                $progressPercent = min(100, round(($sold / $quantity) * 100));
            }

            return (object) [
                'id' => $item->product_id,
                'item_id' => $item->id,
                'name' => $name,
                'image' => $image,
                'flash_price' => $displayFlashPrice,
                'original_price' => $originalPrice,
                'discount_percent' => $discountPercent,
                'quantity' => $quantity,
                'sold' => $sold,
                'remaining' => $remaining,
                'progress_percent' => $progressPercent,
                'unit_label' => '',
                'product_url' => url('/san-pham/' . $item->product_id),
            ];
        })->values();

        return (object) [
            'id' => $session->id,
            'title' => $session->title ?: 'Flash Sale',
            'sale_date' => $session->sale_date,
            'start_time' => $session->start_time,
            'end_time' => $session->end_time,
            'time_label' => substr($session->start_time, 0, 5) . ' – ' . substr($session->end_time, 0, 5),
            'date_label' => Carbon::parse($session->sale_date)->format('d/m'),
            'start_at_iso' => $startAt->toIso8601String(),
            'end_at_iso' => $endAt->toIso8601String(),
            'status_key' => $statusKey,
            'status_label' => $statusLabel,
            'status_class' => $statusClass,
            'products' => $products,
        ];
    })->values();

    $nonEndedSessions = $sessions->filter(function ($item) {
        return $item->status_key !== 'ended';
    })->values();

    if ($nonEndedSessions->isNotEmpty()) {
        $sessions = $nonEndedSessions;
    }

    $sessions = $sessions->take(7)->values();

    $activeSession = $sessions->first(function ($item) {
        return $item->status_key === 'active';
    });

    if (!$activeSession) {
        $activeSession = $sessions->first(function ($item) {
            return $item->status_key === 'upcoming';
        });
    }

    if (!$activeSession) {
        $activeSession = $sessions->first();
    }

    return (object) [
        'sessions' => $sessions,
        'active_session' => $activeSession,
        'active_session_id' => $activeSession ? $activeSession->id : null,
    ];
}
    private function getFavoriteBrands()
{
    return DB::table('favorite_trademarks_v1 as ft')
        ->join('trademark_v1 as t', 't.id', '=', 'ft.trademark_id')
        ->where('ft.status', 1)
        ->where('t.status', 1)
        ->orderByRaw('CASE WHEN ft.sort_order IS NULL THEN 1 ELSE 0 END')
        ->orderBy('ft.sort_order', 'asc')
        ->orderBy('ft.id', 'asc')
        ->select([
            'ft.id',
            'ft.trademark_id',
            'ft.featured_image',
            'ft.short_desc',
            'ft.sort_order as favorite_sort_order',
            't.name',
            't.description',
            't.note',
            't.img',
            't.banner',
            't.sort_order as trademark_sort_order',
        ])
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'trademark_id' => $item->trademark_id,
                'name' => $item->name,
                'description' => $item->description,
                'short_desc' => $item->short_desc,
                'featured_image' => $this->resolveImageUrl($item->featured_image, 'images/no-image.png'),
                'logo' => $this->resolveImageUrl($item->img, 'images/no-image.png'),
                'banner' => $this->resolveImageUrl($item->banner, 'images/no-image.png'),
                'url' => route('website.trademark.show', $item->trademark_id),
            ];
        });
}
public function flashSaleIndex(Request $request)
{
    $selectedSessionId = $request->get('session');

    $flashSalePageData = $this->getFlashSalePageData($selectedSessionId);

    return view('website.flash_sale.index', [
        'flashSaleSessions' => $flashSalePageData['sessions'],
        'selectedFlashSale' => $flashSalePageData['selected_session'],
        'selectedFlashSaleProducts' => $flashSalePageData['selected_products'],
    ]);
}
private function getFlashSalePageData($selectedSessionId = null)
{
    $empty = [
        'sessions' => collect(),
        'selected_session' => null,
        'selected_products' => collect(),
    ];

    if (
        !Schema::hasTable('flash_sales_v1') ||
        !Schema::hasTable('flash_sale_items_v1') ||
        !Schema::hasTable('product_v1')
    ) {
        return $empty;
    }

    $now = Carbon::now();
    $dateFrom = $now->copy()->subDays(2)->toDateString();

    $rawSessions = DB::table('flash_sales_v1')
        ->where('status', 1)
        ->whereDate('sale_date', '>=', $dateFrom)
        ->orderBy('sale_date')
        ->orderBy('start_time')
        ->limit(15)
        ->get([
            'id',
            'sale_date',
            'start_time',
            'end_time',
            'title',
        ]);

    if ($rawSessions->isEmpty()) {
        $rawSessions = DB::table('flash_sales_v1')
            ->where('status', 1)
            ->orderByDesc('sale_date')
            ->orderByDesc('start_time')
            ->limit(10)
            ->get([
                'id',
                'sale_date',
                'start_time',
                'end_time',
                'title',
            ]);
    }

    if ($rawSessions->isEmpty()) {
        return $empty;
    }

    $sessionIds = $rawSessions->pluck('id')->all();

    $itemsQuery = DB::table('flash_sale_items_v1 as fsi')
        ->join('product_v1 as p', 'fsi.product_id', '=', 'p.id')
        ->whereIn('fsi.flash_sale_id', $sessionIds)
        ->where('fsi.status', 1)
        ->where('p.is_active', 1);

    if (Schema::hasColumn('product_v1', 'status')) {
        $itemsQuery->where('p.status', 1);
    }

    $rawItems = $itemsQuery
        ->orderByDesc('fsi.sold')
        ->orderByDesc('fsi.id')
        ->select(
            'fsi.id',
            'fsi.flash_sale_id',
            'fsi.product_id',
            'fsi.item_name',
            'fsi.item_image',
            'fsi.flash_price',
            'fsi.quantity',
            'fsi.sold',

            'p.name',
            'p.full_name',
            'p.img_avatar',
            'p.description',
            'p.price',
            'p.price_sale'
        )
        ->get()
        ->groupBy('flash_sale_id');

    $sessions = $rawSessions->map(function ($session) use ($rawItems, $now) {
        $startAt = Carbon::parse($session->sale_date . ' ' . $session->start_time);
        $endAt = Carbon::parse($session->sale_date . ' ' . $session->end_time);

        if ($now->between($startAt, $endAt)) {
            $statusKey = 'active';
            $statusLabel = 'Đang diễn ra';
        } elseif ($now->lt($startAt)) {
            $statusKey = 'upcoming';
            $statusLabel = 'Sắp diễn ra';
        } else {
            $statusKey = 'ended';
            $statusLabel = 'Đã kết thúc';
        }

        $items = collect($rawItems->get($session->id, collect()));

        return (object) [
            'id' => $session->id,
            'title' => $session->title ?: 'Flash Sale',
            'sale_date' => $session->sale_date,
            'start_time' => $session->start_time,
            'end_time' => $session->end_time,
            'start_at_iso' => $startAt->toIso8601String(),
            'end_at_iso' => $endAt->toIso8601String(),
            'status_key' => $statusKey,
            'status_label' => $statusLabel,
            'time_label' => substr($session->start_time, 0, 5) . ' - ' . substr($session->end_time, 0, 5),
            'date_label' => Carbon::parse($session->sale_date)->format('d/m'),
            'product_count' => $items->count(),
            'sold_total' => (int) $items->sum('sold'),
            'quantity_total' => (int) $items->sum('quantity'),
        ];
    })->values();

    $selectedSession = null;

    if ($selectedSessionId) {
        $selectedSession = $sessions->firstWhere('id', (int) $selectedSessionId);
    }

    if (!$selectedSession) {
        $selectedSession = $sessions->first(function ($item) {
            return $item->status_key === 'active';
        });
    }

    if (!$selectedSession) {
        $selectedSession = $sessions->first(function ($item) {
            return $item->status_key === 'upcoming';
        });
    }

    if (!$selectedSession) {
        $selectedSession = $sessions->first();
    }

    $selectedProducts = collect($rawItems->get(optional($selectedSession)->id, collect()))
        ->map(function ($item) {
            /**
             * Ưu tiên tên riêng của item Flash Sale.
             */
            $name = $item->item_name
                ?: ($item->full_name ?: ($item->name ?: 'Sản phẩm'));

            $normalPrice = (float) (
                ($item->price_sale && $item->price_sale > 0)
                    ? $item->price_sale
                    : $item->price
            );

            $flashPrice = (float) ($item->flash_price ?? 0);
            $displayFlashPrice = $flashPrice > 0 ? $flashPrice : $normalPrice;

            $originalPrice = $normalPrice > $displayFlashPrice ? $normalPrice : 0;

            $discountPercent = null;
            if ($originalPrice > 0 && $displayFlashPrice > 0 && $originalPrice > $displayFlashPrice) {
                $discountPercent = round((($originalPrice - $displayFlashPrice) / $originalPrice) * 100);
            }

            $quantity = (int) ($item->quantity ?? 0);
            $sold = (int) ($item->sold ?? 0);
            $remaining = max($quantity - $sold, 0);

            $progressPercent = 0;
            if ($quantity > 0) {
                $progressPercent = min(100, round(($sold / $quantity) * 100));
            }

            $almostSoldOut = $quantity > 0 && $remaining > 0 && ($progressPercent >= 75 || $remaining <= 5);
            $soldOut = $quantity > 0 && $remaining <= 0;

            /**
             * Ưu tiên ảnh riêng của item Flash Sale.
             */
            $image = $item->item_image ?: $item->img_avatar;

            if ($image && !Str::startsWith($image, ['http://', 'https://'])) {
                $image = asset($image);
            }

            if (!$image) {
                $image = asset('phuonganh/img/fl1.jpg');
            }

            return (object) [
                'id' => $item->product_id,
                'item_id' => $item->id,
                'name' => $name,
                'image' => $image,
                'description' => $item->description ? Str::limit(strip_tags($item->description), 120) : '',
                'flash_price' => $displayFlashPrice,
                'original_price' => $originalPrice,
                'discount_percent' => $discountPercent,
                'quantity' => $quantity,
                'sold' => $sold,
                'remaining' => $remaining,
                'progress_percent' => $progressPercent,
                'almost_sold_out' => $almostSoldOut,
                'sold_out' => $soldOut,
                'product_url' => url('/san-pham/' . $item->product_id),
            ];
        })
        ->sortBy(function ($item) {
            return $item->sold_out ? 1 : 0;
        })
        ->values();

    return [
        'sessions' => $sessions,
        'selected_session' => $selectedSession,
        'selected_products' => $selectedProducts,
    ];
}
private function getListSick()
{
    $emptyResult = (object) [
        'default_type' => 1,
        'groups' => collect([
            (object) [
                'type' => 1,
                'label' => 'Bệnh theo mùa',
                'categories' => collect(),
            ],
            (object) [
                'type' => 2,
                'label' => 'Bệnh theo đối tượng',
                'categories' => collect(),
            ],
        ]),
    ];

    if (
        !Schema::hasTable('disease_categories_v1') ||
        !Schema::hasTable('diseases_v1')
    ) {
        return $emptyResult;
    }

    $categories = DB::table('disease_categories_v1')
        ->where('status', 1)
        ->whereIn('type', [1, 2])
        ->orderBy('type')
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->get([
            'id',
            'avatar',
            'banner',
            'name',
            'short_description',
            'type',
            'sort_order',
        ]);
    if ($categories->isEmpty()) {
        return $emptyResult;
    }

    $categoryIds = $categories->pluck('id')->all();

    $diseaseMap = DB::table('diseases_v1')
        ->where('status', 1)
        ->whereIn('id_category', $categoryIds)
        ->orderByDesc('posted_at')
        ->orderByDesc('id')
        ->get([
            'id',
            'id_category',
            'title',
            'short_description',
            'avatar',
            'banner',
            'content',
            'posted_at',
        ])
        ->groupBy('id_category');

    $mappedCategories = $categories->map(function ($category) use ($diseaseMap) {
        $articles = collect($diseaseMap->get($category->id, collect()))
            ->take(4)
            ->values()
            ->map(function ($article) {
                return (object) [
                    'id' => $article->id,
                    'title' => $article->title,
                    'short_description' => $article->short_description,
                    'avatar' => $article->avatar,
                    'banner' => $article->banner,
                    'content' => $article->content,
                    'posted_at' => $article->posted_at,
                ];
            });

        return (object) [
            'id' => $category->id,
            'type' => (int) $category->type,
            'name' => $category->name,
            'short_description' => $category->short_description,
            'avatar' => $category->avatar,
            'banner' => $category->banner,
            'image' => $category->avatar ?: $category->banner,
            'articles' => $articles,
        ];
    });

    $group1 = $mappedCategories
        ->where('type', 1)
        ->values();

    $group2 = $mappedCategories
        ->where('type', 2)
        ->values();
    return (object) [
        'default_type' => 1,
        'groups' => collect([
            (object) [
                'type' => 1,
                'label' => 'Bệnh theo mùa',
                'categories' => $group1,
            ],
            (object) [
                'type' => 2,
                'label' => 'Bệnh theo đối tượng',
                'categories' => $group2,
            ],
        ]),
    ];
}
private function getDiseaseTypeLabel($type)
{
    return (int) $type === 1 ? 'Bệnh theo mùa' : 'Bệnh theo đối tượng';
}
public function diseaseCategoryShow(Request $request, $category)
{
    $category = DB::table('disease_categories_v1')
        ->where('status', 1)
        ->where('id', $category)
        ->first([
            'id',
            'avatar',
            'banner',
            'name',
            'short_description',
            'type',
            'sort_order',
            'created_at',
            'updated_at',
        ]);

    abort_if(!$category, 404);

    $typeLabel = $this->getDiseaseTypeLabel($category->type);

    $featuredArticle = DB::table('diseases_v1')
        ->where('status', 1)
        ->where('id_category', $category->id)
        ->orderByDesc('posted_at')
        ->orderByDesc('id')
        ->first([
            'id',
            'id_category',
            'title',
            'short_description',
            'avatar',
            'banner',
            'content',
            'posted_at',
            'created_at',
        ]);

    $articlesQuery = DB::table('diseases_v1')
        ->where('status', 1)
        ->where('id_category', $category->id);

    if ($featuredArticle) {
        $articlesQuery->where('id', '!=', $featuredArticle->id);
    }

    $articles = $articlesQuery
        ->orderByDesc('posted_at')
        ->orderByDesc('id')
        ->paginate(12)
        ->withQueryString();

    $relatedCategories = DB::table('disease_categories_v1')
        ->where('status', 1)
        ->where('type', $category->type)
        ->where('id', '!=', $category->id)
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->limit(6)
        ->get([
            'id',
            'name',
            'avatar',
            'banner',
            'short_description',
            'type',
        ]);

    $relatedCategoryIds = $relatedCategories->pluck('id')->all();
    $relatedCategoryCountMap = [];

    if (!empty($relatedCategoryIds)) {
        $relatedCategoryCountMap = DB::table('diseases_v1')
            ->selectRaw('id_category, COUNT(*) as total')
            ->where('status', 1)
            ->whereIn('id_category', $relatedCategoryIds)
            ->groupBy('id_category')
            ->pluck('total', 'id_category')
            ->toArray();
    }

    $latestArticles = DB::table('diseases_v1')
        ->join('disease_categories_v1', 'diseases_v1.id_category', '=', 'disease_categories_v1.id')
        ->where('diseases_v1.status', 1)
        ->where('disease_categories_v1.status', 1)
        ->orderByDesc('diseases_v1.posted_at')
        ->orderByDesc('diseases_v1.id')
        ->limit(6)
        ->get([
            'diseases_v1.id',
            'diseases_v1.id_category',
            'diseases_v1.title',
            'diseases_v1.short_description',
            'diseases_v1.avatar',
            'diseases_v1.banner',
            'diseases_v1.posted_at',
            'disease_categories_v1.name as category_name',
        ]);

    $articleCount = DB::table('diseases_v1')
        ->where('status', 1)
        ->where('id_category', $category->id)
        ->count();

    return view('website.disease.category', compact(
        'category',
        'typeLabel',
        'featuredArticle',
        'articles',
        'relatedCategories',
        'relatedCategoryCountMap',
        'latestArticles',
        'articleCount'
    ));
}
public function diseaseArticleShow($category, $article)
{
    $category = DB::table('disease_categories_v1')
        ->where('status', 1)
        ->where('id', $category)
        ->first([
            'id',
            'avatar',
            'banner',
            'name',
            'short_description',
            'type',
            'sort_order',
            'created_at',
            'updated_at',
        ]);

    abort_if(!$category, 404);

    $article = DB::table('diseases_v1')
        ->where('status', 1)
        ->where('id_category', $category->id)
        ->where('id', $article)
        ->first([
            'id',
            'id_category',
            'title',
            'short_description',
            'avatar',
            'banner',
            'content',
            'posted_at',
            'created_at',
            'updated_at',
        ]);

    abort_if(!$article, 404);

    $typeLabel = $this->getDiseaseTypeLabel($category->type);

    $articleDescription = $article->short_description
        ?: Str::limit(trim(strip_tags($article->content)), 180);

    $relatedArticles = DB::table('diseases_v1')
        ->where('status', 1)
        ->where('id_category', $category->id)
        ->where('id', '!=', $article->id)
        ->orderByDesc('posted_at')
        ->orderByDesc('id')
        ->limit(6)
        ->get([
            'id',
            'id_category',
            'title',
            'short_description',
            'avatar',
            'banner',
            'posted_at',
            'created_at',
        ]);

    $relatedCategories = DB::table('disease_categories_v1')
        ->where('status', 1)
        ->where('type', $category->type)
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->limit(6)
        ->get([
            'id',
            'name',
            'avatar',
            'banner',
            'short_description',
            'type',
        ]);

    $relatedCategoryIds = $relatedCategories->pluck('id')->all();
    $relatedCategoryCountMap = [];

    if (!empty($relatedCategoryIds)) {
        $relatedCategoryCountMap = DB::table('diseases_v1')
            ->selectRaw('id_category, COUNT(*) as total')
            ->where('status', 1)
            ->whereIn('id_category', $relatedCategoryIds)
            ->groupBy('id_category')
            ->pluck('total', 'id_category')
            ->toArray();
    }

    $latestArticles = DB::table('diseases_v1')
        ->join('disease_categories_v1', 'diseases_v1.id_category', '=', 'disease_categories_v1.id')
        ->where('diseases_v1.status', 1)
        ->where('disease_categories_v1.status', 1)
        ->where('diseases_v1.id', '!=', $article->id)
        ->orderByDesc('diseases_v1.posted_at')
        ->orderByDesc('diseases_v1.id')
        ->limit(6)
        ->get([
            'diseases_v1.id',
            'diseases_v1.id_category',
            'diseases_v1.title',
            'diseases_v1.short_description',
            'diseases_v1.avatar',
            'diseases_v1.banner',
            'diseases_v1.posted_at',
            'disease_categories_v1.name as category_name',
        ]);

    return view('website.disease.article', compact(
        'category',
        'article',
        'typeLabel',
        'articleDescription',
        'relatedArticles',
        'relatedCategories',
        'relatedCategoryCountMap',
        'latestArticles'
    ));
}
}