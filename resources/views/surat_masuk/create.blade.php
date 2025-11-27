@extends('layout')

@section('content')
<h4 class="mb-3">Tambah Surat Masuk</h4>

<form method="POST" action="{{ route('web.surat-masuk.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>No Agenda</label>
        <input type="text" name="nomor_agenda" class="form-control" value="{{ old('nomor_agenda') }}" required>
    </div>
    <div class="mb-3">
        <label>No Surat Asal</label>
        <input type="text" name="nomor_surat_asal" class="form-control" value="{{ old('nomor_surat_asal') }}" required>
    </div>
    <div class="mb-3">
        <label>Tanggal Surat</label>
        <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat') }}" required>
    </div>
    <div class="mb-3">
        <label>Tanggal Diterima</label>
        <input type="date" name="tanggal_diterima" class="form-control" value="{{ old('tanggal_diterima') }}" required>
    </div>
    <div class="mb-3">
        <label>Asal Surat</label>
        <input type="text" name="asal_surat" class="form-control" value="{{ old('asal_surat') }}" required>
    </div>
    <div class="mb-3">
        <label>Perihal</label>
        <input type="text" name="perihal" class="form-control" value="{{ old('perihal') }}" required>
    </div>
    <div class="mb-3">
        <label>Kategori</label>
        <select name="kategori_id" class="form-control" required>
            <option value="">-- pilih kategori --</option>
            @foreach($kategoris as $k)
                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Isi Ringkas</label>
        <textarea name="isi_ringkas" class="form-control">{{ old('isi_ringkas') }}</textarea>
    </div>
    <div class="mb-3">
        <label>Lampiran File (PDF/JPG/PNG)</label>
        <input type="file" name="lampiran_file" class="form-control">
        <small class="text-muted">Opsional, bisa diisi untuk upload scan surat.</small>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('web.surat-masuk.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
