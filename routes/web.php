<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\PengumumanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\JadwalSeleksiController;
use App\Http\Controllers\Admin\HasilSeleksiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\AdminUserController;

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

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/peserta', [LaporanController::class, 'peserta'])->name('laporan.peserta');
    Route::get('/laporan/dokumen', [LaporanController::class, 'dokumen'])->name('laporan.dokumen');
    Route::get('/laporan/hasil', [LaporanController::class, 'hasil'])->name('laporan.hasil');

    Route::resource('/admin-user', AdminUserController::class);
    Route::post('/admin-user/{adminUser}/reset-password', [AdminUserController::class, 'resetPassword'])
        ->name('admin-user.resetPassword');
    Route::resource('/admin-users', AdminUserController::class);
    Route::get('/cek-laravel', function () {
    return 'Laravel jalan';
});
});
