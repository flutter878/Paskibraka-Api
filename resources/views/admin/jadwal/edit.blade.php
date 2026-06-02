@extends('layouts.admin')

@section('page-title', 'Edit Jadwal Seleksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Edit Jadwal Seleksi</h3>
        <p class="text-muted mb-0">
            Perbarui data jadwal tahapan seleksi.
        </p>
    </div>

    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline-danger">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali
    </a>
</div>

<div class="modern-card p-4">
    <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" class="form-control" value="{{ old('nama_kegiatan', $jadwal->nama_kegiatan) }}" required>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $jadwal->tanggal) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai', $jadwal->jam_mulai ? \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') : '') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai', $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : '') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $jadwal->lokasi) }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="4">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select" required>
                <option value="aktif" {{ old('status', $jadwal->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status', $jadwal->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-save me-1"></i>
                Update Jadwal
            </button>

            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-light">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
