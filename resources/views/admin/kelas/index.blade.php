@extends('layouts.admin')

@section('title', 'Manajemen Kelas')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><i class="bi bi-collection me-2"></i>Manajemen Kelas</h1>
            <p class="text-muted mb-0">Kelola kelas berdasarkan jurusan</p>
        </div>
    </div>

    <!-- Statistik Global -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-mortarboard fs-1 me-3"></i>
                        <div>
                            <h6 class="mb-0">Total Jurusan</h6>
                            <h2 class="mb-0">{{ $jurusans->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-collection fs-1 me-3"></i>
                        <div>
                            <h6 class="mb-0">Total Kelas</h6>
                            <h2 class="mb-0">{{ $totalKelas }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-people fs-1 me-3"></i>
                        <div>
                            <h6 class="mb-0">Total Siswa Terassign</h6>
                            <h2 class="mb-0">{{ $totalSiswaTerassign }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Jurusan -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-grid me-2"></i>Daftar Jurusan</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="5%">#</th>
                            <th class="text-start">Jurusan</th>
                            <th>Kode</th>
                            <th>Total Kelas</th>
                            <th>Siswa / Kapasitas</th>
                            <th>Slot Tersedia</th>
                            <th>Status</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jurusans as $index => $jurusan)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $jurusan->nama }}</strong>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $jurusan->kode_jurusan }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $jurusan->kelas_count }} kelas</span>
                                </td>
                                <td class="text-center">
                                    @if($jurusan->kelas_count > 0)
                                        <strong>{{ $jurusan->total_siswa }}</strong> / {{ $jurusan->total_kapasitas }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($jurusan->kelas_count > 0)
                                        <span class="badge {{ $jurusan->slot_tersedia > 10 ? 'bg-success' : ($jurusan->slot_tersedia > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                            {{ $jurusan->slot_tersedia }} slot
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($jurusan->kelas_count == 0)
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-dash-circle me-1"></i>Belum Ada Kelas
                                        </span>
                                    @elseif($jurusan->is_penuh)
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>PENUH
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Tersedia
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.kelas.manage', $jurusan) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-gear me-1"></i>Kelola
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2">Belum ada jurusan. Tambahkan jurusan terlebih dahulu.</p>
                                    <a href="{{ route('admin.jurusan.create') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle me-1"></i>Tambah Jurusan
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-header bg-info text-white">
            <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Sistem Kelas</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="bi bi-robot me-2"></i>Assign Kelas Otomatis</h6>
                    <p class="text-muted small mb-0">
                        Sistem akan otomatis menempatkan siswa ke kelas setelah pembayaran <strong>LUNAS</strong>. 
                        Siswa akan ditempatkan ke kelas sesuai jurusan yang dipilih.
                    </p>
                </div>
                <div class="col-md-6">
                    <h6><i class="bi bi-lightbulb me-2"></i>Tips</h6>
                    <p class="text-muted small mb-0">
                        Klik tombol <strong>Kelola</strong> pada setiap jurusan untuk membuat dan mengatur kelas.
                        Anda dapat membuat beberapa kelas sekaligus dengan fitur bulk create.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
