<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::resource('/', HomeController::class)->only(['index']);

Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/product', [ProductController::class, 'index'])->name('product');

Route::get('/account', [AccountController::class, 'index'])->name('account');

// We will add these later when pages are converted:
Route::get('/categories', function () { return view('categories.index'); });
Route::get('/contact', function () { return view('contact.index'); });
Route::get('/checkout', function () { return view('cart.checkout'); });
Route::get('/faq', function () { return view('legal.faq'); });
Route::get('/about', function () { return view('legal.about'); });
Route::get('/terms', function () { return view('legal.terms'); });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
