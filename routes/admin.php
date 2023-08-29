<?php

use Ecommerce\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "admin" middleware group. Make something great!
|
*/


Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['prefix' => 'admin','middleware' => ['auth', 'verified']], function () {

       Route::resource('/',DashboardController::class)->name('index','dashboard');

    });
});



