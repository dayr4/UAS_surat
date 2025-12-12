@extends('layout')

@section('content')
<h4>📌 Surat Disposisi Saya</h4>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="GET" class="mb-3">
    <select name="status" class="form-control w-25 d-inline">
        <option value="">Semua</option>
        <option value="belum" {{ request('status')=='belum'?'selected':'' }}>
            Belum selesai
        </option>
    </select>
    <button class="btn btn-dark">Filter</button>
</form>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>No Agenda</th>
            <th>Perihal</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Didisposisikan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($surats as $s)
        <tr>
            <td>{{ $s->nomor_agenda }}</td>
            <td>{{ $s->perihal }}</td>
            <td>{{ $s->kategori->nama_kategori ?? '-' }}</td>
            <td>
                <span class="badge 
                    {{ $s->pivot->status == 'Selesai' ? 'bg-success' : 'bg-warning' }}">
                    {{ $s->pivot->status }}
                </span>
            </td>
            <td>{{ optional($s->pivot->created_at)->format('d-m-Y H:i') ?? '-' }}</td>
            <td>
                @if($s->pivot->status !== 'Selesai')
                    <form method="POST"
                          action="{{ route('web.disposisi.selesai', $s->id) }}">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-sm btn-success">
                            Tandai Selesai
                        </button>
                    </form>
                @else
                    <span class="text-muted">✔</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center text-muted">
                Tidak ada disposisi
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
