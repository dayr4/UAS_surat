@extends('layout')

@section('content')
<h4 class="mb-3">Tambah Kategori Surat</h4>

<form method="POST" action="{{ route('web.kategori.store') }}">
    @csrf

    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control"></textarea>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('web.kategori.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
