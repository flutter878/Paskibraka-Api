@extends('layouts.admin')

@section('page-title', 'Tambah Pengumuman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Tambah Pengumuman</h3>
        <p class="text-muted mb-0">
            Buat informasi baru untuk ditampilkan di aplikasi peserta.
        </p>
    </div>

    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-outline-danger">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali
    </a>
</div>

<div class="modern-card p-4">
    <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Pengumuman</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Isi Konten</label>
            <textarea name="isi_konten" class="form-control" rows="6" required>{{ old('isi_konten') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select" required>
                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Lampiran</label>
                <input type="file" name="lampiran" class="form-control">
                <small class="text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 2 MB.</small>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-save me-1"></i>
                Simpan Pengumuman
            </button>

            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-light">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
