@extends('layouts.admin')

@section('page-title', 'Kelola Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Kelola Admin</h3>
        <p class="text-muted mb-0">
            Tambah dan kelola akun admin sistem Paskibraka.
        </p>
    </div>

    <a href="{{ route('admin.admin-user.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Admin
    </a>
</div>

<div class="modern-card p-4 mb-4">
    <form action="{{ route('admin.admin-user.index') }}" method="GET">
        <div class="row align-items-end">
            <div class="col-md-10 mb-3">
                <label class="form-label fw-semibold">Cari Admin</label>
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari nama, NIK, atau email admin..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="col-md-2 mb-3">
                <button type="submit" class="btn btn-danger w-100">
                    <i class="bi bi-search me-1"></i>
                    Cari
                </button>
            </div>
        </div>

        @if(request('search'))
            <a href="{{ route('admin.admin-user.index') }}" class="btn btn-light">
                <i class="bi bi-x-circle me-1"></i>
                Reset Filter
            </a>
        @endif
    </form>
</div>

<div class="table-card">
    <div class="table-card-header">
        <h5 class="table-card-title">
            <i class="bi bi-person-gear text-danger me-2"></i>
            Daftar Admin
        </h5>

        <div class="d-flex gap-2 align-items-center">
            @if(request('search'))
                <span class="badge bg-warning text-dark">Filter Aktif</span>
            @endif

            <span class="badge bg-danger">
                Total: {{ $admins->total() }} Admin
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Admin</th>
                    <th>NIK</th>
                    <th>Status Akun</th>
                    <th>Tanggal Dibuat</th>
                    <th width="210">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($admins as $item)
                    <tr>
                        <td>
                            {{ $loop->iteration + ($admins->currentPage() - 1) * $admins->perPage() }}
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
                                    <i class="bi bi-person-fill-gear"></i>
                                </div>

                                <div>
                                    <div class="fw-bold">{{ $item->name }}</div>
                                    <small class="text-muted">{{ $item->email }}</small>
                                </div>
                            </div>
                        </td>

                        <td>{{ $item->nik }}</td>

                        <td>
                            @if($item->status_akun == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @elseif($item->status_akun == 'nonaktif')
                                <span class="badge bg-secondary">Nonaktif</span>
                            @else
                                <span class="badge bg-warning text-dark">Bermasalah</span>
                            @endif
                        </td>

                        <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>

                        <td>
                            <a href="{{ route('admin.admin-user.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            @if(auth()->id() !== $item->id)
                                <form action="{{ route('admin.admin-user.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-dark">Akun Saat Ini</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-person-gear fs-1 d-block mb-2"></i>
                            Data admin tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $admins->links() }}
    </div>
</div>
@endsection
