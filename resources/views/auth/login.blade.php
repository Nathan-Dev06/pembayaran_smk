<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pembayaran Digital SMK</title>
    <!-- Bootstrap CSS untuk styling responsive -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons untuk icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* ========================================
           STYLE VARIABLES - Warna utama aplikasi
           ======================================== */
        :root {
            --primary: #6366f1;      /* Warna ungu main */
            --secondary: #8b5cf6;    /* Warna ungu secondary */
        }

        /* ========================================
           BODY - Background & Layout
           ======================================== */
        body {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ========================================
           LOGIN CONTAINER - Wrapper form login
           ======================================== */
        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
        }

        /* ========================================
           CARD - White box untuk form
           ======================================== */
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .card-body {
            padding: 2.5rem;
        }

        /* ========================================
           LOGO SECTION - Header dengan logo & title
           ======================================== */
        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .logo-section h2 {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .logo-section p {
            color: #999;
            font-size: 0.9rem;
            margin: 0;
        }

        /* ========================================
           FORM - Input & label styling
           ======================================== */
        .form-label {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        /* Focus state - Highlight ketika user klik input */
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.15);
        }

        /* ========================================
           BUTTON LOGIN - Tombol submit
           ======================================== */
        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        /* Hover effect - Animasi saat mouse hover */
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
            color: white;
        }

        /* ========================================
           ALERT - Error message styling
           ======================================== */
        .alert {
            border-radius: 0.5rem;
            border: none;
            margin-bottom: 1.5rem;
        }

        /* ========================================
           DEMO INFO - Informasi akun demo
           ======================================== */
        .demo-info {
            background-color: #f0f9ff;
            border-left: 4px solid var(--primary);
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            color: #333;
            margin-top: 1.5rem;
        }        }

        .demo-info strong {
            color: var(--primary);
            display: block;
            margin-bottom: 0.5rem;
        }

        .demo-account {
            padding: 0.5rem 0;
            font-family: 'Courier New', monospace;
            color: #555;
        }

        .demo-account span {
            display: inline-block;
            background-color: #e0e0e0;
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
            font-size: 0.8rem;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .logo-icon {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- LOGIN CONTAINER - Wrapper utama -->
    <div class="login-container">
        <!-- CARD - White box container -->
        <div class="card">
            <div class="card-body">
                <!-- LOGO SECTION - Header dengan brand identity -->
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <h2>PaySMK</h2>
                    <p>Sistem Pembayaran Digital</p>
                </div>

                <!-- ERROR MESSAGE - Tampil jika login gagal -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i>
                        <strong>Login Gagal!</strong><br>
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <!-- LOGIN FORM - Form untuk input email & password -->
                <form action="{{ route('auth.login') }}" method="POST">
                    @csrf

                    <!-- EMAIL INPUT -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <!-- PASSWORD INPUT -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>

                <!-- DEMO ACCOUNT INFO - Informasi akun test untuk development -->
                <div class="demo-info">
                    <strong>📌 Akun Demo - Untuk Testing</strong>
                    <div class="demo-account">
                        <strong>Admin:</strong> <span>admin@smk.com</span><br>
                        <strong>Kepsek:</strong> <span>kepsek@smk.com</span><br>
                        <strong>Siswa:</strong> <span>siswa@smk.com</span><br>
                        <strong>Password:</strong> <span>password123</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
