@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Kategori Surat</h4>

    @if(auth()->user()->role === 'admin')
        {{-- ✅ FIX --}}
        <a href="{{ route('web.kategori.create') }}" class="btn btn-primary">
            + Tambah Kategori
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nama Kategori</th>
            <th>Keterangan</th>
            @if(auth()->user()->role === 'admin')
                <th width="150">Aksi</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @forelse($kategoris as $k)
        <tr>
            <td>{{ $k->nama_kategori }}</td>
            <td>{{ $k->keterangan ?? '-' }}</td>

            @if(auth()->user()->role === 'admin')
            <td>
                {{-- ✅ FIX --}}
                <a href="{{ route('web.kategori.edit', $k->id) }}"
                   class="btn btn-sm btn-warning">
                    Edit
                </a>

                <form action="{{ route('web.kategori.destroy', $k->id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Hapus kategori ini?')">
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
                Belum ada kategori
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
