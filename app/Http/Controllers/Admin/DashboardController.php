<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BiodataPeserta;
use App\Models\DokumenPeserta;
use App\Models\Pengumuman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeserta = User::where('role', 'peserta')->count();
        $menungguVerifikasi = BiodataPeserta::where('status_verifikasi', 'menunggu_verifikasi')->count();
        $lulusVerifikasi = BiodataPeserta::where('status_verifikasi', 'lulus_verifikasi')->count();
        $dokumenMenunggu = DokumenPeserta::where('status_dokumen', 'menunggu')->count();
        $totalPengumuman = Pengumuman::count();

        return view('admin.dashboard', compact(
            'totalPeserta',
            'menungguVerifikasi',
            'lulusVerifikasi',
            'dokumenMenunggu',
            'totalPengumuman'
        ));
    }
}
