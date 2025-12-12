@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Jenis Agenda</h4>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('web.jenis-agenda.create') }}"
           class="btn btn-primary">
            + Tambah Jenis Agenda
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nama Jenis</th>
            <th>Keterangan</th>
            @if(auth()->user()->role === 'admin')
                <th width="150">Aksi</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @forelse($jenis as $j)
        <tr>
            <td>{{ $j->nama_jenis }}</td>
            <td>{{ $j->keterangan ?? '-' }}</td>

            @if(auth()->user()->role === 'admin')
            <td>
                <a href="{{ route('web.jenis-agenda.edit', $j->id) }}"
                   class="btn btn-sm btn-warning">
                    Edit
                </a>

                <form action="{{ route('web.jenis-agenda.destroy', $j->id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Hapus jenis agenda ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">
                        Hapus
                    </button>
                </form>
            </td>
            @endif
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center text-muted">
                Belum ada jenis agenda
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
