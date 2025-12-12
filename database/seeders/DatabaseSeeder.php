<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =======================
        // User Seeder
        // =======================
        User::updateOrCreate(
            ['email' => 'admin@smk.com'],
            [
                'name' => 'Admin SMK',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'kepsek@smk.com'],
            [
                'name' => 'Kepala Sekolah',
                'password' => bcrypt('password123'),
                'role' => 'kepsek',
            ]
        );

        User::updateOrCreate(
            ['email' => 'siswa@smk.com'],
            [
                'name' => 'Budi Santoso',
                'password' => bcrypt('password123'),
                'role' => 'siswa',
                'nisn' => '12345678901234',
            ]
        );

        // =======================
        // Seeder siswa
        // =======================
        $this->call(SiswaSeeder::class);
    }
}
