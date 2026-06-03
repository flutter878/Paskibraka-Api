@extends('layouts.admin')

@section('page-title', 'Jadwal Seleksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Jadwal Seleksi</h3>
        <p class="text-muted mb-0">
            Kelola jadwal tahapan seleksi yang tampil di aplikasi peserta.
        </p>
    </div>

    <a href="{{ route('admin.jadwal.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Jadwal
    </a>
</div>

<div class="modern-card p-4 mb-4">
    <form action="{{ route('admin.jadwal.index') }}" method="GET">
        <div class="row align-items-end">
            <div class="col-md-5 mb-3">
                <label class="form-label fw-semibold">Cari Jadwal</label>
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari kegiatan, lokasi, atau keterangan..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Tanggal</label>
                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    value="{{ request('tanggal') }}"
                >
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>
                        Nonaktif
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

        @if(request('search') || request('tanggal') || request('status'))
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-light">
                <i class="bi bi-x-circle me-1"></i>
                Reset Filter
            </a>
        @endif
    </form>
</div>

<div class="table-card">
    <div class="table-card-header">
        <h5 class="table-card-title">
            <i class="bi bi-calendar-event-fill text-danger me-2"></i>
            Daftar Jadwal
        </h5>

        <div class="d-flex gap-2 align-items-center">
            @if(request('search') || request('tanggal') || request('status'))
                <span class="badge bg-warning text-dark">
                    Filter Aktif
                </span>
            @endif

            <span class="badge bg-danger">
                Total: {{ $jadwal->total() }} Jadwal
            </span>
</div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($jadwal as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($jadwal->currentPage() - 1) * $jadwal->perPage() }}</td>

                        <td>
                            <div class="fw-bold">{{ $item->nama_kegiatan }}</div>
                            <small class="text-muted">
                                {{ \Illuminate\Support\Str::limit($item->keterangan ?? '-', 80) }}
                            </small>
                        </td>

                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>

                        <td>
                            {{ $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '-' }}
                            -
                            {{ $item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-' }}
                        </td>

                        <td>{{ $item->lokasi ?? '-' }}</td>

                        <td>
                            @if($item->status == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.jadwal.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('admin.jadwal.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
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
                            <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                            Belum ada jadwal seleksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $jadwal->links() }}
    </div>
</div>
@endsection
