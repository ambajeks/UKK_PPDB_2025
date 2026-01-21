@extends('layouts.admin')

@section('title', 'Riwayat Pengambilan Seragam')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-history me-2 text-secondary"></i>Riwayat Pengambilan Seragam
            </h1>
            <a href="{{ route('admin.seragam.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clipboard-check me-2"></i>Siswa yang Sudah Mengambil Seragam</span>
                <span class="badge bg-light text-secondary">{{ $calonSiswa->count() }} siswa</span>
            </div>
            
            <!-- Search Form -->
            <div class="card-body border-bottom pb-3">
                <form method="GET" action="{{ route('admin.seragam.riwayat') }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari: nama, no pendaftaran, kelas, jurusan, admin..." 
                                       value="{{ $search ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary me-2" type="submit">
                                <i class="fas fa-search me-1"></i>Cari
                            </button>
                            @if($search ?? false)
                                <a href="{{ route('admin.seragam.riwayat') }}" class="btn btn-outline-secondary">
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
                                    <th>Tanggal Pengambilan</th>
                                    <th>Diproses Oleh</th>
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
                                        <td>
                                            <span class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                {{ $siswa->tanggal_pengambilan_seragam?->format('d/m/Y H:i') ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($siswa->adminPengambilan)
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-user me-1"></i>{{ $siswa->adminPengambilan->username }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">
                            @if($search)
                                Tidak ada siswa yang ditemukan untuk pencarian "{{ $search }}"
                            @else
                                Belum ada siswa yang mengambil seragam
                            @endif
                        </h5>
                        @if($search)
                            <a href="{{ route('admin.seragam.riwayat') }}" class="btn btn-outline-primary mt-2">
                                <i class="fas fa-arrow-left me-1"></i>Lihat Semua
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
