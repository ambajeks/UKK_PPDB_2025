@extends('layouts.admin')

@section('title', 'Kelola Kelas - ' . $jurusan->nama)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kelas.index') }}">Manajemen Kelas</a></li>
                    <li class="breadcrumb-item active">{{ $jurusan->kode_jurusan }}</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0">
                <i class="bi bi-collection me-2"></i>{{ $jurusan->nama }}
                <span class="badge bg-info fs-6">{{ $jurusan->kode_jurusan }}</span>
            </h1>
        </div>
        <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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

    <!-- Statistik Jurusan -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-collection text-primary fs-1"></i>
                    <h6 class="mt-2 mb-0">Total Kelas</h6>
                    <h2 class="mb-0">{{ $kelas->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-people text-success fs-1"></i>
                    <h6 class="mt-2 mb-0">Total Siswa</h6>
                    <h2 class="mb-0">{{ $totalSiswa }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-diagram-3 text-info fs-1"></i>
                    <h6 class="mt-2 mb-0">Total Kapasitas</h6>
                    <h2 class="mb-0">{{ $totalKapasitas }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-door-open text-warning fs-1"></i>
                    <h6 class="mt-2 mb-0">Slot Tersedia</h6>
                    <h2 class="mb-0 {{ $slotTersedia <= 0 ? 'text-danger' : '' }}">{{ $slotTersedia }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Form Bulk Create -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Buat Kelas Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kelas.bulk-store', $jurusan) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="jumlah_kelas" class="form-label fw-semibold">
                                Jumlah Kelas <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="jumlah_kelas" id="jumlah_kelas" 
                                   class="form-control" value="{{ old('jumlah_kelas', 1) }}" min="1" max="20" required>
                            <small class="text-muted">Contoh: 5 = akan membuat X {{ $jurusan->kode_jurusan }} 1 - X {{ $jurusan->kode_jurusan }} 5</small>
                        </div>

                        <div class="mb-3">
                            <label for="kapasitas" class="form-label fw-semibold">
                                Kapasitas per Kelas <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="kapasitas" id="kapasitas" 
                                   class="form-control" value="{{ old('kapasitas', 32) }}" min="1" max="100" required>
                            <small class="text-muted">Jumlah siswa maksimal per kelas</small>
                        </div>

                        <div class="mb-3">
                            <label for="tipe_kelas" class="form-label fw-semibold">
                                Tipe Kelas <span class="text-danger">*</span>
                            </label>
                            <select name="tipe_kelas" id="tipe_kelas" class="form-select" required>
                                <option value="Reguler" {{ old('tipe_kelas') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="Unggulan" {{ old('tipe_kelas') == 'Unggulan' ? 'selected' : '' }}>Unggulan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tahun_ajaran" class="form-label fw-semibold">
                                Tahun Ajaran <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="tahun_ajaran" id="tahun_ajaran" 
                                   class="form-control" value="{{ old('tahun_ajaran', date('Y')) }}" min="2020" max="2100" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-plus-circle me-1"></i>Buat Kelas
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar Kelas -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Kelas</h5>
                </div>
                <div class="card-body p-0">
                    @if($kelas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th width="5%">#</th>
                                        <th class="text-start">Nama Kelas</th>
                                        <th>Tipe</th>
                                        <th>Siswa</th>
                                        <th>Kapasitas</th>
                                        <th>Status</th>
                                        <th width="18%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kelas as $index => $k)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $k->nama_kelas }}</strong>
                                                <br><small class="text-muted">{{ $k->tahun_ajaran }}</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $k->tipe_kelas == 'Unggulan' ? 'bg-warning text-dark' : 'bg-secondary' }}">
                                                    {{ $k->tipe_kelas }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $k->siswa_count }} siswa</span>
                                            </td>
                                            <td class="text-center">
                                                <strong>{{ $k->siswa_count }}</strong> / {{ $k->kapasitas_awal }}
                                                <div class="progress mt-1" style="height: 5px;">
                                                    @php
                                                        $percent = $k->kapasitas_awal > 0 ? ($k->siswa_count / $k->kapasitas_awal) * 100 : 0;
                                                    @endphp
                                                    <div class="progress-bar {{ $percent >= 100 ? 'bg-danger' : ($percent >= 80 ? 'bg-warning' : 'bg-success') }}" 
                                                         style="width: {{ $percent }}%"></div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($k->kapasitas <= 0)
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle me-1"></i>PENUH
                                                    </span>
                                                @elseif($k->kapasitas <= 5)
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="bi bi-exclamation-circle me-1"></i>Hampir Penuh
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>{{ $k->kapasitas }} slot
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.kelas.show', $k) }}" class="btn btn-info btn-sm" title="Lihat Siswa">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.kelas.edit', $k) }}" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.kelas.destroy', $k) }}" method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Yakin ingin menghapus kelas {{ $k->nama_kelas }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus" 
                                                            {{ $k->siswa_count > 0 ? 'disabled' : '' }}>
                                                        <i class="bi bi-trash"></i>
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
                            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                            <h5 class="text-muted mt-3">Belum Ada Kelas</h5>
                            <p class="text-muted">Gunakan form di sebelah kiri untuk membuat kelas baru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Info -->
    <div class="alert alert-info mt-4">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Info:</strong> Kelas yang sudah memiliki siswa tidak dapat dihapus. Siswa akan otomatis ditambahkan ke kelas ini ketika pembayaran berstatus <strong>LUNAS</strong>.
    </div>
</div>
@endsection
