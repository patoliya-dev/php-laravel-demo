<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\user\RegisterController;
use App\Http\Controllers\user\DashboardController;
use App\Http\Controllers\admin\AdminDashboardController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(RegisterController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/register', 'store');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index');
    Route::post('/loginform', 'login');
    Route::get('/reset-password', 'resetPassword');
    Route::post('/reset-password-action', 'resetPasswordAction');
    Route::get('/reset-password-view/{token}', 'resetPasswordView');
    Route::post('/reset-password-confirm', 'resetPasswordConfirm');
    Route::get('/logout', 'logout');
});

Route::group(['prefix' => 'user-dashboard'], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('edit/{id}', 'edit')->name('user');
        Route::post('update/{id}', 'update')->name('user');
    });
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::controller(AdminDashboardController::class)->group(function () {
        Route::get('/', 'usersShow');
        Route::delete('delete/{id}', 'userDelete')->name('admin');
        Route::put('updateRole/{id}', 'updateUserRole')->name('admin');
    });
});
