<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biodata_peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('nama_lengkap');
            $table->string('asal_sekolah');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('tinggi_badan');
            $table->integer('berat_badan');
            $table->string('golongan_darah')->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->text('motivasi_esai')->nullable();

            $table->enum('status_verifikasi', [
                'belum_lengkap',
                'menunggu_verifikasi',
                'lulus_verifikasi',
                'ditolak'
            ])->default('belum_lengkap');

            $table->text('catatan_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biodata_peserta');
    }
};
