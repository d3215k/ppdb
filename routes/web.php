<?php

use Illuminate\Support\Facades\Route;

Route::get('/pendaftar', function () {
  return view('pendaftar.index');
})->name('pendaftar.beranda');

Route::redirect('/laravel/login', '/login')->name('login');
