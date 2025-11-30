@extends('layout')

@section('content')
<h4>Update Disposisi Surat</h4>

<form method="POST" action="{{ route('web.surat-masuk.disposisi.store', $surat->id) }}">
    @csrf

    <div class="mb-3">
        <label>Status Disposisi</label>
        <select name="status_disposisi" class="form-control" required>
            <option value="">-- Pilih Status --</option>
            <option value="Menunggu"  {{ $surat->status_disposisi == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
            <option value="Diproses" {{ $surat->status_disposisi == 'Diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="Selesai"  {{ $surat->status_disposisi == 'Selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('web.surat-masuk.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
