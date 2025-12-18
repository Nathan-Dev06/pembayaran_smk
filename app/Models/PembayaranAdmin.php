<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranAdmin extends Model
{
    use HasFactory;

    // 1. Sambungkan ke tabel yang benar
    protected $table = 'pembayaran_admins';

    // 2. Izinkan kolom ini diisi oleh Admin
    protected $fillable = [
        'tagihan_admin_id', // Ini kunci relasinya
        'tanggal_bayar',
        'jumlah_bayar',
        'metode_pembayaran',
        'bukti_transfer',
        'status_konfirmasi',
        'user_id',
    ];

    // 3. DEFINISI RELASI (PENTING!)
    // Fungsi ini biar kita bisa panggil: $pembayaran->tagihan->nama_siswa
    public function tagihan()
    {
        // Pembayaran ini "Milik" satu TagihanAdmin
        return $this->belongsTo(TagihanAdmin::class, 'tagihan_admin_id');
    }
}
