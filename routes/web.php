<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\Client\OrderController;
use App\Http\Controllers\Dashboard\OrderController as OrdersController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group(
    ['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']],
    function () {

        Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard');

        Route::redirect('/', '/dashboard/index');


        Route::resource('dashboard/users', UserController::class)->except('show');
        Route::resource('dashboard/categories', CategoryController::class)->except('show');
        Route::resource('dashboard/products', ProductController::class)->except('show');
        Route::resource('dashboard/clients', ClientController::class)->except('show');
        Route::resource('dashboard/{client}/orders', OrderController::class)->except('show', 'index');
        Route::resource('dashboard/orders', OrdersController::class)->except('show', 'create', 'store', 'edit', 'update');

        Route::get('orders/get-products/{order}', [OrdersController::class, 'getProducts'])->name('orders.get-products');
    }
);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
