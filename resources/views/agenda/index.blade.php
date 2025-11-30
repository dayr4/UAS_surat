@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Agenda Kegiatan</h4>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('web.agenda.create') }}" class="btn btn-primary">
            + Tambah Agenda
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- ================= FORM PENCARIAN ================= --}}
<form method="GET" class="mb-3 row g-2">

    <div class="col-md-3">
        <input type="text" name="q" class="form-control"
               placeholder="Cari nama kegiatan / tempat..."
               value="{{ request('q') }}">
    </div>

    <div class="col-md-3">
        <select name="jenis" class="form-control">
            <option value="">Semua Jenis Agenda</option>
            @foreach($jenisList as $j)
                <option value="{{ $j->id }}" 
                    {{ request('jenis') == $j->id ? 'selected' : '' }}>
                    {{ $j->nama_jenis }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <select name="status" class="form-control">
            <option value="">Semua Status</option>
            <option value="Menunggu"  {{ request('status')=='Menunggu' ? 'selected':'' }}>Menunggu</option>
            <option value="Berjalan"  {{ request('status')=='Berjalan' ? 'selected':'' }}>Berjalan</option>
            <option value="Selesai"   {{ request('status')=='Selesai' ? 'selected':'' }}>Selesai</option>
            <option value="Dibatalkan"{{ request('status')=='Dibatalkan' ? 'selected':'' }}>Dibatalkan</option>
        </select>
    </div>

    <div class="col-md-2">
        <input type="date" name="mulai" class="form-control" value="{{ request('mulai') }}">
    </div>

    <div class="col-md-2">
        <input type="date" name="selesai" class="form-control" value="{{ request('selesai') }}">
    </div>

    <div class="col-md-2 mt-2">
        <button class="btn btn-dark w-100">Filter</button>
    </div>
</form>

{{-- ================= TAMBAH TABEL ================= --}}
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nama Kegiatan</th>
            <th>Jenis</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Tempat</th>
            <th>Status</th>
            @if(auth()->user()->role === 'admin')
                <th>Aksi</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @forelse($agenda as $a)
        <tr>
            <td>{{ $a->nama_kegiatan }}</td>
            <td>{{ $a->jenis->nama_jenis ?? '-' }}</td>
            <td>{{ $a->waktu_mulai }}</td>
            <td>{{ $a->waktu_selesai }}</td>
            <td>{{ $a->tempat }}</td>
            <td>{{ ucfirst($a->status) }}</td>

            @if(auth()->user()->role === 'admin')
            <td>
                <a href="{{ route('web.agenda.edit', $a->id) }}"
                   class="btn btn-warning btn-sm">
                   Edit
                </a>
            </td>
            @endif
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">Belum ada agenda</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
