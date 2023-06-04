<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers'], function() {
    Route::get('/', function () {
        return view('index');
    })->name("home.index");
    
    Route::group(['middleware' => ['guest']], function() {
        Route::get('/login', function () {
            return view('login');
        })->name('login.index');
    });
});