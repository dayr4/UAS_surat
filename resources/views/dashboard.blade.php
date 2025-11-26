@extends('layout')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Dashboard UAS Surat</h4>
        <p>Aplikasi pengelolaan surat masuk, surat keluar, dan agenda kegiatan.</p>
        <a href="{{ route('web.surat-masuk.index') }}" class="btn btn-primary">Kelola Surat Masuk</a>
        <a href="{{ route('web.surat-keluar.index') }}" class="btn btn-success">Kelola Surat Keluar</a>
    </div>
</div>
@endsection
