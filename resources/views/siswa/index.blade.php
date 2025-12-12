@extends('layouts.app')

@section('content')
<div class="container-siswa">
    <h1 class="title-page">Daftar Tagihan Siswa</h1>

    <div class="card-siswa">
        <p class="label">Nama: {{ auth()->user()->name }}</p>
        <p class="sub-label">NIS: {{ auth()->user()->nis ?? '-' }}</p>
    </div>

    <div class="table-card">
        <table class="table-tagihan">
            <thead>
                <tr>
                    <th>Nama Tagihan</th>
                    <th>Jatuh Tempo</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($tagihan as $t)
                <tr>
                    <td>{{ $t->nama_tagihan }}</td>
                    <td>{{ $t->jatuh_tempo }}</td>
                    <td>Rp {{ number_format($t->nominal) }}</td>
                    <td>
                        <span class="status {{ $t->status }}">
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                    <td>
                        @if ($t->status == 'belum')
                        <a href="{{ route('siswa.tagihan.bayar', $t->id) }}" class="btn-bayar">Bayar</a>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-row">Tidak ada tagihan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
