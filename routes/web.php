<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', function () {
        return redirect('/login');
    })->name("home.index");

    Route::group(['middleware' => ['guest']], function () {
        Route::get('/login', 'AuthController@index')->name('auth.index');
        Route::post('/login', 'AuthController@login')->name('auth.login');
    });


    Route::group(['middleware' => ['auth']], function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
        Route::post('/logout', 'AuthController@logout')->name('auth.logout');

        Route::get('/posko', 'PoskoController@index')->name('posko.index');
        Route::get('/posko/create', 'PoskoController@create')->name('posko.create');
        Route::post('/posko/store', 'PoskoController@store')->name('posko.store');

        Route::get('/admin', 'AdminController@index')->name('admin.index');

        Route::get('/kader', 'KaderController@index')->name('kader.index');

        Route::get('/petugas-kesehatan', 'PetugasController@index')->name('petugas.index');
    });
});
