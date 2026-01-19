@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Formulir Pendaftaran PPDB</h1>
                <p class="text-gray-600">Isi data diri dengan lengkap dan benar sesuai dokumen yang sah</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="text-green-700 font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($sudahBayar)
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-lock text-blue-500 mr-3"></i>
                                <div>
                                    <span class="text-blue-700 font-medium">Form Terkunci</span>
                                    <p class="text-blue-600 text-sm">Anda sudah melakukan pembayaran. Formulir tidak dapat
                                        diubah lagi.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($revisiMenunggu)
                        <div class="mb-6 p-4 bg-yellow-50 border-2 border-yellow-300 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 flex items-start">
                                    <i class="fas fa-exclamation-circle text-yellow-600 mr-3 mt-1 text-xl"></i>
                                    <div>
                                        <h4 class="text-yellow-800 font-bold mb-2">Ada Permintaan Revisi dari Admin</h4>
                                        <p class="text-yellow-700 text-sm">Silakan lengkapi data yang diminta admin di halaman
                                            revisi.</p>
                                    </div>
                                </div>
                                <a href="{{ route('revisi.show') }}"
                                    class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 whitespace-nowrap ml-4">
                                    <i class="fas fa-arrow-right mr-1"></i>Buka Form Revisi
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                                <span class="text-red-700 font-medium">Terjadi kesalahan. Silakan periksa kembali data yang
                                    dimasukkan.</span>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('formulir.store') }}" class="space-y-8" {{ $sudahBayar ? 'style=opacity:0.6' : '' }}>
                        @csrf

                        @if(isset($formulir))
                            <input type="hidden" name="formulir_id" value="{{ $formulir->id }}">
                        @endif

                        <!-- Section 1: Data Pribadi -->
                        <div class="border border-gray-200 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">1</span>
                                </div>
                                Data Pribadi
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nama Lengkap -->
                                <div class="md:col-span-2">
                                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap"
                                        value="{{ old('nama_lengkap', $formulir->nama_lengkap ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 {{ $sudahBayar ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                        placeholder="Masukkan nama lengkap sesuai ijazah" required {{ $sudahBayar ? 'disabled' : '' }}>
                                    @error('nama_lengkap')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- NISN -->
                                <div>
                                    <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">
                                        NISN (Nomor Induk Siswa Nasional)
                                    </label>
                                    <input type="text" id="nisn" name="nisn"
                                        value="{{ old('nisn', $formulir->nisn ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        placeholder="10 digit NISN" maxlength="10">
                                    @error('nisn')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Asal Sekolah -->
                                <div>
                                    <label for="asal_sekolah" class="block text-sm font-medium text-gray-700 mb-2">
                                        Asal Sekolah <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="asal_sekolah" name="asal_sekolah"
                                        value="{{ old('asal_sekolah', $formulir->asal_sekolah ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        placeholder="Nama sekolah asal" required>
                                    @error('asal_sekolah')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tempat Lahir -->
                                <div>
                                    <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tempat Lahir <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="tempat_lahir" name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $formulir->tempat_lahir ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        placeholder="Kota/kabupaten tempat lahir" required>
                                    @error('tempat_lahir')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Lahir -->
                                <div>
                                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Lahir <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', isset($formulir->tanggal_lahir) ? \Carbon\Carbon::parse($formulir->tanggal_lahir)->format('Y-m-d') : '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        required>
                                    @error('tanggal_lahir')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Agama -->
                                <div>
                                    <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">
                                        Agama <span class="text-red-500">*</span>
                                    </label>
                                    <select id="agama" name="agama"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        required>
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" {{ old('agama', $formulir->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama', $formulir->agama ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ old('agama', $formulir->agama ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('agama', $formulir->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama', $formulir->agama ?? '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ old('agama', $formulir->agama ?? '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                    @error('agama')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jenis Kelamin -->
                                <div>
                                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jenis Kelamin <span class="text-red-500">*</span>
                                    </label>
                                    <select id="jenis_kelamin" name="jenis_kelamin"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="male" {{ old('jenis_kelamin', $formulir->jenis_kelamin ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="female" {{ old('jenis_kelamin', $formulir->jenis_kelamin ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- NIK -->
                                <div>
                                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                                        NIK (Nomor Induk Kependudukan)
                                    </label>
                                    <input type="text" id="nik" name="nik" value="{{ old('nik', $formulir->nik ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        placeholder="16 digit NIK" maxlength="16">
                                    @error('nik')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Anak Ke -->
                                <div>
                                    <label for="anak_ke" class="block text-sm font-medium text-gray-700 mb-2">
                                        Anak Ke
                                    </label>
                                    <input type="number" id="anak_ke" name="anak_ke"
                                        value="{{ old('anak_ke', $formulir->anak_ke ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        placeholder="Contoh: 1, 2, 3..." min="1">
                                    @error('anak_ke')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <!-- Section 2: Alamat Lengkap -->
                        <div class="border border-gray-200 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">2</span>
                                </div>
                                Alamat Lengkap
                            </h3>

                            <!-- Alamat Lengkap -->
                            <div class="mb-6">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Lengkap <span class="text-red-500">*</span>
                                </label>
                                <textarea id="alamat" name="alamat" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                                    placeholder="Masukkan alamat lengkap (jalan, RT/RW, nomor rumah)"
                                    required>{{ old('alamat', $formulir->alamat ?? '') }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Desa -->
                                <div>
                                    <label for="desa" class="block text-sm font-medium text-gray-700 mb-2">
                                        Desa <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="desa" name="desa"
                                        value="{{ old('desa', $formulir->desa ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                                        placeholder="Nama desa" required>
                                    @error('desa')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kelurahan -->
                                <div>
                                    <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kelurahan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="kelurahan" name="kelurahan"
                                        value="{{ old('kelurahan', $formulir->kelurahan ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                                        placeholder="Nama kelurahan" required>
                                    @error('kelurahan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kecamatan -->
                                <div>
                                    <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kecamatan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="kecamatan" name="kecamatan"
                                        value="{{ old('kecamatan', $formulir->kecamatan ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                                        placeholder="Nama kecamatan" required>
                                    @error('kecamatan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kota -->
                                <div>
                                    <label for="kota" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kota/Kabupaten <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="kota" name="kota"
                                        value="{{ old('kota', $formulir->kota ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                                        placeholder="Nama kota/kabupaten" required>
                                    @error('kota')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Kontak dan Pendaftaran -->
                        <div class="border border-gray-200 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">3</span>
                                </div>
                                Kontak dan Pendaftaran
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nomor HP -->
                                <div>
                                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor HP/Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="no_hp" name="no_hp"
                                        value="{{ old('no_hp', $formulir->no_hp ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                                        placeholder="Contoh: 081234567890" required>
                                    @error('no_hp')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jurusan -->
                                <div>
                                    <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jurusan <span class="text-red-500">*</span>
                                    </label>
                                    <select id="jurusan" name="jurusan_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        required>
                                        <option value="">Pilih Jurusan</option>
                                        @foreach ($jurusan as $j)
                                            <option value="{{ $j->id }}" {{ old('jurusan', $formulir->jurusan_id ?? '') == $j->id ? 'selected' : '' }}>{{$j->nama}}</option>
                                        @endforeach

                                    </select>
                                    @error('jurusan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gelombang Pendaftaran (Otomatis) -->

                            </div>
                            <div>
                                <label class="block w-100 mt-4 text-sm font-medium text-gray-700 mb-2">
                                    Gelombang Pendaftaran <span class="text-blue-500">(Otomatis)</span>
                                </label>
                                <div class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg text-gray-700">
                                    @if($activeWave)
                                        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2">
                                            <div>
                                                <i class="fas fa-calendar-check text-green-500 mr-2"></i>
                                                <strong>{{ $activeWave->nama_gelombang }}</strong>
                                                <span class="text-sm text-gray-500 ml-2">({{ $activeWave->tanggal_mulai }} s/d
                                                    {{ $activeWave->tanggal_selesai }})</span>
                                            </div>
                                            <div>
                                                @php
                                                    $sisaSlot = $activeWave->limit_siswa - $activeWave->formulirs_count;
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sisaSlot < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                    <i class="fas fa-users mr-1"></i> Sisa Slot: {{ $sisaSlot }}
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                        <span>Gelombang akan ditentukan otomatis oleh sistem.</span>
                                    @endif
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Sistem akan otomatis memilih gelombang yang tersedia
                                    untuk Anda.</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div
                            class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 pt-6 border-t border-gray-200">
                            <div class="text-sm text-gray-500">
                                <span class="text-red-500">*</span> Menandakan field wajib diisi
                            </div>
                            <div class="flex space-x-4">
                                <!-- <button type="reset" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-medium">
                                        <i class="fas fa-redo mr-2"></i>Reset Form
                                    </button> -->
                                <button type="submit"
                                    class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium shadow-lg">
                                    <i class="fas fa-save mr-2"></i>
                                    {{ isset($formulir) ? 'Update Formulir' : 'Simpan Formulir' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Disable all form fields jika sudah bayar
            const sudahBayar = {{ $sudahBayar ? 'true' : 'false' }};

            if (sudahBayar) {
                // Disable semua input, select, textarea
                const form = document.querySelector('form');
                if (form) {
                    const inputs = form.querySelectorAll('input, select, textarea, button[type="submit"]');
                    inputs.forEach(input => {
                        if (input.type !== 'hidden') {
                            input.disabled = true;
                            input.classList.add('bg-gray-100', 'cursor-not-allowed', 'opacity-75');
                        }
                    });
                }
            }

            // Validasi NISN (10 digit)
            const nisnInput = document.getElementById('nisn');
            if (nisnInput) {
                nisnInput.addEventListener('input', function () {
                    const value = this.value.replace(/\D/g, '');
                    this.value = value;

                    if (value.length > 0 && value.length !== 10) {
                        this.classList.add('border-yellow-500');
                    } else {
                        this.classList.remove('border-yellow-500');
                    }
                });
            }

            // Validasi NIK (16 digit)
            const nikInput = document.getElementById('nik');
            if (nikInput) {
                nikInput.addEventListener('input', function () {
                    const value = this.value.replace(/\D/g, '');
                    this.value = value;

                    if (value.length > 0 && value.length !== 16) {
                        this.classList.add('border-yellow-500');
                    } else {
                        this.classList.remove('border-yellow-500');
                    }
                });
            }

            // Validasi Nomor HP
            const noHpInput = document.getElementById('no_hp');
            if (noHpInput) {
                noHpInput.addEventListener('input', function () {
                    const value = this.value.replace(/\D/g, '');
                    this.value = value;
                });
            }
        });
    </script>
@endsection