<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\DetailController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Client\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('client.google.redirect')->middleware('web');
Route::get('google/callback', [GoogleController::class, 'callback'])->name('client.google.callback')->middleware('web');

Route::get('/', [HomeController::class, 'index'])->name('client.home');

Route::prefix('')
    ->controller(ClientController::class)
    ->name('client.')
    ->group(function () {
        Route::get('shop', 'shop')->name('shop');
        Route::get('order-history', 'orderHistory')->name('order-history');
    });

Route::prefix('user')
    ->controller(CartController::class)
    ->name('client.')
    ->middleware('auth')
    ->group(function () {
        Route::get('cart', 'index')->name('cart');
        Route::post('add-item-to-cart/{product}', 'addToCart')->name('add-item-to-cart');
        Route::post('update-cart', 'updateCart')->name('update-cart');
        Route::post('add-to-cart-from-detail/{product}', 'addToCartFromDetail')->name('add-to-cart-from-detail');
        Route::get('checkout', 'checkout')->name('checkout');
        Route::post('place-order', 'placeOrder')->name('place-order');
        Route::post('delete-product/{product}', 'deleteProductFromCart')->name('delete-product');
        Route::get('cart-count', 'cartCount')->name('cart-count');
        Route::get('vnpay_return', 'vnpayReturn')->name('vnpay-return');
    });

Route::prefix('')
    ->controller(DetailController::class)
    ->name('client.')
    ->group(function () {
        Route::get('detail/{product}', 'detail')->name('detail');
        Route::post('leave-comment/{product}', 'comment')->name('comment')->middleware('auth');
    });

    Route::prefix('')
    ->controller(ContactController::class)
    ->name('client.')
    ->group(function () {
        Route::get('contact', 'index')->name('contact');
        Route::post('receive-message', 'store')->name('receive-message');
    });

Route::get('vnpay_return', [CartController::class, 'vnpayReturn'])->name('vnpay-return');