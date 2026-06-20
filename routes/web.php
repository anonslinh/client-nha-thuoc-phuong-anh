<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckLogin;
use App\Http\Controllers\Admin\SyncController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\GiftController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\LoyaltyController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingAIAgentsController;
use App\Http\Controllers\LoginZaloController;
use App\Http\Controllers\Admin\DealController;
use App\Http\Controllers\VideoProductController;
use App\Http\Controllers\RotationController;
use App\Http\Controllers\Admin\ProductCertificateController;
use App\Http\Controllers\Admin\PharmacyController;
use App\Http\Controllers\Admin\InvoicesController;
use App\Http\Controllers\Admin\TaskManagementController;
use App\Http\Controllers\Client\HomeClientController;
use App\Http\Controllers\Client\ImagesRoomsController;
use App\Http\Controllers\Client\RoomsClientController;
use App\Http\Controllers\Client\RoomsController;
use App\Http\Controllers\Client\MenusController;
use App\Http\Controllers\Client\UtilitiesController;

use App\Http\Controllers\Frontend\RoomClientController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Client\BookingCalendarController;
use App\Http\Controllers\Client\BookingClientController;
use App\Http\Controllers\Frontend\BookingClientFEController;
use App\Http\Controllers\Client\BookingFEController;
use App\Http\Controllers\Client\BlogController;


use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\BlogCategoryController;

use App\Services\KiotVietService;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Danh sách các route website 
|
*/
use App\Http\Controllers\NhaThuocPhuongAnh\HomeWebsiteController;
use App\Http\Controllers\NhaThuocPhuongAnh\SearchController;
use App\Http\Controllers\NhaThuocPhuongAnh\TextSeoHeaderClientController;
use App\Http\Controllers\NhaThuocPhuongAnh\WebisteMainCategoryV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsiteProductV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsiteCartV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsiteCheckoutV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsiteGuestCustomerController;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsiteAuthV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnh\SeasonDiseaseWebsiteController;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsiteMyOrderV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsiteCategoryController;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsiteTrademarkController;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsiteBannerController;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsiteSearchController;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsitePrescriptionRequestV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsitePharmacistConsultV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsiteLoyaltyPointV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsitePurchasedMedicineV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnh\WebsiteRewardExchangeV1Controller;

// Trang chủ
Route::get('', [HomeWebsiteController::class, 'index'])->name('index');

//Tìm kiếm
Route::get('/tim-kiem', [SearchController::class, 'index'])->name('website.search');
Route::get('/tim-kiem/tu-khoa/{id}', [SearchController::class, 'keywordDetail'])->name('website.search.keyword');

// Chi tiết thông tin nổi bật
Route::get('/thong-tin-noi-bat/{id}', [TextSeoHeaderClientController::class, 'textSeoHeaderDetail'])
    ->name('website.text_seo_header.show');

Route::get('abc', [HomeWebsiteController::class, 'abc123'])->name('abc123');
Route::prefix('home')->name('home.')->group(function () {
});

// Danh mục tổng
Route::get('/danh-muc-tong/{id}', [WebisteMainCategoryV1Controller::class, 'show'])
    ->name('website.main-category-v1.show');

// Chi tiết sản phẩm
Route::get('/san-pham/{id}', [WebsiteProductV1Controller::class, 'show'])
    ->name('website.product-v1.show');

// Giỏ hàng
Route::prefix('gio-hang')->name('website.cart.')->group(function () {
    Route::get('/', [WebsiteCartV1Controller::class, 'index'])->name('index');
    Route::get('/tom-tat', [WebsiteCartV1Controller::class, 'summary'])->name('summary');

    Route::post('/them', [WebsiteCartV1Controller::class, 'add'])->name('add');
    Route::post('/cap-nhat', [WebsiteCartV1Controller::class, 'update'])->name('update');
    Route::post('/xoa', [WebsiteCartV1Controller::class, 'remove'])->name('remove');
    Route::post('/xoa-tat-ca', [WebsiteCartV1Controller::class, 'clear'])->name('clear');
});

// Đặt hàng & Thanh toán
Route::prefix('dat-hang')->name('website.checkout.')->group(function () {
    Route::get('/', [WebsiteCheckoutV1Controller::class, 'index'])->name('index');
    Route::post('/tao-don', [WebsiteCheckoutV1Controller::class, 'store'])->name('store');
    Route::get('/thanh-cong/{orderCode}', [WebsiteCheckoutV1Controller::class, 'success'])->name('success');
    Route::post('/ap-dung-ma-giam-gia', [WebsiteCheckoutV1Controller::class, 'applyDiscountCode'])->name('apply-discount');
    Route::post('/bo-ma-giam-gia', [WebsiteCheckoutV1Controller::class, 'removeDiscountCode'])->name('remove-discount');
});

// Lưu thông tin khách hàng khi đặt hàng không cần đăng nhập
Route::post('/khach-hang/luu-session', [WebsiteGuestCustomerController::class, 'store'])
    ->name('website.guest-customer.store');
Route::post('/khach-hang/xoa-session', [WebsiteGuestCustomerController::class, 'clear'])
    ->name('website.guest-customer.clear');

// Đăng nhập khách hàng bằng OTP (Zalo) - đăng nhập 1 lần, dùng vĩnh viễn tới khi đăng xuất
Route::prefix('khach-hang')->name('website.auth.')->group(function () {
    Route::post('gui-otp', [WebsiteAuthV1Controller::class, 'sendOtp'])->name('send-otp');
    Route::post('xac-thuc-otp', [WebsiteAuthV1Controller::class, 'verifyOtp'])->name('verify-otp');
    Route::post('cap-nhat-thong-tin', [WebsiteAuthV1Controller::class, 'updateProfile'])->name('update-profile');
    Route::post('dang-xuat', [WebsiteAuthV1Controller::class, 'logout'])->name('logout');
    Route::get('thong-tin', [WebsiteAuthV1Controller::class, 'me'])->name('me');
});

//Chi tiết bệnh theo mùa
Route::get('/benh-theo-mua/{id}', [SeasonDiseaseWebsiteController::class, 'show'])
    ->name('website.season-disease.show');

// Góc sức khoẻ
Route::get('/goc-suc-khoe', [HomeWebsiteController::class, 'healthCornerIndex'])
    ->name('website.health-corner.index');

Route::get('/goc-suc-khoe/{category}/{article}', [HomeWebsiteController::class, 'healthCornerShow'])
    ->name('website.health-corner.show');

// Đơn hàng của tôi
Route::get('/don-hang-cua-toi', [WebsiteMyOrderV1Controller::class, 'index'])
    ->name('website.my-order.index');

// Danh mục sản phẩm
Route::get('/danh-muc/{id}', [WebsiteCategoryController::class, 'show'])
    ->name('website.category.show');

// Chi nhánh gần tôi
Route::get('/chi-nhanh-gan-toi', [HomeWebsiteController::class, 'nearBranches'])
    ->name('website.near-branches');
    
// Flash sale
Route::get('/flash-sale', [HomeWebsiteController::class, 'flashSaleIndex'])
    ->name('website.flash-sale.index');

// Thương hiệu
Route::get('/thuong-hieu/{id}', [WebsiteTrademarkController::class, 'show'])
    ->name('website.trademark.show');

// Banner
Route::get('/banner/{id}', [WebsiteBannerController::class, 'show'])
    ->name('website.banner.show');

// Tìm kiếm
Route::get('/tim-kiem', [WebsiteSearchController::class, 'index'])
    ->name('website.search.index');

// Bệnh
Route::get('/benh/{category}', [HomeWebsiteController::class, 'diseaseCategoryShow'])
    ->name('website.disease.category');

Route::get('/benh/{category}/{article}', [HomeWebsiteController::class, 'diseaseArticleShow'])
    ->name('website.disease.article');

// Yêu cầu đơn thuốc
Route::prefix('can-mua-thuoc')->name('website.prescription_request_v1.')->group(function () {
    Route::get('/', [WebsitePrescriptionRequestV1Controller::class, 'index'])->name('index');
    Route::post('/gui-yeu-cau', [WebsitePrescriptionRequestV1Controller::class, 'store'])->name('store');
});

// Tư vấn dược sĩ
Route::get('/tu-van-duoc-si', [WebsitePharmacistConsultV1Controller::class, 'index'])
    ->name('website.pharmacist_consult_v1.index');

// Điểm thưởng (yêu cầu đăng nhập OTP - tránh lộ dữ liệu khách khác qua số điện thoại tự nhập)
Route::get('/tich-diem-doi-qua', [WebsiteLoyaltyPointV1Controller::class, 'index'])
    ->middleware('website_customer.auth')
    ->name('website.loyalty_point_v1.index');

// Đơn thuốc đã mua (yêu cầu đăng nhập OTP)
Route::get('/don-thuoc-da-mua', [WebsitePurchasedMedicineV1Controller::class, 'index'])
    ->middleware('website_customer.auth')
    ->name('website.purchased_medicine_v1.index');

// Đổi quà (yêu cầu đăng nhập OTP)
Route::get('/doi-qua', [WebsiteRewardExchangeV1Controller::class, 'index'])
    ->middleware('website_customer.auth')
    ->name('website.reward_exchange_v1.index');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Danh sách các route admin
|
*/
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\ProductV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\CategoryV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\TrademarkV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\FlashSaleV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\BestSellerV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\FavoriteTrademarkV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\SearchKeywordV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\SeasonDiseaseCategoryV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\HealthCornerV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\DiseaseV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\TextSeoHeaderController;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\BannerV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\MainCategoryV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\OrderV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\PrescriptionRequestV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\PopupTestController;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\ShippingFeeRuleV1Controller;
use App\Http\Controllers\NhaThuocPhuongAnhAdmin\DiscountCodeV1Controller;

Route::get('gINNtanfKE2buXB/login', [LoginController::class, 'login'])->name('login');
Route::get('authentication-forgot-password', [LoginController::class, 'forgotPassword'])->name('authentication-forgot-password');
Route::post('store-forgot-password', [LoginController::class, 'storeForgotPassword'])->name('store-forgot-password');
Route::get('/reset-password', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'storeResetPassword'])->name('password.update');

Route::get('register', [LoginController::class, 'register'])->name('register');
Route::post('user-register', [LoginController::class, 'userRegister'])->name('register-user');
Route::post('doLogin', [LoginController::class, 'doLogin'])->name('doLogin');

Route::get('login/zalo', [LoginZaloController::class, 'loginZalo']);
Route::get('zalo', [LoginZaloController::class, 'zaloUser']);

Route::middleware([CheckLogin::class])->group(function (){
    Route::get('admin', [DashboardController::class, 'index1'])->name('index1');

    Route::prefix('catalog-v1')->name('catalog_v1.')->group(function () {
        // CATEGORY
        // Route::prefix('categories')->name('categories.')->group(function () {
        //     Route::get('/', [CategoryV1Controller::class, 'index'])->name('index');
        //     Route::post('store', [CategoryV1Controller::class, 'store'])->name('store');
        //     Route::post('update/{id}', [CategoryV1Controller::class, 'update'])->name('update');
        //     Route::get('delete/{id}', [CategoryV1Controller::class, 'destroy'])->name('destroy');

        //     Route::get('{id}/products', [CategoryV1Controller::class, 'products'])->name('products');

        //     Route::get('{id}/attach-products', [CategoryV1Controller::class, 'attachProductsPage'])->name('attach.products.page');
        //     Route::post('{id}/attach-products', [CategoryV1Controller::class, 'attachProductsStore'])->name('attach.products.store');
        //     Route::post('{id}/detach-products', [CategoryV1Controller::class, 'detachProducts'])->name('detach.products');

        //     Route::get('{id}/attach-kiotviet', [CategoryV1Controller::class, 'attachKiotPage'])->name('attach.kiot.page');
        //     Route::post('{id}/attach-kiotviet', [CategoryV1Controller::class, 'attachKiotStore'])->name('attach.kiot.store');
        // });
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoryV1Controller::class, 'index'])->name('index');
            Route::post('store', [CategoryV1Controller::class, 'store'])->name('store');
            Route::post('update/{id}', [CategoryV1Controller::class, 'update'])->name('update');
            Route::get('delete/{id}', [CategoryV1Controller::class, 'destroy'])->name('destroy');

            Route::get('sync-all-kiot', [CategoryV1Controller::class, 'syncAllKiot'])->name('sync.all.kiot');
            Route::get('{id}/sync-kiot', [CategoryV1Controller::class, 'syncCategoryKiot'])->name('sync.kiot');

            Route::get('{id}/products', [CategoryV1Controller::class, 'products'])->name('products');

            Route::get('{id}/attach-products', [CategoryV1Controller::class, 'attachProductsPage'])->name('attach.products.page');
            Route::post('{id}/attach-products', [CategoryV1Controller::class, 'attachProductsStore'])->name('attach.products.store');
            Route::post('{id}/detach-products', [CategoryV1Controller::class, 'detachProducts'])->name('detach.products');

            Route::get('{id}/attach-kiotviet', [CategoryV1Controller::class, 'attachKiotPage'])->name('attach.kiot.page');
            Route::post('{id}/attach-kiotviet', [CategoryV1Controller::class, 'attachKiotStore'])->name('attach.kiot.store');
        });
        
        //MAIN CATEGORIES
        Route::prefix('main-categories')->name('main_categories.')->group(function () {
            Route::get('/', [MainCategoryV1Controller::class, 'index'])->name('index');
            Route::post('store', [MainCategoryV1Controller::class, 'store'])->name('store');
            Route::post('update/{id}', [MainCategoryV1Controller::class, 'update'])->name('update');
            Route::get('delete/{id}', [MainCategoryV1Controller::class, 'destroy'])->name('destroy');

            Route::get('{id}/categories', [MainCategoryV1Controller::class, 'categories'])->name('categories');
            Route::get('{id}/attach', [MainCategoryV1Controller::class, 'attachPage'])->name('attach.page');
            Route::post('{id}/attach', [MainCategoryV1Controller::class, 'attachStore'])->name('attach.store');
            Route::post('{id}/detach', [MainCategoryV1Controller::class, 'detachCategories'])->name('detach');
        });
        // TRADEMARK
        Route::prefix('trademarks')->name('trademarks.')->group(function () {
            Route::get('/', [TrademarkV1Controller::class, 'index'])->name('index');
            Route::post('store', [TrademarkV1Controller::class, 'store'])->name('store');
            Route::post('update/{id}', [TrademarkV1Controller::class, 'update'])->name('update');
            Route::get('delete/{id}', [TrademarkV1Controller::class, 'destroy'])->name('destroy');

            Route::get('{id}/products', [TrademarkV1Controller::class, 'products'])->name('products');
            Route::get('{id}/attach', [TrademarkV1Controller::class, 'attachPage'])->name('attach.page');
            Route::post('{id}/attach', [TrademarkV1Controller::class, 'attachProducts'])->name('attach');
            Route::post('{id}/detach', [TrademarkV1Controller::class, 'detachProducts'])->name('detach');
        });

        // PRODUCTS
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductV1Controller::class, 'index'])->name('index');
            Route::get('show/{id}', [ProductV1Controller::class, 'show'])->name('show');
            Route::post('store', [ProductV1Controller::class, 'store'])->name('store');
            Route::post('update/{id}', [ProductV1Controller::class, 'update'])->name('update');
            Route::get('delete/{id}', [ProductV1Controller::class, 'destroy'])->name('destroy');

            // Sync from KiotViet (page + import)
            Route::get('kiotviet', [ProductV1Controller::class, 'kiotviet'])->name('kiotviet');
            Route::post('kiotviet/import', [ProductV1Controller::class, 'kiotvietImport'])->name('kiotviet.import');
        });

        // FLASHSALES
        Route::prefix('flashsales')->name('flashsales.')->group(function () {
            Route::get('/', [FlashSaleV1Controller::class, 'index'])->name('index');
            Route::post('store', [FlashSaleV1Controller::class, 'store'])->name('store');
            Route::post('update/{id}', [FlashSaleV1Controller::class, 'update'])->name('update');
            Route::get('delete/{id}', [FlashSaleV1Controller::class, 'destroy'])->name('destroy');

            // quản lý sản phẩm trong 1 khung giờ
            Route::get('{id}/items', [FlashSaleV1Controller::class, 'items'])->name('items');
            Route::post('{id}/items/store', [FlashSaleV1Controller::class, 'itemsStore'])->name('items.store');
            Route::post('{id}/items/update/{item_id}', [FlashSaleV1Controller::class, 'itemsUpdate'])->name('items.update');
            Route::get('{id}/items/delete/{item_id}', [FlashSaleV1Controller::class, 'itemsDestroy'])->name('items.destroy');
        });

        //BESTSELLER
        Route::prefix('best-sellers')->name('best_sellers.')->group(function () {
            Route::get('/', [BestSellerV1Controller::class, 'index'])->name('index');

            Route::post('store', [BestSellerV1Controller::class, 'store'])->name('store');
            Route::post('update/{id}', [BestSellerV1Controller::class, 'update'])->name('update');
            Route::get('delete/{id}', [BestSellerV1Controller::class, 'destroy'])->name('destroy');

            // chọn sản phẩm từ product_v1
            Route::get('attach', [BestSellerV1Controller::class, 'attachPage'])->name('attach.page');
            Route::post('attach', [BestSellerV1Controller::class, 'attachStore'])->name('attach.store');
        });

        //FAVORITE READEMARKS
        Route::prefix('favorite-trademarks')->name('favorite_trademarks.')->group(function () {
            Route::get('/', [FavoriteTrademarkV1Controller::class, 'index'])->name('index');

            Route::post('update/{id}', [FavoriteTrademarkV1Controller::class, 'update'])->name('update');
            Route::get('delete/{id}', [FavoriteTrademarkV1Controller::class, 'destroy'])->name('destroy');

            // chọn thương hiệu từ trademark_v1
            Route::get('attach', [FavoriteTrademarkV1Controller::class, 'attachPage'])->name('attach.page');
            Route::post('attach', [FavoriteTrademarkV1Controller::class, 'attachStore'])->name('attach.store');
        });

        //KEYSEARCH
        Route::prefix('search-keywords')->name('search_keywords.')->group(function () {
            Route::get('/', [SearchKeywordV1Controller::class, 'index'])->name('index');
            Route::post('store', [SearchKeywordV1Controller::class, 'store'])->name('store');
            Route::post('update/{id}', [SearchKeywordV1Controller::class, 'update'])->name('update');
            Route::get('delete/{id}', [SearchKeywordV1Controller::class, 'destroy'])->name('destroy');

            // cấu hình sản phẩm ưu tiên
            Route::get('{id}/products', [SearchKeywordV1Controller::class, 'products'])->name('products');
            Route::get('{id}/attach', [SearchKeywordV1Controller::class, 'attachPage'])->name('attach.page');
            Route::post('{id}/attach', [SearchKeywordV1Controller::class, 'attachProducts'])->name('attach');
            Route::post('{id}/detach', [SearchKeywordV1Controller::class, 'detachProducts'])->name('detach');
            Route::post('{id}/product/update/{map_id}', [SearchKeywordV1Controller::class, 'updateMapItem'])->name('product.update');
        });

        //DISEASE CATEGORY
        Route::prefix('season-disease-categories')->name('season_disease_categories.')->group(function () {
            Route::get('/', [SeasonDiseaseCategoryV1Controller::class, 'index'])->name('index');
            Route::post('store', [SeasonDiseaseCategoryV1Controller::class, 'store'])->name('store');
            Route::post('update/{id}', [SeasonDiseaseCategoryV1Controller::class, 'update'])->name('update');
            Route::get('delete/{id}', [SeasonDiseaseCategoryV1Controller::class, 'destroy'])->name('destroy');

            Route::get('{id}/products', [SeasonDiseaseCategoryV1Controller::class, 'products'])->name('products');
            Route::get('{id}/attach', [SeasonDiseaseCategoryV1Controller::class, 'attachPage'])->name('attach.page');
            Route::post('{id}/attach', [SeasonDiseaseCategoryV1Controller::class, 'attachStore'])->name('attach.store');

            Route::post('{id}/product/update/{map_id}', [SeasonDiseaseCategoryV1Controller::class, 'updateProductItem'])->name('product.update');
            Route::get('{id}/product/delete/{map_id}', [SeasonDiseaseCategoryV1Controller::class, 'destroyProductItem'])->name('product.destroy');
        });

        //HEALTH CORNER
        Route::prefix('health-corner')->name('health_corner.')->group(function () {
        // categories
            Route::get('categories', [HealthCornerV1Controller::class, 'categories'])->name('categories');
            Route::post('categories/store', [HealthCornerV1Controller::class, 'storeCategory'])->name('categories.store');
            Route::post('categories/update/{id}', [HealthCornerV1Controller::class, 'updateCategory'])->name('categories.update');
            Route::get('categories/delete/{id}', [HealthCornerV1Controller::class, 'destroyCategory'])->name('categories.destroy');
            
            Route::get('categories/{category_id}/articles/show/{id}', [HealthCornerV1Controller::class, 'showArticle'])->name('articles.show');
            // articles by category
            Route::get('categories/{category_id}/articles', [HealthCornerV1Controller::class, 'articles'])->name('articles');
            Route::post('categories/{category_id}/articles/store', [HealthCornerV1Controller::class, 'storeArticle'])->name('articles.store');
            Route::post('categories/{category_id}/articles/update/{id}', [HealthCornerV1Controller::class, 'updateArticle'])->name('articles.update');
            Route::get('categories/{category_id}/articles/delete/{id}', [HealthCornerV1Controller::class, 'destroyArticle'])->name('articles.destroy');
        });

        //DISEASES
        Route::prefix('diseases')->name('diseases.')->group(function () {
        // categories
            Route::get('categories', [DiseaseV1Controller::class, 'categories'])->name('categories');
            Route::post('categories/store', [DiseaseV1Controller::class, 'storeCategory'])->name('categories.store');
            Route::post('categories/update/{id}', [DiseaseV1Controller::class, 'updateCategory'])->name('categories.update');
            Route::get('categories/delete/{id}', [DiseaseV1Controller::class, 'destroyCategory'])->name('categories.destroy');

            // disease list by category
            Route::get('categories/{category_id}/items', [DiseaseV1Controller::class, 'items'])->name('items');
            Route::post('categories/{category_id}/items/store', [DiseaseV1Controller::class, 'storeItem'])->name('items.store');
            Route::post('categories/{category_id}/items/update/{id}', [DiseaseV1Controller::class, 'updateItem'])->name('items.update');
            Route::get('categories/{category_id}/items/delete/{id}', [DiseaseV1Controller::class, 'destroyItem'])->name('items.destroy');

            // preview
            Route::get('categories/{category_id}/items/show/{id}', [DiseaseV1Controller::class, 'showItem'])->name('items.show');
        }); 
        
        //TEXT SEO HEADER
        Route::prefix('text-seo-header')->name('text_seo_header.')->group(function () {
            Route::get('/', [TextSeoHeaderController::class, 'index'])->name('index');
            Route::post('store', [TextSeoHeaderController::class, 'store'])->name('store');
            Route::post('update/{id}', [TextSeoHeaderController::class, 'update'])->name('update');
            Route::get('delete/{id}', [TextSeoHeaderController::class, 'destroy'])->name('destroy');
            Route::get('show/{id}', [TextSeoHeaderController::class, 'show'])->name('show');

            Route::get('{id}/products', [TextSeoHeaderController::class, 'products'])->name('products');
            Route::get('{id}/attach', [TextSeoHeaderController::class, 'attachPage'])->name('attach.page');
            Route::post('{id}/attach', [TextSeoHeaderController::class, 'attachStore'])->name('attach.store');
            Route::post('{id}/detach', [TextSeoHeaderController::class, 'detachProducts'])->name('detach');
            Route::post('{id}/product/update/{map_id}', [TextSeoHeaderController::class, 'updateProductItem'])->name('product.update');
        });

        //BANNERS
        Route::prefix('banners')->name('banners.')->group(function () {
            Route::get('/', [BannerV1Controller::class, 'index'])->name('index');
            Route::post('store', [BannerV1Controller::class, 'store'])->name('store');
            Route::post('update/{id}', [BannerV1Controller::class, 'update'])->name('update');
            Route::get('delete/{id}', [BannerV1Controller::class, 'destroy'])->name('destroy');
            Route::get('show/{id}', [BannerV1Controller::class, 'show'])->name('show');
        });

        //POPUP THU NGHIEM
        Route::prefix('popup-test')->name('popup_test.')->group(function () {
            Route::get('/', [PopupTestController::class, 'index'])->name('index');
            Route::post('update', [PopupTestController::class, 'update'])->name('update');
        });

        //ORDER
        Route::prefix('admin/catalog-v1/order-v1')->name('admin.order_v1.')->group(function () {
            Route::get('/', [OrderV1Controller::class, 'index'])->name('index');
            Route::get('/{id}', [OrderV1Controller::class, 'show'])->name('show');
            Route::post('/{id}/update', [OrderV1Controller::class, 'update'])->name('update');
        });

        //PHI VAN CHUYEN
        Route::prefix('shipping-fee')->name('shipping_fee.')->group(function () {
            Route::get('/', [ShippingFeeRuleV1Controller::class, 'index'])->name('index');
            Route::post('store', [ShippingFeeRuleV1Controller::class, 'store'])->name('store');
            Route::post('update/{id}', [ShippingFeeRuleV1Controller::class, 'update'])->name('update');
            Route::get('delete/{id}', [ShippingFeeRuleV1Controller::class, 'destroy'])->name('destroy');
        });

        //VOUCHER & MA GIAM GIA
        Route::prefix('discount-code')->name('discount_code.')->group(function () {
            Route::get('/', [DiscountCodeV1Controller::class, 'index'])->name('index');
            Route::post('store', [DiscountCodeV1Controller::class, 'store'])->name('store');
            Route::post('update/{id}', [DiscountCodeV1Controller::class, 'update'])->name('update');
            Route::get('delete/{id}', [DiscountCodeV1Controller::class, 'destroy'])->name('destroy');
        });

        //prescription request
        Route::prefix('admin/catalog-v1/prescription-request-v1')->name('prescription_request_v1.')->group(function () {
            Route::get('/', [PrescriptionRequestV1Controller::class, 'index'])->name('index');
            Route::get('/{id}', [PrescriptionRequestV1Controller::class, 'show'])->name('show');
            Route::post('/{id}/update', [PrescriptionRequestV1Controller::class, 'update'])->name('update');
        });

    });
    //Cài đặt tài khoản Admin
    Route::prefix('account-admin')->name('account-admin.')->group(function (){
        Route::get('new-user-and-password', [LoginController::class, 'settingAccount'])->name('new-user-and-password');
        Route::post('change-password', [LoginController::class, 'changePassword'])->name('change-password');
        Route::post('add-user', [LoginController::class, 'storeUser'])->name('add-user');
        Route::get('delete-user/{id}', [LoginController::class, 'deleteUser'])->name('delete-user');

    });
    Route::get('customer-exchange-gift', [HomeController::class, 'customerExchangeGift'])->name('customer.exchange-gift');
    Route::get('export-customer-exchange-gift', [HomeController::class, 'exportCustomerExchangeGift'])->name('customer.export-exchange-gift');
    Route::get('customer-exchange-gift/{id}', [HomeController::class, 'customerExchangeGiftReturn'])->name('customer.exchange-gift-return');
    Route::get('customer-exchange-gift-confirm/{id}', [HomeController::class, 'customerExchangeGiftConfirm'])->name('customer.exchange-gift-confirm');
    Route::get('customer-exchange-voucher', [HomeController::class, 'customerVoucher'])->name('customer.exchange-voucher');
    Route::get('customer', [HomeController::class, 'customer'])->name('customer');
    Route::get('export-customer', [HomeController::class, 'exportCustomer'])->name('customer.export');
    Route::post('customer/plus-points', [HomeController::class, 'plusPointCustomer'])->name('customer.plus-point');
    Route::post('customer/exchange-code', [HomeController::class, 'exchangeCodeCustomer'])->name('customer.exchange-code');
    Route::prefix('gift')->name('gift.')->group(function (){
        Route::get('index', [GiftController::class, 'index'])->name('index');
        Route::get('created', [GiftController::class, 'created'])->name('created');
        Route::get('detail/{id}', [GiftController::class, 'detail'])->name('detail');
        Route::post('store', [GiftController::class, 'store'])->name('store');
        Route::post('update/{id}', [GiftController::class, 'update'])->name('update');
        Route::get('delete/{id}', [GiftController::class, 'delete'])->name('delete');
        Route::post('detail-product-kiotviet', [GiftController::class, 'detailProductKiotviet'])->name('detail-product');
        Route::post('import', [GiftController::class, 'import'])->name('import');
    });
    Route::prefix('banner')->name('banner.')->group(function (){
       Route::get('list-data', [GiftController::class, 'banner'])->name('list-data');
       Route::post('store', [GiftController::class, 'storeBanner'])->name('store');
       Route::post('update/{id}', [GiftController::class, 'updateBanner'])->name('update');
       Route::get('delete/{id}', [GiftController::class, 'deleteBanner'])->name('delete');
    });
    Route::prefix('program')->name('program.')->group(function (){
       Route::get('list-data', [GiftController::class, 'program'])->name('list-data');
       Route::get('create', [GiftController::class, 'createProgram'])->name('create');
       Route::post('store', [GiftController::class, 'storeProgram'])->name('store');
       Route::get('detail/{id}', [GiftController::class, 'detailProgram'])->name('detail');
       Route::post('update/{id}', [GiftController::class, 'updateProgram'])->name('update');
       Route::get('delete/{id}', [GiftController::class, 'deleteProgram'])->name('delete');
    });
    Route::prefix('promotion')->name('promotion.')->group(function (){
        Route::get('list-data', [GiftController::class, 'promotion'])->name('list-data');
        Route::get('create', [GiftController::class, 'createPromotion'])->name('create');
        Route::post('store', [GiftController::class, 'storePromotion'])->name('store');
        Route::get('detail/{id}', [GiftController::class, 'detailPromotion'])->name('detail');
        Route::post('update/{id}', [GiftController::class, 'updatePromotion'])->name('update');
        Route::get('delete/{id}', [GiftController::class, 'deletePromotion'])->name('delete');
    });
    Route::prefix('events')->name('events.')->group(function (){
       Route::get('list-product', [EventsController::class, 'listProduct'])->name('list-product');
       Route::get('delete-product/{id}', [EventsController::class, 'deleteProduct'])->name('product.delete');
       Route::get('list-customer', [EventsController::class, 'listCustomer'])->name('list-customer');
       Route::get('history-point', [EventsController::class, 'historyPoint'])->name('history-point');
       Route::get('export-history-point', [EventsController::class, 'exportHistoryPoint'])->name('export-history-point');
       Route::post('customer-update-point', [EventsController::class, 'customerUpdatePoint'])->name('customer.update-point');
       Route::get('list-gift', [EventsController::class, 'listGift'])->name('list-gift');
       Route::get('view-create-gift', [EventsController::class, 'viewCreateGift'])->name('gift.create');
       Route::post('create-gift', [EventsController::class, 'createGift'])->name('gift.store');
       Route::get('detail-gift/{id}', [EventsController::class, 'detailGift'])->name('gift.detail');
       Route::post('update-gift/{id}', [EventsController::class, 'updateGift'])->name('gift.update');
       Route::get('delete-gift/{id}', [EventsController::class, 'deleteGift'])->name('gift.delete');
       Route::get('history-exchange-gift', [EventsController::class, 'historyExchangeGift'])->name('history-exchange-gift');
       Route::get('export-history-exchange-gift', [EventsController::class, 'exportHistoryExchangeGift'])->name('export-history-exchange-gift');
       Route::get('product/create', [VideoProductController::class, 'createProduct'])->name('product.create');
       Route::get('list-gift/{id}', [VideoProductController::class, 'listGift'])->name('list-gift-product');
        Route::get('detail/{id}', [VideoProductController::class, 'detailProduct'])->name('detail-product');
        Route::post('update/{id}', [VideoProductController::class, 'updateProduct'])->name('update-product');
        Route::get('cart', [VideoProductController::class, 'listCart'])->name('cart');
    });

    Route::prefix('voucher')->name('voucher.')->group(function (){
       Route::get('list-data', [HomeController::class, 'voucher'])->name('list-data');
       Route::post('store', [HomeController::class, 'storeVoucher'])->name('store');
       Route::post('update/{id}', [HomeController::class, 'updateVoucher'])->name('update');
       Route::get('delete/{id}', [HomeController::class, 'deleteVoucher'])->name('delete');
       Route::get('created-voucher', [HomeController::class, 'createdVoucher'])->name('created-voucher');
       Route::get('detail-voucher/{id}', [HomeController::class, 'detailVoucher'])->name('detail-voucher');
    });
    Route::prefix('rank')->name('rank.')->group(function (){
       Route::get('index', [HomeController::class, 'listRank'])->name('index');
       Route::post('update/{id}', [HomeController::class, 'updateRank'])->name('update');
       Route::post('type-rank', [HomeController::class,'typeRank'])->name('type_rank');
    });

    //Cài đặt
    Route::prefix('config')->name('config.')->group(function (){

        //Đồng bộ nhân viên
        Route::get('employees', [SettingController::class, 'getEmployees'])->name('employees');
        Route::get('employees-sync', [SyncController::class, 'syncEmployees'])->name('employees-sync');

        //Đồng bộ cửa hàng
        Route::get('branches', [SettingController::class, 'getBranches'])->name('branches');
        Route::get('branches-sync', [SyncController::class, 'syncBranches'])->name('branches-sync');

        //Liên hệ & Phản hồi
        Route::get('contacts', [SettingController::class, 'getContacts'])->name('contacts');
        Route::post('contact-update/{id}', [SettingController::class, 'updateContact'])->name('contact-update');

        //Slogan
        Route::get('slogan', [SettingController::class, 'getSlogan'])->name('slogan');
        Route::post('slogan-update/{id}', [SettingController::class, 'updateSlogan'])->name('slogan-update');

        //Cài đặt điểm đánh giá
        Route::get('setting-point-order-review', [SettingController::class, 'settingPointOrderReview'])->name('setting-point-order-review');
        Route::post('update-point-order-review/{id}', [SettingController::class, 'updateSettingPointOrderReview'])->name('update-point-order-review');

        //Cài đặt chung
        Route::get('setting-global', [SettingController::class, 'settingGlobal'])->name('setting-global');
        Route::post('update-setting-global/{id}', [SettingController::class, 'updateSettingGlobal'])->name('update-setting-global');
        Route::post('change-type-point', [SettingController::class, 'changeTypePoint'])->name('change-type-point');
        Route::post('set-time-point', [SettingController::class, 'setTimePoint'])->name('set-time-point');
        Route::post('set-type-invoice', [SettingController::class, 'typeInvoice'])->name('set-type-invoice');

        //Cấu hình điều khoản khi đổi quà
        Route::prefix('terms')->name('terms.')->group(function () {
            Route::post('update', [SettingController::class, 'termsUpdate'])->name('update');
            Route::post('active', [SettingController::class, 'statusTerms'])->name('active');
        });
        //Cài đặt nhiều tài khoản kiotviet
        Route::get('index-account-branches', [SettingController::class, 'indexAccountBranches'])->name('index-account-branches');
        Route::post('store-account-branches', [SettingController::class, 'storeAccountBranch'])->name('store-account-branches');
        Route::post('update-account-branches/{id}', [SettingController::class, 'updateAccountBranch'])->name('update-account-branches');
        Route::get('delete-account-branches/{id}', [SettingController::class, 'deleteAccountBranch'])->name('delete-account-branches');

        Route::get('list-product', [SettingController::class, 'listProduct'])->name('list-product');
        Route::get('history-point', [SettingController::class, 'historyPoint'])->name('history-point');
        Route::get('excel-product', [SettingController::class, 'excelProduct'])->name('excel-product');
        Route::post('import-product', [SettingController::class, 'importProduct'])->name('import-product');
        Route::get('delete-product/{id}', [SettingController::class, 'deleteProduct'])->name('delete-product');
        Route::post('add-product', [SettingController::class, 'addProduct'])->name('add-product');
    });

    //Loyalty
    Route::prefix('loyalty')->name('loyalty.')->group(function (){

        //Mini Games
        Route::get('mini-games', [LoyaltyController::class, 'getMiniGames'])->name('mini-games');
        Route::post('update-mini-games/{id}', [LoyaltyController::class, 'updateMiniGame'])->name('update-mini-games');
        Route::get('delete-mini-games/{id}', [LoyaltyController::class, 'deleteMiniGame'])->name('delete-mini-games');
        Route::post('store-mini-games', [LoyaltyController::class, 'storeMiniGame'])->name('store-mini-games');

    });

    //Đánh giá nhân viên & Đánh giá đơn hàng
    Route::prefix('employees')->name('employees.')->group(function (){
        Route::get('employees', [EmployeeController::class, 'getEmployees'])->name('employees');
        Route::get('export-employees', [EmployeeController::class, 'exportEmployees'])->name('export-employees');
        Route::get('employee-detail/{id}', [EmployeeController::class, 'getEmployeeDetails'])->name('employee-detail');
        Route::get('employee-export/{id}', [EmployeeController::class, 'exportEmployeeRatings'])->name('employee-export');
        Route::get('ratings-invoice', [EmployeeController::class, 'getRatingsInvoice'])->name('ratings-invoice');
        Route::get('export-ratings-invoice', [EmployeeController::class, 'exportRatingsInvoice'])->name('export-ratings-invoice');
    });

    //Cài đặt tự động
    Route::prefix('setting-automatic')->name('setting-automatic.')->group(function (){
        Route::get('index-setting-email', [SettingAIAgentsController::class, 'indexEmailSettingAutomatic'])->name('index-setting-email');
        Route::get('destroy-setting-email/{id}', [SettingAIAgentsController::class, 'destroyEmailSettingAutomatic'])->name('destroy-setting-email');
        Route::post('store-setting-email', [SettingAIAgentsController::class, 'storeEmailSettingAutomatic'])->name('store-setting-email');
        Route::post('update-setting-email/{id}', [SettingAIAgentsController::class, 'updateEmailSettingAutomatic'])->name('update-setting-email');

        //Test form mail tự động
        Route::get('test-mail-invoice/{id}', [SettingAIAgentsController::class, 'testMailInvoice'])->name('test-mail-invoice');
        Route::get('test-mail-employee-kpi', [SettingAIAgentsController::class, 'sendMailKpiEmployee'])->name('test-mail-employee-kpi');
    });

    //Deal chớp nhoáng
    Route::prefix('deal')->name('deal.')->group(function (){
        //Deal
        Route::get('index-deal', [DealController::class, 'indexDeal'])->name('index-deal');
        Route::post('store-deal', [DealController::class, 'storeDeal'])->name('store-deal');
        Route::get('delete-deal/{id}', [DealController::class, 'destroyDeal'])->name('delete-deal');
        Route::post('update-deal/{id}', [DealController::class, 'updateDeal'])->name('update-deal');

        //Sản phẩm trong deal
        Route::get('index-product-deal/{deal_id}', [DealController::class, 'indexDealProduct'])->name('index-product-deal');
        Route::get('created-product-deal/{deal_id}', [DealController::class, 'indexDeal'])->name('created-product-deal/{deal_id}');
    });
    // Video sản phẩm
    Route::prefix('product')->name('product.')->group(function (){
       Route::get('video', [VideoProductController::class, 'video'])->name('video');
       Route::post('store', [VideoProductController::class, 'store'])->name('store-video');
       Route::get('delete/{id}', [VideoProductController::class, 'delete'])->name('video.delete');
       Route::post('update/{id}', [VideoProductController::class, 'update'])->name('video.update');
    });
    // Cài đặt sản phẩm và quà
    Route::prefix('product-gift')->name('product_gift.')->group(function (){
        Route::get('', [VideoProductController::class, 'giftProduct'])->name('index');
        Route::get('create', [VideoProductController::class, 'createProduct'])->name('create');
        Route::post('store', [VideoProductController::class, 'storeProduct'])->name('store');
        Route::get('detail/{id}', [VideoProductController::class, 'detailProduct'])->name('detail');
        Route::post('update/{id}', [VideoProductController::class, 'updateProduct'])->name('update');
        Route::get('list-gift/{id}', [VideoProductController::class, 'listGift'])->name('list-gift');
        Route::get('delete/{id}', [VideoProductController::class, 'deleteProduct'])->name('delete');
    });
    // Vòng quay may mắn
    Route::prefix('rotation')->name('rotation.')->group(function (){
       Route::get('setting', [RotationController::class, 'setting'])->name('setting');
       Route::get('gift', [RotationController::class, 'gift'])->name('gift');
       Route::get('gift/create', [RotationController::class, 'addGift'])->name('gift.create');
       Route::get('gift/detail/{id}', [RotationController::class, 'detailGift'])->name('gift.detail');
       Route::post('create', [RotationController::class, 'create'])->name('create');
       Route::get('delete', [RotationController::class, 'delete'])->name('delete');
       Route::post('create-gift', [RotationController::class, 'createGift'])->name('create-gift');
       Route::post('update-gift/{id}', [RotationController::class, 'updateGift'])->name('update-gift');
       Route::get('delete-gift/{id}', [RotationController::class, 'deleteGift'])->name('delete-gift');
       Route::get('history-exchange-gift', [RotationController::class, 'historyExchangeGift'])->name('history-exchange-gift');
       Route::get('export-history-exchange-gift', [RotationController::class, 'exportHistoryExchangeGift'])->name('export-history-exchange-gift');
       Route::get('sub-gift', [RotationController::class, 'subGift'])->name('sub-gift'); // Quà tặng của cô Xuyến
       Route::post('create-gift-2', [RotationController::class, 'createGift2'])->name('create-gift-2');
       Route::post('update-gift-2/{id}', [RotationController::class, 'updateGift2'])->name('update-gift-2');
       Route::get('delete-gift-2/{id}', [RotationController::class, 'deleteGiftSub'])->name('sub-gift.delete');
       Route::prefix('gift-checkin')->name('gift_checkin.')->group(function (){
          Route::get('setting', [RotationController::class, 'settingRotationCheckin'])->name('setting');
          Route::post('create_setting', [RotationController::class, 'createSettingCheckIn'])->name('create_setting');
          Route::get('', [RotationController::class, 'listGiftCheckin'])->name('index');
          Route::get('create', [RotationController::class, 'createGiftCheckin'])->name('create');
          Route::post('store', [RotationController::class, 'storedGiftCheckin'])->name('store');
          Route::get('delete/{id}', [RotationController::class, 'deleteGiftCheckin'])->name('delete');
          Route::get('detail/{id}', [RotationController::class, 'detailGiftCheckin'])->name('detail');
          Route::post('update/{id}', [RotationController::class, 'updateGiftCheckin'])->name('update');
          Route::get('exchange-gift', [RotationController::class, 'exchangeGiftCheckin'])->name('exchange-gift');
          Route::get('export-exchange-gift', [RotationController::class, 'exportExchangeGiftCheckin'])->name('export-exchange-gift');
          Route::get('list-customer', [RotationController::class, 'listCustomerCheckin'])->name('list-customer');
       });
       Route::post('interface', [RotationController::class, 'interface'])->name('interface');
    });
    //Giấy chứng nhận sản phẩm
    Route::prefix('certificates')->name('certificates.')->group(function () {
        Route::get('/', [ProductCertificateController::class, 'indexCertificates'])->name('index');
        Route::post('/', [ProductCertificateController::class, 'storeCertificates'])->name('store');
        Route::post('/{id}', [ProductCertificateController::class, 'updateCertificates'])->name('update');
        Route::get('destroy/{id}', [ProductCertificateController::class, 'destroyCertificates'])->name('destroy');
        Route::get('/certificates/export', [ProductCertificateController::class, 'exportCertificates'])->name('export');
        Route::post('/certificates/import', [ProductCertificateController::class, 'importCertificates'])->name('import');

    });
    //Yêu cầu xuất hoá đơn
    Route::prefix('invoices-request')->name('invoices-request.')->group(function () {
        Route::get('/', [InvoicesController::class, 'indexRequestInvoice'])->name('index');
        Route::get('destroy/{id}', [InvoicesController::class, 'destroyRequestInvoice'])->name('destroy');
        Route::get('/invoices-request/export', [InvoicesController::class, 'exportInvoiceRequest'])->name('export');
        Route::post('/invoices-request/import', [InvoicesController::class, 'importRequestInvoice'])->name('import');
    });
    //Nhà thuốc
    Route::prefix('pharmacy')->name('pharmacy.')->group(function () {
        Route::get('prescription', [PharmacyController::class, 'indexPrescription'])->name('prescription');
        Route::get('prescription-detail/{id}', [PharmacyController::class, 'showPrescription'])->name('prescription-detail');
    });

    //CRM chăm sóc khách hàng
    Route::prefix('crm-customers')->name('crm-customers.')->group(function () {
        Route::get('task-management', [TaskManagementController::class, 'indexProductBy'])->name('task-management');
        Route::get('detail-customer/{customer_id}', [TaskManagementController::class, 'detailCustomer'])->name('detail-customer');
        Route::post('store-child', [TaskManagementController::class, 'storeChildCustomer'])->name('store-child');
        Route::post('update-child', [TaskManagementController::class, 'updateChildCustomer'])->name('update-child');
        Route::get('delete-child/{child_id}', [TaskManagementController::class, 'deleteChild'])->name('delete-child');
        Route::post('store-customer-note', [TaskManagementController::class, 'storeCustomerNote'])->name('store-customer-note');
        Route::post('update-note-item', [TaskManagementController::class, 'updateCustomerNoteItem'])->name('update-note-item');
        Route::get('list-task-note', [TaskManagementController::class, 'listTaskNote'])->name('list-task-note');
        Route::get('export-task-management', [TaskManagementController::class, 'excelIndexProductBy'])->name('export-task-management');
    });

    Route::get('logout', [HomeController::class, 'logout'])->name('logout');

    // Quản lý phòng - Ảnh phòng
    Route::prefix('images-room')->name('images-room.')->group(function () {
        // Quản lý ảnh phòng
        Route::get('list-data', [ImagesRoomsController::class, 'listDataImagesRoom'])->name('listDataImagesRoom');
        Route::post('store', [ImagesRoomsController::class, 'storeImagesRoom'])->name('storeImagesRoom');
        Route::post('update/{id}', [ImagesRoomsController::class, 'updateImagesRoom'])->name('updateImagesRoom');
        Route::get('delete/{id}', [ImagesRoomsController::class, 'deleteImagesRoom'])->name('ImagesRoom'); // theo đúng tên bạn đưa
    });
    // Quản lý phòng
    Route::prefix('rooms')->name('rooms.')->group(function () {
        Route::get('list-data', [RoomsController::class, 'listDataRooms'])->name('listDataRooms');
        Route::post('store',     [RoomsController::class, 'storeRoom'])->name('storeRoom');
        Route::post('update/{id}', [RoomsController::class, 'updateRoom'])->name('updateRoom');
        Route::get('delete/{id}',  [RoomsController::class, 'deleteRoom'])->name('deleteRoom');
    });
    // Quản lý thực đơn
    Route::prefix('menus')->name('menus.')->group(function () {
        Route::get('list-data',   [MenusController::class, 'listDataMenus'])->name('listDataMenus');
        Route::post('store',      [MenusController::class, 'storeMenu'])->name('storeMenu');
        Route::post('update/{id}',[MenusController::class, 'updateMenu'])->name('updateMenu');
        Route::get('delete/{id}', [MenusController::class, 'deleteMenu'])->name('deleteMenu');
    });
    // Quản lý tiện ích
    Route::prefix('utilities')->name('utilities.')->group(function () {
        Route::get('list-data',    [UtilitiesController::class, 'listDataUtilities'])->name('listDataUtilities');
        Route::post('store',       [UtilitiesController::class, 'storeUtility'])->name('storeUtility');
        Route::post('update/{id}', [UtilitiesController::class, 'updateUtility'])->name('updateUtility');
        Route::get('delete/{id}',  [UtilitiesController::class, 'deleteUtility'])->name('deleteUtility');
    });
    // Đặt phòng (Admin)
    Route::prefix('booking')->name('booking.')->group(function () {

        // 1) Cấu hình lịch phòng theo ngày
        Route::prefix('calendar')->name('calendar.')->group(function () {
            Route::get('list-data',     [BookingCalendarController::class, 'listData'])->name('listData');
            Route::post('seed-month',   [BookingCalendarController::class, 'seedMonth'])->name('seedMonth');
            Route::post('bulk-update',  [BookingCalendarController::class, 'bulkUpdate'])->name('bulkUpdate');
            Route::post('update/{id}',  [BookingCalendarController::class, 'update'])->name('update');
            Route::get('delete/{id}',   [BookingCalendarController::class, 'delete'])->name('delete');
        });

        // 2) Quản lý đặt phòng
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('list-data',     [BookingController::class, 'listData'])->name('listData');
            Route::post('store',        [BookingController::class, 'store'])->name('store');
            Route::post('update/{id}',  [BookingController::class, 'update'])->name('update');

            Route::post('confirm/{id}', [BookingController::class, 'confirm'])->name('confirm');
            Route::post('cancel/{id}',  [BookingController::class, 'cancel'])->name('cancel');

            Route::get('delete/{id}',   [BookingController::class, 'delete'])->name('delete');
        });
        
    });
    // 3) Trang chi tiết đặt phòng
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/posts', [BlogPostController::class, 'index'])->name('posts.index');
        Route::post('/posts/store', [BlogPostController::class, 'store'])->name('posts.store');
        Route::post('/posts/update/{id}', [BlogPostController::class, 'update'])->name('posts.update');
        Route::post('/posts/toggle/{id}', [BlogPostController::class, 'toggle'])->name('posts.toggle');
        Route::get('/posts/delete/{id}', [BlogPostController::class, 'delete'])->name('posts.delete');

        Route::get('/categories', [BlogCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories/store', [BlogCategoryController::class, 'store'])->name('categories.store');
        Route::post('/categories/update/{id}', [BlogCategoryController::class, 'update'])->name('categories.update');
        Route::post('/categories/toggle/{id}', [BlogCategoryController::class, 'toggle'])->name('categories.toggle');
        Route::get('/categories/delete/{id}', [BlogCategoryController::class, 'delete'])->name('categories.delete');
    });
    
});
// Giao diện vòng quay
Route::get('play-rotation', [RotationController::class, 'playRotation']);
Route::get('lucky-wheel', function (){
   return view('lucky-wheel');
});
Route::get('rotation-checkin', function (){
   return view('rotation-checkin');
});
//Get Token Kiotviet
Route::get('get-token-kiotviet', [KiotVietService::class, 'playRotation']);

// // Website Phong Hoa
// Route::prefix('/')->group(function (){
// Route::get('', [HomeClientController::class, 'index'])->name('index1');;

//Phòng
// Route::prefix('phong')->name('phong.')->group(function () {
//     Route::get('', [RoomsClientController::class, 'index'])->name('index');
//     Route::get('detail/{id}', [RoomsClientController::class, 'detailRooms'])->name('detail');
// });

// Trang danh sách phòng (client)
Route::get('/phong', [RoomClientController::class, 'index'])->name('client.rooms.index');

// Trang chi tiết phòng theo code_url (SEO)
Route::get('/phong/{code_url}', [RoomClientController::class, 'show'])->name('client.rooms.show');
// });
// Trang danh sách phòng theo bộ lọc (client)
Route::get('/phong-booking', [BookingClientController::class, 'indexBookingClient'])->name('client.rooms.indexBookingClient');

Route::get('/api/rooms/availability', [RoomClientController::class, 'availability'])->name('client.rooms.availability');


// API check phòng trống (JS gọi)
Route::get('/api/bookings/check', [BookingFEController::class, 'check'])
    ->name('client.bookings.check');

// Submit đặt phòng (lưu vào admin)
Route::post('/dat-phong', [BookingFEController::class, 'store'])
    ->name('client.bookings.store');

// // Danh sách blog
// Route::get('/blog', [BlogController::class, 'indexBlog'])
//     ->name('client.blog.index');
//     // Chi tiết blog
// Route::get('/blog/show', [BlogController::class, 'showBlog'])
//     ->name('client.blog.show');
    
// Trang blog
Route::get('/bai-viet', [BlogController::class, 'index'])->name('client.blog.index');
Route::get('/bai-viet/{post:slug}', [BlogController::class, 'show'])->name('client.blog.show');