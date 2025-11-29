@extends('layout')

@section('content')
<h4 class="mb-3">Edit Kategori Surat</h4>

<form method="POST" action="{{ route('web.kategori.update', $kategori->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control"
               value="{{ $kategori->nama_kategori }}" required>
    </div>

    <div class="mb-3">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control">{{ $kategori->keterangan }}</textarea>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="{{ route('web.kategori.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
