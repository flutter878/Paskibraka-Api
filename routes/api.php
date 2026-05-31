<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BiodataController;
use App\Http\Controllers\Api\DokumenController;
use App\Http\Controllers\Api\PengumumanController;
use App\Http\Controllers\Api\AdminPesertaController;
use App\Http\Controllers\Api\KartuPesertaController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

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
});

