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
    Route::get('customer-exchange-voucher', [HomeController::class, 'customerVoucher'])->name('customer.exchange-voucher');
    Route::get('customer', [HomeController::class, 'customer'])->name('customer');
    Route::get('logout', [HomeController::class, 'logout'])->name('logout');
    Route::prefix('gift')->name('gift.')->group(function (){
        Route::get('index', [GiftController::class, 'index'])->name('index');
        Route::get('created', [GiftController::class, 'created'])->name('created');
        Route::get('detail/{id}', [GiftController::class, 'detail'])->name('detail');
        Route::post('store', [GiftController::class, 'store'])->name('store');
        Route::post('update/{id}', [GiftController::class, 'update'])->name('update');
        Route::get('delete/{id}', [GiftController::class, 'delete'])->name('delete');
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
       Route::get('list-data', [EventsController::class, 'listData'])->name('list-data');
       Route::get('create', [EventsController::class, 'create'])->name('create');
       Route::post('store', [EventsController::class, 'store'])->name('store');
       Route::get('detail/{id}', [EventsController::class, 'detail'])->name('detail');
       Route::get('delete/{id}', [EventsController::class, 'delete'])->name('delete');
       Route::post('update/{id}', [EventsController::class, 'update'])->name('update');
       Route::get('add-product/{id}', [EventsController::class, 'addProduct'])->name('add-product');
       Route::post('create-product', [EventsController::class, 'createProduct'])->name('create-product');
       Route::get('list-product', [EventsController::class, 'listProduct'])->name('list-product');
       Route::get('delete-product/{id}', [EventsController::class, 'deleteProduct'])->name('product.delete');
       Route::post('update-product/{id}', [EventsController::class, 'updateProduct'])->name('product.update');
       Route::get('list-customer', [EventsController::class, 'listCustomer'])->name('list-customer');
       Route::post('update-point', [EventsController::class, 'updatePoint'])->name('update-point');
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

        //Cài đặt nhiều tài khoản kiotviet
        Route::get('index-account-branches', [SettingController::class, 'indexAccountBranches'])->name('index-account-branches');
        Route::post('store-account-branches', [SettingController::class, 'storeAccountBranch'])->name('store-account-branches');
        Route::post('update-account-branches/{id}', [SettingController::class, 'updateAccountBranch'])->name('update-account-branches');
        Route::get('delete-account-branches/{id}', [SettingController::class, 'deleteAccountBranch'])->name('delete-account-branches');
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
});
