<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        Siswa::updateOrCreate(
            ['nis' => '10101'],
            [
                'nama' => 'Budi Santoso',
                'kelas' => '10A',
                'email' => 'budi@example.com',
            ]
        );

        Siswa::updateOrCreate(
            ['nis' => '10102'],
            [
                'nama' => 'Ani Putri',
                'kelas' => '10B',
                'email' => 'ani@example.com',
            ]
        );
    }
}
