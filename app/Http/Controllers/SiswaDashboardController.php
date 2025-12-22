<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;

class SiswaDashboardController extends Controller
{
    public function index()
{
    $siswa = auth()->user()->siswa;

    $tagihans = \App\Models\Tagihan::where('siswa_id', $siswa->id)->get();

    $totalTagihan = $tagihans->sum('nominal');
    $totalLunas   = $tagihans->where('status', 'lunas')->sum('nominal');
    $sisaTagihan  = $totalTagihan - $totalLunas;

    return view('siswa.dashboard', compact(
        'siswa',
        'tagihans',
        'totalTagihan',
        'totalLunas',
        'sisaTagihan'
    ));
}
}
