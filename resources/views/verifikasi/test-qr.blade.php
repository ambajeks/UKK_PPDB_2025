@extends('layouts.admin')

@section('title', 'Test QR Code')

@section('content')
    <div class="py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-8">Test QR Code</h1>

                <div class="space-y-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Siswa</label>
                        <p class="text-lg text-gray-800">{{ $formulir->nama_lengkap }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Nomor Pendaftaran</label>
                        <p class="text-lg text-gray-800">{{ $formulir->nomor_pendaftaran }}</p>
                    </div>

                    <div class="border-t pt-6">
                        <label class="text-sm font-semibold text-gray-600 block mb-4">QR Code</label>
                        <div class="bg-gray-100 p-4 rounded-lg text-center">
                            <p class="text-sm text-gray-600 mb-4">QR Data: {{ $qrData }}</p>
                            <!-- You can generate QR code using a library like endroid/qr-code -->
                            <p class="text-sm text-gray-500">QR Code akan di-generate oleh frontend atau gunakan library QR
                                Code generator</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-2">QR Verification URL</label>
                        <input type="text" value="{{ $qrUrl }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('qr.siswa', ['id' => $formulir->id, 'code' => request()->route('code')]) }}"
                            class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            Lihat Data Siswa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection