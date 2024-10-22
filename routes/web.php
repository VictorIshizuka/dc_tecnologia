<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



// Route::get('/register', [UserController::class, 'register'])->name('register');

// Rotas de auth
Route::post('/register-action', [UserController::class, 'register_action'])->name('register_action');

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login-action', [UserController::class, 'login_action'])->name('login_action');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.home');

    // Rotas de clientes
    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.home');
        Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('{id}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });

    // Rotas de produtos
    Route::prefix('products')->group(function () {
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/info', [ProductController::class, 'show'])->name('products.show');
        Route::get('{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Rotas de pedidos de venda
    Route::prefix('sales-orders')->group(function () {
        Route::get('/', [SalesOrderController::class, 'index'])->name('sales_orders.home');
        Route::post('/', [SalesOrderController::class, 'store'])->name('sales_orders.store');
        Route::get('/search', [SalesOrderController::class, 'search'])->name('sales_orders.search');
        Route::get('/show/{id}', [SalesOrderController::class, 'show'])->name('sales_orders.show');
        Route::get('{id}/edit', [SalesOrderController::class, 'edit'])->name('sales_orders.edit');
        Route::put('{id}', [SalesOrderController::class, 'update'])->name('sales_orders.update');
        Route::delete('{id}', [SalesOrderController::class, 'destroy'])->name('sales_orders.destroy');
        Route::get('/create', [SalesOrderController::class, 'create'])->name('sales_orders.create');
        Route::get('/create/pdf/{id}', [SalesOrderController::class, 'createPDF'])->name('generatePDF');
    });
});