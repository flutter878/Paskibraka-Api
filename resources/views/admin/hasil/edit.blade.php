@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Edit Hasil Seleksi</h3>

    <a href="{{ route('admin.hasil.index') }}" class="btn btn-secondary btn-sm">
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

        <form action="{{ route('admin.hasil.update', $hasil->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Peserta</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- Pilih Peserta --</option>
                    @foreach($peserta as $item)
                        <option value="{{ $item->id }}" {{ old('user_id', $hasil->user_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->name }} - {{ $item->nik }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tahap Seleksi</label>
                <input type="text" name="tahap" class="form-control" value="{{ old('tahap', $hasil->tahap) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nilai</label>
                <input type="number" name="nilai" class="form-control" value="{{ old('nilai', $hasil->nilai) }}" min="0" max="100">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="menunggu" {{ old('status', $hasil->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="lulus" {{ old('status', $hasil->status) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="tidak_lulus" {{ old('status', $hasil->status) == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                    <option value="cadangan" {{ old('status', $hasil->status) == 'cadangan' ? 'selected' : '' }}>Cadangan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="4">{{ old('catatan', $hasil->catatan) }}</textarea>
            </div>

            <button type="submit" class="btn btn-danger">
                Update Hasil
            </button>
        </form>
    </div>
</div>
@endsection
