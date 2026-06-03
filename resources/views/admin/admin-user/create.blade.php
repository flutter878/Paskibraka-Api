@extends('layouts.admin')

@section('page-title', 'Tambah Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Tambah Admin</h3>
        <p class="text-muted mb-0">
            Buat akun admin baru untuk mengelola sistem.
        </p>
    </div>

    <a href="{{ route('admin.admin-user.index') }}" class="btn btn-outline-danger">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali
    </a>
</div>

<div class="modern-card p-4">
    <form action="{{ route('admin.admin-user.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">NIK Admin</label>
            <input
                type="text"
                name="nik"
                class="form-control"
                value="{{ old('nik') }}"
                placeholder="Masukkan NIK admin"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Admin</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                placeholder="Masukkan nama admin"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                placeholder="Masukkan email admin"
                required
            >
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Minimal 8 karakter"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password"
                    required
                >
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Status Akun</label>
            <select name="status_akun" class="form-select" required>
                <option value="aktif" {{ old('status_akun') == 'aktif' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="nonaktif" {{ old('status_akun') == 'nonaktif' ? 'selected' : '' }}>
                    Nonaktif
                </option>
                <option value="bermasalah" {{ old('status_akun') == 'bermasalah' ? 'selected' : '' }}>
                    Bermasalah
                </option>
            </select>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-save me-1"></i>
                Simpan Admin
            </button>

            <a href="{{ route('admin.admin-user.index') }}" class="btn btn-light">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
