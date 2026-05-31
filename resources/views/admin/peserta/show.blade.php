@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Detail Peserta</h3>
    <a href="{{ route('admin.peserta.index') }}" class="btn btn-secondary btn-sm">
        Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-5 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-danger text-white">
                Data Akun
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="160">NIK</th>
                        <td>: {{ $peserta->nik }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>: {{ $peserta->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>: {{ $peserta->email }}</td>
                    </tr>
                    <tr>
                        <th>Status Akun</th>
                        <td>: {{ ucfirst($peserta->status_akun) }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Daftar</th>
                        <td>: {{ $peserta->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-7 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-danger text-white">
                Biodata Peserta
            </div>
            <div class="card-body">
                @if($peserta->biodata)
                    <table class="table table-borderless">
                        <tr>
                            <th width="180">Nama Lengkap</th>
                            <td>: {{ $peserta->biodata->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>Asal Sekolah</th>
                            <td>: {{ $peserta->biodata->asal_sekolah }}</td>
                        </tr>
                        <tr>
                            <th>Tempat Lahir</th>
                            <td>: {{ $peserta->biodata->tempat_lahir }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>: {{ \Carbon\Carbon::parse($peserta->biodata->tanggal_lahir)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Tinggi Badan</th>
                            <td>: {{ $peserta->biodata->tinggi_badan }} cm</td>
                        </tr>
                        <tr>
                            <th>Berat Badan</th>
                            <td>: {{ $peserta->biodata->berat_badan }} kg</td>
                        </tr>
                        <tr>
                            <th>Golongan Darah</th>
                            <td>: {{ $peserta->biodata->golongan_darah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Riwayat Penyakit</th>
                            <td>: {{ $peserta->biodata->riwayat_penyakit ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Motivasi Esai</th>
                            <td>: {{ $peserta->biodata->motivasi_esai ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Verifikasi</th>
                            <td>:
                                <strong>{{ str_replace('_', ' ', strtoupper($peserta->biodata->status_verifikasi)) }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Catatan Admin</th>
                            <td>: {{ $peserta->biodata->catatan_admin ?? '-' }}</td>
                        </tr>
                    </table>
                @else
                    <div class="alert alert-warning">
                        Peserta belum mengisi biodata.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($peserta->biodata)
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-danger text-white">
        Verifikasi Biodata
    </div>
    <div class="card-body">
        <form action="{{ route('admin.peserta.verifikasiBiodata', $peserta->id) }}" method="POST">
            @csrf

            <div class="mb-3">
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

            <div class="mb-3">
                <label class="form-label">Catatan Admin</label>
                <textarea name="catatan_admin" class="form-control" rows="3">{{ $peserta->biodata->catatan_admin }}</textarea>
            </div>

            <button type="submit" class="btn btn-danger">
                Simpan Verifikasi Biodata
            </button>
        </form>
    </div>
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-danger text-white">
        Dokumen Peserta
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-danger">
                    <tr>
                        <th>No</th>
                        <th>Jenis Dokumen</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th width="300">Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peserta->dokumen as $dokumen)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ str_replace('_', ' ', strtoupper($dokumen->jenis_dokumen)) }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="btn btn-sm btn-outline-danger">
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
                                        Simpan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Peserta belum mengunggah dokumen.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
