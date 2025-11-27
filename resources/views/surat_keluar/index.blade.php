@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Data Surat Keluar</h4>
    <a href="{{ route('web.surat-keluar.create') }}" class="btn btn-success">+ Tambah Surat Keluar</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>No Agenda</th>
            <th>No Surat</th>
            <th>Tujuan Surat</th>
            <th>Perihal</th>
            <th>Tanggal Surat</th>
            <th>Kategori</th>
            <th>Lampiran</th>
            <th width="140">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($surats as $s)
        <tr>
            <td>{{ $s->nomor_agenda }}</td>
            <td>{{ $s->nomor_surat }}</td>
            <td>{{ $s->tujuan_surat }}</td>
            <td>{{ $s->perihal }}</td>
            <td>{{ $s->tanggal_surat }}</td>
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
                <a href="{{ route('web.surat-keluar.edit',$s->id) }}" 
                   class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('web.surat-keluar.destroy',$s->id) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Yakin hapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center text-muted">Belum ada data</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
