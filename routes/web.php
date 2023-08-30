<?php

use App\Http\Controllers\Auth\LoginController;
use Ecommerce\Admin\DashboardController;
use Ecommerce\Customer\Controllers\Dashboard\DashboardCustomerController;
use Ecommerce\Home\HomeController;
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

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {
    // Login
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/login/{type}', [LoginController::class, 'loginForm'])->middleware('guest')->name('login.show');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::get('/logout/{type}', [LoginController::class, 'logout'])->name('logout');
    });

    Route::get('/selection', [HomeController::class, 'selection'])->name('selection');
    Route::resource('/', Homecontroller::class)->name('index', 'home');
    Route::resource('/dashboard', DashboardController::class)->name('index', 'dashboard')->middleware(['auth', 'verified']);
    Route::resource('/customer/dashboard', DashboardCustomerController::class)->name('index', '/customer/dashboard');

});
require __DIR__ . '/auth.php';
