<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\SessionTimeout;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
| Route ini dapat diakses tanpa login. 
| Fungsi: Redirect ke login atau dashboard jika sudah login
*/
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| LOGIN ROUTES
|--------------------------------------------------------------------------
| Route untuk menampilkan halaman login dan memproses login user
| GET  /login  - Menampilkan form login
| POST /login  - Memproses input email & password
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    // Validasi input dari form login
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Coba melakukan authentication dengan email & password
    if (Auth::attempt($credentials)) {
        // Jika berhasil, regenerate session untuk keamanan
        $request->session()->regenerate();
        return redirect('/dashboard');
    }

    // Jika gagal, kembali ke form login dengan error message
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
})->name('auth.login');

/*
|--------------------------------------------------------------------------
| LOGOUT ROUTE
|--------------------------------------------------------------------------
| Route untuk logout user
| POST /logout - Menghapus session user dan redirect ke home
| Middleware 'auth' memastikan hanya user yang login dapat logout
*/
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    // Logout user dari aplikasi
    Auth::logout();
    
    // Invalidate session untuk security
    $request->session()->invalidate();
    
    // Regenerate CSRF token
    $request->session()->regenerateToken();
    
    // Redirect ke home page
    return redirect('/');
})->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| DASHBOARD ROUTES (PROTECTED)
|--------------------------------------------------------------------------
| Route ini hanya bisa diakses oleh user yang sudah login
| Middleware 'auth' = User harus login
| Middleware 'SessionTimeout' = Check session timeout (2 jam idle)
| 
| Logika:
| - Role 'admin' atau 'kepsek' -> Dashboard Admin
| - Role 'siswa' -> Dashboard Siswa
*/
Route::middleware(['auth', SessionTimeout::class])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        // Redirect berdasarkan role user
        if ($user->role === 'admin' || $user->role === 'kepsek') {
            return view('admin.dashboard');
        }
        
        return view('siswa.dashboard');
    })->name('dashboard');
});
