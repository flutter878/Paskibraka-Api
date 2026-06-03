@extends('layouts.admin')

@section('page-title', 'Edit Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Edit Admin</h3>
        <p class="text-muted mb-0">
            Perbarui data admin dan reset password jika diperlukan.
        </p>
    </div>

    <a href="{{ route('admin.admin-user.index') }}" class="btn btn-outline-danger">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="modern-card p-4">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-person-gear text-danger me-2"></i>
                Data Admin
            </h5>

            <form action="{{ route('admin.admin-user.update', $adminUser->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">NIK Admin</label>
                    <input
                        type="text"
                        name="nik"
                        class="form-control"
                        value="{{ old('nik', $adminUser->nik) }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Admin</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $adminUser->name) }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $adminUser->email) }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Status Akun</label>
                    <select name="status_akun" class="form-select" required>
                        <option value="aktif" {{ old('status_akun', $adminUser->status_akun) == 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="nonaktif" {{ old('status_akun', $adminUser->status_akun) == 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                        <option value="bermasalah" {{ old('status_akun', $adminUser->status_akun) == 'bermasalah' ? 'selected' : '' }}>
                            Bermasalah
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-save me-1"></i>
                    Update Admin
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-5 mb-4">
        <div class="modern-card p-4">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-key-fill text-danger me-2"></i>
                Reset Password
            </h5>

            <form action="{{ route('admin.admin-user.resetPassword', $adminUser->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password Baru</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Minimal 8 karakter"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Ulangi password baru"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-key me-1"></i>
                    Reset Password
                </button>
            </form>

            <div class="alert alert-warning mt-4 mb-0">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Password lama akan diganti dengan password baru.
            </div>
        </div>
    </div>
</div>
@endsection
