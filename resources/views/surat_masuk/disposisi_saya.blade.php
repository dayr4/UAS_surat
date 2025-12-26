@extends('layout')

@section('content')
<h4>Disposisi Saya</h4>

@if ($surats->isEmpty())
    <div class="alert alert-info">
        Belum ada surat disposisi.
    </div>
@else
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Perihal</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surats as $i => $surat)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $surat->nomor_surat_asal }}</td>
                    <td>{{ $surat->perihal }}</td>
                    <td>{{ $surat->kategori->nama ?? '-' }}</td>
                    <td>
                        <span class="badge bg-warning text-dark">
                            {{ $surat->pivot->status }}
                        </span>
                    </td>
                    <td>
                        @if ($surat->pivot->status !== 'Selesai')
                            <form
                                action="{{ route('web.disposisi.selesai', $surat->id) }}"
                                method="POST"
                                class="d-inline"
                            >
                                @csrf
                                @method('PUT')

                                <button class="btn btn-success btn-sm">
                                    Tandai Selesai
                                </button>
                            </form>
                        @else
                            <span class="text-success fw-bold">
                                ✔ Selesai
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
