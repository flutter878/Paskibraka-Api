<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BiodataPeserta;
use App\Models\DokumenPeserta;
use App\Models\Pengumuman;
use App\Models\JadwalSeleksi;
use App\Models\HasilSeleksi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeserta = User::where('role', 'peserta')->count();

        $menungguVerifikasi = BiodataPeserta::where('status_verifikasi', 'menunggu_verifikasi')->count();
        $lulusVerifikasi = BiodataPeserta::where('status_verifikasi', 'lulus_verifikasi')->count();
        $ditolakVerifikasi = BiodataPeserta::where('status_verifikasi', 'ditolak')->count();

        $dokumenMenunggu = DokumenPeserta::where('status_dokumen', 'menunggu')->count();
        $dokumenDiterima = DokumenPeserta::where('status_dokumen', 'diterima')->count();
        $dokumenRevisi = DokumenPeserta::where('status_dokumen', 'revisi')->count();
        $dokumenDitolak = DokumenPeserta::where('status_dokumen', 'ditolak')->count();

        $totalPengumuman = Pengumuman::count();
        $pengumumanAktif = Pengumuman::where('status', 'aktif')->count();

        $totalJadwal = JadwalSeleksi::count();
        $jadwalAktif = JadwalSeleksi::where('status', 'aktif')->count();

        $totalHasilSeleksi = HasilSeleksi::count();
        $hasilLulus = HasilSeleksi::where('status', 'lulus')->count();
        $hasilTidakLulus = HasilSeleksi::where('status', 'tidak_lulus')->count();
        $hasilCadangan = HasilSeleksi::where('status', 'cadangan')->count();
        $hasilMenunggu = HasilSeleksi::where('status', 'menunggu')->count();

        $pesertaTerbaru = User::with('biodata')
            ->where('role', 'peserta')
            ->latest()
            ->take(5)
            ->get();

        $hasilTerbaru = HasilSeleksi::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPeserta',
            'menungguVerifikasi',
            'lulusVerifikasi',
            'ditolakVerifikasi',
            'dokumenMenunggu',
            'dokumenDiterima',
            'dokumenRevisi',
            'dokumenDitolak',
            'totalPengumuman',
            'pengumumanAktif',
            'totalJadwal',
            'jadwalAktif',
            'totalHasilSeleksi',
            'hasilLulus',
            'hasilTidakLulus',
            'hasilCadangan',
            'hasilMenunggu',
            'pesertaTerbaru',
            'hasilTerbaru'
        ));
    }
}
