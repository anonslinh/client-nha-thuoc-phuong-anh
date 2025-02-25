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

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::get('register', [LoginController::class, 'register'])->name('register');
Route::post('user-register', [LoginController::class, 'userRegister'])->name('register-user');
Route::post('doLogin', [LoginController::class, 'doLogin'])->name('doLogin');

Route::middleware([CheckLogin::class])->group(function (){
    Route::get('', [DashboardController::class, 'index'])->name('index');
    Route::get('customer-exchange-gift', [HomeController::class, 'customerExchangeGift'])->name('customer.exchange-gift');
    Route::get('customer', [HomeController::class, 'customer'])->name('customer');
    Route::get('logout', [HomeController::class, 'logout'])->name('logout');
    Route::prefix('gift')->name('gift.')->group(function (){
        Route::get('index', [GiftController::class, 'index'])->name('index');
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
       Route::get('delete/{id}', [EventsController::class, 'detail'])->name('delete');
    });

    Route::prefix('voucher')->name('voucher.')->group(function (){
       Route::get('list-data', [HomeController::class, 'voucher'])->name('list-data');
       Route::get('customer', [HomeController::class, 'customerVoucher'])->name('customer');
       Route::post('store', [HomeController::class, 'storeVoucher'])->name('store');
       Route::post('update/{id}', [HomeController::class, 'updateVoucher'])->name('update');
       Route::get('delete/{id}', [HomeController::class, 'deleteVoucher'])->name('delete');
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
    });

    //Loyalty
    Route::prefix('loyalty')->name('loyalty.')->group(function (){

        //Mini Games
        Route::get('mini-games', [LoyaltyController::class, 'getMiniGames'])->name('mini-games');
        Route::post('update-mini-games/{id}', [LoyaltyController::class, 'updateMiniGame'])->name('update-mini-games');
        Route::get('delete-mini-games/{id}', [LoyaltyController::class, 'deleteMiniGame'])->name('delete-mini-games');
        Route::post('store-mini-games', [LoyaltyController::class, 'storeMiniGame'])->name('store-mini-games');

    });

    //Đánh giá nhân viên
    Route::prefix('employees')->name('employees.')->group(function (){
        Route::get('employees', [EmployeeController::class, 'getEmployees'])->name('employees');
        Route::get('employee-detail/{id}', [EmployeeController::class, 'getEmployeeDetails'])->name('employee-detail');
        Route::get('employee-export/{id}', [EmployeeController::class, 'exportEmployeeRatings'])->name('employee-export');
    });
});
