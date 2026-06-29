@extends('layouts.admin')

@section('page-title', 'Laporan Peserta')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <div>
        <h3 class="fw-bold mb-1">Laporan Data Peserta</h3>
        <p class="text-muted mb-0">
            Laporan peserta pendaftaran seleksi Paskibraka.
        </p>
    </div>

    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-danger">
            <i class="bi bi-printer me-1"></i>
            Cetak
        </button>

        <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-danger">
            Kembali
        </a>
    </div>
</div>

<div class="modern-card p-4 mb-4 no-print">
    <form action="{{ route('admin.laporan.peserta') }}" method="GET">
        <div class="row align-items-end">
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Tahun</label>
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunList as $thn)
                        <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>
                            {{ $thn }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Bulan</label>
                <select name="bulan" class="form-select">
                    <option value="">Semua Bulan</option>
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $nama)
                        <option value="{{ $i + 1 }}" {{ request('bulan') == ($i + 1) ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Status Verifikasi</label>
                <select name="status_verifikasi" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="belum_lengkap" {{ request('status_verifikasi') == 'belum_lengkap' ? 'selected' : '' }}>Belum Lengkap</option>
                    <option value="menunggu_verifikasi" {{ request('status_verifikasi') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="lulus_verifikasi" {{ request('status_verifikasi') == 'lulus_verifikasi' ? 'selected' : '' }}>Lulus Verifikasi</option>
                    <option value="ditolak" {{ request('status_verifikasi') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Cari Peserta</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Nama, NIK, email...">
            </div>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-danger" type="submit">
                <i class="bi bi-search me-1"></i>
                Filter
            </button>
            @if(request('tahun') || request('bulan') || request('status_verifikasi') || request('search'))
                <a href="{{ route('admin.laporan.peserta') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i>
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<div class="table-card">
    <div class="table-card-header">
        <h5 class="table-card-title">Laporan Data Peserta</h5>
        <div class="d-flex gap-2 align-items-center">
            @if(request('tahun') || request('bulan'))
                <span class="badge bg-warning text-dark">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ request('bulan') ? \Carbon\Carbon::create()->month(request('bulan'))->translatedFormat('F') : '' }}
                    {{ request('tahun') }}
                </span>
            @endif
            <span class="badge bg-danger">Total: {{ $peserta->count() }} Peserta</span>
        </div>
    </div>

    <div class="p-4 print-header d-none">
        <h3 class="text-center mb-1">LAPORAN DATA PESERTA PASKIBRAKA</h3>
        <p class="text-center mb-0">Dicetak pada: {{ date('d-m-Y H:i') }}</p>
        <hr>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Email</th>
                    <th>Asal Sekolah</th>
                    <th>Status Verifikasi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peserta as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->biodata->asal_sekolah ?? '-' }}</td>
                        <td>
                            {{ $item->biodata ? str_replace('_', ' ', strtoupper($item->biodata->status_verifikasi)) : 'BELUM ADA BIODATA' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Data peserta tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
@media print {
    .sidebar,
    .topbar,
    .no-print {
        display: none !important;
    }

    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
    }

    .content-area {
        padding: 0 !important;
    }

    .print-header {
        display: block !important;
    }

    .table-card {
        box-shadow: none !important;
        border-radius: 0 !important;
    }
}
</style>
@endsection
