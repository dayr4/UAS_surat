@extends('layout')

@section('content')
<h4 class="mb-4">Detail Surat Masuk</h4>

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table table-bordered">
            <tr>
                <th width="200">No Agenda</th>
                <td>{{ $surat->nomor_agenda }}</td>
            </tr>
            <tr>
                <th>No Surat Asal</th>
                <td>{{ $surat->nomor_surat_asal }}</td>
            </tr>
            <tr>
                <th>Asal Surat</th>
                <td>{{ $surat->asal_surat }}</td>
            </tr>
            <tr>
                <th>Tanggal Surat</th>
                <td>{{ $surat->tanggal_surat }}</td>
            </tr>
            <tr>
                <th>Tanggal Diterima</th>
                <td>{{ $surat->tanggal_diterima }}</td>
            </tr>
            <tr>
                <th>Perihal</th>
                <td>{{ $surat->perihal }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $surat->kategori->nama_kategori ?? '-' }}</td>
            </tr>
            <tr>
                <th>Isi Ringkas</th>
                <td>{{ $surat->isi_ringkas ?? '-' }}</td>
            </tr>
            <tr>
                <th>Lampiran</th>
                <td>
                    @if($surat->lampiran_file)
                        <a href="{{ asset('storage/'.$surat->lampiran_file) }}" 
                           class="btn btn-sm btn-info" target="_blank">
                            Lihat Lampiran
                        </a>
                    @else
                        <span class="text-muted">Tidak ada lampiran</span>
                    @endif
                </td>
            </tr>
        </table>

        <a href="{{ route('web.surat-masuk.index') }}" class="btn btn-secondary mt-3">
            Kembali
        </a>

    </div>
</div>
@endsection
