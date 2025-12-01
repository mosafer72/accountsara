<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpAuthController;
use App\Http\Controllers\User\OrderCotroller;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\TicketCotroller;
use Illuminate\Support\Facades\Route;


Route::get('/profile', [ProfileController::class,"index"])->middleware('auth')->name('dashboard');
Route::get('/profile/orders', [OrderCotroller::class,"orders"])->middleware('auth')->name('profile.orders');
Route::get('/profile/tickets', [TicketCotroller::class,"tickets"])->middleware('auth')->name('profile.tickets');
Route::get('/profile/tickets/create/{id?}', [TicketCotroller::class,"create"])->middleware('auth')->name('profile.tickets.create');
Route::post('/profile/tickets/store', [TicketCotroller::class,"store"])->middleware('auth')->name('profile.tickets.store');
Route::get('/orders/result', [OrderCotroller::class,"result"])->middleware('auth')->name('user.orders.result');
Route::get('logout', [LoginController::class,'logout'])->name('logout');
Route::get('login', [OtpAuthController::class,'showPhoneForm'])->name('login');

