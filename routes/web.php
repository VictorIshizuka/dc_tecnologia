<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register-action', [UserController::class, 'register_action'])->name('register_action');

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login-action', [UserController::class, 'login_action'])->name('login_action');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');
