<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', function () {
        return redirect('/login');
    })->name("home.index");
    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });
    Route::fallback(function () {
        return response()->view('errors.403', [], 403);
    });

    Route::group(['middleware' => ['guest']], function () {
        Route::get('/login', 'AuthController@index')->name('auth.index');
        Route::post('/login', 'AuthController@login')->name('auth.login');
    });


    Route::group(['middleware' => ['auth']], function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
        Route::post('/logout', 'AuthController@logout')->name('auth.logout');

        Route::prefix('posko')->group(function () {
            Route::get('/', 'PoskoController@index')->name('posko.index');
            Route::get('/create', 'PoskoController@create')->name('posko.create');
            Route::get('/{id}/edit', 'PoskoController@edit')->name('posko.edit');
            Route::put('/{id}/update', 'PoskoController@update')->name('posko.update');
            Route::post('/store', 'PoskoController@store')->name('posko.store');
            Route::delete('/{id}/destroy', 'PoskoController@destroy')->name('posko.destroy');
            Route::get('/get-posko', 'PoskoController@getPosko')->name('getPosko');
        });

        Route::prefix('admin')->group(function () {
            Route::get('/', 'AdminController@index')->name('admin.index');
            Route::get('/create', 'AdminController@create')->name('admin.create');
            Route::get('/{id}/edit', 'AdminController@edit')->name('admin.edit');
            Route::post('/store', 'AdminController@store')->name('admin.store');
            Route::put('/{id}/update', 'AdminController@update')->name('admin.update');
            Route::delete('/{id}/destroy', 'AdminController@destroy')->name('admin.destroy');
        });

        Route::prefix('kader')->group(function () {
            Route::get('/', 'KaderController@index')->name('kader.index');
            Route::get('/create', 'KaderController@create')->name('kader.create');
            Route::post('/store', 'KaderController@store')->name('kader.store');
        });

        Route::get('/petugas-kesehatan', 'PetugasController@index')->name('petugas.index');
    });
});
