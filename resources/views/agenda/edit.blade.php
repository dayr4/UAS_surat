@extends('layout')

@section('content')
<h4 class="mb-3">Edit Agenda Kegiatan</h4>

<form method="POST" action="{{ route('web.agenda.update', $agenda->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Kegiatan</label>
        <input type="text" name="nama_kegiatan" class="form-control" value="{{ $agenda->nama_kegiatan }}" required>
    </div>

    <div class="mb-3">
        <label>Jenis Agenda</label>
        <select name="jenis_agenda_id" class="form-control">
            @foreach($jenis as $j)
                <option value="{{ $j->id }}" {{ $agenda->jenis_agenda_id == $j->id ? 'selected' : '' }}>
                    {{ $j->nama_jenis }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Waktu Mulai</label>
        <input type="datetime-local" name="waktu_mulai" class="form-control"
               value="{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('Y-m-d\TH:i') }}">
    </div>

    <div class="mb-3">
        <label>Waktu Selesai</label>
        <input type="datetime-local" name="waktu_selesai" class="form-control"
               value="{{ \Carbon\Carbon::parse($agenda->waktu_selesai)->format('Y-m-d\TH:i') }}">
    </div>

    <div class="mb-3">
        <label>Tempat</label>
        <input type="text" name="tempat" class="form-control" value="{{ $agenda->tempat }}">
    </div>

    <div class="mb-3">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control">{{ $agenda->keterangan }}</textarea>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="Aktif" {{ $agenda->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Selesai" {{ $agenda->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="Batal" {{ $agenda->status == 'Batal' ? 'selected' : '' }}>Batal</option>
        </select>
    </div>

    <button class="btn btn-success">Perbarui</button>
    <a href="{{ route('web.agenda.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
