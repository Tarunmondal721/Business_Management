<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\RoleCrontroller;
use Illuminate\Support\Facades\Route;

Route::redirect('/','admin/login');

Route::prefix('/admin')->name('admin.')->group(function () {
    Route::controller(AuthController::class)->group(function(){
        Route::get('/login','loginForm')->name('login');
        Route::post('/login','login')->name('login.submit');
        Route::get('/forgot-password','showLinkRequestForm')->name('forgot.password');
        Route::post('/forgot-password','sendResetLinkEmail')->name('forgot.password.email');
        Route::get('/reset-password/{token}','showResetForm')->name('reset-password');
        Route::post('/reset-password','reset')->name('reset-password.submit');

    });

    Route::controller(DashBoardController::class)->group(function(){
        Route::get('/dashboard','index')->name('dashboard');
    });

    Route::middleware('isAdmin')->group(function(){
        Route::get('/logout',[AuthController::class,'logout'])->name('logout');
        Route::resource('/role', RoleCrontroller::class)->names('role');

    });
});
