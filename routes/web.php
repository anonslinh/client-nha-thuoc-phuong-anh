<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckLogin;

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::get('register', [LoginController::class, 'register'])->name('register');
Route::post('user-register', [LoginController::class, 'userRegister'])->name('register-user');
Route::post('doLogin', [LoginController::class, 'doLogin'])->name('doLogin');

Route::middleware([CheckLogin::class])->group(function (){
   Route::get('', function (){
     return view('welcome');
   })->name('index');
});
