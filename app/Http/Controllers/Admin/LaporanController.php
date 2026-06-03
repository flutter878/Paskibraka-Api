<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BiodataPeserta;
use App\Models\DokumenPeserta;
use App\Models\HasilSeleksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $totalPeserta = User::where('role', 'peserta')->count();

        $lulusVerifikasi = BiodataPeserta::where('status_verifikasi', 'lulus_verifikasi')->count();
        $menungguVerifikasi = BiodataPeserta::where('status_verifikasi', 'menunggu_verifikasi')->count();
        $ditolakVerifikasi = BiodataPeserta::where('status_verifikasi', 'ditolak')->count();

        $dokumenDiterima = DokumenPeserta::where('status_dokumen', 'diterima')->count();
        $dokumenMenunggu = DokumenPeserta::where('status_dokumen', 'menunggu')->count();
        $dokumenRevisi = DokumenPeserta::where('status_dokumen', 'revisi')->count();
        $dokumenDitolak = DokumenPeserta::where('status_dokumen', 'ditolak')->count();

        $hasilLulus = HasilSeleksi::where('status', 'lulus')->count();
        $hasilTidakLulus = HasilSeleksi::where('status', 'tidak_lulus')->count();
        $hasilCadangan = HasilSeleksi::where('status', 'cadangan')->count();
        $hasilMenunggu = HasilSeleksi::where('status', 'menunggu')->count();

        return view('admin.laporan.index', compact(
            'totalPeserta',
            'lulusVerifikasi',
            'menungguVerifikasi',
            'ditolakVerifikasi',
            'dokumenDiterima',
            'dokumenMenunggu',
            'dokumenRevisi',
            'dokumenDitolak',
            'hasilLulus',
            'hasilTidakLulus',
            'hasilCadangan',
            'hasilMenunggu'
        ));
    }

    public function peserta(Request $request)
    {
        $query = User::with('biodata')
            ->where('role', 'peserta');

        if ($request->filled('status_verifikasi')) {
            $query->whereHas('biodata', function ($biodata) use ($request) {
                $biodata->where('status_verifikasi', $request->status_verifikasi);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhereHas('biodata', function ($biodata) use ($search) {
                        $biodata->where('asal_sekolah', 'like', '%' . $search . '%');
                    });
            });
        }

        $peserta = $query->latest()->get();

        return view('admin.laporan.peserta', compact('peserta'));
    }

    public function dokumen(Request $request)
    {
        $query = DokumenPeserta::with('user');

        if ($request->filled('status_dokumen')) {
            $query->where('status_dokumen', $request->status_dokumen);
        }

        if ($request->filled('jenis_dokumen')) {
            $query->where('jenis_dokumen', $request->jenis_dokumen);
        }

        $dokumen = $query->latest()->get();

        return view('admin.laporan.dokumen', compact('dokumen'));
    }

    public function hasil(Request $request)
    {
        $query = HasilSeleksi::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tahap')) {
            $query->where('tahap', 'like', '%' . $request->tahap . '%');
        }

        $hasil = $query->latest()->get();

        return view('admin.laporan.hasil', compact('hasil'));
    }
}
