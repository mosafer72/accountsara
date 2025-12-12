<?php

require_once "auth.php";
require_once "user.php";
require_once "admin.php";
require_once "site_map.php";



use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\Site\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\CartCouponController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\PaymentController;

Route::get("/faq", [HomeController::class,"faq"])->name("faq");
Route::get("/about_us", [HomeController::class,"about_us"])->name("about_us");
Route::get('/product/{id}', [ProductController::class,"show_more"])->name("product.show_more");
Route::get('/category/{id}/products', [ProductController::class,"show_by_category"])->name("category.products");

Route::get('/cart/show', [CartController::class,"show"])->name("cart.show");
Route::get('/cart/show', [CartController::class,"show"])->name("cart.show");
Route::post('/cart/{id}/add', [CartController::class,"add"])->name("cart.add");
Route::get('/cart/{id}/add', [CartController::class,"add"])->name("cart.add");
Route::get('/cart/{id}/delete', [CartController::class,"delete"])->name("cart.delete");



use App\Http\Controllers\Auth\OtpAuthController;

Route::middleware('guest')->group(function () {
    Route::get('/auth/phone', [OtpAuthController::class, 'showPhoneForm'])->name('otp.phone.form');
    Route::post('/auth/send',  [OtpAuthController::class, 'send'])->name('otp.send');

    Route::get('/auth/verify', [OtpAuthController::class, 'showVerifyForm'])->name('otp.verify.form');
    Route::post('/auth/verify', [OtpAuthController::class, 'verify'])->name('otp.verify');
});



Route::middleware('auth')->group(function () {
  Route::post('/cart/coupon/apply',  [CartCouponController::class, 'apply'])->name('cart.coupon.apply');
  Route::delete('/cart/coupon/remove', [CartCouponController::class, 'remove'])->name('cart.coupon.remove');
  // ساخت سفارش از روی سبد خرید (ایجاد order + order_items)
  Route::get('/checkout/place-order', [CheckoutController::class, 'createOrder'])
        ->name('checkout.place');
  Route::get('/payment/start/{order}', [PaymentController::class, 'start'])->name('payment.start');
  Route::match(['GET','POST'],'/payment/callback/{provider}', [PaymentController::class, 'callback'])
    ->name('payment.callback');
});



// this is for perfium
Route::get('/', [HomeController::class,"index"]);
Route::get('/products', [ProductController::class,"products"]);






