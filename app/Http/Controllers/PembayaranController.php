<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembayaranAdmin; // Panggil Model Pembayaran
use App\Models\TagihanAdmin;    // Panggil Model Tagihan (buat dropdown & update status)

class PembayaranController extends Controller
{
    // 1. HALAMAN DAFTAR PEMBAYARAN (History) + FITUR SEARCH
    public function index(Request $request)
    {
        // 1. Mulai Query
        $query = PembayaranAdmin::with('tagihan');

        // 2. Cek Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('tagihan', function($q) use ($search) {
                $q->where('nama_siswa', 'LIKE', "%$search%")
                  ->orWhere('kelas', 'LIKE', "%$search%")
                  ->orWhere('jurusan', 'LIKE', "%$search%");
            });
        }

        // 3. Eksekusi dengan Pagination + Appends
        // 'appends' fungsinya sama: menempelkan parameter search ke link halaman berikutnya
        $pembayarans = $query->latest()
                             ->paginate(10)
                             ->appends($request->all());

        return view('admin.pembayaran.index', compact('pembayarans'));
    }
    // 2. HALAMAN FORM INPUT PEMBAYARAN
    public function create()
    {
        // Ambil tagihan yang BELUM LUNAS saja, biar admin gak salah pilih
        // Kita tampilkan supaya admin bisa pilih "Mau bayar tagihan punya siapa?"
        $tagihans = TagihanAdmin::where('status', '!=', 'lunas')->get();

        return view('admin.pembayaran.create', compact('tagihans'));
    }

    // 3. PROSES SIMPAN PEMBAYARAN (LOGIKA UTAMA)
    public function store(Request $request)
    {
        // A. Validasi Input
        $request->validate([
            'tagihan_admin_id'  => 'required', // Harus pilih tagihan mana
            'tanggal_bayar'     => 'required|date',
            'jumlah_bayar'      => 'required|numeric',
            'metode_pembayaran' => 'required',
        ]);

        // B. Simpan ke Tabel Pembayaran (Catat Uang Masuk)
        PembayaranAdmin::create([
            'tagihan_admin_id'  => $request->tagihan_admin_id,
            'tanggal_bayar'     => $request->tanggal_bayar,
            'jumlah_bayar'      => $request->jumlah_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_konfirmasi' => 'diterima', // Kalau admin yang input, otomatis diterima
            'user_id'           => auth()->id() ?? 1, // Siapa admin yang input
        ]);

        // C. UPDATE STATUS TAGIHAN JADI 'LUNAS'
        // Cari tagihan aslinya
        $tagihan = TagihanAdmin::findOrFail($request->tagihan_admin_id);

        // Ubah statusnya
        $tagihan->update([
            'status' => 'lunas'
        ]);

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil disimpan & Status tagihan menjadi Lunas!');
    }
}
