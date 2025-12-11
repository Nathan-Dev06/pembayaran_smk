<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Pembayaran Digital SMK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #8b5cf6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f3f4f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            min-height: 100vh;
            padding: 2rem 0;
            color: white;
            position: fixed;
            width: 260px;
            left: 0;
            top: 0;
            overflow-y: auto;
        }

        .sidebar .brand {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .sidebar .brand h4 {
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .sidebar .brand small {
            opacity: 0.8;
            font-size: 0.8rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem 1.5rem;
            display: block;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }

        .sidebar .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
        }

        .main-content {
            margin-left: 260px;
        }

        .topbar {
            background: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h3 {
            margin: 0;
            color: var(--primary);
            font-weight: 600;
            font-size: 1.5rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-info {
            text-align: right;
        }

        .user-info .name {
            font-weight: 600;
            color: #111;
            margin-bottom: 0.25rem;
        }

        .user-info .role {
            font-size: 0.875rem;
            color: #666;
        }

        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .content {
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #e5e7eb;
            padding: 1.5rem;
            font-weight: 600;
            color: var(--primary);
        }

        .card-body {
            padding: 1.5rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
        }

        .stat-card.success {
            border-left-color: var(--success);
        }

        .stat-card.danger {
            border-left-color: var(--danger);
        }

        .stat-card.warning {
            border-left-color: var(--warning);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .stat-card.success .stat-number {
            color: var(--success);
        }

        .stat-card.danger .stat-number {
            color: var(--danger);
        }

        .stat-card.warning .stat-number {
            color: var(--warning);
        }

        .stat-label {
            color: #666;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .badge-menunggu {
            background-color: var(--warning);
            color: white;
        }

        .badge-dibayar {
            background-color: var(--success);
            color: white;
        }

        table {
            margin-bottom: 0;
        }

        table thead {
            background-color: #f9fafb;
        }

        table th {
            border-bottom: 2px solid #e5e7eb;
            color: #374151;
            font-weight: 600;
        }

        table td {
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                flex-wrap: wrap;
                gap: 1rem;
            }

            .topbar h3 {
                font-size: 1.25rem;
            }

            .content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand">
            <h4><i class="bi bi-wallet2"></i> PaySMK</h4>
            <small>Sistem Pembayaran Digital</small>
        </div>
        <nav>
            <a href="/dashboard" class="nav-link active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="#" class="nav-link">
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

    <div class="main-content">
        <div class="topbar">
            <h3>Dashboard</h3>
            <div class="user-menu">
                <div class="user-info">
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="role">Administrator</div>
                </div>
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="content">
            <h5 class="mb-4">Selamat datang, {{ Auth::user()->name }}! 👋</h5>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Total Siswa</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card danger">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Tagihan Menunggu</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card success">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Pembayaran Terverifikasi</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card warning">
                        <div class="stat-number">Rp 0</div>
                        <div class="stat-label">Total Terkumpul</div>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="bi bi-list"></i> Tagihan Terbaru
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Belum ada data tagihan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="bi bi-pie-chart"></i> Ringkasan Pembayaran
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Terbayar</span>
                                    <strong class="text-success">0%</strong>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Menunggu</span>
                                    <strong class="text-warning">0%</strong>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Terlambat</span>
                                    <strong class="text-danger">0%</strong>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-danger" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
