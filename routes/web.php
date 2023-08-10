<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\user\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(RegisterController::class)->group(function () {
    Route::post('/register', 'store');
});
Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/logout', 'logout');
    });
    Route::group(['prefix' => 'dashboard'], function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('edit/{id}', 'edit')->name('user');
            Route::post('update/{id}', 'update')->name('user');
            Route::delete('delete/{id}', 'userDelete')->name('admin');
            Route::put('updateRole/{id}', 'updateUserRole')->name('admin');
        });
    });
});
