<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nis',
        'nama',
        'kelas',  // sekarang string langsung
        'jurusan',
        'angkatan',
        'email',
    ];

    /**
     * Relasi: Siswa memiliki banyak Tagihan
     */
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }

    /**
     * Scope contoh: ambil siswa kelas 10
     */
    public function scopeKelas10($query)
    {
        return $query->where('kelas', 'like', '10%'); // cari kelas yang mulai dengan 10
    }

    /**
     * Accessor contoh: tampilkan nama huruf kapital
     */
    public function getNamaAttribute($value)
    {
        return strtoupper($value);
    }
}
