<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalSeleksi extends Model
{
    protected $table = 'jadwal_seleksi';

    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'keterangan',
        'status',
    ];
}
