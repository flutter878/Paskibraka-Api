@extends('layouts.admin')

@section('page-title', 'Dashboard Admin')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1">Dashboard Admin</h3>
    <p class="text-muted mb-0">
        Pantau seluruh proses pendaftaran dan seleksi Paskibraka dalam satu halaman.
    </p>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Total Peserta</div>
                    <div class="stat-value">{{ $totalPeserta }}</div>
                    <span class="badge bg-danger mt-2">Peserta Terdaftar</span>
                </div>
                <div class="stat-icon" style="background:#fee2e2;color:#dc2626;">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Menunggu Verifikasi</div>
                    <div class="stat-value">{{ $menungguVerifikasi }}</div>
                    <span class="badge bg-warning text-dark mt-2">Biodata</span>
                </div>
                <div class="stat-icon" style="background:#fef3c7;color:#d97706;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Lulus Verifikasi</div>
                    <div class="stat-value">{{ $lulusVerifikasi }}</div>
                    <span class="badge bg-success mt-2">Valid</span>
                </div>
                <div class="stat-icon" style="background:#dcfce7;color:#16a34a;">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Ditolak</div>
                    <div class="stat-value">{{ $ditolakVerifikasi }}</div>
                    <span class="badge bg-secondary mt-2">Verifikasi</span>
                </div>
                <div class="stat-icon" style="background:#f3f4f6;color:#6b7280;">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Dokumen Menunggu</div>
                    <div class="stat-value">{{ $dokumenMenunggu }}</div>
                    <span class="badge bg-warning text-dark mt-2">Dokumen</span>
                </div>
                <div class="stat-icon" style="background:#fef3c7;color:#d97706;">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Dokumen Diterima</div>
                    <div class="stat-value">{{ $dokumenDiterima }}</div>
                    <span class="badge bg-success mt-2">Diterima</span>
                </div>
                <div class="stat-icon" style="background:#dcfce7;color:#16a34a;">
                    <i class="bi bi-file-earmark-check-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Dokumen Revisi</div>
                    <div class="stat-value">{{ $dokumenRevisi }}</div>
                    <span class="badge bg-info mt-2">Revisi</span>
                </div>
                <div class="stat-icon" style="background:#dbeafe;color:#2563eb;">
                    <i class="bi bi-pencil-square"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Dokumen Ditolak</div>
                    <div class="stat-value">{{ $dokumenDitolak }}</div>
                    <span class="badge bg-danger mt-2">Ditolak</span>
                </div>
                <div class="stat-icon" style="background:#fee2e2;color:#dc2626;">
                    <i class="bi bi-file-earmark-x-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Pengumuman</div>
                    <div class="stat-value">{{ $totalPengumuman }}</div>
                    <span class="badge bg-danger mt-2">{{ $pengumumanAktif }} Aktif</span>
                </div>
                <div class="stat-icon" style="background:#fee2e2;color:#dc2626;">
                    <i class="bi bi-megaphone-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Jadwal Seleksi</div>
                    <div class="stat-value">{{ $totalJadwal }}</div>
                    <span class="badge bg-danger mt-2">{{ $jadwalAktif }} Aktif</span>
                </div>
                <div class="stat-icon" style="background:#fee2e2;color:#dc2626;">
                    <i class="bi bi-calendar-event-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Total Hasil Seleksi</div>
                    <div class="stat-value">{{ $totalHasilSeleksi }}</div>
                    <span class="badge bg-dark mt-2">Hasil</span>
                </div>
                <div class="stat-icon" style="background:#e0e7ff;color:#4f46e5;">
                    <i class="bi bi-clipboard-data-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Lulus Seleksi</div>
                    <div class="stat-value">{{ $hasilLulus }}</div>
                    <span class="badge bg-success mt-2">Lulus</span>
                </div>
                <div class="stat-icon" style="background:#dcfce7;color:#16a34a;">
                    <i class="bi bi-trophy-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Tidak Lulus</div>
                    <div class="stat-value">{{ $hasilTidakLulus }}</div>
                    <span class="badge bg-danger mt-2">Hasil Seleksi</span>
                </div>
                <div class="stat-icon" style="background:#fee2e2;color:#dc2626;">
                    <i class="bi bi-x-octagon-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Cadangan</div>
                    <div class="stat-value">{{ $hasilCadangan }}</div>
                    <span class="badge bg-warning text-dark mt-2">Hasil Seleksi</span>
                </div>
                <div class="stat-icon" style="background:#fef3c7;color:#d97706;">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-12 mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">Menunggu Hasil</div>
                    <div class="stat-value">{{ $hasilMenunggu }}</div>
                    <span class="badge bg-secondary mt-2">Hasil Seleksi</span>
                </div>
                <div class="stat-icon" style="background:#f3f4f6;color:#6b7280;">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-lg-6 mb-4">
        <div class="table-card">
            <div class="table-card-header">
                <h5 class="table-card-title">
                    <i class="bi bi-person-lines-fill text-danger me-2"></i>
                    Peserta Terbaru
                </h5>

                <a href="{{ route('admin.peserta.index') }}" class="btn btn-sm btn-outline-danger">
                    Lihat Semua
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesertaTerbaru as $peserta)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $peserta->name }}</div>
                                    <small class="text-muted">{{ $peserta->email }}</small>
                                </td>
                                <td>{{ $peserta->nik }}</td>
                                <td>
                                    @if($peserta->biodata)
                                        @if($peserta->biodata->status_verifikasi == 'lulus_verifikasi')
                                            <span class="badge bg-success">Lulus</span>
                                        @elseif($peserta->biodata->status_verifikasi == 'menunggu_verifikasi')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($peserta->biodata->status_verifikasi == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary">Belum Lengkap</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Belum Ada</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted text-center py-4">
                                    Belum ada peserta.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="table-card">
            <div class="table-card-header">
                <h5 class="table-card-title">
                    <i class="bi bi-trophy-fill text-danger me-2"></i>
                    Hasil Seleksi Terbaru
                </h5>

                <a href="{{ route('admin.hasil.index') }}" class="btn btn-sm btn-outline-danger">
                    Lihat Semua
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Peserta</th>
                            <th>Tahap</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilTerbaru as $item)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $item->user->name ?? '-' }}</div>
                                    <small class="text-muted">{{ $item->user->nik ?? '-' }}</small>
                                </td>
                                <td>{{ $item->tahap }}</td>
                                <td>
                                    @if($item->status == 'lulus')
                                        <span class="badge bg-success">Lulus</span>
                                    @elseif($item->status == 'tidak_lulus')
                                        <span class="badge bg-danger">Tidak Lulus</span>
                                    @elseif($item->status == 'cadangan')
                                        <span class="badge bg-warning text-dark">Cadangan</span>
                                    @else
                                        <span class="badge bg-secondary">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted text-center py-4">
                                    Belum ada hasil seleksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
