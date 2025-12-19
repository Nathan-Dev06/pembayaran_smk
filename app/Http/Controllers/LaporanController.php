<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembayaranAdmin;
use App\Models\TagihanAdmin;
use Illuminate\Support\Facades\DB; // Tambahkan ini buat jaga-jaga fungsi raw query

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // === 1. LOGIKA UNTUK KARTU ATAS (STATISTIK DASHBOARD) ===
        // Data Realtime (Berdasarkan waktu sekarang)

        $pembayaranBulanIni = PembayaranAdmin::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('jumlah_bayar');

        $totalTunggakan = TagihanAdmin::where('status', '!=', 'lunas')->sum('nominal');

        $transaksiHariIni = PembayaranAdmin::whereDate('tanggal_bayar', now())->count();


        // === 2. LOGIKA UNTUK REKAP KELAS (PROGRESS BAR) - [BARU DITAMBAHKAN] ===
        // Kita kelompokkan data tagihan berdasarkan Kelas & Jurusan
        // Lalu kita hitung berapa % yang sudah lunas
        $rekapKelas = TagihanAdmin::selectRaw('
                kelas,
                jurusan,
                count(*) as total_tagihan_count,
                sum(nominal) as total_nominal,
                sum(case when status = "lunas" then nominal else 0 end) as uang_masuk,
                sum(case when status = "lunas" then 1 else 0 end) as siswa_lunas
            ')
            ->groupBy('kelas', 'jurusan')
            ->orderBy('kelas', 'asc') // Urutkan dari kelas X, XI, XII
            ->get();


        // === 3. LOGIKA UNTUK TABEL RIWAYAT BAWAH (FILTERABLE) ===
        $query = PembayaranAdmin::with('tagihan');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('kelas') && $request->kelas != 'Semua') {
            $query->whereHas('tagihan', function($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        $pembayarans = $query->latest()->get();
        $totalPemasukan = $pembayarans->sum('jumlah_bayar');

        return view('admin.laporan.index', compact(
            'pembayarans',
            'totalPemasukan',
            'pembayaranBulanIni',
            'totalTunggakan',
            'transaksiHariIni',
            'rekapKelas' // <--- Jangan lupa variabel ini dikirim ke View
        ));
    }

    // Fungsi Cetak (Biarkan seperti sebelumnya atau sesuaikan jika perlu)
    public function cetak(Request $request)
    {
        // ... (Kode cetak kamu yang lama) ...
        // Kalau mau tabel kelasnya ikut dicetak, copy logika $rekapKelas ke sini juga.

        // Sementara kita pakai return redirect dulu biar gak error kalau belum diset
        return redirect()->back();
    }

    // HALAMAN DETAIL: LIHAT SIAPA SAJA DI KELAS ITU
    public function detailKelas($kelas, $jurusan)
    {
        // 1. Ambil semua tagihan milik Kelas & Jurusan yang dipilih
        $dataSiswa = TagihanAdmin::where('kelas', $kelas)
                    ->where('jurusan', $jurusan)
                    ->orderBy('nama_siswa', 'asc') // Urutkan nama A-Z
                    ->get();

        // 2. Hitung statistik kecil buat header halaman detail
        $totalTagihan = $dataSiswa->sum('nominal');
        $totalLunas   = $dataSiswa->where('status', 'lunas')->sum('nominal');
        $jumlahSiswa  = $dataSiswa->count();
        $siswaLunas   = $dataSiswa->where('status', 'lunas')->count();

        return view('admin.laporan.detail_kelas', compact(
            'dataSiswa', 
            'kelas', 
            'jurusan',
            'totalTagihan',
            'totalLunas',
            'jumlahSiswa',
            'siswaLunas'
        ));
    }
}
