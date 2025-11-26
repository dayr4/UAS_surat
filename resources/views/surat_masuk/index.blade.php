@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Data Surat Masuk</h4>
    <a href="{{ route('web.surat-masuk.create') }}" class="btn btn-primary">+ Tambah Surat Masuk</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No Agenda</th>
            <th>Asal Surat</th>
            <th>Perihal</th>
            <th>Tanggal Diterima</th>
            <th>Kategori</th>
        </tr>
    </thead>
    <tbody>
    @foreach($surats as $s)
        <tr>
            <td>{{ $s->nomor_agenda }}</td>
            <td>{{ $s->asal_surat }}</td>
            <td>{{ $s->perihal }}</td>
            <td>{{ $s->tanggal_diterima }}</td>
            <td>{{ $s->kategori->nama_kategori ?? '-' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
