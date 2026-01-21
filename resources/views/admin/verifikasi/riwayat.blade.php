@extends('layouts.admin')

@section('title', 'Riwayat Verifikasi')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Riwayat Verifikasi</h1>
            <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke Verifikasi
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-history me-2"></i>Riwayat Verifikasi Calon Siswa
            </div>
            <div class="card-body p-0">
                @if($calonSiswa->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>No. Pendaftaran</th>
                                    <th>Nama Calon Siswa</th>
                                    <th>Jurusan</th>
                                    <th>Kelas</th>
                                    <th>Promo</th>
                                    <th>Kode Transaksi</th>
                                    <th>Status Verifikasi</th>
                                    <th>Admin Verifikasi</th>
                                    <th>Tanggal Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calonSiswa as $siswa)
                                    <tr>
                                        <td>{{ $siswa->nomor_pendaftaran ?? '-' }}</td>
                                        <td>{{ $siswa->nama_lengkap }}</td>
                                        <td>{{ $siswa->jurusan->nama ?? '-' }}</td>
                                        <td>
                                            @if($siswa->kelas)
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-graduation-cap me-1"></i>{{ $siswa->kelas->nama_kelas }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Belum assign</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($siswa->pembayaran && $siswa->pembayaran->promo)
                                                <span class="badge bg-info">
                                                    <i class="fas fa-tag me-1"></i>{{ $siswa->pembayaran->promo->kode_promo }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($siswa->pembayaran && $siswa->pembayaran->kode_transaksi)
                                                <code class="text-primary">{{ $siswa->pembayaran->kode_transaksi }}</code>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($siswa->status_verifikasi === 'diverifikasi')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Terverifikasi
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $siswa->adminVerifikasi->username ?? '-' }}</td>
                                        <td>{{ $siswa->verified_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada riwayat verifikasi</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection