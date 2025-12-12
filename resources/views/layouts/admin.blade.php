<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin') - Sistem Pembayaran Digital SMK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* CSS Tambahan Jaga-jaga kalau file admin.css belum ke-load */
        .sidebar { background: linear-gradient(135deg, #6366f1, #8b5cf6); min-height: 100vh; padding: 2rem 0; color: white; position: fixed; width: 260px; left: 0; top: 0; overflow-y: auto; z-index: 1000; }
        .sidebar .brand { padding: 1.5rem; text-align: center; border-bottom: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 2rem; }
        .sidebar .nav-link { color: rgba(255, 255, 255, 0.8); padding: 1rem 1.5rem; display: block; text-decoration: none; border-left: 3px solid transparent; transition: all 0.3s ease; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; background-color: rgba(255, 255, 255, 0.1); border-left-color: white; }
        .sidebar .nav-link i { margin-right: 0.75rem; width: 20px; }
        .main-content { margin-left: 260px; }
        .topbar { background: white; padding: 1.5rem 2rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 2rem; }
        @media (max-width: 768px) { .sidebar { width: 0; overflow: hidden; } .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand">
            <h4><i class="bi bi-wallet2"></i> PaySMK</h4>
            <small>Sistem Pembayaran Digital</small>
        </div>
        <nav>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Siswa
            </a>

            {{-- MENU TAGIHAN (SUDAH DIPERBAIKI) --}}
            <a href="{{ route('admin.tagihan.index') }}" class="nav-link {{ request()->routeIs('admin.tagihan*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark"></i> Tagihan
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-credit-card"></i> Pembayaran
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-bar-chart"></i> Laporan
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-gear"></i> Pengaturan
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="topbar">
            <h3>@yield('title', 'Dashboard')</h3>
            <div class="user-menu">
                <div class="user-info">
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
                <div class="avatar" style="width: 40px; height: 40px; background: #6366f1; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-left: 10px;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline ms-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
