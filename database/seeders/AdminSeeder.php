<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nik' => '0000000000000000',
            'name' => 'Admin Paskibraka',
            'email' => 'admin@paskibraka.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status_akun' => 'aktif',
        ]);
    }
}
