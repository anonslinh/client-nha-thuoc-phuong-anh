<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\InvoicesController;
use App\Http\Controllers\API\GiftExchangesController;
use App\Http\Controllers\API\VoucherExchangesController;

Route::post('reward-point', [HomeController::class, 'rewardPointCustomer']);
Route::get('banners', [HomeController::class, 'getBanners']);
Route::get('gifts', [HomeController::class, 'getGifts']);
Route::get('programs', [HomeController::class, 'getPrograms']);
Route::get('promotions', [HomeController::class, 'getPromotions']);
Route::get('invoices', [InvoicesController::class, 'getInvoices']);
Route::post('invoice-rating', [InvoicesController::class, 'invoiceRating']);
Route::get('membership-info', [HomeController::class, 'getMembershipInfo']);
Route::get('vouchers', [HomeController::class, 'getVouchers']);
Route::get('mini-games', [HomeController::class, 'getActiveMiniGames']);
Route::get('contacts', [HomeController::class, 'getContacts']);

//Đổi quà
Route::post('exchange-gift', [GiftExchangesController::class, 'exchangeGift']);
Route::get('gift-exchanges-by-phone', [GiftExchangesController::class, 'getGiftExchangesByPhone']);
Route::post('gift-exchange/confirm', [GiftExchangesController::class, 'confirmGiftExchange']);
Route::post('gift-exchange/cancel', [GiftExchangesController::class, 'cancelGiftExchange']);

//Đổi voucher
Route::post('exchange-voucher', [VoucherExchangesController::class, 'exchangeVoucher']);
Route::get('voucher-exchanges-by-phone', [VoucherExchangesController::class, 'getVouchersByPhone']);
Route::post('voucher-exchange/confirm', [VoucherExchangesController::class, 'confirmVoucherExchange']);
Route::post('voucher-exchange/cancel', [VoucherExchangesController::class, 'cancelVoucherExchange']);

