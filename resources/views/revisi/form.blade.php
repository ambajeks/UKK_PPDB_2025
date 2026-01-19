@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('status.index') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center mb-4">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Status Pendaftaran
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
                    <p class="text-yellow-700 mb-3"><strong>Field yang perlu direvisi:</strong></p>
                    <div class="bg-white p-3 rounded border border-yellow-200 mb-3">
                        <ul class="list-disc list-inside text-yellow-700">
                            @foreach($revisi->field_revisi as $field)
                                <li>
                                    @switch($field)
                                        @case('nama_lengkap')
                                            Nama Lengkap
                                            @break
                                        @case('nisn')
                                            NISN
                                            @break
                                        @case('jenis_kelamin')
                                            Jenis Kelamin
                                            @break
                                        @case('tempat_lahir')
                                            Tempat Lahir
                                            @break
                                        @case('tanggal_lahir')
                                            Tanggal Lahir
                                            @break
                                        @case('asal_sekolah')
                                            Asal Sekolah
                                            @break
                                        @case('agama')
                                            Agama
                                            @break
                                        @case('nik')
                                            NIK
                                            @break
                                        @case('anak_ke')
                                            Anak Ke-
                                            @break
                                        @case('alamat')
                                            Alamat
                                            @break
                                        @case('desa')
                                            Desa
                                            @break
                                        @case('kelurahan')
                                            Kelurahan
                                            @break
                                        @case('kecamatan')
                                            Kecamatan
                                            @break
                                        @case('kota')
                                            Kota
                                            @break
                                        @case('no_hp')
                                            No. HP
                                            @break
                                        @case('dokumen')
                                            Dokumen
                                            @break
                                        @default
                                            {{ $field }}
                                    @endswitch
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <p class="text-yellow-700 text-sm"><i class="fas fa-info-circle mr-1"></i>Silakan lengkapi field yang ditandai di atas, kemudian klik tombol "Simpan Revisi" di bawah.</p>
                </div>
            </div>
        </div>

        <!-- Form Revisi -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 bg-white border-b border-gray-200">
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                            <span class="text-red-700 font-medium">Terjadi kesalahan. Silakan periksa kembali data yang dimasukkan.</span>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('revisi.store') }}" class="space-y-8">
                    @csrf
                    <input type="hidden" name="formulir_id" value="{{ $formulir->id }}">
                    <input type="hidden" name="revisi_id" value="{{ $revisi->id }}">

                    <!-- Section: Data yang Perlu Direvisi -->
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-sm">!</span>
                            </div>
                            Data yang Perlu Direvisi
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            @if(in_array('nama_lengkap', $revisi->field_revisi))
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
                            @if(in_array('nisn', $revisi->field_revisi))
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
                            @if(in_array('jenis_kelamin', $revisi->field_revisi))
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
                            @if(in_array('tempat_lahir', $revisi->field_revisi))
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
                            @if(in_array('tanggal_lahir', $revisi->field_revisi))
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
                            @if(in_array('asal_sekolah', $revisi->field_revisi))
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
                            @if(in_array('agama', $revisi->field_revisi))
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
                            @if(in_array('nik', $revisi->field_revisi))
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
                            @if(in_array('anak_ke', $revisi->field_revisi))
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
                            @if(in_array('alamat', $revisi->field_revisi))
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
                            @if(in_array('desa', $revisi->field_revisi))
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
                            @if(in_array('kelurahan', $revisi->field_revisi))
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
                            @if(in_array('kecamatan', $revisi->field_revisi))
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
                            @if(in_array('kota', $revisi->field_revisi))
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
                            @if(in_array('no_hp', $revisi->field_revisi))
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

                            <!-- Dokumen Upload -->
                            @if(in_array('dokumen', $revisi->field_revisi))
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload Ulang Dokumen <span class="text-red-500">*</span>
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                                    <p class="text-gray-600 mb-2">Drag & drop dokumen atau klik untuk browse</p>
                                    <p class="text-sm text-gray-500">Format: PDF, JPG, PNG (Max 2MB)</p>
                                    <input type="file" id="dokumen_upload" name="dokumen_upload" 
                                        class="hidden"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        multiple>
                                    <button type="button" 
                                        class="mt-3 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                                        onclick="document.getElementById('dokumen_upload').click()">
                                        Pilih File
                                    </button>
                                </div>
                                <div id="dokumen_list" class="mt-3"></div>
                                @error('dokumen_upload')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            <span class="text-red-500">*</span> Menandakan field wajib diisi
                        </div>
                        <div class="flex space-x-4">
                            <a href="{{ route('status.index') }}" 
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

<script>
    // Handle dokumen upload dengan drag & drop
    const dokumenInput = document.getElementById('dokumen_upload');
    const dropZone = dokumenInput?.parentElement;
    
    if (dropZone) {
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('bg-blue-50', 'border-blue-400');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('bg-blue-50', 'border-blue-400');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('bg-blue-50', 'border-blue-400');
            dokumenInput.files = e.dataTransfer.files;
            updateDokumenList();
        });

        dokumenInput?.addEventListener('change', updateDokumenList);
    }

    function updateDokumenList() {
        const list = document.getElementById('dokumen_list');
        const files = dokumenInput?.files;
        
        if (!files) return;

        list.innerHTML = '<div class="mt-3 space-y-2">';
        for (let file of files) {
            list.innerHTML += `
                <div class="flex items-center justify-between p-2 bg-blue-50 rounded border border-blue-200">
                    <span class="text-sm text-blue-900"><i class="fas fa-file mr-2"></i>${file.name}</span>
                    <span class="text-xs text-blue-600">${(file.size / 1024).toFixed(2)} KB</span>
                </div>
            `;
        }
        list.innerHTML += '</div>';
    }
</script>
@endsection
