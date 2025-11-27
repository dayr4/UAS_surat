@extends('layout')

@section('content')
<h4 class="mb-3">Tambah Agenda Kegiatan</h4>

<form method="POST" action="{{ route('web.agenda.store') }}">
    @csrf
    <div class="mb-3">
        <label>Nama Kegiatan</label>
        <input type="text" name="nama_kegiatan" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Jenis Agenda</label>
        <select name="jenis_agenda_id" class="form-control" required>
            <option value="">-- pilih jenis --</option>
            @foreach($jenis as $j)
                <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Waktu Mulai</label>
        <input type="datetime-local" name="waktu_mulai" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Waktu Selesai</label>
        <input type="datetime-local" name="waktu_selesai" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Tempat</label>
        <input type="text" name="tempat" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="aktif">Aktif</option>
            <option value="selesai">Selesai</option>
            <option value="batal">Batal</option>
        </select>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('web.agenda.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
