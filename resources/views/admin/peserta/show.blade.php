@extends('layouts.admin')

@section('page-title', 'Detail Peserta')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Detail Peserta</h3>
        <p class="text-muted mb-0">
            Lihat biodata, dokumen, dan lakukan verifikasi peserta.
        </p>
    </div>

    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalResetPassword">
            <i class="bi bi-key-fill me-1"></i>
            Reset Password
        </button>

        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalHapus">
            <i class="bi bi-trash-fill me-1"></i>
            Hapus Peserta
        </button>

        <a href="{{ route('admin.peserta.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="modern-card p-4">
            <div class="text-center mb-4">
                <div style="
                    width: 86px;
                    height: 86px;
                    border-radius: 28px;
                    background: #fee2e2;
                    color: #dc2626;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 46px;
                    margin: 0 auto 14px;
                ">
                    <i class="bi bi-person-fill"></i>
                </div>

                <h4 class="fw-bold mb-1">{{ $peserta->name }}</h4>
                <p class="text-muted mb-0">{{ $peserta->email }}</p>
            </div>

            <div class="mb-3">
                <small class="text-muted">NIK</small>
                <div class="fw-bold">{{ $peserta->nik }}</div>
            </div>

            <div class="mb-3">
                <small class="text-muted">Status Akun</small>
                <div class="mt-1">
                    @if($peserta->status_akun == 'aktif')
                        <span class="badge bg-success">Aktif</span>
                    @elseif($peserta->status_akun == 'nonaktif')
                        <span class="badge bg-secondary">Nonaktif</span>
                    @else
                        <span class="badge bg-warning text-dark">Bermasalah</span>
                    @endif
                </div>
            </div>

            <div>
                <small class="text-muted">Tanggal Daftar</small>
                <div class="fw-bold">
                    {{ $peserta->created_at->format('d-m-Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 mb-4">
        <div class="modern-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-card-checklist text-danger me-2"></i>
                    Biodata Peserta
                </h5>

                @if($peserta->biodata)
                    @if($peserta->biodata->status_verifikasi == 'lulus_verifikasi')
                        <span class="badge bg-success">Lulus Verifikasi</span>
                    @elseif($peserta->biodata->status_verifikasi == 'menunggu_verifikasi')
                        <span class="badge bg-warning text-dark">Menunggu</span>
                    @elseif($peserta->biodata->status_verifikasi == 'ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @else
                        <span class="badge bg-secondary">Belum Lengkap</span>
                    @endif
                @endif
            </div>

            @if($peserta->biodata)
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Nama Lengkap</small>
                        <div class="fw-bold">{{ $peserta->biodata->nama_lengkap }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Asal Sekolah</small>
                        <div class="fw-bold">{{ $peserta->biodata->asal_sekolah }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Tempat Lahir</small>
                        <div class="fw-bold">{{ $peserta->biodata->tempat_lahir }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Tanggal Lahir</small>
                        <div class="fw-bold">
                            {{ \Carbon\Carbon::parse($peserta->biodata->tanggal_lahir)->format('d-m-Y') }}
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <small class="text-muted">Tinggi Badan</small>
                        <div class="fw-bold">{{ $peserta->biodata->tinggi_badan }} cm</div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <small class="text-muted">Berat Badan</small>
                        <div class="fw-bold">{{ $peserta->biodata->berat_badan }} kg</div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <small class="text-muted">Golongan Darah</small>
                        <div class="fw-bold">{{ $peserta->biodata->golongan_darah ?? '-' }}</div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <small class="text-muted">Riwayat Penyakit</small>
                        <div class="fw-bold">{{ $peserta->biodata->riwayat_penyakit ?? '-' }}</div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <small class="text-muted">Motivasi Esai</small>
                        <div class="fw-bold">{{ $peserta->biodata->motivasi_esai ?? '-' }}</div>
                    </div>

                    <div class="col-md-12">
                        <small class="text-muted">Catatan Admin</small>
                        <div class="fw-bold">{{ $peserta->biodata->catatan_admin ?? '-' }}</div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning mb-0">
                    Peserta belum mengisi biodata.
                </div>
            @endif
        </div>
    </div>
</div>

@if($peserta->biodata)
<div class="modern-card p-4 mb-4">
    <h5 class="fw-bold mb-3">
        <i class="bi bi-shield-check text-danger me-2"></i>
        Verifikasi Biodata
    </h5>

    <form action="{{ route('admin.peserta.verifikasiBiodata', $peserta->id) }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Status Verifikasi</label>
                <select name="status_verifikasi" class="form-select" required>
                    <option value="belum_lengkap" {{ $peserta->biodata->status_verifikasi == 'belum_lengkap' ? 'selected' : '' }}>
                        Belum Lengkap
                    </option>
                    <option value="menunggu_verifikasi" {{ $peserta->biodata->status_verifikasi == 'menunggu_verifikasi' ? 'selected' : '' }}>
                        Menunggu Verifikasi
                    </option>
                    <option value="lulus_verifikasi" {{ $peserta->biodata->status_verifikasi == 'lulus_verifikasi' ? 'selected' : '' }}>
                        Lulus Verifikasi
                    </option>
                    <option value="ditolak" {{ $peserta->biodata->status_verifikasi == 'ditolak' ? 'selected' : '' }}>
                        Ditolak
                    </option>
                </select>
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label">Catatan Admin</label>
                <textarea name="catatan_admin" class="form-control" rows="2">{{ $peserta->biodata->catatan_admin }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-danger">
            <i class="bi bi-save me-1"></i>
            Simpan Verifikasi Biodata
        </button>
    </form>
</div>
@endif

<div class="table-card">
    <div class="table-card-header">
        <h5 class="table-card-title">
            <i class="bi bi-folder-fill text-danger me-2"></i>
            Dokumen Peserta
        </h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Dokumen</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th width="330">Verifikasi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peserta->dokumen as $dokumen)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <div class="fw-bold">
                                {{ str_replace('_', ' ', strtoupper($dokumen->jenis_dokumen)) }}
                            </div>
                            <small class="text-muted">
                                Upload: {{ $dokumen->created_at->format('d-m-Y H:i') }}
                            </small>
                        </td>

                        <td>
                            <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-file-earmark-text me-1"></i>
                                Lihat File
                            </a>
                        </td>

                        <td>
                            @if($dokumen->status_dokumen == 'diterima')
                                <span class="badge bg-success">Diterima</span>
                            @elseif($dokumen->status_dokumen == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif($dokumen->status_dokumen == 'revisi')
                                <span class="badge bg-warning text-dark">Revisi</span>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </td>

                        <td>{{ $dokumen->catatan_admin ?? '-' }}</td>

                        <td>
                            <form action="{{ route('admin.dokumen.verifikasi', $dokumen->id) }}" method="POST">
                                @csrf

                                <div class="mb-2">
                                    <select name="status_dokumen" class="form-select form-select-sm" required>
                                        <option value="menunggu" {{ $dokumen->status_dokumen == 'menunggu' ? 'selected' : '' }}>
                                            Menunggu
                                        </option>
                                        <option value="diterima" {{ $dokumen->status_dokumen == 'diterima' ? 'selected' : '' }}>
                                            Diterima
                                        </option>
                                        <option value="ditolak" {{ $dokumen->status_dokumen == 'ditolak' ? 'selected' : '' }}>
                                            Ditolak
                                        </option>
                                        <option value="revisi" {{ $dokumen->status_dokumen == 'revisi' ? 'selected' : '' }}>
                                            Revisi
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <textarea name="catatan_admin" class="form-control form-control-sm" rows="2" placeholder="Catatan admin">{{ $dokumen->catatan_admin }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-save me-1"></i>
                                    Simpan
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                            Peserta belum mengunggah dokumen.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Reset Password --}}
<div class="modal fade" id="modalResetPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-key-fill text-warning me-2"></i>
                    Reset Password Peserta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.peserta.resetPassword', $peserta->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-3">
                        Reset password untuk <strong>{{ $peserta->name }}</strong>
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <input type="password" name="password" class="form-control" minlength="8" required placeholder="Minimal 8 karakter">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password baru">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-key-fill me-1"></i>
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Hapus Peserta --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                    Konfirmasi Hapus Peserta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus peserta <strong>{{ $peserta->name }}</strong>?</p>
                <p class="text-danger mb-0">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    Seluruh data biodata dan dokumen peserta akan ikut terhapus secara permanen.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.peserta.destroy', $peserta->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill me-1"></i>
                        Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
