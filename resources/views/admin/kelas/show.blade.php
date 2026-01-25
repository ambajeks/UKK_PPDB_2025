@extends('layouts.admin')

@section('title', 'Detail Kelas - ' . $kelas->nama_kelas)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $kelas->nama_kelas }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kelas.index') }}">Manajemen Kelas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.kelas.manage', $kelas->jurusan) }}">{{ $kelas->jurusan->kode_jurusan }}</a></li>
                    <li class="breadcrumb-item active">{{ $kelas->nama_kelas }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.kelas.manage', $kelas->jurusan) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- Info Kelas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-collection text-primary" style="font-size: 2rem;"></i>
                    <h6 class="mt-2 mb-0">Nama Kelas</h6>
                    <h4 class="fw-bold">{{ $kelas->nama_kelas }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-book text-info" style="font-size: 2rem;"></i>
                    <h6 class="mt-2 mb-0">Jurusan</h6>
                    <h4 class="fw-bold">{{ $kelas->jurusan->kode_jurusan ?? '-' }}</h4>
                    <small class="text-muted">{{ $kelas->jurusan->nama ?? '' }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-people text-success" style="font-size: 2rem;"></i>
                    <h6 class="mt-2 mb-0">Jumlah Siswa</h6>
                    <h4 class="fw-bold">{{ $kelas->siswa->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-door-open text-warning" style="font-size: 2rem;"></i>
                    <h6 class="mt-2 mb-0">Kapasitas Tersisa</h6>
                    <h4 class="fw-bold">{{ $kelas->kapasitas }} slot</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Siswa -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Daftar Siswa di Kelas Ini</h5>
        </div>
        <div class="card-body p-0">
            @if($kelas->siswa->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-success">
                            <tr class="text-center">
                                <th width="5%">No</th>
                                <th>No. Pendaftaran</th>
                                <th>Nama Lengkap</th>
                                <th>NISN</th>
                                <th>Asal Sekolah</th>
                                <th>Status Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelas->siswa as $index => $siswa)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        <code>{{ $siswa->nomor_pendaftaran ?? '-' }}</code>
                                    </td>
                                    <td>
                                        <strong>{{ $siswa->nama_lengkap }}</strong>
                                    </td>
                                    <td class="text-center">{{ $siswa->nisn ?? '-' }}</td>
                                    <td>{{ $siswa->asal_sekolah ?? '-' }}</td>
                                    <td class="text-center">
                                        @if($siswa->status_verifikasi === 'diverifikasi')
                                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Terverifikasi</span>
                                        @elseif($siswa->status_verifikasi === 'menunggu')
                                            <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Menunggu</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $siswa->status_verifikasi }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <h5 class="text-muted mt-3">Belum Ada Siswa di Kelas Ini</h5>
                    <p class="text-muted">Siswa akan otomatis ditambahkan setelah pembayaran LUNAS.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Info Assign Otomatis -->
    <div class="alert alert-info mt-4">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Info:</strong> Siswa akan otomatis ditambahkan ke kelas ini ketika:
        <ul class="mb-0 mt-2">
            <li>Siswa memilih jurusan <strong>{{ $kelas->jurusan->nama ?? '(jurusan ini)' }}</strong></li>
            <li>Pembayaran berstatus <strong>LUNAS</strong></li>
            <li>Kelas ini masih memiliki kapasitas tersisa</li>
        </ul>
    </div>
</div>
@endsection
