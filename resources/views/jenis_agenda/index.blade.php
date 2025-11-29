@extends('layout')

@section('content')
<h4 class="mb-3">Jenis Agenda</h4>

<a href="{{ route('web.jenis-agenda.create') }}" class="btn btn-primary mb-3">+ Tambah Jenis Agenda</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Jenis</th>
            <th>Keterangan</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($jenis as $j)
        <tr>
            <td>{{ $j->nama_jenis }}</td>
            <td>{{ $j->keterangan }}</td>
            <td>
                <a href="{{ route('web.jenis-agenda.edit', $j->id) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('web.jenis-agenda.destroy', $j->id) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus jenis agenda ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center text-muted">Belum ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
