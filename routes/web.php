<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\CartController;
use \App\Http\Controllers\CheckoutController;
use \App\Http\Controllers\ProfileController;

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

Route::get('/', [ProductController::class, 'index']);
Route::get('/catalog', [ProductController::class, 'index'])->name('catalog.show');
Route::post('/cart/add/{product}', [CartController::class, 'create'])->name('cartAdd');
Route::post('/cart/remove/{item}', [CartController::class, 'destroy'])->name('cart.remove');
Route::post('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/show', [CartController::class, 'index'])->name('cart.show');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.show')->middleware('auth');
Route::post('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm')->middleware('auth');
Route::get('user/orders', [ProfileController::class, 'orders'])->name('user.orders')->middleware('auth');
Route::resource('user', \App\Http\Controllers\ProfileController::class)->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
