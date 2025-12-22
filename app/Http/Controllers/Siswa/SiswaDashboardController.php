<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $siswa = auth()->user();
        $tagihans = $siswa->tagihan()->get();

        $totalTagihan = $tagihans->sum('jumlah');
        $lunas = $tagihans->where('status','Lunas')->count();
        $belumLunas = $tagihans->where('status','!=','Lunas')->count();

        return view('siswa.dashboard', compact('siswa','tagihans','totalTagihan','lunas','belumLunas'));
    }
}
