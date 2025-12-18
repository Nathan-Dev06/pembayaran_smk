<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\SessionTimeout;
<<<<<<< Updated upstream
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PembayaranController; // Pastikan controller dipanggil
=======
use App\Http\Controllers\SiswaTagihanController;
>>>>>>> Stashed changes

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

/*
|--------------------------------------------------------------------------
| LOGIN & LOGOUT ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
})->name('auth.login');

<<<<<<< Updated upstream
=======
/*
|--------------------------------------------------------------------------
| LOGOUT ROUTE
|--------------------------------------------------------------------------
*/
>>>>>>> Stashed changes
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
<<<<<<< Updated upstream
| DASHBOARD & ADMIN ROUTES (PROTECTED)
=======
| PROTECTED ROUTES (AUTH + SESSION TIMEOUT)
>>>>>>> Stashed changes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', SessionTimeout::class])->group(function () {

<<<<<<< Updated upstream
    // 1. DASHBOARD UTAMA
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin' || $user->role === 'kepsek') {
            return view('admin.dashboard');
        }
        return view('siswa.dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | KHUSUS ADMIN
    |--------------------------------------------------------------------------
    | Semua route di bawah ini otomatis punya awalan URL: /admin/...
    | dan punya awalan Nama Route: admin....
    */
    Route::middleware(['role:admin,kepsek'])->prefix('admin')->name('admin.')->group(function () {

        // A. Manajemen Siswa (Otomatis index, create, store, dll)
        Route::resource('siswa', \App\Http\Controllers\SiswaController::class);

        // B. Manajemen Tagihan (Manual Route)
        Route::get('/tagihan/create', [TagihanController::class, 'create'])->name('tagihan.create');
        Route::post('/tagihan', [TagihanController::class, 'store'])->name('tagihan.store');
        Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');

        // C. Manajemen Pembayaran (Resource Route)
        // INI YANG BENAR: Langsung taruh di sini, jangan bikin group admin lagi
        Route::resource('pembayaran', PembayaranController::class);
=======
    // DASHBOARD
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'kepsek'])) {
            return view('admin.dashboard');
        }

        return view('siswa.dashboard');
    })->name('dashboard');

    // =====================================================
    // 📌 ADMIN – Halaman Index Data Siswa
    // =====================================================
    Route::get('/siswa', function () {
        return view('admin.siswa.index');
    })->name('siswa.index');

    // =====================================================
    // 📌 SISWA – Tagihan
    // Middleware role:siswa supaya hanya siswa bisa akses
    // =====================================================
    Route::middleware(['role:siswa'])->group(function () {

        Route::get('/siswa/tagihan', 
            [SiswaTagihanController::class, 'index']
        )->name('siswa.tagihan.index');

        Route::get('/siswa/tagihan/{id}', 
            [SiswaTagihanController::class, 'show']
        )->name('siswa.tagihan.show');

        Route::get('/siswa/tagihan/{id}/bayar', 
            [SiswaTagihanController::class, 'bayar']
        )->name('siswa.tagihan.bayar');

        Route::post('/siswa/tagihan/{id}/bayar', 
            [SiswaTagihanController::class, 'prosesBayar']
        )->name('siswa.tagihan.proses');
>>>>>>> Stashed changes

    });

<<<<<<< HEAD
    Route::prefix('admin/tagihan')->name('admin.tagihan.')->group(function () {
    Route::get('/', [TagihanController::class, 'index'])->name('index');
    Route::get('/create', [TagihanController::class, 'create'])->name('create');
    Route::post('/store', [TagihanController::class, 'store'])->name('store');

    // 🔥 ROUTE BARU (MASSAL)
    Route::get('/massal/create', [TagihanController::class, 'createMassal'])
        ->name('massal.create');
    Route::post('/massal/store', [TagihanController::class, 'storeMassal'])
        ->name('massal.store');
});

=======
>>>>>>> 911112f5258688af278d7877a14c53e9462ee795
});
