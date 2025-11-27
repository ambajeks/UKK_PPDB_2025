@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-600 mt-2">Portal Pendaftaran Peserta Didik Baru</p>
        </div>

        <!-- Status Pendaftaran -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Status Pendaftaran</h2>
                    <p class="text-gray-500 text-sm">Status formulir pendaftaran</p>
                </div>
            </div>

            @php
                $form = auth()->user()->formulir()->first();
                $status = $form ? 'terisi' : 'belum';
                
                // Hitung dokumen yang sudah diupload
                $dokumenCount = 0;
                if ($form) {
                    try {
                        $dokumenCount = \App\Models\DokumenPendaftaran::where('formulir_id', $form->id)->count();
                    } catch (\Exception $e) {
                        $dokumenCount = 0;
                    }
                }
            @endphp

            <div class="mb-6">
                @if ($status === 'belum')
                    <div class="inline-flex items-center px-4 py-3 bg-red-100 border border-red-200 text-red-700 rounded-xl font-semibold">
                        <i class="fas fa-clock mr-2"></i>
                        Belum Mengisi Formulir
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('formulir.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                            <i class="fas fa-file-alt mr-2"></i>
                            Isi Formulir Pendaftaran
                        </a>
                    </div>
                @else
                    <div class="inline-flex items-center px-4 py-3 bg-green-100 border border-green-200 text-green-700 rounded-xl font-semibold">
                        <i class="fas fa-check-circle mr-2"></i>
                        Sudah Mengisi Formulir
                    </div>
                    <div class="mt-4 space-y-4">
                        <div>
                            <a href="{{ route('formulir.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Formulir Pendaftaran
                            </a>
                        </div>
                        
                        <!-- Info Ringkasan Data -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-800 mb-2">Ringkasan Data:</h4>
                            <p class="text-sm text-gray-600"><strong>Nama:</strong> {{ $form->nama_lengkap }}</p>
                            <p class="text-sm text-gray-600"><strong>Asal Sekolah:</strong> {{ $form->asal_sekolah }}</p>
                            <p class="text-sm text-gray-600"><strong>No. Pendaftaran:</strong> {{ $form->nomor_pendaftaran ?? 'Belum ada' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Progress Pendaftaran -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Progress Pendaftaran</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Step 1: Formulir -->
                <div class="text-center p-4 border-2 {{ $form ? 'border-green-500 bg-green-50' : 'border-gray-300 bg-gray-50' }} rounded-xl">
                    <div class="w-12 h-12 {{ $form ? 'bg-green-500' : 'bg-gray-400' }} rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Formulir</h3>
                    <p class="text-sm text-gray-600">{{ $form ? 'Selesai' : 'Belum' }}</p>
                </div>

                <!-- Step 2: Dokumen -->
                <div class="text-center p-4 border-2 {{ $dokumenCount > 0 ? 'border-green-500 bg-green-50' : 'border-gray-300 bg-gray-50' }} rounded-xl">
                    <div class="w-12 h-12 {{ $dokumenCount > 0 ? 'bg-green-500' : 'bg-gray-400' }} rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-file-upload text-white"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Dokumen</h3>
                    <p class="text-sm text-gray-600">
                        {{ $dokumenCount }}/6
                    </p>
                </div>

                <!-- Step 3: Pembayaran -->
                <div class="text-center p-4 border-2 border-gray-300 bg-gray-50 rounded-xl">
                    <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-credit-card text-white"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Pembayaran</h3>
                    <p class="text-sm text-gray-600">Belum</p>
                </div>

                <!-- Step 4: Verifikasi -->
                <div class="text-center p-4 border-2 border-gray-300 bg-gray-50 rounded-xl">
                    <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-check-double text-white"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Verifikasi</h3>
                    <p class="text-sm text-gray-600">Menunggu</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Aksi Cepat</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('formulir.index') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition duration-200 text-center">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Formulir</h3>
                    <p class="text-sm text-gray-600">Isi/Edit data</p>
                </a>

                <a href="{{ route('dokumen.index') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-200 transition duration-200 text-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-upload text-white"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Upload Dokumen</h3>
                    <p class="text-sm text-gray-600">Upload berkas</p>
                </a>

                <a href="#" class="p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-200 transition duration-200 text-center">
                    <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-credit-card text-white"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Pembayaran</h3>
                    <p class="text-sm text-gray-600">Status bayar</p>
                </a>

                <a href="#" class="p-4 border border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-200 transition duration-200 text-center">
                    <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-question-circle text-white"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Bantuan</h3>
                    <p class="text-sm text-gray-600">Hubungi admin</p>
                </a>
            </div>
        </div>

        <!-- Pengumuman (Opsional) -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mt-6">
            <div class="flex items-start">
                <i class="fas fa-bullhorn text-yellow-500 text-xl mr-3 mt-1"></i>
                <div>
                    <h3 class="font-semibold text-yellow-800 mb-2">Pengumuman</h3>
                    <p class="text-yellow-700 text-sm">
                        Pendaftaran PPDB Tahun Ajaran 2024/2025 sedang berlangsung. 
                        Pastikan Anda melengkapi semua data dan dokumen sebelum tanggal penutupan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection