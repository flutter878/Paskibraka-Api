@extends('layouts.admin')

@section('page-title', 'Hasil Seleksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Hasil Seleksi</h3>
        <p class="text-muted mb-0">
            Kelola hasil seleksi peserta berdasarkan setiap tahapan.
        </p>
    </div>

    <a href="{{ route('admin.hasil.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Hasil
    </a>
</div>

<div class="modern-card p-4 mb-4">
    <form action="{{ route('admin.hasil.index') }}" method="GET">
        <div class="row align-items-end">
            <div class="col-md-5 mb-3">
                <label class="form-label fw-semibold">Cari Hasil Seleksi</label>
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari nama, NIK, email, tahap, atau catatan..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Tahap Seleksi</label>
                <input
                    type="text"
                    name="tahap"
                    class="form-control"
                    placeholder="Contoh: Administrasi"
                    value="{{ request('tahap') }}"
                >
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                        Menunggu
                    </option>
                    <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>
                        Lulus
                    </option>
                    <option value="tidak_lulus" {{ request('status') == 'tidak_lulus' ? 'selected' : '' }}>
                        Tidak Lulus
                    </option>
                    <option value="cadangan" {{ request('status') == 'cadangan' ? 'selected' : '' }}>
                        Cadangan
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

        @if(request('search') || request('tahap') || request('status'))
            <a href="{{ route('admin.hasil.index') }}" class="btn btn-light">
                <i class="bi bi-x-circle me-1"></i>
                Reset Filter
            </a>
        @endif
    </form>
</div>

<div class="table-card">
    <div class="table-card-header">
        <h5 class="table-card-title">
            <i class="bi bi-trophy-fill text-danger me-2"></i>
            Daftar Hasil Seleksi
        </h5>

        <div class="d-flex gap-2 align-items-center">
            @if(request('search') || request('tahap') || request('status'))
                <span class="badge bg-warning text-dark">
                    Filter Aktif
                </span>
            @endif

            <span class="badge bg-danger">
                Total: {{ $hasil->total() }} Data
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peserta</th>
                    <th>Tahap Seleksi</th>
                    <th>Nilai</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($hasil as $item)
                    <tr>
                        <td>
                            {{ $loop->iteration + ($hasil->currentPage() - 1) * $hasil->perPage() }}
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
                                        {{ $item->user->name ?? '-' }}
                                    </div>
                                    <small class="text-muted">
                                        NIK: {{ $item->user->nik ?? '-' }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="fw-bold">{{ $item->tahap }}</div>
                            <small class="text-muted">
                                Diinput: {{ $item->created_at->format('d-m-Y H:i') }}
                            </small>
                        </td>

                        <td>
                            @if($item->nilai !== null)
                                <span class="fw-bold">{{ $item->nilai }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>
                            @if($item->status == 'lulus')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Lulus
                                </span>
                            @elseif($item->status == 'tidak_lulus')
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle me-1"></i>
                                    Tidak Lulus
                                </span>
                            @elseif($item->status == 'cadangan')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-hourglass-split me-1"></i>
                                    Cadangan
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Menunggu
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ \Illuminate\Support\Str::limit($item->catatan ?? '-', 70) }}
                        </td>

                        <td>
                            <a href="{{ route('admin.hasil.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('admin.hasil.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus hasil seleksi ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-trophy fs-1 d-block mb-2"></i>
                            Data hasil seleksi tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $hasil->links() }}
    </div>
</div>
@endsection
