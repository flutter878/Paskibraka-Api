<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BiodataController;
use App\Http\Controllers\Api\DokumenController;
use App\Http\Controllers\Api\PengumumanController;

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

});

