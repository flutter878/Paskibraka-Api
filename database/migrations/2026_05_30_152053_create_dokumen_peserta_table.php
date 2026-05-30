<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->enum('jenis_dokumen', [
                'surat_izin_orang_tua',
                'surat_sehat',
                'nilai_rapor'
            ]);

            $table->string('file_path');

            $table->enum('status_dokumen', [
                'menunggu',
                'diterima',
                'ditolak',
                'revisi'
            ])->default('menunggu');

            $table->text('catatan_admin')->nullable();

            $table->timestamp('waktu_unggah')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_peserta');
    }
};
