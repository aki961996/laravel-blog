<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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



Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'auth_login')->name('auth_login');

    Route::get('register', 'register')->name('register');
    Route::post('register', 'create_user')->name('create_user');

    Route::get('forget_password', 'forget_pass')->name('forget_password');
    Route::post('forget_password', 'forget_password_create')->name('forget_password_create');

    Route::get('reset-password/{token}', 'reset_password');
    Route::post('reset-password/{token}', 'rest_password_post')->name('rest_password_post');


    Route::get('verify/{token}', 'verify');
});

Route::controller(DashboardController::class)->group(function () {

    Route::get('panel/dashboard', 'dashboard')->name('dashboard');
});
