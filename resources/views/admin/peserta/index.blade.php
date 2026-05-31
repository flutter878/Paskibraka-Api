@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Data Peserta</h3>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-danger">
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Asal Sekolah</th>
                        <th>Status Akun</th>
                        <th>Status Verifikasi</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peserta as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($peserta->currentPage() - 1) * $peserta->perPage() }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->biodata->asal_sekolah ?? '-' }}</td>
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
                                        <span class="badge bg-success">Lulus Verifikasi</span>
                                    @elseif($item->biodata->status_verifikasi == 'menunggu_verifikasi')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($item->biodata->status_verifikasi == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Lengkap</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Belum Ada Biodata</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.peserta.show', $item->id) }}" class="btn btn-sm btn-danger">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Belum ada data peserta.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $peserta->links() }}
        </div>
    </div>
</div>
@endsection
