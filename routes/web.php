<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');


// Checkout Routes (handled for authenticated users below)
/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
// (removed duplicate public checkout routes) The checkout routes are available inside the authenticated group below.
Route::middleware(['auth'])->group(function () {
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/confirm/{order}', [CheckoutController::class, 'confirmPurchase'])->name('checkout.confirm');
    // Profile Routes
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::put('/profile', [HomeController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [HomeController::class, 'updatePassword'])->name('password.update');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // Sell Books
    Route::get('/sell', [BookController::class, 'create'])->name('sell');
    Route::post('/sell', [BookController::class, 'store'])->name('books.store');
});
