@extends('layout')

@section('content')

<h3 class="mb-4">Dashboard Aplikasi Surat</h3>

{{-- CARD STATISTIK --}}
<div class="row mb-4">

    <div class="col-md-4">
        <div class="card shadow-sm p-4">
            <h6 class="text-muted">Surat Masuk</h6>
            <h2 class="text-primary">{{ $countMasuk }}</h2>
            <p class="text-muted">Total surat masuk</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-4">
            <h6 class="text-muted">Surat Keluar</h6>
            <h2 class="text-success">{{ $countKeluar }}</h2>
            <p class="text-muted">Total surat keluar</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-4">
            <h6 class="text-muted">Agenda Kegiatan</h6>
            <h2 class="text-warning">{{ $countAgenda }}</h2>
            <p class="text-muted">Total agenda kegiatan</p>
        </div>
    </div>

</div>

{{-- GRAFIK --}}
<div class="card shadow-sm p-4">
    <h5 class="mb-3">Statistik Surat Bulanan</h5>
    <canvas id="chartSurat" height="120"></canvas>
</div>

@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chartSurat').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [
            {
                label: 'Surat Masuk',
                data: {!! json_encode($chartMasuk) !!},
                borderColor: 'blue',
                tension: 0.3,
            },
            {
                label: 'Surat Keluar',
                data: {!! json_encode($chartKeluar) !!},
                borderColor: 'green',
                tension: 0.3,
            }
        ]
    }
});
</script>
@endsection
