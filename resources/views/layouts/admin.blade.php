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
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <h4><i class="bi bi-wallet2"></i> PaySMK</h4>
            <small>Sistem Pembayaran Digital</small>
        </div>
        <nav>
            <a href="/dashboard" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Siswa
            </a>
            <a href="#" class="nav-link">
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h3>@yield('title', 'Dashboard')</h3>
            <div class="user-menu">
                <div class="user-info">
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
                <div class="avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>