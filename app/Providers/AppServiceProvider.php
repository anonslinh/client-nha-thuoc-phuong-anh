<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SearchKeywordV1;
use App\Models\MainCategoryV1;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer([
            'website.partials.header',
            'website.home.header-menu',
        ], function ($view) {
            $headerSearchKeywords = SearchKeywordV1::query()
                ->orderBy('sort_order')
                ->orderBy('id', 'desc')
                ->get();

            $listMainCategory = MainCategoryV1::query()
                ->orderByRaw('sort_order IS NULL, sort_order ASC, id ASC')
                ->limit(9)
                ->get();

            $view->with([
                'headerSearchKeywords' => $headerSearchKeywords,
                'listMainCategory' => $listMainCategory,
            ]);
        });
        Carbon::setLocale('vi');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }
}
