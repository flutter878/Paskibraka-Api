<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPeserta extends Model
{
    protected $table = 'dokumen_peserta';

    protected $fillable = [
        'user_id',
        'jenis_dokumen',
        'file_path',
        'status_dokumen',
        'catatan_admin',
        'waktu_unggah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
