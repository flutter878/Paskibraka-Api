@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Edit Pengumuman</h3>

    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary btn-sm">
        Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Judul Pengumuman</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $pengumuman->judul) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Konten</label>
                <textarea name="isi_konten" class="form-control" rows="6" required>{{ old('isi_konten', $pengumuman->isi_konten) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="aktif" {{ old('status', $pengumuman->status) == 'aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="nonaktif" {{ old('status', $pengumuman->status) == 'nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Lampiran Baru</label>
                <input type="file" name="lampiran" class="form-control">
                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti lampiran.
                </small>
            </div>

            @if($pengumuman->lampiran)
                <div class="mb-3">
                    <label class="form-label">Lampiran Saat Ini</label><br>
                    <a href="{{ asset('storage/' . $pengumuman->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                        Lihat Lampiran
                    </a>
                </div>
            @endif

            <button type="submit" class="btn btn-danger">
                Update Pengumuman
            </button>
        </form>
    </div>
</div>
@endsection
