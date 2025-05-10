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
use App\Http\Controllers\Admin\InvoicesController;

Route::get('login', [LoginController::class, 'login'])->name('login');
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
    Route::get('', [DashboardController::class, 'index'])->name('index');

    //Cài đặt tài khoản Admin
    Route::prefix('account-admin')->name('account-admin.')->group(function (){
        Route::get('new-user-and-password', [LoginController::class, 'settingAccount'])->name('new-user-and-password');
        Route::post('change-password', [LoginController::class, 'changePassword'])->name('change-password');
        Route::post('add-user', [LoginController::class, 'storeUser'])->name('add-user');
        Route::get('delete-user/{id}', [LoginController::class, 'deleteUser'])->name('delete-user');

    });
    Route::get('customer-exchange-gift', [HomeController::class, 'customerExchangeGift'])->name('customer.exchange-gift');
    Route::get('customer-exchange-gift/{id}', [HomeController::class, 'customerExchangeGiftReturn'])->name('customer.exchange-gift-return');
    Route::get('customer-exchange-voucher', [HomeController::class, 'customerVoucher'])->name('customer.exchange-voucher');
    Route::get('customer', [HomeController::class, 'customer'])->name('customer');
    Route::post('customer/plus-points', [HomeController::class, 'plusPointCustomer'])->name('customer.plus-point');
    Route::get('logout', [HomeController::class, 'logout'])->name('logout');
    Route::prefix('gift')->name('gift.')->group(function (){
        Route::get('index', [GiftController::class, 'index'])->name('index');
        Route::get('created', [GiftController::class, 'created'])->name('created');
        Route::get('detail/{id}', [GiftController::class, 'detail'])->name('detail');
        Route::post('store', [GiftController::class, 'store'])->name('store');
        Route::post('update/{id}', [GiftController::class, 'update'])->name('update');
        Route::get('delete/{id}', [GiftController::class, 'delete'])->name('delete');
        Route::post('detail-product-kiotviet', [GiftController::class, 'detailProductKiotviet'])->name('detail-product');
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
       Route::post('customer-update-point', [EventsController::class, 'customerUpdatePoint'])->name('customer.update-point');
       Route::get('list-gift', [EventsController::class, 'listGift'])->name('list-gift');
       Route::get('view-create-gift', [EventsController::class, 'viewCreateGift'])->name('gift.create');
       Route::post('create-gift', [EventsController::class, 'createGift'])->name('gift.store');
       Route::get('detail-gift/{id}', [EventsController::class, 'detailGift'])->name('gift.detail');
       Route::post('update-gift/{id}', [EventsController::class, 'updateGift'])->name('gift.update');
       Route::get('delete-gift/{id}', [EventsController::class, 'deleteGift'])->name('gift.delete');
       Route::get('history-exchange-gift', [EventsController::class, 'historyExchangeGift'])->name('history-exchange-gift');
       Route::post('create-product-with-category', [EventsController::class, 'createProductWithCategory'])->name('create-product-with-category');
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
          Route::get('', [RotationController::class, 'listGiftCheckin'])->name('index');
          Route::get('create', [RotationController::class, 'createGiftCheckin'])->name('create');
          Route::post('store', [RotationController::class, 'storedGiftCheckin'])->name('store');
          Route::get('delete/{id}', [RotationController::class, 'deleteGiftCheckin'])->name('delete');
          Route::get('detail/{id}', [RotationController::class, 'detailGiftCheckin'])->name('detail');
          Route::post('update/{id}', [RotationController::class, 'updateGiftCheckin'])->name('update');
          Route::get('exchange-gift', [RotationController::class, 'exchangeGiftCheckin'])->name('exchange-gift');
       });
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
});
// Giao diện vòng quay
Route::get('play-rotation', [RotationController::class, 'playRotation']);
Route::get('lucky-wheel', function (){
   return view('lucky-wheel');
});
Route::get('rotation-checkin', function (){
   return view('rotation-checkin');
});
