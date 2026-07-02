<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AuthController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/pendaftaran/simpan', [PendaftaranController::class, 'simpan']);
Route::get('/pendaftaran/status', [PendaftaranController::class, 'cekStatus']);

// Jalur API Khusus Admin
Route::get('/admin/pendaftar', [PendaftaranController::class, 'semuaPendaftar']);
Route::post('/admin/pendaftar/update', [PendaftaranController::class, 'updateStatus']);
Route::get('/lihat-berkas/{namafile}', [PendaftaranController::class, 'lihatBerkas']);

// Route untuk sistem manajemen artikel
Route::post('/simpan-artikel', [PendaftaranController::class, 'simpanArtikel']);
Route::get('/list-artikel', [PendaftaranController::class, 'ambilArtikel']);
Route::get('/lihat-gambar-artikel/{namafile}', [PendaftaranController::class, 'lihatGambarArtikel']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

