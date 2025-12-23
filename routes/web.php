<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/update/{productId}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
    Route::get('/data', [CartController::class, 'getCartData'])->name('data');
});

// Checkout (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.coupon');
    Route::post('/checkout/shipping-options', [CheckoutController::class, 'getShippingOptions'])->name('checkout.shipping');
    Route::get('/checkout/calculate', [CheckoutController::class, 'calculateTotal'])->name('checkout.calculate');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/return', [OrderController::class, 'requestReturn'])->name('orders.return');
    Route::post('/orders/{order}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('orders.track');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    
    // Payment Routes
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/cod/{order}', [PaymentController::class, 'codPayment'])->name('cod');
        Route::get('/card/{order}', [PaymentController::class, 'cardPayment'])->name('card');
        Route::get('/bkash/{order}', [PaymentController::class, 'bkashPayment'])->name('bkash');
        Route::get('/nagad/{order}', [PaymentController::class, 'nagadPayment'])->name('nagad');
        
        Route::post('/confirm/{order}', [PaymentController::class, 'confirmPayment'])->name('confirm');
        Route::post('/cancel/{order}', [PaymentController::class, 'cancelPayment'])->name('cancel');
        Route::post('/delivery/{order}', [PaymentController::class, 'confirmDelivery'])->name('delivery');
    });
});

// Payment Webhook (no auth required)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Admin routes (requires admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Products management
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // Order management
    Route::post('/orders/{order}/return/{line}', [OrderController::class, 'processReturn'])->name('orders.processReturn');
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';