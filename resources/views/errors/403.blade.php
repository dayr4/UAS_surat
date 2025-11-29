@extends('layout')

@section('content')
<div class="alert alert-warning mt-4">
    <h4 class="alert-heading">Akses Ditolak</h4>
    <p>Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
    <hr>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
