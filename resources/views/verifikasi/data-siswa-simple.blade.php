@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Data Siswa</h1>
            
            <!-- Student Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Photo -->
                <div class="md:col-span-1">
                    <div class="bg-gray-100 rounded-lg p-4 text-center">
                        @if($fotoSiswa && file_exists(storage_path('app/' . $fotoSiswa->path_file)))
                            <img src="{{ asset('storage/' . $fotoSiswa->path_file) }}" 
                                 alt="Foto {{ $formulir->nama_lengkap }}" 
                                 class="w-full h-auto rounded object-cover">
                        @else
                            <div class="flex items-center justify-center h-64 bg-gray-200 rounded">
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Student Details -->
                <div class="md:col-span-2">
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Nomor Pendaftaran</label>
                            <p class="text-lg text-gray-800">{{ $formulir->nomor_pendaftaran }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Nama Lengkap</label>
                            <p class="text-lg text-gray-800">{{ $formulir->nama_lengkap }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Tanggal Lahir</label>
                            <p class="text-lg text-gray-800">{{ $formulir->tanggal_lahir ? \Carbon\Carbon::parse($formulir->tanggal_lahir)->format('d/m/Y') : '-' }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Email</label>
                            <p class="text-lg text-gray-800">{{ $formulir->user->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Registration Details -->
            <div class="border-t pt-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Pendaftaran</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Program</label>
                        <p class="text-gray-800">{{ $formulir->jurusan->nama ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Gelombang</label>
                        <p class="text-gray-800">{{ $formulir->gelombang->nama_gelombang ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Kelas</label>
                        <p class="text-gray-800">{{ $formulir->kelas->nama_kelas ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Status Pembayaran</label>
                        <p class="text-gray-800">
                            @if($formulir->pembayaran && $formulir->pembayaran->first())
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                    @if($formulir->pembayaran->first()->status == 'completed')
                                        bg-green-100 text-green-800
                                    @elseif($formulir->pembayaran->first()->status == 'pending')
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ ucfirst($formulir->pembayaran->first()->status) }}
                                </span>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Tanggal Pendaftaran</label>
                        <p class="text-gray-800">{{ $formulir->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Status Verifikasi</label>
                        <p class="text-gray-800">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                @if($formulir->status_verifikasi == 'verified')
                                    bg-green-100 text-green-800
                                @elseif($formulir->status_verifikasi == 'pending')
                                    bg-yellow-100 text-yellow-800
                                @else
                                    bg-red-100 text-red-800
                                @endif
                            ">
                                {{ ucfirst($formulir->status_verifikasi ?? 'pending') }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
