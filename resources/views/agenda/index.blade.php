@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Agenda Kegiatan</h4>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('web.agenda.create') }}" class="btn btn-primary">
            + Tambah Agenda
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nama Kegiatan</th>
            <th>Jenis</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Tempat</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse($agenda as $a)
        <tr>
            <td>{{ $a->nama_kegiatan }}</td>
            <td>{{ $a->jenis->nama_jenis ?? '-' }}</td>
            <td>{{ $a->waktu_mulai }}</td>
            <td>{{ $a->waktu_selesai }}</td>
            <td>{{ $a->tempat }}</td>
            <td>{{ ucfirst($a->status) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Belum ada agenda</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
