<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BiodataController;
use App\Http\Controllers\Api\DokumenController;
use App\Http\Controllers\Api\PengumumanController;
use App\Http\Controllers\Api\AdminPesertaController;
use App\Http\Controllers\Api\KartuPesertaController;
use App\Http\Controllers\Api\JadwalSeleksiController;
use App\Http\Controllers\Api\HasilSeleksiController;
use Illuminate\Http\Request;

    Route::get('/test', function () {
    return response()->json([
        'message' => 'API Laravel berhasil jalan'
    ]);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/kartu-peserta/preview-token', [KartuPesertaController::class, 'previewByToken']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/biodata', [BiodataController::class, 'show']);
    Route::post('/biodata', [BiodataController::class, 'update']);

    Route::get('/dokumen', [DokumenController::class, 'index']);
    Route::post('/dokumen/upload', [DokumenController::class, 'upload']);
    Route::get('/dokumen/{id}', [DokumenController::class, 'show']);
    Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy']);

    Route::get('/pengumuman', [PengumumanController::class, 'index']);
    Route::get('/pengumuman/{id}', [PengumumanController::class, 'show']);

    Route::get('/admin/pengumuman', [PengumumanController::class, 'adminIndex']);
    Route::post('/admin/pengumuman', [PengumumanController::class, 'store']);
    Route::post('/admin/pengumuman/{id}', [PengumumanController::class, 'update']);
    Route::delete('/admin/pengumuman/{id}', [PengumumanController::class, 'destroy']);

    Route::get('/admin/peserta', [AdminPesertaController::class, 'index']);
    Route::get('/admin/peserta/{id}', [AdminPesertaController::class, 'show']);
    Route::post('/admin/peserta/{id}/status-akun', [AdminPesertaController::class, 'updateStatusAkun']);
    Route::post('/admin/peserta/{id}/reset-password', [AdminPesertaController::class, 'resetPassword']);
    Route::post('/admin/peserta/{id}/verifikasi-biodata', [AdminPesertaController::class, 'verifikasiBiodata']);
    Route::post('/admin/dokumen/{id}/verifikasi', [AdminPesertaController::class, 'verifikasiDokumen']);

    Route::get('/kartu-peserta/preview', [KartuPesertaController::class, 'preview']);
    Route::get('/kartu-peserta/download', [KartuPesertaController::class, 'download']);

    Route::get('/jadwal-seleksi', [JadwalSeleksiController::class, 'index']);
    Route::get('/jadwal-seleksi/{id}', [JadwalSeleksiController::class, 'show']);

    Route::get('/admin/jadwal-seleksi', [JadwalSeleksiController::class, 'adminIndex']);
    Route::post('/admin/jadwal-seleksi', [JadwalSeleksiController::class, 'store']);
    Route::post('/admin/jadwal-seleksi/{id}', [JadwalSeleksiController::class, 'update']);
    Route::delete('/admin/jadwal-seleksi/{id}', [JadwalSeleksiController::class, 'destroy']);

    Route::get('/hasil-seleksi', [HasilSeleksiController::class, 'index']);
    Route::get('/hasil-seleksi/{id}', [HasilSeleksiController::class, 'show']);

    Route::get('/admin/hasil-seleksi', [HasilSeleksiController::class, 'adminIndex']);
    Route::post('/admin/hasil-seleksi', [HasilSeleksiController::class, 'store']);
    Route::post('/admin/hasil-seleksi/{id}', [HasilSeleksiController::class, 'update']);
    Route::delete('/admin/hasil-seleksi/{id}', [HasilSeleksiController::class, 'destroy']);
});

