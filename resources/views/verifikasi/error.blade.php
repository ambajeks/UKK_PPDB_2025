@extends('layouts.app')

@section('title', 'Error - QR Verification')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <h1 class="text-2xl font-bold text-gray-800 mb-2">Verifikasi Gagal</h1>

                @if ($message = session('error'))
                    <p class="text-red-600 mb-6">{{ $message }}</p>
                @else
                    <p class="text-gray-600 mb-6">Terjadi kesalahan saat memverifikasi data siswa.</p>
                @endif

                <a href="/" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
@endsection