<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\HasilSeleksi;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nik',
        'name',
        'email',
        'password',
        'role',
        'status_akun',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke tabel biodata_peserta.
     * Satu user peserta memiliki satu biodata.
     */
    public function biodata()
    {
        return $this->hasOne(BiodataPeserta::class);
    }

    /**
     * Relasi ke tabel dokumen_peserta.
     * Satu user peserta bisa memiliki banyak dokumen.
     */
    public function dokumen()
    {
        return $this->hasMany(DokumenPeserta::class);
    }

    /**
     * Relasi ke tabel pengumuman.
     * Satu admin bisa membuat banyak pengumuman.
     */
    public function pengumuman()
    {
        return $this->hasMany(Pengumuman::class, 'admin_id');
    }

    public function hasilSeleksi()
        {
            return $this->hasMany(HasilSeleksi::class);
        }
}
