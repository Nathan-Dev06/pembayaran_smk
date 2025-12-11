<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Sistem Pembayaran Digital SMK</title>
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

        .container-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0;
        }

        .topbar {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 1.5rem 2rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .topbar h3 {
            margin: 0;
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
            margin-bottom: 0.25rem;
        }

        .user-info .role {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
            border: 2px solid white;
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

        .stat-number {
            font-size: 1.75rem;
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

        .stat-label {
            color: #666;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .btn-logout {
            background-color: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: white;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            border-radius: 0.4rem;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background-color: var(--danger);
            border-color: var(--danger);
            color: white;
        }

        @media (max-width: 768px) {
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
    <div class="topbar">
        <h3><i class="bi bi-wallet2"></i> PaySMK</h3>
        <div class="user-menu">
            <div class="user-info">
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="role">Siswa</div>
            </div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="container-main">
        <div class="content">
            <h5 class="mb-4">Selamat datang, {{ Auth::user()->name }}! 👋</h5>

            <!-- Statistics -->
            <div class="row mb-4">
                <div class="col-sm-6 col-lg-4">
                    <div class="stat-card">
                        <div class="stat-number">Rp 0</div>
                        <div class="stat-label">Total Tagihan</div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="stat-card success">
                        <div class="stat-number">Rp 0</div>
                        <div class="stat-label">Sudah Dibayar</div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="stat-card danger">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Tagihan Menunggu</div>
                    </div>
                </div>
            </div>

            <!-- Tagihan List -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-file-earmark"></i> Daftar Tagihan Saya
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Belum ada tagihan
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-exclamation-triangle"></i> <strong>Informasi:</strong> 
                Sesi Anda akan berakhir setelah 2 jam tidak ada aktivitas. Silakan login kembali untuk melanjutkan.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
