@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Agenda Kegiatan</h4>
    <a href="{{ route('web.agenda.create') }}" class="btn btn-primary">+ Tambah Agenda</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@forelse($agendas as $tanggal => $list)
    <h5 class="mt-4">{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jam</th>
                <th>Nama Kegiatan</th>
                <th>Jenis</th>
                <th>Tempat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($list as $a)
            <tr>
                <td>
                    {{ \Carbon\Carbon::parse($a->waktu_mulai)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($a->waktu_selesai)->format('H:i') }}
                </td>
                <td>{{ $a->nama_kegiatan }}</td>
                <td>{{ $a->jenisAgenda->nama_jenis ?? '-' }}</td>
                <td>{{ $a->tempat }}</td>
                <td>{{ $a->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@empty
    <p>Belum ada agenda.</p>
@endforelse
@endsection
