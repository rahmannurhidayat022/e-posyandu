<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', "LandingController@index")->name("home.index");
    Route::get('/kms/{id}', "LandingController@kms")->name("home.kms");
    Route::get('/artikel', 'ArticleController@publicArticle')->name('artikel');
    Route::get('/galeri', 'GalleryController@publicGallery')->name('galeri');
    Route::get('/artikel/{slug}', 'ArticleController@publicArticleDetail')->name('artikel_detail');
    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
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
            Route::get('/create', 'PoskoController@create')->name('posko.create')->middleware('role:admin');
            Route::get('/{id}/edit', 'PoskoController@edit')->name('posko.edit')->middleware('role:admin');
            Route::put('/{id}/update', 'PoskoController@update')->name('posko.update')->middleware('role:admin');
            Route::post('/store', 'PoskoController@store')->name('posko.store')->middleware('role:admin');
            Route::delete('/{id}/destroy', 'PoskoController@destroy')->name('posko.destroy')->middleware('role:admin');
            Route::get('/get-posko', 'PoskoController@getPosko')->name('getPosko');
        });

        Route::prefix('admin')->middleware('role:admin')->group(function () {
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
            Route::put('/{id}/update', 'KaderController@update')->name('kader.update');
            Route::delete('/{id}/destroy', 'KaderController@destroy')->name('kader.destroy');
            Route::get('/get-kader', 'KaderController@getKader')->name('getKader');
        });

        Route::prefix('petugas')->group(function () {
            Route::get('/', 'PetugasController@index')->name('petugas.index');
            Route::get('/create', 'PetugasController@create')->name('petugas.create');
            Route::post('/store', 'PetugasController@store')->name('petugas.store');
            Route::get('/{id}/edit', 'PetugasController@edit')->name('petugas.edit');
            Route::put('/{id}/update', 'PetugasController@update')->name('petugas.update');
            Route::delete('/{id}/destroy', 'PetugasController@destroy')->name('petugas.destroy');
            Route::get('/get-petugas', 'PetugasController@getPetugas')->name('getPetugas');
        });

        Route::prefix('ibu')->group(function () {
            Route::get('/', 'IbuController@index')->name('ibu.index');
            Route::get('/create', 'IbuController@create')->name('ibu.create')->middleware('role:operator');
            Route::get('/{id}/edit', 'IbuController@edit')->name('ibu.edit')->middleware('role:operator,admin');
            Route::post('/store', 'IbuController@store')->name('ibu.store')->middleware('role:operator');
            Route::put('/{id}/update', 'IbuController@update')->name('ibu.update')->middleware('role:operator,admin');
            Route::delete('/{id}/destroy', 'IbuController@destroy')->name('ibu.destroy')->middleware('role:operator,admin');
            Route::get('/get-ibu', 'IbuController@getIbu')->name('getIbu');
        });

        Route::prefix('kesehatan-anak')->group(function () {
            Route::get('/', 'AnakController@index')->name('anak.index');
            Route::get('/create', 'AnakController@create')->name('anak.create')->middleware('role:operator');
            Route::get('/{id}/edit', 'AnakController@edit')->name('anak.edit')->middleware('role:operator,admin');
            Route::post('/store', 'AnakController@store')->name('anak.store')->middleware('role:operator');
            Route::put('/{id}/update', 'AnakController@update')->name('anak.update')->middleware('role:operator,admin');
            Route::delete('/{id}/destroy', 'AnakController@destroy')->name('anak.destroy')->middleware('role:operator,admin');
            Route::get('/get-anak', 'AnakController@getAnak')->name('getAnak');

            Route::prefix('penimbangan')->group(function () {
                Route::get('/{id}', 'PenimbanganAnakController@index')->name('penimbangan.index');
                Route::get('/{id}/create', 'PenimbanganAnakController@create')->name('penimbangan.create')->middleware('role:operator');
                Route::post('/{id}/store', 'PenimbanganAnakController@store')->name('penimbangan.store')->middleware('role:operator');
                Route::get('/{id}/{penimbangan_id}/edit', 'PenimbanganAnakController@edit')->name('penimbangan.edit')->middleware('role:operator,admin');
                Route::put('/{id}/update', 'PenimbanganAnakController@update')->name('penimbangan.update')->middleware('role:operator,admin');
                Route::delete('/{id}/destroy', 'PenimbanganAnakController@destroy')->name('penimbangan.destroy')->middleware('role:operator,admin');
            });

            Route::prefix('imunisasi')->group(function () {
                Route::get('/{id}', 'ImunisasiController@index')->name('imunisasi.index');
                Route::get('/{id}/create', 'ImunisasiController@create')->name('imunisasi.create')->middleware('role:operator');
                Route::post('/{id}/store', 'ImunisasiController@store')->name('imunisasi.store')->middleware('role:operator');
                Route::get('/{id}/{imunisasi_id}/edit', 'ImunisasiController@edit')->name('imunisasi.edit')->middleware('role:operator,admin');
                Route::put('/{id}/update', 'ImunisasiController@update')->name('imunisasi.update')->middleware('role:operator,admin');
                Route::delete('/{id}/destroy', 'ImunisasiController@destroy')->name('imunisasi.destroy')->middleware('role:operator,admin');
            });

            Route::prefix('kms')->group(function () {
                Route::get('/{id}', 'KMSController@index')->name('kms.index');
            });
        });

        Route::prefix('lansia')->group(function () {
            Route::get('/', 'LansiaController@index')->name('lansia.index');
            Route::get('/create', 'LansiaController@create')->name('lansia.create')->middleware('role:operator');
            Route::get('/{id}/edit', 'LansiaController@edit')->name('lansia.edit')->middleware('role:operator,admin');
            Route::post('/store', 'LansiaController@store')->name('lansia.store')->middleware('role:operator');
            Route::put('/{id}/update', 'LansiaController@update')->name('lansia.update')->middleware('role:operator,admin');
            Route::delete('/{id}/destroy', 'LansiaController@destroy')->name('lansia.destroy')->middleware('role:operator,admin');
            Route::get('/get-lansia', 'LansiaController@getLansia')->name('getLansia');

            Route::prefix('cek-kesehatan')->group(function () {
                Route::get('/{id}', 'KesehatanLansiaController@index')->name('kesehatan_lansia.index');
                Route::get('/{id}/create', 'KesehatanLansiaController@create')->name('kesehatan_lansia.create')->middleware('role:operator');
                Route::post('/{id}/store', 'KesehatanLansiaController@store')->name('kesehatan_lansia.store')->middleware('role:operator');
                Route::get('/{id}/{kesehatan_id}/edit', 'KesehatanLansiaController@edit')->name('kesehatan_lansia.edit')->middleware('role:operator,admin');
                Route::put('/{id}/update', 'KesehatanLansiaController@update')->name('kesehatan_lansia.update')->middleware('role:operator,admin');
                Route::delete('/{id}/destroy', 'KesehatanLansiaController@destroy')->name('kesehatan_lansia.destroy')->middleware('role:operator,admin');
            });
        });

        Route::prefix('laporan')->middleware('role:admin,viewer')->group(function () {
            Route::get('/', 'LaporanPelayanan@index')->name('laporan.index');
            Route::get('get-report', 'LaporanPelayanan@getReportByMonth')->name('laporan.report');
        });

        Route::prefix('gallery')->group(function () {
            Route::get('/', 'GalleryController@index')->name('gallery.index');
            Route::get('/create', 'GalleryController@add')->name('gallery.add');
            Route::get('/{id}/edit', 'GalleryController@edit')->name('gallery.edit');
            Route::post('/store', 'GalleryController@store')->name('gallery.store');
            Route::put('/{id}/update', 'GalleryController@update')->name('gallery.update');
            Route::delete('/{id}/destroy', 'GalleryController@destroy')->name('gallery.destroy');
        });

        Route::prefix('article')->group(function () {
            Route::get('/', 'ArticleController@index')->name('article.index');
            Route::get('/create', 'ArticleController@create')->name('article.add');
            Route::get('/{id}/edit', 'ArticleController@edit')->name('article.edit');
            Route::get('/{id}/preview', 'ArticleController@preview')->name('article.preview');
            Route::post('/store', 'ArticleController@store')->name('article.store');
            Route::put('/{id}/update', 'ArticleController@update')->name('article.update');
            Route::delete('/{id}/destroy', 'ArticleController@destroy')->name('article.destroy');
        });

        Route::prefix('vaksin')->group(function () {
            Route::get('/get', 'VaksinController@getVaksin')->name('get-vaksin');
            Route::get('/', 'VaksinController@index')->name('vaksin.index');
            Route::get('/create', 'VaksinController@create')->name('vaksin.create');
            Route::get('/{id}/edit', 'VaksinController@edit')->name('vaksin.edit');
            Route::post('/store', 'VaksinController@store')->name('vaksin.store');
            Route::put('/{id}/update', 'VaksinController@update')->name('vaksin.update');
            Route::delete('/{id}/destroy', 'VaksinController@destroy')->name('vaksin.destroy');
        });
    });
});
