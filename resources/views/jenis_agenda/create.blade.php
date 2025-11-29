@extends('layout')

@section('content')
<h4 class="mb-3">Tambah Jenis Agenda</h4>

<form action="{{ route('web.jenis-agenda.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Nama Jenis</label>
        <input type="text" name="nama_jenis" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="keterangan" class="form-control"></textarea>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('web.jenis-agenda.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
