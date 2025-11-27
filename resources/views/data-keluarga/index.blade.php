@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Data Orang Tua dan Wali</h1>
            <p class="text-gray-600 mt-2">Lengkapi data orang tua/wali calon siswa</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span class="text-green-700 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                    <span class="text-red-700 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                    <div>
                        <span class="text-red-700 font-medium">Terjadi kesalahan:</span>
                        <ul class="mt-1 text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Data Ayah -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Data Ayah Kandung</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ isset($ayah) && $ayah && $ayah->nama_ayah ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    <i class="fas {{ isset($ayah) && $ayah && $ayah->nama_ayah ? 'fa-check' : 'fa-times' }} mr-1"></i>
                    {{ isset($ayah) && $ayah && $ayah->nama_ayah ? 'Sudah Diisi' : 'Belum Diisi' }}
                </span>
            </div>

            <form action="{{ route('data-keluarga.store-orang-tua') }}" method="POST">
                @csrf
                <input type="hidden" name="formulir_id" value="{{ $formulir->id }}">
                <input type="hidden" name="jenis_orangtua" value="ayah">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Ayah -->
                    <div>
                        <label for="nama_ayah" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap Ayah *</label>
                        <input type="text" id="nama_ayah" name="nama_ayah" 
                               value="{{ old('nama_ayah', isset($ayah) && $ayah ? $ayah->nama_ayah : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               required>
                        @error('nama_ayah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir Ayah -->
                    <div>
                        <label for="tanggal_lahir_ayah" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir Ayah</label>
                        <input type="date" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" 
                               value="{{ old('tanggal_lahir_ayah', isset($ayah) && $ayah && $ayah->tanggal_lahir_ayah ? \Carbon\Carbon::parse($ayah->tanggal_lahir_ayah)->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <!-- Pekerjaan Ayah -->
                    <div>
                        <label for="pekerjaan_ayah" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Ayah</label>
                        <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" 
                               value="{{ old('pekerjaan_ayah', isset($ayah) && $ayah ? $ayah->pekerjaan_ayah : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <!-- Penghasilan Ayah -->
                    <div>
                        <label for="penghasilan_ayah" class="block text-sm font-medium text-gray-700 mb-2">Penghasilan Ayah (per bulan)</label>
                        <input type="number" id="penghasilan_ayah" name="penghasilan_ayah" step="0.01" min="0"
                               value="{{ old('penghasilan_ayah', isset($ayah) && $ayah ? $ayah->penghasilan_ayah : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <!-- NIK Ayah -->
                    <div>
                        <label for="nik_ayah" class="block text-sm font-medium text-gray-700 mb-2">NIK Ayah</label>
                        <input type="text" id="nik_ayah" name="nik_ayah" 
                               value="{{ old('nik_ayah', isset($ayah) && $ayah ? $ayah->nik_ayah : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        @error('nik_ayah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No HP Ayah -->
                    <div>
                        <label for="no_hp_ayah" class="block text-sm font-medium text-gray-700 mb-2">No. HP Ayah *</label>
                        <input type="text" id="no_hp_ayah" name="no_hp_ayah" 
                               value="{{ old('no_hp_ayah', isset($ayah) && $ayah ? $ayah->no_hp_ayah : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               required>
                        @error('no_hp_ayah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alamat Ayah -->
                <div class="mt-6">
                    <label for="alamat_ayah" class="block text-sm font-medium text-gray-700 mb-2">Alamat Ayah *</label>
                    <textarea id="alamat_ayah" name="alamat_ayah" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                              required>{{ old('alamat_ayah', isset($ayah) && $ayah ? $ayah->alamat_ayah : '') }}</textarea>
                    @error('alamat_ayah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                        <i class="fas fa-save mr-2"></i>Simpan Data Ayah
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Ibu -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Data Ibu Kandung</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ isset($ibu) && $ibu && $ibu->nama_ibu ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    <i class="fas {{ isset($ibu) && $ibu && $ibu->nama_ibu ? 'fa-check' : 'fa-times' }} mr-1"></i>
                    {{ isset($ibu) && $ibu && $ibu->nama_ibu ? 'Sudah Diisi' : 'Belum Diisi' }}
                </span>
            </div>

            <form action="{{ route('data-keluarga.store-orang-tua') }}" method="POST">
                @csrf
                <input type="hidden" name="formulir_id" value="{{ $formulir->id }}">
                <input type="hidden" name="jenis_orangtua" value="ibu">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Ibu -->
                    <div>
                        <label for="nama_ibu" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap Ibu *</label>
                        <input type="text" id="nama_ibu" name="nama_ibu" 
                               value="{{ old('nama_ibu', isset($ibu) && $ibu ? $ibu->nama_ibu : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               required>
                        @error('nama_ibu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir Ibu -->
                    <div>
                        <label for="tanggal_lahir_ibu" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir Ibu</label>
                        <input type="date" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" 
                               value="{{ old('tanggal_lahir_ibu', isset($ibu) && $ibu && $ibu->tanggal_lahir_ibu ? \Carbon\Carbon::parse($ibu->tanggal_lahir_ibu)->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <!-- Pekerjaan Ibu -->
                    <div>
                        <label for="pekerjaan_ibu" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Ibu</label>
                        <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" 
                               value="{{ old('pekerjaan_ibu', isset($ibu) && $ibu ? $ibu->pekerjaan_ibu : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <!-- Penghasilan Ibu -->
                    <div>
                        <label for="penghasilan_ibu" class="block text-sm font-medium text-gray-700 mb-2">Penghasilan Ibu (per bulan)</label>
                        <input type="number" id="penghasilan_ibu" name="penghasilan_ibu" step="0.01" min="0"
                               value="{{ old('penghasilan_ibu', isset($ibu) && $ibu ? $ibu->penghasilan_ibu : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <!-- NIK Ibu -->
                    <div>
                        <label for="nik_ibu" class="block text-sm font-medium text-gray-700 mb-2">NIK Ibu</label>
                        <input type="text" id="nik_ibu" name="nik_ibu" 
                               value="{{ old('nik_ibu', isset($ibu) && $ibu ? $ibu->nik_ibu : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        @error('nik_ibu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No HP Ibu -->
                    <div>
                        <label for="no_hp_ibu" class="block text-sm font-medium text-gray-700 mb-2">No. HP Ibu *</label>
                        <input type="text" id="no_hp_ibu" name="no_hp_ibu" 
                               value="{{ old('no_hp_ibu', isset($ibu) && $ibu ? $ibu->no_hp_ibu : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               required>
                        @error('no_hp_ibu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alamat Ibu -->
                <div class="mt-6">
                    <label for="alamat_ibu" class="block text-sm font-medium text-gray-700 mb-2">Alamat Ibu *</label>
                    <textarea id="alamat_ibu" name="alamat_ibu" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                              required>{{ old('alamat_ibu', isset($ibu) && $ibu ? $ibu->alamat_ibu : '') }}</textarea>
                    @error('alamat_ibu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                        <i class="fas fa-save mr-2"></i>Simpan Data Ibu
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Wali (Opsional) -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Data Wali (Jika Berbeda dengan Orang Tua)</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ isset($wali) && $wali && $wali->nama_wali ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    <i class="fas {{ isset($wali) && $wali && $wali->nama_wali ? 'fa-check' : 'fa-info' }} mr-1"></i>
                    {{ isset($wali) && $wali && $wali->nama_wali ? 'Sudah Diisi' : 'Opsional' }}
                </span>
            </div>

            <form action="{{ route('data-keluarga.store-wali') }}" method="POST">
                @csrf
                <input type="hidden" name="formulir_id" value="{{ $formulir->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Wali -->
                    <div>
                        <label for="nama_wali" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap Wali</label>
                        <input type="text" id="nama_wali" name="nama_wali" 
                               value="{{ old('nama_wali', isset($wali) && $wali ? $wali->nama_wali : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <!-- No HP Wali -->
                    <div>
                        <label for="no_hp_wali" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon Wali</label>
                        <input type="text" id="no_hp_wali" name="no_hp_wali" 
                               value="{{ old('no_hp_wali', isset($wali) && $wali ? $wali->no_hp_wali : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                </div>

                <!-- Alamat Wali -->
                <div class="mt-6">
                    <label for="alamat_wali" class="block text-sm font-medium text-gray-700 mb-2">Alamat Wali</label>
                    <textarea id="alamat_wali" name="alamat_wali" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ old('alamat_wali', isset($wali) && $wali ? $wali->alamat_wali : '') }}</textarea>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                        <i class="fas fa-save mr-2"></i>Simpan Data Wali
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection