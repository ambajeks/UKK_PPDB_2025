@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center mb-4">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Menu Revisi</h1>
            <p class="text-gray-600">Kelola revisi data pendaftaran Anda</p>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- Revisi Menunggu -->
        @if($revisiMenunggu)
        <div class="bg-yellow-50 border-2 border-yellow-300 rounded-lg p-6 mb-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold text-yellow-800 mb-2">Revisi Diperlukan</h3>
                    <p class="text-yellow-700 mb-3">Admin meminta Anda untuk merevisi beberapa data:</p>

                    <!-- Field yang perlu direvisi -->
                    @if(!empty($revisiMenunggu->field_revisi))
                    <div class="mb-3">
                        <span class="text-sm font-medium text-yellow-800">Data yang perlu diperbaiki:</span>
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach($revisiMenunggu->field_revisi as $field)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-200 text-yellow-800">
                                @switch($field)
                                @case('nama_lengkap') Nama Lengkap @break
                                @case('nisn') NISN @break
                                @case('jenis_kelamin') Jenis Kelamin @break
                                @case('tempat_lahir') Tempat Lahir @break
                                @case('tanggal_lahir') Tanggal Lahir @break
                                @case('asal_sekolah') Asal Sekolah @break
                                @case('agama') Agama @break
                                @case('nik') NIK @break
                                @case('anak_ke') Anak Ke- @break
                                @case('alamat') Alamat @break
                                @case('desa') Desa @break
                                @case('kelurahan') Kelurahan @break
                                @case('kecamatan') Kecamatan @break
                                @case('kota') Kota @break
                                @case('no_hp') No. HP @break
                                @default {{ $field }}
                                @endswitch
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Dokumen yang perlu diupload ulang -->
                    @if(!empty($revisiMenunggu->dokumen_revisi))
                    <div class="mb-3">
                        <span class="text-sm font-medium text-yellow-800">Dokumen yang perlu diupload ulang:</span>
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach($revisiMenunggu->dokumen_revisi as $dokumen)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-200 text-orange-800">
                                <i class="fas fa-file mr-1"></i>
                                @switch($dokumen)
                                @case('kartu_keluarga') Kartu Keluarga @break
                                @case('akta_kelahiran') Akta Kelahiran @break
                                @case('foto_3x4') Foto 3x4 @break
                                @case('surat_keterangan_lulus') Surat Keterangan Lulus @break
                                @case('ijazah_sd') Ijazah SD @break
                                @case('ktp_orang_tua') KTP Orang Tua @break
                                @default {{ $dokumen }}
                                @endswitch
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Catatan Admin -->
                    <div class="bg-white p-3 rounded border border-yellow-200 mb-4">
                        <span class="text-sm font-medium text-gray-600">Catatan dari Admin:</span>
                        <p class="text-gray-800 mt-1">{{ $revisiMenunggu->catatan_revisi }}</p>
                    </div>

                    <a href="{{ route('revisi.show') }}"
                        class="inline-flex items-center px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-200 font-medium shadow-lg">
                        <i class="fas fa-edit mr-2"></i>Kerjakan Revisi Sekarang
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
                <div>
                    <h3 class="text-lg font-medium text-green-800">Tidak Ada Revisi</h3>
                    <p class="text-green-600">Saat ini tidak ada permintaan revisi yang perlu dikerjakan.</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Riwayat Revisi -->
        @if($riwayatRevisi->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-history mr-2 text-gray-500"></i>Riwayat Revisi
                </h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($riwayatRevisi as $riwayat)
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>Selesai
                                </span>
                                <span class="ml-3 text-sm text-gray-500">
                                    Diselesaikan: {{ $riwayat->selesai_at?->format('d M Y, H:i') ?? '-' }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm">{{ $riwayat->catatan_revisi }}</p>

                            @if(!empty($riwayat->field_revisi) || !empty($riwayat->dokumen_revisi))
                            <div class="mt-2 flex flex-wrap gap-1">
                                @foreach($riwayat->field_revisi ?? [] as $field)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-600">
                                    {{ ucfirst(str_replace('_', ' ', $field)) }}
                                </span>
                                @endforeach
                                @foreach($riwayat->dokumen_revisi ?? [] as $dokumen)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-blue-100 text-blue-600">
                                    <i class="fas fa-file text-xs mr-1"></i>{{ ucfirst(str_replace('_', ' ', $dokumen)) }}
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection