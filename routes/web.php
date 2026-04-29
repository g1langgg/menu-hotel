<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MenuController as PublicMenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public Menu Routes
Route::get('/menu', [PublicMenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{id}', [PublicMenuController::class, 'show'])->name('menu.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// Order Routes
Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
Route::post('/order/search', [OrderController::class, 'search'])->name('order.search');

// Service Requests
Route::post('/service-request', [\App\Http\Controllers\ServiceRequestController::class, 'store'])->name('service.request');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('menus', MenuController::class);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{id}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::get('orders/{id}/print', [AdminOrderController::class, 'print'])->name('orders.print');
    Route::post('service-request/{id}/resolve', [\App\Http\Controllers\ServiceRequestController::class, 'resolve'])->name('service.request.resolve');
    Route::get('qrcode', [\App\Http\Controllers\Admin\QrCodeController::class, 'index'])->name('qrcode.index');
    // API: real-time dashboard data
    Route::get('api/dashboard-data', [AdminOrderController::class, 'dashboardData'])->name('api.dashboard');
    
    // Settings
    Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'store'])->name('settings.store');
});

// Public API: order status polling
Route::get('/api/order/{id}/status', [OrderController::class, 'status'])->name('order.status');

// QRIS Payment Routes
Route::get('/order/{id}/payment', [OrderController::class, 'payment'])->name('order.payment');
Route::post('/order/{id}/payment', [OrderController::class, 'uploadReceipt'])->name('order.payment.store');

require __DIR__.'/auth.php';
