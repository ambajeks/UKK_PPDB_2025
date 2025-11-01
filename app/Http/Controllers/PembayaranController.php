<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PPDB Admin</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
        }

        .navbar {
            background-color: #0d6efd !important;
        }

        .navbar .nav-link {
            color: #fff !important;
            font-weight: 500;
            transition: 0.3s;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: #dbeafe !important;
        }

        .content {
            padding: 40px;
        }

        .card-header {
            background-color: #0d6efd;
            color: white;
            font-weight: 600;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-grid-1x2-fill"></i> PPDB Admin
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.gelombang.index') }}" class="nav-link {{ request()->routeIs('admin.gelombang.*') ? 'active' : '' }}">Gelombang</a></li>
                <li class="nav-item"><a href="{{ route('admin.promo.index') }}" class="nav-link {{ request()->routeIs('admin.promo.*') ? 'active' : '' }}">Promo</a></li>
                <li class="nav-item"><a href="{{ route('admin.jurusan.index') }}" class="nav-link {{ request()->routeIs('admin.jurusan.*') ? 'active' : '' }}">Jurusan</a></li>
                <li class="nav-item"><a href="{{ route('admin.kelas.index') }}" class="nav-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">Kelas</a></li>
                <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
