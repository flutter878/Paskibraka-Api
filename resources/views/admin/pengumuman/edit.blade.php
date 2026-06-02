@extends('layouts.admin')

@section('page-title', 'Edit Pengumuman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Edit Pengumuman</h3>
        <p class="text-muted mb-0">
            Perbarui informasi pengumuman peserta.
        </p>
    </div>

    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-outline-danger">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali
    </a>
</div>

<div class="modern-card p-4">
    <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Pengumuman</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $pengumuman->judul) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Isi Konten</label>
            <textarea name="isi_konten" class="form-control" rows="6" required>{{ old('isi_konten', $pengumuman->isi_konten) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select" required>
                    <option value="aktif" {{ old('status', $pengumuman->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $pengumuman->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Lampiran Baru</label>
                <input type="file" name="lampiran" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti lampiran.</small>
            </div>
        </div>

        @if($pengumuman->lampiran)
            <div class="mb-3">
                <label class="form-label fw-semibold">Lampiran Saat Ini</label><br>
                <a href="{{ asset('storage/' . $pengumuman->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-paperclip me-1"></i>
                    Lihat Lampiran
                </a>
            </div>
        @endif

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-save me-1"></i>
                Update Pengumuman
            </button>

            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-light">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
