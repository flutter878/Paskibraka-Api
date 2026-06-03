@extends('layouts.admin')

@section('page-title', 'Kelola Pengumuman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Kelola Pengumuman</h3>
        <p class="text-muted mb-0">
            Buat dan kelola informasi yang akan tampil di aplikasi peserta.
        </p>
    </div>

    <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Pengumuman
    </a>
</div>

<div class="modern-card p-4 mb-4">
    <form action="{{ route('admin.pengumuman.index') }}" method="GET">
        <div class="row align-items-end">
            <div class="col-md-7 mb-3">
                <label class="form-label fw-semibold">Cari Pengumuman</label>
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari judul atau isi pengumuman..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
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

        @if(request('search') || request('status'))
            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-light">
                <i class="bi bi-x-circle me-1"></i>
                Reset Filter
            </a>
        @endif
    </form>
</div>

<div class="table-card">
    <div class="table-card-header">
        <h5 class="table-card-title">
            <i class="bi bi-megaphone-fill text-danger me-2"></i>
            Daftar Pengumuman
        </h5>

        <div class="d-flex gap-2 align-items-center">
            @if(request('search') || request('status'))
                <span class="badge bg-warning text-dark">
                    Filter Aktif
                </span>
            @endif

            <span class="badge bg-danger">
                Total: {{ $pengumuman->total() }} Pengumuman
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pengumuman</th>
                    <th>Lampiran</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pengumuman as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($pengumuman->currentPage() - 1) * $pengumuman->perPage() }}</td>

                        <td>
                            <div class="fw-bold">{{ $item->judul }}</div>
                            <small class="text-muted">
                                {{ \Illuminate\Support\Str::limit($item->isi_konten, 90) }}
                            </small>
                        </td>

                        <td>
                            @if($item->lampiran)
                                <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-paperclip me-1"></i>
                                    Lampiran
                                </a>
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>

                        <td>
                            @if($item->status == 'aktif')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>

                        <td>
                            <a href="{{ route('admin.pengumuman.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('admin.pengumuman.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
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
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-megaphone fs-1 d-block mb-2"></i>
                            Belum ada pengumuman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $pengumuman->links() }}
    </div>
</div>
@endsection
