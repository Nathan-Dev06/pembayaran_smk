@extends('layouts.admin')

@section('title', 'Daftar Tagihan Siswa')

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4 fw-bold text-dark">Data Tagihan Siswa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Tagihan</li>
    </ol>

    <div class="card mb-4 border-0 shadow-sm rounded-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3 text-secondary"><i class="bi bi-funnel"></i> Filter Pencarian</h6>
            <form action="" method="GET">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label small text-muted fw-bold">Kelas</label>
                        <select class="form-select bg-light border-0" name="kelas">
                            <option value="">Semua</option>
                            <option value="X">Kelas X</option>
                            <option value="XI">Kelas XI</option>
                            <option value="XII">Kelas XII</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label small text-muted fw-bold">Jurusan</label>
                        <select class="form-select bg-light border-0" name="jurusan">
                            <option value="">Semua</option>
                            <option value="TKR">TKR</option>
                            <option value="RPL">RPL</option>
                            <option value="TMI">TMI</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">Periode Bulan</label>
                        <select class="form-select bg-light border-0" name="bulan">
                            <option value="">Semua Bulan</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">Jenis Pembayaran</label>
                        <select class="form-select bg-light border-0" name="jenis_pembayaran">
                            <option value="">Semua Jenis</option>
                            <option value="SPP" {{ request('jenis_pembayaran') == 'SPP' ? 'selected' : '' }}>SPP</option>
                            <option value="Uang Gedung" {{ request('jenis_pembayaran') == 'Uang Gedung' ? 'selected' : '' }}>Uang Gedung</option>
                            <option value="Uang Ujian" {{ request('jenis_pembayaran') == 'Uang Ujian' ? 'selected' : '' }}>Uang Ujian</option>
                        </select>
                    </div>

                    
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">Status Tagihan</label>
                        <select class="form-select bg-light border-0" name="status">
                            <option value="">Semua Status</option>
                            <option value="belum_lunas">Belum Lunas</option>
                            <option value="menunggak">Menunggak</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100 text-white fw-bold">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4 border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div class="fw-bold text-primary">
                <i class="bi bi-table me-1"></i> Daftar Tagihan
            </div>
            <div class="d-flex gap-2">
    <a href="{{ route('admin.tagihan.create') }}" class="btn btn-primary btn-sm px-3">
        <i class="bi bi-person-plus"></i> Tagihan Tunggal
    </a>

    <a href="{{ route('admin.tagihan.massal.create') }}" class="btn btn-success btn-sm px-3">
        <i class="bi bi-people-fill"></i> Tagihan Per Kelas / Angkatan
    </a>
</div>

        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Periode</th>
                            <th>Jenis Pembayaran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- MULAI LOOPING DATA DARI DATABASE --}}
                        @forelse($tagihans as $key => $tagihan)
                            <tr>
                                {{-- 1. Nomor Urut --}}
                                <td class="ps-4">{{ $tagihans->firstItem() + $key }}</td>
                                
                                {{-- 2. Nama Siswa --}}
                                <td>
                                    <div class="fw-bold text-dark">{{ $tagihan->nama_siswa }}</div>
                                    <small class="text-muted">ID: #{{ $tagihan->id }}</small>
                                </td>
                                
                                {{-- 3. Kelas & Jurusan --}}
                                <td>{{ $tagihan->kelas }} - {{ $tagihan->jurusan }}</td>
                                
                                {{-- 4. Periode --}}
                                <td>{{ $tagihan->bulan }} {{ $tagihan->tahun }}</td>
                                
                                {{-- 5. Jenis & Nominal --}}
                                <td>
                                    <div class="fw-bold">{{ $tagihan->jenis_pembayaran }}</div>
                                    <small class="text-success fw-bold">Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</small>
                                </td>
                                
                                {{-- 6. Status (Logika Otomatis: Cek Tanggal Jatuh Tempo) --}}
                                <td>
                                    @php
                                        // Ubah nama bulan jadi angka
                                        $bulanIndo = ['Januari'=>1, 'Februari'=>2, 'Maret'=>3, 'April'=>4, 'Mei'=>5, 'Juni'=>6, 'Juli'=>7, 'Agustus'=>8, 'September'=>9, 'Oktober'=>10, 'November'=>11, 'Desember'=>12];
                                        $angkaBulan = $bulanIndo[$tagihan->bulan] ?? date('m');
                                        
                                        // Tetapkan Jatuh Tempo tanggal 10
                                        $jatuhTempo = \Carbon\Carbon::createFromDate($tagihan->tahun, $angkaBulan, 10)->endOfDay();
                                        $hariIni = \Carbon\Carbon::now();
                                    @endphp

                                    @if($tagihan->status == 'lunas')
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i> Lunas
                                        </span>
                                    @elseif($hariIni->gt($jatuhTempo) && $tagihan->status != 'lunas')
                                        {{-- Kalau lewat tgl 10 & belum lunas = Menunggak --}}
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i> Menunggak
                                        </span>
                                    @else
                                        {{-- Kalau belum lewat tgl 10 = Belum Lunas --}}
                                        <span class="badge bg-warning text-dark bg-opacity-25 px-3 py-2 rounded-pill">
                                            <i class="bi bi-exclamation-circle me-1"></i> Belum Lunas
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            {{-- TAMPILAN JIKA DATA KOSONG --}}
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    Belum ada daftar tagihan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end p-3">
                {{ $tagihans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection