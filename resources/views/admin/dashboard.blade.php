@extends('layouts.admin')

@section('content')
<h3 class="mb-4">Dashboard Admin</h3>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6>Total Peserta</h6>
                <h3>{{ $totalPeserta }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6>Menunggu Verifikasi</h6>
                <h3>{{ $menungguVerifikasi }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6>Lulus Verifikasi</h6>
                <h3>{{ $lulusVerifikasi }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6>Dokumen Menunggu</h6>
                <h3>{{ $dokumenMenunggu }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-3">
    <div class="card-body">
        <h5>Selamat Datang, {{ auth()->user()->name }}</h5>
        <p class="mb-0">
            Gunakan dashboard ini untuk mengelola peserta, verifikasi berkas, dan mengelola pengumuman seleksi.
        </p>
    </div>
</div>
@endsection
