<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiodataPeserta extends Model
{
    protected $table = 'biodata_peserta';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'asal_sekolah',
        'tempat_lahir',
        'tanggal_lahir',
        'tinggi_badan',
        'berat_badan',
        'golongan_darah',
        'riwayat_penyakit',
        'motivasi_esai',
        'status_verifikasi',
        'catatan_admin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
