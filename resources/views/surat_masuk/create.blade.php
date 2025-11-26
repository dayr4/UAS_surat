@extends('layout')

@section('content')
<h4 class="mb-3">Tambah Surat Masuk</h4>

<form method="POST" action="{{ route('web.surat-masuk.store') }}">
    @csrf
    <div class="mb-3">
        <label>No Agenda</label>
        <input type="text" name="nomor_agenda" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>No Surat Asal</label>
        <input type="text" name="nomor_surat_asal" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Tanggal Surat</label>
        <input type="date" name="tanggal_surat" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Tanggal Diterima</label>
        <input type="date" name="tanggal_diterima" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Asal Surat</label>
        <input type="text" name="asal_surat" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Perihal</label>
        <input type="text" name="perihal" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Kategori</label>
        <select name="kategori_id" class="form-control" required>
            <option value="">-- pilih kategori --</option>
            @foreach($kategoris as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Isi Ringkas</label>
        <textarea name="isi_ringkas" class="form-control"></textarea>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('web.surat-masuk.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
