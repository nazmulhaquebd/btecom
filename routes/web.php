<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
Route::get('/contact', [App\Http\Controllers\Frontend\HomeController::class, 'contact'])->name('contact');
Route::get('/products/show/{id}', [App\Http\Controllers\Frontend\ProductController::class, 'show'])->name('product.show');

Route::get('/login',[\App\Http\Controllers\Frontend\UserController::class,'login'])->name('login');

//admin login
Route::get('/admin/login', [\App\Http\Controllers\Backend\LoginController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\Backend\LoginController::class, 'submitLogin']);

Route::get('add/cart/{id}',[\App\Http\Controllers\Frontend\CartController::class,'store'])->name('add.cart');
Route::get('checkout',[\App\Http\Controllers\Frontend\CartController::class,'checkout'])->name('checkout');


Route::middleware(['auth'])->group(function () {

    Route::get('/profile',[\App\Http\Controllers\Frontend\UserController::class,'index'])->name('profile');
    Route::get('/user/logout',[\App\Http\Controllers\Frontend\UserController::class,'logout'])->name('user.logout');

    Route::get('place-order',[\App\Http\Controllers\Frontend\OrderController::class,'placeOrder'])->name('place_order');

    Route::get('order/{id}',[\App\Http\Controllers\Frontend\OrderController::class,'show'])->name('user.order.show');

    Route::post('order/submit',[\App\Http\Controllers\Frontend\OrderController::class,'submitOrder'])->name('submit.order');

    Route::middleware(['check_admin'])->prefix('admin')->group(function () {

        //admin Dashboard
        Route::get('/', [\App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('admin.dashboard');

        //admin users
        Route::get('/users', [\App\Http\Controllers\Backend\UserController::class, 'index'])->name('admin.user');

        //admin Profile
        Route::get('/profile', [\App\Http\Controllers\Backend\UserController::class, 'profile'])->name('admin.profile');
        Route::post('/profile', [\App\Http\Controllers\Backend\UserController::class, 'editProfile']);
        Route::get('/logout', [\App\Http\Controllers\Backend\UserController::class, 'logout'])->name('admin.logout');

        //admin product
        Route::get('/products',[\App\Http\Controllers\Backend\ProductController::class,'index'])->name('admin.product');
        Route::get('/products/create',[\App\Http\Controllers\Backend\ProductController::class,'create'])->name('admin.product.create');
        Route::post('/products/create',[\App\Http\Controllers\Backend\ProductController::class,'store']);

        Route::get('/products/{id}/edit/',[\App\Http\Controllers\Backend\ProductController::class,'edit'])->name('admin.product.edit');
        Route::post('/products/{id}/edit/',[\App\Http\Controllers\Backend\ProductController::class,'update']);

        //Admin order

        Route::get('orders',[\App\Http\Controllers\Backend\OrderController::class,'index'])->name('admin.order');
        Route::get('orders/{id}',[\App\Http\Controllers\Backend\OrderController::class,'show'])->name('admin.order.show');

        Route::post('orders/{id}/status',[\App\Http\Controllers\Backend\OrderController::class,'changeStatus'])->name('admin.order.status');

    });
});
