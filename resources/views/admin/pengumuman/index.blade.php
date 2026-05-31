@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Kelola Pengumuman</h3>

    <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-danger">
        + Tambah Pengumuman
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-danger">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Isi Konten</th>
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
                            <td>{{ $item->judul }}</td>
                            <td>{{ Str::limit($item->isi_konten, 80) }}</td>
                            <td>
                                @if($item->lampiran)
                                    <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                        Lihat Lampiran
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.pengumuman.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('admin.pengumuman.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
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
                            <td colspan="7" class="text-center text-muted">
                                Belum ada pengumuman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $pengumuman->links() }}
        </div>
    </div>
</div>
@endsection
