<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', function () {
        return redirect('/login');
    })->name("home.index");
    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });
    // Route::fallback(function () {
    //     return response()->view('errors.403', [], 403);
    // });

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
            Route::get('/{id}/edit', 'KaderController@edit')->name('kader.edit');
            Route::post('/store', 'KaderController@store')->name('kader.store');
            Route::put('/{id}/{user_id}/update', 'KaderController@update')->name('kader.update');
            Route::delete('/{id}/{user_id}/destroy', 'KaderController@destroy')->name('kader.destroy');
        });

        Route::prefix('petugas')->group(function () {
            Route::get('/', 'PetugasController@index')->name('petugas.index');
            Route::get('/create', 'PetugasController@create')->name('petugas.create');
            Route::post('/store', 'PetugasController@store')->name('petugas.store');
            Route::get('/{id}/edit', 'PetugasController@edit')->name('petugas.edit');
            Route::put('/{id}/{user_id}/update', 'PetugasController@update')->name('petugas.update');
            Route::delete('/{id}/{user_id}/destroy', 'PetugasController@destroy')->name('petugas.destroy');
        });

        Route::prefix('ibu')->group(function () {
            Route::get('/', 'IbuController@index')->name('ibu.index');
            Route::get('/create', 'IbuController@create')->name('ibu.create');
            Route::get('/{id}/edit', 'IbuController@edit')->name('ibu.edit');
            Route::post('/store', 'IbuController@store')->name('ibu.store');
            Route::put('/{id}/update', 'IbuController@update')->name('ibu.update');
            Route::delete('/{id}/destroy', 'IbuController@destroy')->name('ibu.destroy');
        });
    });
});
