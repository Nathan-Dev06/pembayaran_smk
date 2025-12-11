<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/*
|--------------------------------------------------------------------------
| DATABASE SEEDER
|--------------------------------------------------------------------------
|
| Seeder ini berfungsi untuk mengisi database dengan data dummy
| saat development atau testing.
|
| Jalankan dengan: php artisan db:seed
|
| Data yang dibuat:
| 1. Admin - Akses penuh ke sistem
| 2. Kepala Sekolah - Hanya view laporan
| 3. Siswa - View tagihan & pembayaran sendiri
|
*/

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ====================================================================
        // CREATE ADMIN USER
        // ====================================================================
        // Role: Admin (Full Access)
        // Email: admin@smk.com
        // Password: password123
        
        User::create([
            'name' => 'Admin SMK',
            'email' => 'admin@smk.com',
            'password' => bcrypt('password123'),  // Password di-hash dengan bcrypt
            'role' => 'admin',
        ]);

        // ====================================================================
        // CREATE KEPALA SEKOLAH USER
        // ====================================================================
        // Role: Kepsek (Kepala Sekolah)
        // Email: kepsek@smk.com
        // Password: password123
        
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@smk.com',
            'password' => bcrypt('password123'),
            'role' => 'kepsek',
        ]);

        // ====================================================================
        // CREATE SISWA USER
        // ====================================================================
        // Role: Siswa (Limited Access - View Own Data Only)
        // Email: siswa@smk.com
        // Password: password123
        // NISN: Nomor Induk Siswa Nasional
        
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'siswa@smk.com',
            'password' => bcrypt('password123'),
            'role' => 'siswa',
            'nisn' => '12345678901234',
        ]);
    }
}
