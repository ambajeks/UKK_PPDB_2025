@extends('layouts.admin')

@section('title', 'Ambil Seragam & Atribut')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-tshirt me-2 text-primary"></i>Ambil Seragam & Atribut
            </h1>
            <a href="{{ route('admin.seragam.riwayat') }}" class="btn btn-secondary">
                <i class="fas fa-history me-1"></i>Riwayat Pengambilan
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users me-2"></i>Daftar Siswa Belum Ambil Seragam</span>
                <span class="badge bg-light text-primary">{{ $calonSiswa->count() }} siswa</span>
            </div>
            
            <!-- Search Form -->
            <div class="card-body border-bottom pb-3">
                <form method="GET" action="{{ route('admin.seragam.index') }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari: nama, no pendaftaran, kelas, jurusan..." 
                                       value="{{ $search ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary me-2" type="submit">
                                <i class="fas fa-search me-1"></i>Cari
                            </button>
                            @if($search ?? false)
                                <a href="{{ route('admin.seragam.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                @if($calonSiswa->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>No. Pendaftaran</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jurusan</th>
                                    <th>Kelas</th>
                                    <th>Tanggal Verifikasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calonSiswa as $siswa)
                                    <tr>
                                        <td>
                                            <code class="text-primary">{{ $siswa->nomor_pendaftaran ?? '-' }}</code>
                                        </td>
                                        <td>
                                            <strong>{{ $siswa->nama_lengkap }}</strong>
                                        </td>
                                        <td>{{ $siswa->jurusan->nama ?? '-' }}</td>
                                        <td>
                                            @if($siswa->kelas)
                                                <span class="badge bg-info">
                                                    <i class="fas fa-graduation-cap me-1"></i>{{ $siswa->kelas->nama_kelas }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Belum assign</span>
                                            @endif
                                        </td>
                                        <td>{{ $siswa->verified_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.seragam.ambil', $siswa->id) }}" method="POST" 
                                                  onsubmit="return confirm('Konfirmasi siswa {{ $siswa->nama_lengkap }} sudah mengambil seragam & atribut?')">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check me-1"></i>Sudah Mengambil
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-tshirt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">
                            @if($search)
                                Tidak ada siswa yang ditemukan untuk pencarian "{{ $search }}"
                            @else
                                Semua siswa sudah mengambil seragam & atribut
                            @endif
                        </h5>
                        @if($search)
                            <a href="{{ route('admin.seragam.index') }}" class="btn btn-outline-primary mt-2">
                                <i class="fas fa-arrow-left me-1"></i>Lihat Semua
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
