<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\PengumumanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\JadwalSeleksiController;
use App\Http\Controllers\Admin\HasilSeleksiController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AdminLoginController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminLoginController::class, 'login'])->name('login.process');
Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta.index');
    Route::get('/peserta/{id}', [PesertaController::class, 'show'])->name('peserta.show');
    Route::post('/peserta/{id}/verifikasi-biodata', [PesertaController::class, 'verifikasiBiodata'])->name('peserta.verifikasiBiodata');
    Route::post('/dokumen/{id}/verifikasi', [PesertaController::class, 'verifikasiDokumen'])->name('dokumen.verifikasi');

    Route::resource('/pengumuman', PengumumanController::class);
    Route::resource('/jadwal', JadwalSeleksiController::class);
    Route::resource('/hasil', HasilSeleksiController::class);

    Route::get('/cek-laravel', function () {
    return 'Laravel jalan';
});
});
