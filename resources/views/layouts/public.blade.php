<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>@yield('title', 'Verifikasi Data') - {{ config('app.name', 'PPDB') }}</title> -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .public-header {
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
        }

        .public-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #4f46e5;
        }

        .public-header p {
            font-size: 0.875rem;
            color: #6b7280;
        }
    </style>
</head>

<body class="antialiased">
    <!-- Simple Header -->
    <div class="public-header">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div>
                <h1><i class="fas fa-graduation-cap mr-2"></i>PPDB Online</h1>
                <!-- <p>Sistem Verifikasi Pendaftaran Peserta Didik Baru</p> -->
            </div>
            <!-- <a href="{{ route('landing') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                <i class="fas fa-home mr-1"></i> Beranda
            </a> -->
        </div>
    </div>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <div class="text-center py-6 text-white text-sm opacity-75">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'PPDB') }} - Sistem Pendaftaran Online</p>
    </div>
</body>

</html>
