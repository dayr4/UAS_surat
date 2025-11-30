@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Data Surat Masuk</h4>

    {{-- TOMBOL TAMBAH HANYA UNTUK ADMIN --}}
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('web.surat-masuk.create') }}" class="btn btn-primary">
            + Tambah Surat Masuk
        </a>
    @endif
</div>

{{-- ALERT SUCCESS --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- FORM PENCARIAN --}}
<form method="GET" class="mb-3 d-flex gap-2">

    <input type="text" name="q" class="form-control"
        placeholder="Cari perihal / asal surat / nomor agenda..."
        value="{{ request('q') }}">

    <select name="kategori" class="form-control">
        <option value="">Semua Kategori</option>
        @foreach($kategoris as $k)
            <option value="{{ $k->id }}" 
                {{ request('kategori') == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-dark">Filter</button>
</form>

<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>No Agenda</th>
            <th>Asal Surat</th>
            <th>Perihal</th>
            <th>Tanggal Diterima</th>
            <th>Kategori</th>
            <th>Lampiran</th>
            <th width="220">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($surats as $s)
    <tr>
        <td>{{ $s->nomor_agenda }}</td>
        <td>{{ $s->asal_surat }}</td>
        <td>{{ $s->perihal }}</td>
        <td>{{ $s->tanggal_diterima }}</td>
        <td>{{ $s->kategori->nama_kategori ?? '-' }}</td>

        <td>
            @if($s->lampiran_file)
                <a href="{{ asset('storage/'.$s->lampiran_file) }}" 
                   class="btn btn-sm btn-info" target="_blank">
                   Lihat
                </a>
            @else
                <span class="text-muted">-</span>
            @endif
        </td>

        <td>

            {{-- TOMBOL LIHAT --}}
            <a href="{{ route('web.surat-masuk.show', $s->id) }}" 
               class="btn btn-sm btn-primary">
               Lihat
            </a>

            {{-- TOMBOL DISPOSISI (ADMIN SAJA) --}}
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('web.surat-masuk.disposisi.form', $s->id) }}" 
                   class="btn btn-sm btn-info">
                    Disposisi
                </a>
            @endif

            {{-- AKSI EDIT / HAPUS UNTUK ADMIN --}}
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('web.surat-masuk.edit',$s->id) }}" 
                   class="btn btn-sm btn-warning">
                   Edit
                </a>

                <form action="{{ route('web.surat-masuk.destroy',$s->id) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Yakin hapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">
                        Hapus
                    </button>
                </form>
            @endif

        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="text-center text-muted">Belum ada data</td>
    </tr>
    @endforelse
    </tbody>
</table>
@endsection
