@extends('layout')

@section('content')
<h4 class="mb-3">Edit Jenis Agenda</h4>

<form action="{{ route('web.jenis-agenda.update', $jenis->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Jenis</label>
        <input type="text" name="nama_jenis" value="{{ $jenis->nama_jenis }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="keterangan" class="form-control">{{ $jenis->keterangan }}</textarea>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="{{ route('web.jenis-agenda.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
