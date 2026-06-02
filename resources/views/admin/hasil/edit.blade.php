@extends('layouts.admin')

@section('page-title', 'Edit Hasil Seleksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Edit Hasil Seleksi</h3>
        <p class="text-muted mb-0">
            Perbarui hasil seleksi peserta.
        </p>
    </div>

    <a href="{{ route('admin.hasil.index') }}" class="btn btn-outline-danger">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali
    </a>
</div>

<div class="modern-card p-4">
    <form action="{{ route('admin.hasil.update', $hasil->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Peserta</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Pilih Peserta --</option>
                @foreach($peserta as $item)
                    <option value="{{ $item->id }}" {{ old('user_id', $hasil->user_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->name }} - {{ $item->nik }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tahap Seleksi</label>
                <input
                    type="text"
                    name="tahap"
                    class="form-control"
                    value="{{ old('tahap', $hasil->tahap) }}"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Nilai</label>
                <input
                    type="number"
                    name="nilai"
                    class="form-control"
                    value="{{ old('nilai', $hasil->nilai) }}"
                    min="0"
                    max="100"
                >
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select" required>
                <option value="menunggu" {{ old('status', $hasil->status) == 'menunggu' ? 'selected' : '' }}>
                    Menunggu
                </option>
                <option value="lulus" {{ old('status', $hasil->status) == 'lulus' ? 'selected' : '' }}>
                    Lulus
                </option>
                <option value="tidak_lulus" {{ old('status', $hasil->status) == 'tidak_lulus' ? 'selected' : '' }}>
                    Tidak Lulus
                </option>
                <option value="cadangan" {{ old('status', $hasil->status) == 'cadangan' ? 'selected' : '' }}>
                    Cadangan
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Catatan</label>
            <textarea name="catatan" class="form-control" rows="4">{{ old('catatan', $hasil->catatan) }}</textarea>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-save me-1"></i>
                Update Hasil
            </button>

            <a href="{{ route('admin.hasil.index') }}" class="btn btn-light">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
