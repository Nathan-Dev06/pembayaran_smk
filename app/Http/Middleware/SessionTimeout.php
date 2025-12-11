<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| SESSION TIMEOUT MIDDLEWARE
|--------------------------------------------------------------------------
| 
| Middleware ini berfungsi untuk mengecek apakah session user sudah expired.
| User akan otomatis logout jika tidak ada aktivitas selama 2 jam (120 menit).
|
| Cara Kerja:
| 1. Ambil timestamp terakhir user aktif dari session
| 2. Bandingkan dengan waktu sekarang
| 3. Jika melebihi timeout, logout user secara otomatis
| 4. Update timestamp 'last_activity' setiap kali user membuat request
|
*/

class SessionTimeout
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login/authenticated
        if (Auth::check()) {
            // Ambil timestamp terakhir user aktif, default ke waktu sekarang
            $lastActivity = session('last_activity', now()->timestamp);
            
            // Ambil session lifetime dari config (dalam menit), convert ke detik
            $timeout = config('session.lifetime') * 60; // 120 menit * 60 = 7200 detik

            // Hitung selisih waktu antara sekarang dan last activity
            // Jika lebih besar dari timeout, berarti sudah expired
            if ((time() - $lastActivity) > $timeout) {
                // Logout user
                Auth::logout();
                
                // Invalidate session untuk keamanan
                $request->session()->invalidate();
                
                // Regenerate CSRF token
                $request->session()->regenerateToken();
                
                // Redirect ke login dengan pesan
                return redirect('/login')->with('message', 'Sesi Anda telah berakhir. Silakan login kembali.');
            }
        }

        // Update 'last_activity' dengan timestamp saat ini
        // Ini akan dijalankan setiap kali user membuat request
        session(['last_activity' => time()]);

        // Lanjutkan request ke controller
        return $next($request);
    }
}
