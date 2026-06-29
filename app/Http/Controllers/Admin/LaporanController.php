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
    public function index(Request $request)
    {
        $tahun = $request->filled('tahun') ? $request->tahun : null;
        $bulan = $request->filled('bulan') ? $request->bulan : null;

        // Helper closure untuk filter tahun & bulan
        $applyDateFilter = function ($query, $table = null) use ($tahun, $bulan) {
            $col = $table ? "{$table}.created_at" : 'created_at';
            if ($tahun) {
                $query->whereYear($col, $tahun);
            }
            if ($bulan) {
                $query->whereMonth($col, $bulan);
            }
            return $query;
        };

        $pesertaQuery = User::where('role', 'peserta');
        $applyDateFilter($pesertaQuery);
        $totalPeserta = $pesertaQuery->count();

        $biodataQuery = BiodataPeserta::query();
        $applyDateFilter($biodataQuery);
        $lulusVerifikasi   = (clone $biodataQuery)->where('status_verifikasi', 'lulus_verifikasi')->count();
        $menungguVerifikasi = (clone $biodataQuery)->where('status_verifikasi', 'menunggu_verifikasi')->count();
        $ditolakVerifikasi  = (clone $biodataQuery)->where('status_verifikasi', 'ditolak')->count();

        $dokumenQuery = DokumenPeserta::query();
        $applyDateFilter($dokumenQuery);
        $dokumenDiterima = (clone $dokumenQuery)->where('status_dokumen', 'diterima')->count();
        $dokumenMenunggu = (clone $dokumenQuery)->where('status_dokumen', 'menunggu')->count();
        $dokumenRevisi   = (clone $dokumenQuery)->where('status_dokumen', 'revisi')->count();
        $dokumenDitolak  = (clone $dokumenQuery)->where('status_dokumen', 'ditolak')->count();

        $hasilQuery = HasilSeleksi::query();
        $applyDateFilter($hasilQuery);
        $hasilLulus      = (clone $hasilQuery)->where('status', 'lulus')->count();
        $hasilTidakLulus = (clone $hasilQuery)->where('status', 'tidak_lulus')->count();
        $hasilCadangan   = (clone $hasilQuery)->where('status', 'cadangan')->count();
        $hasilMenunggu   = (clone $hasilQuery)->where('status', 'menunggu')->count();

        $tahunList = $this->getAvailableYears();

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
            'hasilMenunggu',
            'tahunList',
            'tahun',
            'bulan'
        ));
    }

    public function peserta(Request $request)
    {
        $query = User::with('biodata')
            ->where('role', 'peserta');

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

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

        $peserta    = $query->latest()->get();
        $tahunList  = $this->getAvailableYears();

        return view('admin.laporan.peserta', compact('peserta', 'tahunList'));
    }

    public function dokumen(Request $request)
    {
        $query = DokumenPeserta::with('user');

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('status_dokumen')) {
            $query->where('status_dokumen', $request->status_dokumen);
        }

        if ($request->filled('jenis_dokumen')) {
            $query->where('jenis_dokumen', $request->jenis_dokumen);
        }

        $dokumen   = $query->latest()->get();
        $tahunList = $this->getAvailableYears();

        return view('admin.laporan.dokumen', compact('dokumen', 'tahunList'));
    }

    public function hasil(Request $request)
    {
        $query = HasilSeleksi::with('user');

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tahap')) {
            $query->where('tahap', 'like', '%' . $request->tahap . '%');
        }

        $hasil     = $query->latest()->get();
        $tahunList = $this->getAvailableYears();

        return view('admin.laporan.hasil', compact('hasil', 'tahunList'));
    }

    /**
     * Ambil daftar tahun yang tersedia dari semua tabel utama.
     */
    private function getAvailableYears(): array
    {
        $years = collect();

        $years = $years->merge(
            User::where('role', 'peserta')
                ->selectRaw('YEAR(created_at) as tahun')
                ->distinct()->pluck('tahun')
        );
        $years = $years->merge(
            DokumenPeserta::selectRaw('YEAR(created_at) as tahun')
                ->distinct()->pluck('tahun')
        );
        $years = $years->merge(
            HasilSeleksi::selectRaw('YEAR(created_at) as tahun')
                ->distinct()->pluck('tahun')
        );

        $sorted = $years->filter()->unique()->sortDesc()->values()->toArray();

        // Pastikan tahun ini selalu ada
        $currentYear = (int) date('Y');
        if (!in_array($currentYear, $sorted)) {
            array_unshift($sorted, $currentYear);
        }

        return $sorted;
    }
}
