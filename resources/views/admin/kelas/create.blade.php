@extends('layouts.admin')

@section('title', 'Tambah Kelas')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Kelas Baru</h5>
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-light btn-sm text-primary fw-semibold">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.kelas.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jurusan_id" class="form-label fw-semibold">Jurusan <span class="text-danger">*</span></label>
                        <select name="jurusan_id" id="jurusan_id" class="form-select @error('jurusan_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama }} ({{ $jurusan->kode_jurusan }})
                                </option>
                            @endforeach
                        </select>
                        @error('jurusan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_kelas" class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kelas" id="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" 
                               value="{{ old('nama_kelas') }}" placeholder="Contoh: X TKJ 1" required>
                        @error('nama_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="tipe_kelas" class="form-label fw-semibold">Tipe Kelas <span class="text-danger">*</span></label>
                        <select name="tipe_kelas" id="tipe_kelas" class="form-select @error('tipe_kelas') is-invalid @enderror" required>
                            <option value="Reguler" {{ old('tipe_kelas') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                            <option value="Unggulan" {{ old('tipe_kelas') == 'Unggulan' ? 'selected' : '' }}>Unggulan</option>
                        </select>
                        @error('tipe_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="kapasitas" class="form-label fw-semibold">Kapasitas <span class="text-danger">*</span></label>
                        <input type="number" name="kapasitas" id="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" 
                               value="{{ old('kapasitas', 32) }}" min="0" required>
                        @error('kapasitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Jumlah maksimal siswa per kelas</small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="tahun_ajaran" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                        <input type="number" name="tahun_ajaran" id="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                               value="{{ old('tahun_ajaran', date('Y')) }}" min="2020" max="2100" required>
                        @error('tahun_ajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Kelas
                    </button>
                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Box -->
    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-header bg-info text-white">
            <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Panduan Membuat Kelas</h6>
        </div>
        <div class="card-body">
            <ul class="mb-0 text-muted">
                <li><strong>Jurusan:</strong> Pilih jurusan yang sudah tersedia. Jika belum ada, tambahkan jurusan terlebih dahulu.</li>
                <li><strong>Nama Kelas:</strong> Gunakan format seperti "X TKJ 1", "X RPL 2", dst.</li>
                <li><strong>Tipe Kelas:</strong> Reguler untuk kelas biasa, Unggulan untuk kelas dengan kriteria khusus.</li>
                <li><strong>Kapasitas:</strong> Jumlah maksimal siswa yang dapat ditampung dalam 1 kelas.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
