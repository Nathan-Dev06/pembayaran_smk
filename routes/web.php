<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\SessionTimeout;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaTagihanController; // Controller untuk Siswa Login

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
| PROTECTED ROUTES (AUTH + SESSION TIMEOUT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', SessionTimeout::class])->group(function () {

    // 1. DASHBOARD (Bisa untuk Admin & Siswa)
    Route::get('/dashboard', function () {
        $user = Auth::user();
        // Cek Role
        if ($user->role === 'admin' || $user->role === 'kepsek') {
            return view('admin.dashboard');
        }
        return view('siswa.dashboard');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | GROUP KHUSUS ADMIN & KEPSEK
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin,kepsek'])->prefix('admin')->name('admin.')->group(function () {

        // A. Manajemen Siswa
        Route::resource('siswa', SiswaController::class);

        // B. Manajemen Tagihan
        // 1. Tagihan Manual & Resource
        Route::get('/tagihan/create', [TagihanController::class, 'create'])->name('tagihan.create');
        Route::post('/tagihan', [TagihanController::class, 'store'])->name('tagihan.store');
        Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
        
        // 2. Tagihan Massal (Fitur Tambahan Kamu)
        Route::get('/tagihan/massal/create', [TagihanController::class, 'createMassal'])->name('tagihan.massal.create');
        Route::post('/tagihan/massal/store', [TagihanController::class, 'storeMassal'])->name('tagihan.massal.store');

        // 3. Edit & Hapus Tagihan
        Route::get('/tagihan/{tagihan}/edit', [TagihanController::class, 'edit'])->name('tagihan.edit');
        Route::put('/tagihan/{tagihan}', [TagihanController::class, 'update'])->name('tagihan.update');
        Route::delete('/tagihan/{tagihan}', [TagihanController::class, 'destroy'])->name('tagihan.destroy');


        // C. Manajemen Pembayaran
        // 1. Cetak Struk (Perorangan)
        Route::get('/pembayaran/{id}/cetak', [PembayaranController::class, 'cetak'])->name('pembayaran.cetak');
        // 2. Resource Utama
        Route::resource('pembayaran', PembayaranController::class);


        // D. Laporan Keuangan (YANG KITA PERBAIKI TADI)
        // 1. Halaman Utama Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

        // 2. Cetak Laporan Full (PDF)
        Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

        // 3. Detail Laporan Per Kelas (Drill-down)
        // FIXED: Hapus 'admin.' di sini karena group sudah otomatis nambahin
        Route::get('/laporan/detail/{kelas}/{jurusan}', [LaporanController::class, 'detailKelas'])
            ->name('laporan.detail'); 
    });


    /*
    |--------------------------------------------------------------------------
    | GROUP KHUSUS SISWA (Untuk melihat tagihan sendiri)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:siswa'])->group(function () {
        Route::get('/siswa/tagihan', [SiswaTagihanController::class, 'index'])->name('siswa.tagihan.index');
        Route::get('/siswa/tagihan/{id}', [SiswaTagihanController::class, 'show'])->name('siswa.tagihan.show');
        // Jika ada fitur bayar online (opsional)
        // Route::get('/siswa/tagihan/{id}/bayar', [SiswaTagihanController::class, 'bayar'])->name('siswa.tagihan.bayar');
        // Route::post('/siswa/tagihan/{id}/bayar', [SiswaTagihanController::class, 'prosesBayar'])->name('siswa.tagihan.proses');
    });

});