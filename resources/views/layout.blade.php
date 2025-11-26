<!DOCTYPE html>
<html>
<head>
    <title>UAS Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard') }}">UAS Surat</a>
    <div>
      <a href="{{ route('web.surat-masuk.index') }}" class="btn btn-sm btn-light me-2">Surat Masuk</a>
      <a href="{{ route('web.surat-keluar.index') }}" class="btn btn-sm btn-light">Surat Keluar</a>
    </div>
  </div>
</nav>
<div class="container mb-5">
    @yield('content')
</div>
</body>
</html>
