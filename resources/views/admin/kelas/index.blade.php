@extends('layouts.admin')

@section('title', 'Data Kelas')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-collection me-2"></i>Data Kelas</h5>
            <a href="{{ route('kelas.create') }}" class="btn btn-light btn-sm text-primary fw-semibold">
                <i class="bi bi-plus-circle"></i> Tambah Kelas
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr class="text-center">
                            <th width="5%">#</th>
                            <th>Nama Kelas</th>
                            <th>Jurusan</th>
                            <th>Tipe</th>
                            <th>Kapasitas Tersisa</th>
                            <th>Jumlah Siswa</th>
                            <th>Tahun Ajaran</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $index => $k)
                            <tr class="text-center">
                                <td>{{ $kelas->firstItem() + $index }}</td>
                                <td class="fw-semibold">{{ $k->nama_kelas }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $k->jurusan->kode_jurusan ?? '-' }}</span>
                                    <br><small class="text-muted">{{ $k->jurusan->nama ?? '-' }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $k->tipe_kelas == 'Unggulan' ? 'bg-warning text-dark' : 'bg-secondary' }}">
                                        {{ $k->tipe_kelas ?? 'Reguler' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $k->kapasitas < 5 ? 'bg-danger' : ($k->kapasitas < 10 ? 'bg-warning text-dark' : 'bg-success') }}">
                                        {{ $k->kapasitas }} slot
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $k->siswa_count }} siswa</span>
                                </td>
                                <td>{{ $k->tahun_ajaran }}</td>
                                <td>
                                    <a href="{{ route('kelas.show', $k) }}" class="btn btn-info btn-sm" title="Lihat Siswa">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('kelas.edit', $k) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('kelas.destroy', $k) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2">Belum ada data kelas</p>
                                    <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i> Tambah Kelas Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($kelas->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $kelas->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Info Card -->
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
                        Siswa akan ditempatkan ke kelas sesuai jurusan yang dipilih dengan kapasitas yang masih tersedia.
                        Jika semua kelas penuh, sistem akan membuat kelas baru secara otomatis.
                    </p>
                </div>
                <div class="col-md-6">
                    <h6><i class="bi bi-bar-chart me-2"></i>Ringkasan</h6>
                    <ul class="list-unstyled small text-muted mb-0">
                        <li><i class="bi bi-check-circle text-success me-1"></i> Total Kelas: <strong>{{ $kelas->total() }}</strong></li>
                        <li><i class="bi bi-check-circle text-success me-1"></i> Total Siswa Terassign: <strong>{{ $totalSiswaTerassign ?? 0 }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
