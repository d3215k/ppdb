<?php

use App\Http\Controllers\Pendaftar\BerkasController;
use App\Http\Controllers\Pendaftar\BiodataController;
use App\Http\Controllers\Pendaftar\DashboardController;
use App\Http\Controllers\Pendaftar\PendaftaranController;
use App\Http\Controllers\Pendaftar\RaporController;
use Illuminate\Support\Facades\Route;

Route::prefix('pendaftar')->name('pendaftar.')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/biodata', BiodataController::class)->name('biodata');
    Route::get('/rapor', RaporController::class)->name('rapor');
    Route::get('/berkas', BerkasController::class)->name('berkas');
    Route::get('/pendaftaran', PendaftaranController::class)->name('pendaftaran');
});

Route::redirect('/laravel/login', '/login')->name('login');
