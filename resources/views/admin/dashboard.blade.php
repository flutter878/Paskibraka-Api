@extends('layouts.admin')

@section('page-title', 'Dashboard Admin')

@section('content')
<div class="dashboard-header mb-4">
    <div class="row g-4 align-items-center">
        <div class="col-xl-8">
            <div class="card dashboard-profile-card p-4 shadow-sm">
                <div class="d-flex align-items-center gap-4">
                    <div class="profile-photo shadow-sm">
                        @if(auth()->user()->avatar ?? false)
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar {{ auth()->user()->name }}" class="img-fluid rounded-circle">
                        @else
                            <div class="profile-initial">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                        @endif
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">{{ auth()->user()->name ?? 'Admin' }}</h4>
                        <div class="text-danger fw-semibold">Panitia di KABUPATEN/KOTA</div>
                    </div>
                </div>

                <div class="row mt-4 g-3">
                    <div class="col-md-4">
                        <div class="dashboard-info-item">
                            <div class="info-title">NIK</div>
                            <div class="info-value">{{ auth()->user()->nik ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dashboard-info-item">
                            <div class="info-title">Alamat</div>
                            <div class="info-value">{{ auth()->user()->alamat ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dashboard-info-item">
                            <div class="info-title">Phone</div>
                            <div class="info-value">{{ auth()->user()->phone ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card dashboard-logo-card p-4 shadow-sm text-center">
                <img src="{{ asset('images/kabupaten-bantaeng.png') }}" alt="Kabupaten Bantaeng" class="img-fluid" style="max-width: 180px;">
                <div class="mt-3 fw-semibold">KABUPATEN BANTAENG</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6 col-xl-3">
        <div class="card dashboard-stat-card p-4 shadow-sm">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-label">Jumlah Peserta</div>
                    <div class="stat-number">{{ $totalPeserta }}</div>
                    <span class="badge bg-light text-danger mt-2">Peserta Terdaftar</span>
                </div>
                <div class="dashboard-icon bg-danger text-white">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card dashboard-stat-card p-4 shadow-sm">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="stat-label">Status Pendaftaran</div>
                    <div class="stat-number">Buka</div>
                    <span class="badge bg-light text-dark mt-2">Pendaftaran Terbuka</span>
                </div>
                <div class="dashboard-icon bg-secondary text-white">
                    <i class="bi bi-toggle-on"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-summary mb-4">
    <h5 class="dashboard-title mb-3">Statistik Administrasi</h5>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card dashboard-summary-card p-4 shadow-sm">
                <div class="summary-label">Menunggu Verifikasi</div>
                <div class="summary-number text-warning">{{ $menungguVerifikasi }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-summary-card p-4 shadow-sm">
                <div class="summary-label">Terverifikasi</div>
                <div class="summary-number text-success">{{ $lulusVerifikasi }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-summary-card p-4 shadow-sm">
                <div class="summary-label">Ditolak</div>
                <div class="summary-number text-danger">{{ $ditolakVerifikasi }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
