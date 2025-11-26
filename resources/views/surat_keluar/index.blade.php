@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Data Surat Keluar</h4>
    <a href="{{ route('web.surat-keluar.create') }}" class="btn btn-success">+ Tambah Surat Keluar</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No Agenda</th>
            <th>No Surat</th>
            <th>Tujuan</th>
            <th>Perihal</th>
            <th>Tanggal Surat</th>
            <th>Kategori</th>
        </tr>
    </thead>
    <tbody>
    @foreach($surats as $s)
        <tr>
            <td>{{ $s->nomor_agenda }}</td>
            <td>{{ $s->nomor_surat }}</td>
            <td>{{ $s->tujuan_surat }}</td>
            <td>{{ $s->perihal }}</td>
            <td>{{ $s->tanggal_surat }}</td>
            <td>{{ $s->kategori->nama_kategori ?? '-' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
