<?php

use App\Http\Controllers\Auth\LoginController;
use Ecommerce\Admin\DashboardController;
use Ecommerce\Customer\Controllers\Dashboard\DashboardCustomerController;
use Ecommerce\Home\HomeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Dashboard routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "Dashboard" middleware group. Make something great!
|
*/

//Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
//    Route::group(['prefix' => 'customer'], function () {
//    });
//});

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::group(['namespace' => 'Auth'], function () {
        // Defining routes within the 'Auth' namespace group

        // Route to display the login form
        Route::get('/login/{type}', [LoginController::class, 'loginForm'])
            ->middleware('guest') // Applying the 'guest' middleware to prevent authenticated users from accessing this route
            ->name('login.show'); // Assigning the name 'login.show' to this route

        // Route to handle the login form submission
        Route::post('/login', [LoginController::class, 'login'])
            ->name('login'); // Assigning the name 'login' to this route

        // Route to handle user logout
        Route::get('/logout/{type}', [LoginController::class, 'logout'])
            ->name('logout'); // Assigning the name 'logout' to this route
    });

    Route::get('/selection', [HomeController::class, 'selection'])->name('selection');
    Route::resource('/', Homecontroller::class)->name('index', 'home');


    Route::resource('/customer/dashboard', DashboardCustomerController::class)->name('index', '/customer/dashboard');

    Route::resource('/Dashboard', DashboardController::class)->name('index', 'dashboard')->middleware(['auth', 'verified']);

});




