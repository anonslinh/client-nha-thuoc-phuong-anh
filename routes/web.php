<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckLogin;
use App\Http\Controllers\Admin\SyncController;

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::get('register', [LoginController::class, 'register'])->name('register');
Route::post('user-register', [LoginController::class, 'userRegister'])->name('register-user');
Route::post('doLogin', [LoginController::class, 'doLogin'])->name('doLogin');

Route::middleware([CheckLogin::class])->group(function (){
   Route::get('', [SyncController::class, 'syncEmployees'])->name('index');
});
