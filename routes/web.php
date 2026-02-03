<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// Homepage
Route::get('/', [ProductController::class, 'index'])->name('home');

// Product routes
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/catalog', [ProductController::class, 'catalog'])->name('catalog');
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/product-quick-view/{id}', [ProductController::class, 'quickView'])->name('product.quickview');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

// Checkout routes
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/{id}/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');

// Services Routes
Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [App\Http\Controllers\ServiceController::class, 'show'])->name('services.show');
Route::get('/appointment', [App\Http\Controllers\ServiceController::class, 'create'])->name('appointment.create');
Route::post('/appointment', [App\Http\Controllers\ServiceController::class, 'store'])->name('appointment.store');

// Lead Capture
Route::post('/leads', [App\Http\Controllers\LeadController::class, 'store'])->name('leads.store');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
});

Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Account Routes (Protected)
Route::prefix('account')->name('account.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AccountController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [App\Http\Controllers\AccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [App\Http\Controllers\AccountController::class, 'orderDetail'])->name('order.detail');
    Route::get('/profile', [App\Http\Controllers\AccountController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\AccountController::class, 'updateProfile'])->name('profile.update');
});

// POS routes
Route::middleware(['auth', 'permission:access_pos'])->group(function () {
    Route::get('/pos', [App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/session/open', [App\Http\Controllers\PosController::class, 'openSession'])->name('pos.session.open');
    Route::post('/pos/session/close', [App\Http\Controllers\PosController::class, 'closeSession'])->name('pos.session.close');
    Route::post('/pos/order', [App\Http\Controllers\PosController::class, 'store'])->name('pos.order.store');
    Route::get('/pos/receipt/{id}', [App\Http\Controllers\PosController::class, 'receipt'])->name('pos.receipt');
});
