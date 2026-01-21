@extends('layouts.app')

@section('title', 'Verifikasi Data Siswa - ' . ($formulir->nama_lengkap ?? ''))

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header dengan QR Verification Badge -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-qrcode fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1">Data Siswa Terverifikasi</h4>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        Diverifikasi melalui QR Code SMK Antartika 1 Sidoarjo
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="badge bg-success fs-6 p-2">
                                <i class="fas fa-shield-alt me-1"></i>
                                QR VERIFIED
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    ID: {{ $formulir->nomor_pendaftaran }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert informasi verifikasi -->
            <div class="alert alert-success mb-4">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="fas fa-info-circle fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="alert-heading">Informasi Verifikasi</h5>
                        <p class="mb-1">Data ini telah berhasil diverifikasi melalui sistem QR Code.</p>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Waktu verifikasi: {{ now()->format('d/m/Y H:i:s') }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Data Pribadi -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        Data Pribadi
                    </h5>
                    <span class="badge bg-primary">
                        Calon Siswa
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Kolom Foto -->
                        <div class="col-md-4 text-center mb-4">
                            @if($fotoSiswa)
                                <img src="{{ Storage::url($fotoSiswa->path_file) }}" 
                                     alt="Foto {{ $formulir->nama_lengkap }}" 
                                     class="img-fluid rounded border shadow-sm" 
                                     style="max-height: 280px; object-fit: cover;">
                                <div class="mt-2">
                                    <small class="text-muted">Foto 3x4</small>
                                </div>
                            @else
                                <div class="d-flex flex-column align-items-center justify-content-center bg-light rounded border" 
                                     style="height: 250px;">
                                    <i class="fas fa-user fa-4x text-secondary mb-3"></i>
                                    <span class="text-muted">Foto belum tersedia</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Kolom Data -->
                        <div class="col-md-8">
                            <h3 class="border-bottom pb-3 mb-4">{{ $formulir->nama_lengkap }}</h3>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small mb-1">NISN</label>
                                        <div class="fw-bold fs-5">{{ $formulir->nisn ?? '-' }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small mb-1">Jenis Kelamin</label>
                                        <div class="fw-bold">
                                            @if($formulir->jenis_kelamin == 'male')
                                                <span class="badge bg-info">Laki-laki</span>
                                            @elseif($formulir->jenis_kelamin == 'female')
                                                <span class="badge bg-pink">Perempuan</span>
                                            @else
                                                {{ $formulir->jenis_kelamin ?? '-' }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small mb-1">Tempat Lahir</label>
                                        <div class="fw-bold">{{ $formulir->tempat_lahir ?? '-' }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small mb-1">Tanggal Lahir</label>
                                        <div class="fw-bold">
                                            {{ $formulir->tanggal_lahir ? $formulir->tanggal_lahir->format('d F Y') : '-' }}
                                            @if($formulir->tanggal_lahir)
                                                <br>
                                                <small class="text-muted">
                                                    (Usia: {{ Carbon\Carbon::parse($formulir->tanggal_lahir)->age }} tahun)
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small mb-1">Agama</label>
                                        <div class="fw-bold">{{ $formulir->agama ?? '-' }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small mb-1">NIK</label>
                                        <div class="fw-bold">{{ $formulir->nik ?? '-' }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small mb-1">No. HP</label>
                                        <div class="fw-bold">{{ $formulir->no_hp ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Sekolah & Alamat -->
            <div class="row">
                <!-- Informasi Sekolah -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-school me-2"></i>
                                Informasi Sekolah
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Asal Sekolah</label>
                                <div class="fw-bold fs-6">{{ $formulir->asal_sekolah ?? '-' }}</div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Jurusan</label>
                                    <div class="fw-bold">{{ $formulir->jurusan->nama ?? '-' }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Gelombang</label>
                                    <div class="fw-bold">{{ $formulir->gelombang->nama_gelombang ?? '-' }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Kelas</label>
                                    <div class="fw-bold">{{ $formulir->kelas->nama_kelas ?? 'Belum ditentukan' }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Tanggal Daftar</label>
                                    <div class="fw-bold">{{ $formulir->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Alamat -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Alamat Lengkap
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="fw-bold mb-2">{{ $formulir->alamat ?? '-' }}</div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Desa/Kelurahan</label>
                                    <div class="fw-bold">
                                        {{ $formulir->desa ?? '-' }}/{{ $formulir->kelurahan ?? '-' }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Kecamatan</label>
                                    <div class="fw-bold">{{ $formulir->kecamatan ?? '-' }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Kota/Kabupaten</label>
                                    <div class="fw-bold">{{ $formulir->kota ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Pembayaran -->
            @if($formulir->pembayaran)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>
                        Status Pembayaran
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Status</label>
                                <div>
                                    @if($formulir->pembayaran->status === 'Lunas')
                                        <span class="badge bg-success fs-6 p-2">
                                            <i class="fas fa-check-circle me-1"></i>
                                            LUNAS
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark fs-6 p-2">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $formulir->pembayaran->status }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Total Biaya</label>
                                <div class="fw-bold fs-5 text-success">
                                    Rp {{ number_format($formulir->pembayaran->jumlah_akhir, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Admin yang Memverifikasi</label>
                                <div>
                                    @if($formulir->adminVerifikasi)
                                        <span class="badge bg-primary fs-6 p-2">
                                            <i class="fas fa-user-shield me-1"></i>
                                            {{ $formulir->adminVerifikasi->username }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Footer Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="alert alert-light border">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="me-3">
                                <i class="fas fa-qrcode fa-2x text-primary"></i>
                            </div>
                            <div class="text-start">
                                <h6 class="mb-1">Sistem Verifikasi QR Code</h6>
                                <p class="mb-0 text-muted small">
                                    Dokumen ini diverifikasi oleh sistem SMK Antartika 1 Sidoarjo.
                                    Data dijamin keasliannya.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button onclick="window.print()" class="btn btn-primary me-2">
                            <i class="fas fa-print me-1"></i> Cetak Halaman
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-1"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge.bg-pink {
        background-color: #e83e8c;
        color: white;
    }
    .card {
        border-radius: 12px;
    }
    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }
    .form-label {
        font-weight: 500;
    }
</style>
@endsection