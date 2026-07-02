<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('beranda');
});

Route::get('/login', function () {
       return view('login');
   });

Route::get('/santri', function () {
    return view('santri');
});

// Rute URL untuk memuat halaman dashboard admin
Route::get('/admin', function () {
    return view('admin');
});
use Illuminate\Support\Facades\Storage;

Route::get('/buka-berkas/{namafile}', function ($namafile) {
    $path = 'public/berkas-santri/' . $namafile;
    
    if (!Storage::exists($path)) {
        abort(404, 'Berkas tidak ditemukan di server.');
    }
    
    return Storage::response($path);
});