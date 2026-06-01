<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Paskibraka</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-dark bg-danger">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                Admin Paskibraka
            </a>

            <form action="{{ route('logout') }}" method="POST" class="d-flex">
                @csrf
                <button class="btn btn-light btn-sm" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-2 bg-white border-end min-vh-100 p-3">
                <div class="list-group">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.peserta.index') }}" class="list-group-item list-group-item-action">
                        Data Peserta
                    </a>
                    <a href="{{ route('admin.pengumuman.index') }}" class="list-group-item list-group-item-action">
                        Pengumuman
                    </a>
                    <a href="{{ route('admin.jadwal.index') }}" class="list-group-item list-group-item-action">
                        Jadwal Seleksi
                    </a>
                </div>
            </aside>

            <main class="col-md-10 p-4">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
