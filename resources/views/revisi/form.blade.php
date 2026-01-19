@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('revisi.index') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center mb-4">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Menu Revisi
            </a>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Form Revisi Pendaftaran</h1>
            <p class="text-gray-600">Perbaiki data yang diminta oleh admin</p>
        </div>

        <!-- Alert Revisi -->
        <div class="mb-6 p-4 bg-yellow-50 border-2 border-yellow-300 rounded-lg">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-yellow-600 mr-3 mt-1 text-xl"></i>
                <div class="flex-1">
                    <h4 class="text-yellow-800 font-bold mb-2">Permintaan Revisi dari Admin</h4>
                    <p class="text-yellow-700 mb-3"><strong>Catatan Admin:</strong></p>
                    <p class="text-yellow-700 mb-3 bg-white p-3 rounded border border-yellow-200">{{ $revisi->catatan_revisi }}</p>

                    @if(!empty($revisi->field_revisi))
                    <p class="text-yellow-700 mb-2"><strong>Data yang perlu direvisi:</strong></p>
                    <div class="bg-white p-3 rounded border border-yellow-200 mb-3">
                        <ul class="list-disc list-inside text-yellow-700">
                            @foreach($revisi->field_revisi as $field)
                            <li>
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
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(!empty($revisi->dokumen_revisi))
                    <p class="text-yellow-700 mb-2"><strong>Dokumen yang perlu diupload ulang:</strong></p>
                    <div class="bg-white p-3 rounded border border-yellow-200 mb-3">
                        <ul class="list-disc list-inside text-yellow-700">
                            @foreach($revisi->dokumen_revisi as $dokumen)
                            <li>
                                @switch($dokumen)
                                @case('kartu_keluarga') Kartu Keluarga @break
                                @case('akta_kelahiran') Akta Kelahiran @break
                                @case('foto_3x4') Foto 3x4 @break
                                @case('surat_keterangan_lulus') Surat Keterangan Lulus @break
                                @case('ijazah_sd') Ijazah SD @break
                                @case('ktp_orang_tua') KTP Orang Tua @break
                                @default {{ $dokumen }}
                                @endswitch
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <p class="text-yellow-700 text-sm"><i class="fas fa-info-circle mr-1"></i>Silakan lengkapi field yang ditandai di atas, kemudian klik tombol "Simpan Revisi" di bawah.</p>
                </div>
            </div>
        </div>

        <!-- Form Revisi -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 bg-white border-b border-gray-200">
                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                        <span class="text-red-700 font-medium">Terjadi kesalahan. Silakan periksa kembali data yang dimasukkan.</span>
                    </div>
                    <ul class="list-disc list-inside text-red-600 text-sm">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('revisi.store') }}" class="space-y-8" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="formulir_id" value="{{ $formulir->id }}">
                    <input type="hidden" name="revisi_id" value="{{ $revisi->id }}">

                    @php
                    $fieldRevisi = $revisi->field_revisi ?? [];
                    $dokumenRevisi = $revisi->dokumen_revisi ?? [];
                    @endphp

                    <!-- Section: Data yang Perlu Direvisi -->
                    @if(!empty($fieldRevisi))
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-sm">!</span>
                            </div>
                            Data yang Perlu Direvisi
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            @if(in_array('nama_lengkap', $fieldRevisi))
                            <div class="md:col-span-2">
                                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $formulir->nama_lengkap ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Masukkan nama lengkap sesuai ijazah" required>
                                @error('nama_lengkap')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- NISN -->
                            @if(in_array('nisn', $fieldRevisi))
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
                            @endif

                            <!-- Jenis Kelamin -->
                            @if(in_array('jenis_kelamin', $fieldRevisi))
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select id="jenis_kelamin" name="jenis_kelamin"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $formulir->jenis_kelamin ?? '') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $formulir->jenis_kelamin ?? '') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- Tempat Lahir -->
                            @if(in_array('tempat_lahir', $fieldRevisi))
                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="tempat_lahir" name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $formulir->tempat_lahir ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Kota/Kabupaten lahir" required>
                                @error('tempat_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- Tanggal Lahir -->
                            @if(in_array('tanggal_lahir', $fieldRevisi))
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $formulir->tanggal_lahir?->format('Y-m-d') ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    required>
                                @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- Asal Sekolah -->
                            @if(in_array('asal_sekolah', $fieldRevisi))
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
                            @endif

                            <!-- Agama -->
                            @if(in_array('agama', $fieldRevisi))
                            <div>
                                <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">
                                    Agama <span class="text-red-500">*</span>
                                </label>
                                <select id="agama" name="agama"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    required>
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam" {{ old('agama', $formulir->agama ?? '') === 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama', $formulir->agama ?? '') === 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama', $formulir->agama ?? '') === 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama', $formulir->agama ?? '') === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama', $formulir->agama ?? '') === 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama', $formulir->agama ?? '') === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('agama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- NIK -->
                            @if(in_array('nik', $fieldRevisi))
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                                    NIK (Nomor Induk Kependudukan)
                                </label>
                                <input type="text" id="nik" name="nik"
                                    value="{{ old('nik', $formulir->nik ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="16 digit NIK" maxlength="16">
                                @error('nik')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- Anak Ke- -->
                            @if(in_array('anak_ke', $fieldRevisi))
                            <div>
                                <label for="anak_ke" class="block text-sm font-medium text-gray-700 mb-2">
                                    Anak Ke-
                                </label>
                                <input type="number" id="anak_ke" name="anak_ke"
                                    value="{{ old('anak_ke', $formulir->anak_ke ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Nomor urut anak" min="1">
                                @error('anak_ke')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- Alamat -->
                            @if(in_array('alamat', $fieldRevisi))
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat <span class="text-red-500">*</span>
                                </label>
                                <textarea id="alamat" name="alamat"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    rows="3" placeholder="Jalan, nomor rumah, RT/RW" required>{{ old('alamat', $formulir->alamat ?? '') }}</textarea>
                                @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- Desa -->
                            @if(in_array('desa', $fieldRevisi))
                            <div>
                                <label for="desa" class="block text-sm font-medium text-gray-700 mb-2">
                                    Desa <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="desa" name="desa"
                                    value="{{ old('desa', $formulir->desa ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Nama desa" required>
                                @error('desa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- Kelurahan -->
                            @if(in_array('kelurahan', $fieldRevisi))
                            <div>
                                <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kelurahan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="kelurahan" name="kelurahan"
                                    value="{{ old('kelurahan', $formulir->kelurahan ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Nama kelurahan" required>
                                @error('kelurahan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- Kecamatan -->
                            @if(in_array('kecamatan', $fieldRevisi))
                            <div>
                                <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kecamatan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="kecamatan" name="kecamatan"
                                    value="{{ old('kecamatan', $formulir->kecamatan ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Nama kecamatan" required>
                                @error('kecamatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- Kota -->
                            @if(in_array('kota', $fieldRevisi))
                            <div>
                                <label for="kota" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kota/Kabupaten <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="kota" name="kota"
                                    value="{{ old('kota', $formulir->kota ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Nama kota/kabupaten" required>
                                @error('kota')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- No. HP -->
                            @if(in_array('no_hp', $fieldRevisi))
                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                                    No. HP <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="no_hp" name="no_hp"
                                    value="{{ old('no_hp', $formulir->no_hp ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Nomor HP aktif" required>
                                @error('no_hp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Section: Dokumen yang Perlu Diupload Ulang -->
                    @if(!empty($dokumenRevisi))
                    <div class="border border-orange-200 rounded-lg p-6 bg-orange-50">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-file text-white text-sm"></i>
                            </div>
                            Dokumen yang Perlu Diupload Ulang
                        </h3>
                        <p class="text-orange-700 text-sm mb-4">
                            <i class="fas fa-info-circle mr-1"></i>
                            File lama akan otomatis terhapus dan diganti dengan file baru yang Anda upload.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @php
                            $dokumenLabels = [
                            'kartu_keluarga' => 'Kartu Keluarga',
                            'akta_kelahiran' => 'Akta Kelahiran',
                            'foto_3x4' => 'Foto 3x4',
                            'surat_keterangan_lulus' => 'Surat Keterangan Lulus',
                            'ijazah_sd' => 'Ijazah SD',
                            'ktp_orang_tua' => 'KTP Orang Tua'
                            ];
                            @endphp

                            @foreach($dokumenRevisi as $jenisDokumen)
                            @php
                            $label = $dokumenLabels[$jenisDokumen] ?? ucfirst(str_replace('_', ' ', $jenisDokumen));
                            $inputName = "dokumen_{$jenisDokumen}";
                            $dokumenLama = $dokumenAda[$jenisDokumen] ?? null;
                            @endphp
                            <div class="bg-white p-4 rounded-lg border border-orange-200">
                                <label for="{{ $inputName }}" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $label }} <span class="text-red-500">*</span>
                                </label>

                                @if($dokumenLama)
                                <div class="mb-3 p-2 bg-gray-50 rounded border border-gray-200 text-sm">
                                    <span class="text-gray-500">Dokumen lama:</span>
                                    <a href="{{ Storage::url($dokumenLama->path_file) }}" target="_blank"
                                        class="text-blue-600 hover:underline ml-1">
                                        <i class="fas fa-external-link-alt mr-1"></i>{{ $dokumenLama->original_name ?? 'Lihat' }}
                                    </a>
                                </div>
                                @endif

                                <div class="relative">
                                    <input type="file" id="{{ $inputName }}" name="{{ $inputName }}"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200"
                                        required>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Format: PDF, JPG, PNG (Max 2MB)</p>
                                @error($inputName)
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            <span class="text-red-500">*</span> Menandakan field wajib diisi
                        </div>
                        <div class="flex space-x-4">
                            <a href="{{ route('revisi.index') }}"
                                class="px-8 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-medium">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-200 font-medium shadow-lg">
                                <i class="fas fa-save mr-2"></i>Simpan Revisi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection