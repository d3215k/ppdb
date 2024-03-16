<?php

use App\Http\Controllers\Pendaftar\BerkasController;
use App\Http\Controllers\Pendaftar\BiodataController;
use App\Http\Controllers\Pendaftar\CetakBuktiPendaftaranController;
use App\Http\Controllers\Pendaftar\DashboardController;
use App\Http\Controllers\Pendaftar\RaporController;
use App\Http\Middleware\EnsurePendaftarHasCalonPesertaDidik;
use App\Http\Middleware\OnlyPendaftarCanAccess;
use Illuminate\Support\Facades\Route;

Route::prefix('pendaftar')->name('pendaftar.')->middleware('auth')->group(function () {
    Route::middleware(OnlyPendaftarCanAccess::class)->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::get('/biodata', BiodataController::class)->middleware(EnsurePendaftarHasCalonPesertaDidik::class)->name('biodata');
        Route::get('/rapor', RaporController::class)->middleware(EnsurePendaftarHasCalonPesertaDidik::class)->name('rapor');
        Route::get('/berkas', BerkasController::class)->middleware(EnsurePendaftarHasCalonPesertaDidik::class)->name('berkas');
    });
    Route::get('/cetak/{nomor}', CetakBuktiPendaftaranController::class)->name('cetak');
});

Route::redirect('/laravel/login', '/login')->name('login');
