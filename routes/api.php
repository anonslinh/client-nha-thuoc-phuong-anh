<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\InvoicesController;
use App\Http\Controllers\API\GiftExchangesController;
use App\Http\Controllers\API\VoucherExchangesController;
use App\Http\Controllers\API\EventsController;
use App\Http\Controllers\API\SettingGlobalController;
use App\Http\Controllers\VideoProductController;
use App\Http\Controllers\RotationController;

Route::post('reward-point', [HomeController::class, 'rewardPointCustomer']);
Route::get('banners', [HomeController::class, 'getBanners']);
Route::get('gifts', [HomeController::class, 'getGifts']);
Route::get('programs', [HomeController::class, 'getPrograms']);
Route::get('promotions', [HomeController::class, 'getPromotions']);
Route::get('invoices', [InvoicesController::class, 'getInvoices']);
Route::get('today-invoices', [InvoicesController::class, 'getTodayInvoices']);
Route::post('invoice-rating', [InvoicesController::class, 'invoiceRating']);
Route::get('membership-info', [HomeController::class, 'getMembershipInfo']);
Route::get('vouchers', [HomeController::class, 'getVouchers']);
Route::get('mini-games', [HomeController::class, 'getActiveMiniGames']);
Route::get('contacts', [HomeController::class, 'getContacts']);
Route::get('slogan', [HomeController::class, 'getSlogans']);

//Đổi quà
Route::get('branches', [GiftExchangesController::class, 'getBranches']);
Route::post('exchange-gift', [GiftExchangesController::class, 'exchangeGift']);
Route::get('gift-exchanges-by-phone', [GiftExchangesController::class, 'getGiftExchangesByPhone']);
Route::post('gift-exchange/confirm', [GiftExchangesController::class, 'confirmGiftExchange']);
Route::post('gift-exchange/cancel', [GiftExchangesController::class, 'cancelGiftExchange']);

//Đổi voucher
Route::post('exchange-voucher', [VoucherExchangesController::class, 'exchangeVoucher']);
Route::get('voucher-exchanges-by-phone', [VoucherExchangesController::class, 'getVouchersByPhone']);
Route::post('voucher-exchange/confirm', [VoucherExchangesController::class, 'confirmVoucherExchange']);
Route::post('voucher-exchange/cancel', [VoucherExchangesController::class, 'cancelVoucherExchange']);

// Sụ kiện
Route::prefix('events')->group(function (){
    Route::get('get-data', [EventsController::class, 'getDataCustomer']);
    Route::post('exchange-gift', [EventsController::class, 'exchangeGift']);
    Route::get('history-exchange-gift', [EventsController::class, 'historyExchangeGift']);
    Route::post('status-exchange-gift', [EventsController::class, 'statusExchangeGift']);
    Route::get('history-point', [EventsController::class, 'historyPoint']);
});

// Follow OA
Route::prefix('follow')->group(function (){
    Route::post('', [SettingGlobalController::class, 'storeFollow']);
    Route::post('check-follow', [SettingGlobalController::class, 'checkFollow']);
});

// Video Product
Route::get('id-video', [VideoProductController::class, 'idVideoApi']);
// Mua là có quà
Route::prefix('product-gift')->group(function (){
   Route::get('home', [VideoProductController::class, 'homeAPI']);
   Route::get('category-point', [VideoProductController::class, 'categoryPoint']);
   Route::get('list-product', [VideoProductController::class, 'listProduct']);
   Route::post('detail-product', [VideoProductController::class, 'detailProductAPI']);
   Route::get('list-gift', [VideoProductController::class, 'listGiftAPI']);
   Route::get('detail-gift', [VideoProductController::class, 'detailGift']);
   Route::post('info-customer', [VideoProductController::class, 'infoCustomer']);
   Route::post('add-to-cart', [VideoProductController::class, 'addToCart']);
});
// Vòng quay may mắn
Route::prefix('rotation')->group(function (){
    Route::post('list-gift', [RotationController::class, 'listGiftAPI']);
    Route::post('exchange-gift', [RotationController::class, 'exchangeGiftAPI']);
    Route::post('get-my-gift', [RotationController::class, 'getMyGiftAPI']);
});
