<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckLogin;
use App\Http\Controllers\Admin\SyncController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\GiftController;

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::get('register', [LoginController::class, 'register'])->name('register');
Route::post('user-register', [LoginController::class, 'userRegister'])->name('register-user');
Route::post('doLogin', [LoginController::class, 'doLogin'])->name('doLogin');

Route::middleware([CheckLogin::class])->group(function (){
//   Route::get('', [SyncController::class, 'syncEmployees'])->name('index');
    Route::get('', [HomeController::class, 'home'])->name('index');
    Route::get('logout', [HomeController::class, 'logout'])->name('logout');
    Route::prefix('gift')->name('gift.')->group(function (){
        Route::post('store', [GiftController::class, 'store'])->name('store');
    });
    Route::prefix('banner')->name('banner.')->group(function (){
       Route::get('list-data', [GiftController::class, 'banner'])->name('list-data');
       Route::post('store', [GiftController::class, 'storeBanner'])->name('store');
    });
    Route::prefix('program')->name('program.')->group(function (){
       Route::get('list-data', [GiftController::class, 'program'])->name('list-data');
       Route::get('create', [GiftController::class, 'createProgram'])->name('create');
       Route::post('store', [GiftController::class, 'storeProgram'])->name('store');
       Route::get('detail/{id}', [GiftController::class, 'detailProgram'])->name('detail');
    });
});
