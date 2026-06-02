@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Kelola Hasil Seleksi</h3>

    <a href="{{ route('admin.hasil.create') }}" class="btn btn-danger">
        + Tambah Hasil
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-danger">
                    <tr>
                        <th>No</th>
                        <th>Peserta</th>
                        <th>NIK</th>
                        <th>Tahap</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hasil as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($hasil->currentPage() - 1) * $hasil->perPage() }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>{{ $item->user->nik ?? '-' }}</td>
                            <td>{{ $item->tahap }}</td>
                            <td>{{ $item->nilai ?? '-' }}</td>
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
                            <td>{{ $item->catatan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.hasil.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('admin.hasil.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus hasil seleksi ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Belum ada data hasil seleksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $hasil->links() }}
        </div>
    </div>
</div>
@endsection
