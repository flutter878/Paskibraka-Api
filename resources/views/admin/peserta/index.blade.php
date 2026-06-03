@extends('layouts.admin')

@section('page-title', 'Data Peserta')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Data Peserta</h3>
        <p class="text-muted mb-0">
            Kelola data peserta pendaftaran seleksi Paskibraka.
        </p>
    </div>
</div>

<div class="modern-card p-4 mb-4">
    <form action="{{ route('admin.peserta.index') }}" method="GET">
        <div class="row align-items-end">
            <div class="col-md-5 mb-3">
                <label class="form-label fw-semibold">Cari Peserta</label>
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari nama, NIK, email, atau asal sekolah..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Status Verifikasi</label>
                <select name="status_verifikasi" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="belum_lengkap" {{ request('status_verifikasi') == 'belum_lengkap' ? 'selected' : '' }}>
                        Belum Lengkap
                    </option>
                    <option value="menunggu_verifikasi" {{ request('status_verifikasi') == 'menunggu_verifikasi' ? 'selected' : '' }}>
                        Menunggu Verifikasi
                    </option>
                    <option value="lulus_verifikasi" {{ request('status_verifikasi') == 'lulus_verifikasi' ? 'selected' : '' }}>
                        Lulus Verifikasi
                    </option>
                    <option value="ditolak" {{ request('status_verifikasi') == 'ditolak' ? 'selected' : '' }}>
                        Ditolak
                    </option>
                </select>
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label fw-semibold">Status Akun</label>
                <select name="status_akun" class="form-select">
                    <option value="">Semua</option>
                    <option value="aktif" {{ request('status_akun') == 'aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="nonaktif" {{ request('status_akun') == 'nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                    <option value="bermasalah" {{ request('status_akun') == 'bermasalah' ? 'selected' : '' }}>
                        Bermasalah
                    </option>
                </select>
            </div>

            <div class="col-md-2 mb-3">
                <button type="submit" class="btn btn-danger w-100">
                    <i class="bi bi-search me-1"></i>
                    Cari
                </button>
            </div>
        </div>

        @if(request('search') || request('status_verifikasi') || request('status_akun'))
            <a href="{{ route('admin.peserta.index') }}" class="btn btn-light">
                <i class="bi bi-x-circle me-1"></i>
                Reset Filter
            </a>
        @endif
    </form>
</div>

<div class="table-card">
    <div class="table-card-header">
        <h5 class="table-card-title">
            <i class="bi bi-people-fill text-danger me-2"></i>
            Daftar Peserta
        </h5>

        <div class="d-flex gap-2 align-items-center">
            @if(request('search') || request('status_verifikasi') || request('status_akun'))
                <span class="badge bg-warning text-dark">
                    Filter Aktif
                </span>
            @endif

            <span class="badge bg-danger">
                Total: {{ $peserta->total() }} Peserta
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peserta</th>
                    <th>NIK</th>
                    <th>Asal Sekolah</th>
                    <th>Status Akun</th>
                    <th>Status Verifikasi</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peserta as $item)
                    <tr>
                        <td>
                            {{ $loop->iteration + ($peserta->currentPage() - 1) * $peserta->perPage() }}
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div style="
                                    width: 44px;
                                    height: 44px;
                                    border-radius: 14px;
                                    background: #fee2e2;
                                    color: #dc2626;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 22px;
                                ">
                                    <i class="bi bi-person-fill"></i>
                                </div>

                                <div>
                                    <div class="fw-bold">
                                        {{ $item->name }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $item->email }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        <td>{{ $item->nik }}</td>

                        <td>
                            {{ $item->biodata->asal_sekolah ?? '-' }}
                        </td>

                        <td>
                            @if($item->status_akun == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @elseif($item->status_akun == 'nonaktif')
                                <span class="badge bg-secondary">Nonaktif</span>
                            @else
                                <span class="badge bg-warning text-dark">Bermasalah</span>
                            @endif
                        </td>

                        <td>
                            @if($item->biodata)
                                @if($item->biodata->status_verifikasi == 'lulus_verifikasi')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Lulus
                                    </span>
                                @elseif($item->biodata->status_verifikasi == 'menunggu_verifikasi')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-hourglass-split me-1"></i>
                                        Menunggu
                                    </span>
                                @elseif($item->biodata->status_verifikasi == 'ditolak')
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Belum Lengkap
                                    </span>
                                @endif
                            @else
                                <span class="badge bg-secondary">
                                    Belum Ada Biodata
                                </span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.peserta.show', $item->id) }}" class="btn btn-sm btn-danger">
                                <i class="bi bi-eye-fill me-1"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Data peserta tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $peserta->links() }}
    </div>
</div>
@endsection
