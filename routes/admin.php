<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Middleware\isAdmin;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth',isAdmin::class])->prefix('admin')->as('admin.')->group( function () {
    Route::get('', [DashboardController::class,"index"])->name("dashboard");
    Route::get('orders', [OrderController::class,"index"])->name("orders.index");
    Route::resource('/sliders', SliderController::class);
    Route::resource('/users', UserController::class);
    Route::patch('/users/{user}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');
    Route::get('users/{user}/login-as', [UserController::class, 'loginAs'])->name('users.loginAs');
    Route::patch('/sliders/{slider}/toggle', [SliderController::class, 'toggleStatus'])->name('sliders.toggle');
    Route::resource('categories', CategoryController::class);
    Route::patch('/categories/{category}/toggle', [CategoryController::class, 'toggleStatus'])->name('categories.toggle');
    Route::resource('products', ProductController::class);
    Route::patch('products/{product}/toggle', [ProductController::class,'toggle'])->name('products.toggle');
    Route::resource('banners', BannerController::class);
    Route::patch('banners/{banner}/toggle', [BannerController::class, 'toggle'])->name('banners.toggle');
     Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('comments/create/{product}', [CommentController::class, 'create'])->name('comments.create');
    Route::post('comments/store', [CommentController::class, 'store'])->name('comments.store');
    Route::get('comments/edit/{comment}', [CommentController::class, 'edit'])->name('comments.edit');
    Route::patch('comments/update/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::patch('comments/toggle/{comment}', [CommentController::class, 'toggle'])->name('comments.toggle');
    Route::delete('comments/destroy/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::resource('discounts', DiscountController::class)
        ->names('discounts');
    Route::patch('discounts/{discount}/toggle', [DiscountController::class,'toggle'])
        ->name('discounts.toggle');

    Route::get('tickets',[TicketController::class,'index'])->name('tickets.index');
    Route::get('tickets/{ticket}',[TicketController::class,'show'])->name('tickets.show');
    Route::post('tickets',[TicketController::class,'store'])->name('tickets.store');
    Route::patch('tickets/{ticket}/toggle',[TicketController::class,'toggleStatus'])->name('tickets.toggle');
    Route::get('login', [AdminAuthController::class,'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class,'login'])->name('login.submit');
});
