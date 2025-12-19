@extends('layouts.admin')

@section('title', 'Laporan & Rekapitulasi')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 fw-bold text-dark">Laporan Keuangan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan</li>
    </ol>

    {{-- BAGIAN 1: KARTU RINGKASAN (VERTIKAL) --}}
    <div class="row mb-4">

        {{-- Kartu 1: Pembayaran Bulan Ini --}}
        <div class="col-12 mb-3">
            <div class="card border-0 shadow-sm rounded-3 bg-white">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="me-3 d-flex align-items-center justify-content-center rounded-3 bg-success bg-opacity-10 text-success" style="width: 50px; height: 50px;">
                        <i class="bi bi-cash-coin fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-bold mb-1">Pembayaran Bulan Ini</div>
                        <h4 class="mb-0 fw-bold text-dark">
                            Rp {{ number_format($pembayaranBulanIni, 0, ',', '.') }}
                        </h4>
                    </div>
                    <div class="ms-auto text-success fw-bold small bg-success bg-opacity-10 px-3 py-1 rounded-pill">
                        <i class="bi bi-calendar-check me-1"></i> {{ date('F Y') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu 2: Tunggakan Aktif --}}
        <div class="col-12 mb-3">
            <div class="card border-0 shadow-sm rounded-3 bg-white">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="me-3 d-flex align-items-center justify-content-center rounded-3 bg-danger bg-opacity-10 text-danger" style="width: 50px; height: 50px;">
                        <i class="bi bi-exclamation-circle fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-bold mb-1">Tunggakan Aktif</div>
                        <h4 class="mb-0 fw-bold text-dark">
                            Rp {{ number_format($totalTunggakan, 0, ',', '.') }}
                        </h4>
                    </div>
                    <div class="ms-auto text-danger fw-bold small">
                        <i class="bi bi-arrow-down-right"></i> Belum Lunas
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu 3: Transaksi Hari Ini --}}
        <div class="col-12 mb-3">
            <div class="card border-0 shadow-sm rounded-3 bg-white">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="me-3 d-flex align-items-center justify-content-center rounded-3 bg-primary bg-opacity-10 text-primary" style="width: 50px; height: 50px;">
                        <i class="bi bi-receipt fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-bold mb-1">Pembayaran Hari Ini</div>
                        <h4 class="mb-0 fw-bold text-dark">
                            {{ $transaksiHariIni }} <span class="fs-6 text-muted fw-normal">Transaksi</span>
                        </h4>
                    </div>
                    <div class="ms-auto text-primary fw-bold small">
                        <i class="bi bi-check-circle me-1"></i> {{ date('d M Y') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- BAGIAN 2: TABEL PERSENTASE PER KELAS (DENGAN TOMBOL LIHAT) --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <i class="bi bi-trophy me-1 text-warning"></i> <b>Persentase Pembayaran Per Kelas</b>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kelas</th>
                            <th>Total Tagihan</th>
                            <th>Uang Masuk</th>
                            <th style="width: 35%;">Progress Pelunasan</th>
                            <th>Aksi</th> {{-- Judul Kolom Diganti --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapKelas as $row)
                            @php
                                // Hitung Persentase: (Uang Masuk / Total Nominal) * 100
                                $persen = $row->total_nominal > 0 ? ($row->uang_masuk / $row->total_nominal) * 100 : 0;
                            @endphp
                            <tr>
                                <td class="fw-bold">{{ $row->kelas }} - {{ $row->jurusan }}</td>
                                
                                <td class="text-muted">Rp {{ number_format($row->total_nominal, 0, ',', '.') }}</td>
                                <td class="text-success fw-bold">Rp {{ number_format($row->uang_masuk, 0, ',', '.') }}</td>
                                
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar {{ $persen == 100 ? 'bg-success' : ($persen < 50 ? 'bg-danger' : 'bg-warning') }}" 
                                             role="progressbar" 
                                             style="width: {{ $persen }}%">
                                            {{ round($persen) }}%
                                        </div>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        {{ $row->siswa_lunas }} Lunas dari {{ $row->total_tagihan_count }} Tagihan
                                    </small>
                                </td>

                                {{-- KOLOM AKSI (TOMBOL LIHAT) --}}
                                <td class="text-center">
                                    <a href="{{ route('admin.laporan.detail', ['kelas' => $row->kelas, 'jurusan' => $row->jurusan]) }}" 
                                       class="btn btn-sm btn-outline-primary fw-bold px-3 rounded-pill"
                                       title="Lihat Rincian Siswa">
                                        <i class="bi bi-eye me-1"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- BAGIAN 3: FILTER LAPORAN --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <i class="bi bi-funnel me-1 text-primary"></i> <b>Filter Laporan</b>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.laporan.index') }}" method="GET">
                <div class="row g-3 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">Kelas</label>
                        <select name="kelas" class="form-select">
                            <option value="Semua">Semua Kelas</option>
                            <option value="X" {{ request('kelas') == 'X' ? 'selected' : '' }}>Kelas X</option>
                            <option value="XI" {{ request('kelas') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                            <option value="XII" {{ request('kelas') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary fw-bold w-100">
                            <i class="bi bi-search"></i> Tampilkan
                        </button>
                        <a href="{{ route('admin.laporan.cetak', request()->all()) }}" target="_blank" class="btn btn-dark fw-bold w-50" title="Cetak PDF">
                            <i class="bi bi-printer"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- BAGIAN 4: TABEL RINCIAN DATA (FILTER RESULT) --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <i class="bi bi-table me-1 text-success"></i> <b>Rincian Transaksi Masuk</b>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Pembayaran</th>
                            <th>Metode</th>
                            <th class="text-end pe-4">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayarans as $pembayaran)
                            <tr>
                                <td class="ps-4">{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d/m/Y') }}</td>
                                <td class="fw-bold">{{ $pembayaran->tagihan->nama_siswa }}</td>
                                <td>{{ $pembayaran->tagihan->kelas }} - {{ $pembayaran->tagihan->jurusan }}</td>
                                <td>
                                    {{ $pembayaran->tagihan->jenis_pembayaran }} <br>
                                    <small class="text-muted">{{ $pembayaran->tagihan->bulan }} {{ $pembayaran->tagihan->tahun }}</small>
                                </td>
                                <td>
                                    @if($pembayaran->metode_pembayaran == 'tunai')
                                        <span class="badge bg-success">Tunai</span>
                                    @else
                                        <span class="badge bg-info text-dark">Transfer</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4 fw-bold">
                                    {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                    Tidak ada data transaksi yang ditemukan sesuai filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($pembayarans->count() > 0)
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="6" class="text-end text-uppercase">Total (Sesuai Filter)</td>
                            <td class="text-end pe-4 text-primary fs-5">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

</div>
@endsection