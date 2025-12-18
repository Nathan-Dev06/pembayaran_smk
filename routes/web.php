<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\SessionTimeout;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PembayaranController; // Pastikan controller dipanggil

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
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

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| DASHBOARD & ADMIN ROUTES (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', SessionTimeout::class])->group(function () {

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
