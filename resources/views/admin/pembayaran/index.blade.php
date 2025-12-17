@extends('layouts.admin')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 fw-bold text-dark">Riwayat Pembayaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pembayaran</li>
    </ol>

    <div class="card mb-4 border-0 shadow-sm rounded-3">
        {{-- BAGIAN HEADER: Judul + Search (TANPA TOMBOL INPUT) --}}
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                {{-- KIRI: Judul --}}
                <div class="fw-bold text-success">
                    <i class="bi bi-cash-coin me-1"></i> Data Uang Masuk
                </div>

                {{-- KANAN: Search Bar Saja --}}
                <div class="d-flex gap-2">
                    {{-- Form Pencarian --}}
                    <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-sm me-1"
                               placeholder="Cari Nama / Kelas..."
                               value="{{ request('search') }}">
                        <button class="btn btn-outline-success btn-sm" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    {{-- TOMBOL INPUT SUDAH DIHAPUS DI SINI --}}
                </div>

            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Tanggal</th>
                            <th>Siswa / Kelas</th>
                            <th>Tagihan Untuk</th>
                            <th>Nominal Masuk</th>
                            <th>Metode</th>
                            <th>Status</th>
                            {{-- KOLOM AKSI --}}
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayarans as $key => $bayar)
                            <tr>
                                <td class="ps-4">{{ $pembayarans->firstItem() + $key }}</td>

                                {{-- Tanggal Bayar --}}
                                <td>{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}</td>

                                {{-- Nama Siswa --}}
                                <td>
                                    <div class="fw-bold text-dark">{{ $bayar->tagihan->nama_siswa ?? 'Siswa Terhapus' }}</div>
                                    <small class="text-muted">{{ $bayar->tagihan->kelas ?? '-' }} - {{ $bayar->tagihan->jurusan ?? '-' }}</small>
                                </td>

                                {{-- Keterangan Tagihan --}}
                                <td>
                                    {{ $bayar->tagihan->jenis_pembayaran ?? '-' }}
                                    ({{ $bayar->tagihan->bulan ?? '' }} {{ $bayar->tagihan->tahun ?? '' }})
                                </td>

                                {{-- Nominal --}}
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}
                                </td>

                                {{-- Metode --}}
                                <td>
                                    @if($bayar->metode_pembayaran == 'tunai')
                                        <span class="badge bg-secondary">Tunai</span>
                                    @else
                                        <span class="badge bg-info text-dark">Transfer</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle-fill me-1"></i> {{ ucfirst($bayar->status_konfirmasi) }}
                                    </span>
                                </td>

                                {{-- TOMBOL CETAK --}}
                                <td class="text-center">
                                    <a href="{{ route('admin.pembayaran.cetak', $bayar->id) }}" target="_blank" class="btn btn-outline-secondary btn-sm" title="Cetak Kuitansi">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-wallet2 fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    Belum ada data pembayaran masuk
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end p-3">
                {{ $pembayarans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
