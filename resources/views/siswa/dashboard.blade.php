@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<h2>Selamat datang, {{ $siswa->nama }}!</h2>
<p>Tanggal: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>

<!-- Ringkasan Tagihan -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-warning text-white p-3">
            <h5>Total Tagihan</h5>
            <h3>Rp {{ number_format($totalTagihan,0,',','.') }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white p-3">
            <h5>Lunas</h5>
            <h3>{{ $lunas }} Tagihan</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white p-3">
            <h5>Belum Lunas</h5>
            <h3>{{ $belumLunas }} Tagihan</h3>
        </div>
    </div>
</div>

<!-- Daftar Tagihan -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Tagihan</th>
            <th>Jumlah</th>
            <th>Tanggal Jatuh Tempo</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tagihans as $tagihan)
        <tr>
            <td>{{ $tagihan->nama_tagihan }}</td>
            <td>Rp {{ number_format($tagihan->jumlah,0,',','.') }}</td>
            <td>{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d-m-Y') }}</td>
            <td>
                @if($tagihan->status == 'Lunas')
                    <span class="badge bg-success">Lunas</span>
                @else
                    <span class="badge bg-danger">Belum Lunas</span>
                @endif
            </td>
            <td>
                @if($tagihan->status != 'Lunas')
                    <a href="#" class="btn btn-primary btn-sm">Bayar</a>
                @else
                    -
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
