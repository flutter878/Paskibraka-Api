@extends('layouts.admin')

@section('page-title', 'Laporan Hasil Seleksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <div>
        <h3 class="fw-bold mb-1">Laporan Hasil Seleksi</h3>
        <p class="text-muted mb-0">Rekap hasil seleksi peserta.</p>
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
    <form action="{{ route('admin.laporan.hasil') }}" method="GET">
        <div class="row align-items-end">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Tahap Seleksi</label>
                <input type="text" name="tahap" class="form-control" value="{{ request('tahap') }}" placeholder="Contoh: Administrasi">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="tidak_lulus" {{ request('status') == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                    <option value="cadangan" {{ request('status') == 'cadangan' ? 'selected' : '' }}>Cadangan</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <button class="btn btn-danger w-100" type="submit">
                    <i class="bi bi-search me-1"></i>
                    Filter
                </button>
            </div>
        </div>
    </form>
</div>

<div class="table-card">
    <div class="table-card-header">
        <h5 class="table-card-title">Laporan Hasil Seleksi</h5>
        <span class="badge bg-danger">Total: {{ $hasil->count() }} Data</span>
    </div>

    <div class="p-4 print-header d-none">
        <h3 class="text-center mb-1">LAPORAN HASIL SELEKSI PASKIBRAKA</h3>
        <p class="text-center mb-0">Dicetak pada: {{ date('d-m-Y H:i') }}</p>
        <hr>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peserta</th>
                    <th>NIK</th>
                    <th>Tahap</th>
                    <th>Nilai</th>
                    <th>Status</th>
                    <th>Catatan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($hasil as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->name ?? '-' }}</td>
                        <td>{{ $item->user->nik ?? '-' }}</td>
                        <td>{{ $item->tahap }}</td>
                        <td>{{ $item->nilai ?? '-' }}</td>
                        <td>{{ strtoupper(str_replace('_', ' ', $item->status)) }}</td>
                        <td>{{ $item->catatan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Data hasil seleksi tidak ditemukan.
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
