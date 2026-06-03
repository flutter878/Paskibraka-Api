<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Paskibraka</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #dc2626;
            --primary-dark: #991b1b;
            --primary-soft: #fee2e2;
            --bg: #f6f7fb;
            --card: #ffffff;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --border: #e5e7eb;
        }

        * {
            font-family: "Segoe UI", sans-serif;
        }

        body {
            background: var(--bg);
            color: var(--text-dark);
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 270px;
            background: linear-gradient(180deg, #dc2626, #991b1b);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding: 22px 18px;
            z-index: 1000;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .sidebar-brand-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.16);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .sidebar-brand-title {
            font-size: 18px;
            font-weight: 800;
            line-height: 1.2;
        }

        .sidebar-brand-subtitle {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.75);
        }

        .sidebar-menu-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.65);
            margin: 20px 10px 10px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 15px;
            color: rgba(255, 255, 255, 0.88);
            text-decoration: none;
            margin-bottom: 8px;
            transition: all 0.2s ease;
            font-weight: 600;
            font-size: 14px;
        }

        .sidebar-link i {
            font-size: 18px;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.18);
            color: white;
            transform: translateX(4px);
        }

        .main-content {
            margin-left: 270px;
            width: calc(100% - 270px);
            min-height: 100vh;
        }

        .topbar {
            height: 76px;
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .topbar-title {
            font-weight: 800;
            font-size: 20px;
            margin-bottom: 2px;
        }

        .topbar-subtitle {
            color: var(--text-muted);
            font-size: 13px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-avatar {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .content-area {
            padding: 28px;
        }

        .modern-card {
            background: white;
            border: 0;
            border-radius: 22px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        }

        .stat-card {
            background: white;
            border-radius: 22px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
            border: 1px solid rgba(229, 231, 235, 0.7);
            height: 100%;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.10);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 17px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 16px;
        }

        .stat-title {
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 800;
            color: var(--text-dark);
            margin-top: 4px;
        }

        .table-card {
            background: white;
            border-radius: 22px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .table-card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-card-title {
            font-weight: 800;
            font-size: 16px;
            margin: 0;
        }

        .table thead th {
            background: #f9fafb;
            color: #374151;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: 1px solid var(--border);
        }

        .table td {
            vertical-align: middle;
            font-size: 14px;
        }

        .btn-danger {
            background: var(--primary);
            border-color: var(--primary);
            border-radius: 12px;
            font-weight: 600;
        }

        .btn-danger:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline-danger {
            border-radius: 12px;
            font-weight: 600;
        }

        .badge {
            border-radius: 10px;
            padding: 7px 10px;
        }

        .alert {
            border-radius: 16px;
            border: 0;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            padding: 11px 14px;
            border-color: var(--border);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.12);
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 88px;
                padding: 20px 12px;
            }

            .sidebar-brand-title,
            .sidebar-brand-subtitle,
            .sidebar-menu-title,
            .sidebar-link span {
                display: none;
            }

            .sidebar-link {
                justify-content: center;
                padding: 14px;
            }

            .main-content {
                margin-left: 88px;
                width: calc(100% - 88px);
            }
        }

        @media (max-width: 768px) {
            .topbar {
                padding: 0 18px;
            }

            .content-area {
                padding: 18px;
            }

            .admin-profile-info {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="admin-wrapper">
        {{-- Sidebar --}}
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="bi bi-flag-fill"></i>
                </div>
                <div>
                    <div class="sidebar-brand-title">Paskibraka</div>
                    <div class="sidebar-brand-subtitle">Admin Panel</div>
                </div>
            </div>

            <div class="sidebar-menu-title">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.peserta.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.peserta.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Data Peserta</span>
            </a>

            <a href="{{ route('admin.pengumuman.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone-fill"></i>
                <span>Pengumuman</span>
            </a>

            <a href="{{ route('admin.jadwal.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event-fill"></i>
                <span>Jadwal Seleksi</span>
            </a>

            <a href="{{ route('admin.hasil.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.hasil.*') ? 'active' : '' }}">
                <i class="bi bi-trophy-fill"></i>
                <span>Hasil Seleksi</span>
            </a>

            <a href="{{ route('admin.laporan.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph-fill"></i>
                <span>Laporan</span>
            </a>

            <div class="sidebar-menu-title">Akun</div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="sidebar-link border-0 w-100 text-start bg-transparent" type="submit">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </aside>

        {{-- Main Content --}}
        <main class="main-content">
            <nav class="topbar">
                <div>
                    <div class="topbar-title">@yield('page-title', 'Dashboard Admin')</div>
                    <div class="topbar-subtitle">
                        Sistem Manajemen dan Pendaftaran Paskibraka
                    </div>
                </div>

                <div class="admin-profile">
                    <div class="admin-profile-info text-end">
                        <div class="fw-bold">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <small class="text-muted">{{ auth()->user()->email ?? '-' }}</small>
                    </div>
                    <div class="admin-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                </div>
            </nav>

            <section class="content-area">
                @if(session('success'))
                    <div class="alert alert-success shadow-sm mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger shadow-sm mb-4">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
