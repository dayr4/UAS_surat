<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Surat — Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 240px;
            background: #1a73e8;
            padding-top: 20px;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            font-size: 15px;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.18);
        }

        .content {
            margin-left: 260px;
            padding: 25px;
        }

        .navbar-custom {
            margin-left: 240px;
            background: white;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <h4 class="text-center mb-4">📄 UAS Surat</h4>

        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>

        {{-- Menu untuk semua user --}}
        <a href="{{ route('web.surat-masuk.index') }}">📥 Surat Masuk</a>
        <a href="{{ route('web.surat-keluar.index') }}">📤 Surat Keluar</a>
        <a href="{{ route('web.agenda.index') }}">📅 Agenda Kegiatan</a>

        {{-- Menu khusus admin --}}
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('web.kategori.index') }}">📂 Kategori Surat</a>
            <a href="{{ route('web.jenis-agenda.index') }}">🗂 Jenis Agenda</a>  {{-- <<== DITAMBAHKAN --}}
        @endif

        <hr style="border-color: rgba(255,255,255,0.4)">

        <a href="{{ route('profile.edit') }}">👤 Profil</a>

        <form action="{{ route('logout') }}" method="POST" class="mt-3 px-3">
            @csrf
            <button class="btn btn-light w-100">Logout</button>
        </form>
    </div>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-custom px-4 d-flex justify-content-between">
        <span class="navbar-brand fw-bold">Dashboard</span>

        {{-- BADGE ROLE USER --}}
        <div class="d-flex align-items-center">
            <span 
                class="badge 
                {{ auth()->user()->role === 'admin' ? 'bg-danger' : 'bg-secondary' }}
                text-uppercase me-3">
                {{ auth()->user()->role }}
            </span>

            <span class="fw-semibold">
                {{ auth()->user()->name }}
            </span>
        </div>
    </nav>

    {{-- CONTENT --}}
    <div class="content">
        @yield('content')
    </div>

</body>
</html>
