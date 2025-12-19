@extends('layouts.admin')

@section('title', 'Detail Kelas')

@section('content')
<div class="container-fluid px-4">
    
    {{-- Header & Tombol Kembali --}}
    <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-0">Laporan Kelas {{ $kelas }} - {{ $jurusan }}</h1>
            <small class="text-muted">Daftar tagihan siswa perorangan</small>
        </div>
        <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Kartu Ringkasan Kecil --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50">Progress Pelunasan</div>
                        <div class="h4 fw-bold mb-0">
                            {{ $siswaLunas }} / {{ $jumlahSiswa }} Siswa
                        </div>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50">Total Uang Masuk</div>
                        <div class="h4 fw-bold mb-0">
                            Rp {{ number_format($totalLunas, 0, ',', '.') }} 
                            <span class="fs-6 fw-normal text-white-50">/ Rp {{ number_format($totalTagihan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <i class="bi bi-wallet2 fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Daftar Siswa --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <i class="bi bi-list-ul me-1"></i> Daftar Status Pembayaran Siswa
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Tagihan</th>
                            <th>Nominal</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataSiswa as $siswa)
                            <tr>
                                <td class="ps-4">{{ $loop->iteration }}</td>
                                <td class="fw-bold">{{ $siswa->nama_siswa }}</td>
                                <td>
                                    {{ $siswa->jenis_pembayaran }} 
                                    <span class="text-muted small">({{ $siswa->bulan }} {{ $siswa->tahun }})</span>
                                </td>
                                <td>Rp {{ number_format($siswa->nominal, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($siswa->status == 'lunas')
                                        <span class="badge bg-success rounded-pill px-3">
                                            <i class="bi bi-check-circle-fill me-1"></i> Lunas
                                        </span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3">
                                            <i class="bi bi-x-circle-fill me-1"></i> Belum Bayar
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection