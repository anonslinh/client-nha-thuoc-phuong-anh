<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\InvoicesController;

Route::post('reward-point', [HomeController::class, 'rewardPointCustomer']);
Route::get('banners', [HomeController::class, 'getBanners']);
Route::get('gifts', [HomeController::class, 'getGifts']);
Route::get('programs', [HomeController::class, 'getPrograms']);
Route::get('promotions', [HomeController::class, 'getPromotions']);
Route::get('invoices', [InvoicesController::class, 'getInvoices']);
Route::post('invoice-rating', [InvoicesController::class, 'invoiceRating']);
Route::get('membership-info', [HomeController::class, 'getMembershipInfo']);
Route::get('vouchers', [HomeController::class, 'getVouchers']);

