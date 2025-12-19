<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\SessionTimeout;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SiswaController;

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

        // A. Manajemen Siswa
        Route::resource('siswa', SiswaController::class);

        // B. Manajemen Tagihan (Manual Route + Resource buat Hapus/Edit)
        // Kita gunakan resource partial atau manual seperti yang kamu buat:
        Route::get('/tagihan/create', [TagihanController::class, 'create'])->name('tagihan.create');
        Route::post('/tagihan', [TagihanController::class, 'store'])->name('tagihan.store');
        Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
        // Tambahan: Supaya tombol hapus/edit di tabel tagihan jalan, kita butuh ini:
        Route::get('/tagihan/{tagihan}/edit', [TagihanController::class, 'edit'])->name('tagihan.edit');
        Route::put('/tagihan/{tagihan}', [TagihanController::class, 'update'])->name('tagihan.update');
        Route::delete('/tagihan/{tagihan}', [TagihanController::class, 'destroy'])->name('tagihan.destroy');


        // C. Manajemen Pembayaran
        // 1. Route Khusus Cetak Struk (Perorangan) - TARUH DI ATAS RESOURCE
        Route::get('/pembayaran/{id}/cetak', [PembayaranController::class, 'cetak'])->name('pembayaran.cetak');
        
        // 2. Resource Utama Pembayaran
        Route::resource('pembayaran', PembayaranController::class);


        // D. Laporan Keuangan
        // 1. Halaman Utama Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

        // 2. Fitur Cetak Laporan Full (PDF)
        Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

        // 3. Detail Laporan Per Kelas (Drill-down)
        // PERBAIKAN DI SINI: Hapus 'admin.' karena group sudah memberikannya
        Route::get('/laporan/detail/{kelas}/{jurusan}', [LaporanController::class, 'detailKelas'])
            ->name('laporan.detail'); 
    });

});