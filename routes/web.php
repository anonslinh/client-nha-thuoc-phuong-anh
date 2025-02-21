<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckLogin;
use App\Http\Controllers\Admin\SyncController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\GiftController;
use App\Http\Controllers\Admin\EventsController;

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::get('register', [LoginController::class, 'register'])->name('register');
Route::post('user-register', [LoginController::class, 'userRegister'])->name('register-user');
Route::post('doLogin', [LoginController::class, 'doLogin'])->name('doLogin');

Route::middleware([CheckLogin::class])->group(function (){
//   Route::get('', [SyncController::class, 'syncEmployees'])->name('index');
    Route::get('', [HomeController::class, 'home'])->name('index');
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
});
