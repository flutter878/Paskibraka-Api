@extends('layouts.admin')

@section('page-title', 'Laporan')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1">Laporan Sistem</h3>
    <p class="text-muted mb-0">
        Rekap data pendaftaran, verifikasi dokumen, dan hasil seleksi Paskibraka.
    </p>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fee2e2;color:#dc2626;">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-title">Total Peserta</div>
            <div class="stat-value">{{ $totalPeserta }}</div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#dcfce7;color:#16a34a;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="stat-title">Lulus Verifikasi</div>
            <div class="stat-value">{{ $lulusVerifikasi }}</div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7;color:#d97706;">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-title">Menunggu Verifikasi</div>
            <div class="stat-value">{{ $menungguVerifikasi }}</div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fee2e2;color:#dc2626;">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <div class="stat-title">Ditolak Verifikasi</div>
            <div class="stat-value">{{ $ditolakVerifikasi }}</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="modern-card p-4 h-100">
            <div class="d-flex align-items-center mb-3">
                <div class="stat-icon me-3 mb-0" style="background:#fee2e2;color:#dc2626;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Laporan Peserta</h5>
                    <small class="text-muted">Data peserta dan status verifikasi.</small>
                </div>
            </div>

            <a href="{{ route('admin.laporan.peserta') }}" class="btn btn-danger w-100">
                <i class="bi bi-file-earmark-text me-1"></i>
                Buka Laporan Peserta
            </a>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="modern-card p-4 h-100">
            <div class="d-flex align-items-center mb-3">
                <div class="stat-icon me-3 mb-0" style="background:#dbeafe;color:#2563eb;">
                    <i class="bi bi-folder-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Laporan Dokumen</h5>
                    <small class="text-muted">Rekap dokumen yang diupload peserta.</small>
                </div>
            </div>

            <a href="{{ route('admin.laporan.dokumen') }}" class="btn btn-danger w-100">
                <i class="bi bi-file-earmark-text me-1"></i>
                Buka Laporan Dokumen
            </a>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="modern-card p-4 h-100">
            <div class="d-flex align-items-center mb-3">
                <div class="stat-icon me-3 mb-0" style="background:#dcfce7;color:#16a34a;">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Laporan Hasil Seleksi</h5>
                    <small class="text-muted">Rekap hasil seleksi seluruh peserta.</small>
                </div>
            </div>

            <a href="{{ route('admin.laporan.hasil') }}" class="btn btn-danger w-100">
                <i class="bi bi-file-earmark-text me-1"></i>
                Buka Laporan Hasil
            </a>
        </div>
    </div>
</div>
@endsection
