<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\BuyerUserController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\FishController;
use App\Http\Controllers\Admin\RoleCrontroller;
use App\Http\Controllers\Admin\SellerUserController;
use App\Http\Controllers\Admin\SellingController;
use App\Http\Controllers\Admin\UserControlle;
use App\Models\BuyerUser;
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

        Route::controller(BuyerUserController::class)->group(function(){
            Route::get('/buyer-user','index')->name('buyer-user.index');
            Route::get('/buyer-user/create','create')->name('buyer-user.create');
            Route::post('/buyer-user','store')->name('buyer-user.store');
            Route::get('/buyer-user/{buyer_user}/edit','edit')->name('buyer-user.edit');
            Route::put('/buyer-user/{buyer_user}','update')->name('buyer-user.update');
            Route::delete('/buyer-user/{buyer_user}','destroy')->name('buyer-user.destroy');
            Route::post('/buyer-user/change-status','changeStatus')->name('buyer-user.change-status');

        });


        Route::controller(SellerUserController::class)->group(function(){
            Route::get('/seller-user','index')->name('seller-user.index');
            Route::get('/seller-user/create','create')->name('seller-user.create');
            Route::post('/seller-user','store')->name('seller-user.store');
            Route::get('/seller-user/{seller_user}/edit','edit')->name('seller-user.edit');
            Route::put('/seller-user/{seller_user}','update')->name('seller-user.update');
            Route::delete('/seller-user/{seller_user}','destroy')->name('seller-user.destroy');
            Route::post('/seller-user/change-status','changeStatus')->name('seller-user.change-status');
        });

        Route::controller(UserControlle::class)->group(function(){
            Route::get('/user','index')->name('user.index');
            Route::get('/user/create','create')->name('user.create');
            Route::post('/user','store')->name('user.store');
            Route::get('/user/{user}/edit','edit')->name('user.edit');
            Route::put('/user/{user}','update')->name('user.update');
            Route::delete('/user/{user}','destroy')->name('user.destroy');
        });

        Route::controller(FishController::class)->group(function(){
            Route::get('/fish','index')->name('fish.index');
            Route::get('/fish/create','create')->name('fish.create');
            Route::post('/fish','store')->name('fish.store');
            Route::get('/fish/{fish}/edit','edit')->name('fish.edit');
            Route::put('/fish/{fish}','update')->name('fish.update');
            Route::delete('/fish/{fish}','destroy')->name('fish.destroy');
        });

        Route::controller(SellingController::class)->group(function(){
            Route::get('/selling','index')->name('selling.index');
            Route::get('/selling/create','create')->name('selling.create');
            Route::post('/selling','store')->name('selling.store');
            Route::get('/selling/{selling}/show','show')->name('selling.show');
            Route::get('/selling/{selling}/edit','edit')->name('selling.edit');
            Route::put('/selling/{selling}','update')->name('selling.update');
            Route::delete('/selling/{selling}','destroy')->name('selling.destroy');
        });


    });
});
