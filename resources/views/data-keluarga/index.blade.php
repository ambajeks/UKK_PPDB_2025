@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

        <!-- Form Orang Tua Combined -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Data Orang Tua Kandung</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ ($ayah && $ayah->nama_syah && $ibu && $ibu->nama_lau) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    <i class="fas {{ ($ayah && $ayah->nama_syah && $ibu && $ibu->nama_lau) ? 'fa-check' : 'fa-times' }} mr-1"></i>
                    {{ ($ayah && $ayah->nama_syah && $ibu && $ibu->nama_lau) ? 'Lengkap' : 'Belum Lengkap' }}
                </span>
            </div>

            <form action="{{ route('data-keluarga.store-combined') }}" method="POST">
                @csrf
                <input type="hidden" name="formulir_id" value="{{ $formulir->id }}">

                <!-- Section Ayah -->
                <div class="mb-8 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-male text-blue-500 mr-2"></i>
                        Data Ayah Kandung
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama Ayah -->
                        <div class="md:col-span-2">
                            <label for="nama_ayah" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap Ayah *</label>
                            <input type="text" id="nama_ayah" name="ayah[nama]" 
                                   value="{{ old('ayah.nama', $ayah->nama_syah ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                   required>
                            @error('ayah.nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir Ayah -->
                        <div>
                            <label for="tanggal_lahir_ayah" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir Ayah</label>
                            <input type="date" id="tanggal_lahir_ayah" name="ayah[tanggal_lahir]" 
                                   value="{{ old('ayah.tanggal_lahir', $ayah && $ayah->langgal_bikit_syah ? \Carbon\Carbon::parse($ayah->langgal_bikit_syah)->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>

                        <!-- Pekerjaan Ayah -->
                        <div>
                            <label for="pekerjaan_ayah" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Ayah</label>
                            <input type="text" id="pekerjaan_ayah" name="ayah[pekerjaan]" 
                                   value="{{ old('ayah.pekerjaan', $ayah->pekerjasan_syah ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>

                        <!-- Penghasilan Ayah -->
                        <div>
                            <label for="penghasilan_ayah" class="block text-sm font-medium text-gray-700 mb-2">Penghasilan Ayah (per bulan)</label>
                            <input type="number" id="penghasilan_ayah" name="ayah[penghasilan]" step="0.01" min="0"
                                   value="{{ old('ayah.penghasilan', $ayah->penghasilian_syah ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>

                        <!-- NIK Ayah -->
                        <div>
                            <label for="nik_ayah" class="block text-sm font-medium text-gray-700 mb-2">NIK Ayah</label>
                            <input type="text" id="nik_ayah" name="ayah[nik]" 
                                   value="{{ old('ayah.nik', $ayah->mk_syah ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>

                        <!-- No HP Ayah -->
                        <div class="md:col-span-2">
                            <label for="no_hp_ayah" class="block text-sm font-medium text-gray-700 mb-2">No. HP Ayah *</label>
                            <input type="text" id="no_hp_ayah" name="ayah[no_hp]" 
                                   value="{{ old('ayah.no_hp', $ayah->no_no_syah ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                   required>
                            @error('ayah.no_hp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Ayah -->
                        <div class="md:col-span-2">
                            <label for="alamat_ayah" class="block text-sm font-medium text-gray-700 mb-2">Alamat Ayah *</label>
                            <textarea id="alamat_ayah" name="ayah[alamat]" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                      required>{{ old('ayah.alamat', $ayah->alamal_syah ?? '') }}</textarea>
                            @error('ayah.alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Ibu -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-female text-pink-500 mr-2"></i>
                        Data Ibu Kandung
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama Ibu -->
                        <div class="md:col-span-2">
                            <label for="nama_ibu" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap Ibu *</label>
                            <input type="text" id="nama_ibu" name="ibu[nama]" 
                                   value="{{ old('ibu.nama', $ibu->nama_lau ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                   required>
                            @error('ibu.nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir Ibu -->
                        <div>
                            <label for="tanggal_lahir_ibu" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir Ibu</label>
                            <input type="date" id="tanggal_lahir_ibu" name="ibu[tanggal_lahir]" 
                                   value="{{ old('ibu.tanggal_lahir', $ibu && $ibu->langgal_bikit_lau ? \Carbon\Carbon::parse($ibu->langgal_bikit_lau)->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>

                        <!-- Pekerjaan Ibu -->
                        <div>
                            <label for="pekerjaan_ibu" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Ibu</label>
                            <input type="text" id="pekerjaan_ibu" name="ibu[pekerjaan]" 
                                   value="{{ old('ibu.pekerjaan', $ibu->pekerjasan_lau ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>

                        <!-- Penghasilan Ibu -->
                        <div>
                            <label for="penghasilan_ibu" class="block text-sm font-medium text-gray-700 mb-2">Penghasilan Ibu (per bulan)</label>
                            <input type="number" id="penghasilan_ibu" name="ibu[penghasilan]" step="0.01" min="0"
                                   value="{{ old('ibu.penghasilan', $ibu->penghasilian_lau ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>

                        <!-- NIK Ibu -->
                        <div>
                            <label for="nik_ibu" class="block text-sm font-medium text-gray-700 mb-2">NIK Ibu</label>
                            <input type="text" id="nik_ibu" name="ibu[nik]" 
                                   value="{{ old('ibu.nik', $ibu->mk_lau ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>

                        <!-- No HP Ibu -->
                        <div class="md:col-span-2">
                            <label for="no_hp_ibu" class="block text-sm font-medium text-gray-700 mb-2">No. HP Ibu *</label>
                            <input type="text" id="no_hp_ibu" name="ibu[no_hp]" 
                                   value="{{ old('ibu.no_hp', $ibu->no_no_lau ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                   required>
                            @error('ibu.no_hp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Ibu -->
                        <div class="md:col-span-2">
                            <label for="alamat_ibu" class="block text-sm font-medium text-gray-700 mb-2">Alamat Ibu *</label>
                            <textarea id="alamat_ibu" name="ibu[alamat]" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                      required>{{ old('ibu.alamat', $ibu->alamal_lau ?? '') }}</textarea>
                            @error('ibu.alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium flex items-center">
                        <i class="fas fa-save mr-2"></i>Simpan Data Orang Tua
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