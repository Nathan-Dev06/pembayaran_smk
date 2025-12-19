<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class SiswaTagihanController extends Controller
{
    // Daftar tagihan siswa
    public function index()
    {
        // Ambil user login
        $siswaId = auth()->user()->id;

        // Ambil tagihan untuk siswa tersebut
        $tagihan = Tagihan::where('siswa_id', $siswaId)->get();

        return view('siswa.tagihan.index', compact('tagihan'));
    }

    // Detail tagihan
    public function show($id)
    {
        $tagihan = Tagihan::findOrFail($id);

        // Pastikan tagihan hanya milik siswa terkait
        if ($tagihan->siswa_id != auth()->user()->id) {
            abort(403, "Anda tidak boleh membuka tagihan ini");
        }

        return view('siswa.tagihan.show', compact('tagihan'));
    }

    // Form bayar tagihan
    public function bayar($id)
    {
        $tagihan = Tagihan::findOrFail($id);

        if ($tagihan->siswa_id != auth()->user()->id) {
            abort(403);
        }

        return view('siswa.tagihan.bayar', compact('tagihan'));
    }

    // Proses pembayaran
    public function prosesBayar(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);

        if ($tagihan->siswa_id != auth()->user()->id) {
            abort(403);
        }

        $request->validate([
            'metode' => 'required',
            'bukti' => 'required|image|max:2048', // upload bukti pembayaran
        ]);

        // Simpan bukti
        $namaFile = $request->bukti->store('bukti_pembayaran', 'public');

        Pembayaran::create([
            'tagihan_id' => $id,
            'siswa_id' => auth()->user()->id,
            'metode' => $request->metode,
            'bukti' => $namaFile,
            'status' => 'menunggu verifikasi'
        ]);

        // Update status tagihan
        $tagihan->update(['status' => 'menunggu']);

        return redirect()->route('siswa.tagihan.index')
                         ->with('success', 'Pembayaran berhasil dikirim, menunggu verifikasi admin.');
    }
}
