@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    
    <!-- ROW 1 - STATISTIK -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Pendaftar</h6>
                    <h2 class="fw-bold">{{ $total_pendaftar }}</h2>
                    <small class="text-muted">*Sudah terverifikasi</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Menunggu Verifikasi</h6>
                    <h2 class="fw-bold text-warning">{{ $menunggu_verifikasi }}</h2>
                    <small class="text-muted">*Sudah bayar, tunggu verifikasi</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 border-warning">
                <div class="card-body">
                    <h6 class="text-muted">Slot Gelombang Tersisa</h6>
                    <h2 class="fw-bold text-warning">{{ $totalSlotTersisa }}</h2>
                    <small class="text-muted">
                        @foreach($gelombangInfo as $g)
                            @if($g['tersisa'] > 0)
                                {{ $g['nama'] }}: {{ $g['tersisa'] }}<br>
                            @endif
                        @endforeach
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 border-success">
                <div class="card-body">
                    <h6 class="text-muted">Total Penerimaan</h6>
                    <h2 class="fw-bold text-success">Rp {{ number_format($total_penerimaan, 0, ',', '.') }}</h2>
                    <small class="text-muted">{{ $pembayaran_lunas }} pembayaran lunas</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- HEADER LAPORAN -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Laporan untuk Kepala Sekolah</h6>
                            <small class="text-muted">Data terbaru per {{ now()->format('d F Y H:i') }}</small>
                        </div>
                        <a href="{{ route('admin.laporan.export') }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Download Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ROW 2 - GRAFIK -->
    <div class="row g-3 mb-4">
        <!-- GRAFIK PENDAFTAR -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>Grafik Pendaftar Per Hari (Terverifikasi)</span>
                    <small>Total: {{ $total_pendaftar }} siswa</small>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="chartPendaftar"></canvas>
                    </div>
                    @if($total_pendaftar == 0)
                    <div class="text-center mt-2">
                        <small class="text-muted">Belum ada pendaftar terverifikasi dalam 7 hari terakhir</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- GRAFIK PEMASUKAN -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <span>Grafik Pemasukan</span>
                    <small>Total: Rp {{ number_format($total_penerimaan, 0, ',', '.') }}</small>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="chartIncome"></canvas>
                    </div>
                    @if($total_penerimaan == 0)
                    <div class="text-center mt-2">
                        <small class="text-muted">Belum ada pemasukan dalam 6 bulan terakhir</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- ROW 3 - INFO GELOMBANG -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-layer-group me-2"></i> Status Slot Gelombang
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Gelombang</th>
                                    <th>Terisi</th>
                                    <th>Tersisa</th>
                                    <th>Kapasitas</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gelombangInfo as $g)
                                <tr>
                                    <td>{{ $g['nama'] }}</td>
                                    <td>{{ $g['terisi'] }}</td>
                                    <td>
                                        <span class="badge {{ $g['tersisa'] < 10 ? 'bg-warning' : 'bg-success' }}">
                                            {{ $g['tersisa'] }}
                                        </span>
                                    </td>
                                    <td>{{ $g['kapasitas'] }}</td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar {{ $g['persentase'] > 80 ? 'bg-warning' : ($g['persentase'] > 50 ? 'bg-info' : 'bg-success') }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $g['persentase'] }}%">
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $g['persentase'] }}%</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-chart-line me-2"></i> Gelombang Terpopuler
                </div>
                <div class="card-body">
                    @if($gelombangPopuler->count() > 0)
                        <div class="list-group">
                            @foreach($gelombangPopuler as $gelombang)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $gelombang->nama_gelombang }}</h6>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $gelombang->formulirs_count }} siswa
                                    </span>
                                </div>
                                <small class="text-muted">
                                    {{ $gelombang->tanggal_mulai }} s/d {{ $gelombang->tanggal_selesai }}
                                    <br>Harga: Rp {{ number_format($gelombang->harga, 0, ',', '.') }}
                                </small>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-muted my-3">Belum ada data gelombang</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- ROW 4 - CALON PESERTA DIDIK BARU -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span>Calon Peserta Didik Baru (Terverifikasi)</span>
            <button class="btn btn-sm btn-outline-light" onclick="location.href='{{ route('admin.verifikasi.index') }}'">
                Lihat Semua →
            </button>
        </div>
        <div class="card-body p-0">
            @if($pendaftar_baru->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama Lengkap</th>
                                <th>Jurusan</th>
                                <th>Kelas</th>
                                <th>Gelombang</th>
                                <th>Promo</th>
                                <th>Kode Transaksi</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftar_baru as $p)
                                <tr>
                                    <td>{{ $p->nomor_pendaftaran ?? 'Belum ada' }}</td>
                                    <td>{{ $p->nama_lengkap ?? $p->user->username ?? '-' }}</td>
                                    <td>{{ $p->jurusan->nama ?? '-' }}</td>
                                    <td>
                                        @if($p->kelas)
                                            <span class="badge bg-primary">
                                                <i class="fas fa-graduation-cap me-1"></i>{{ $p->kelas->nama_kelas }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Belum assign</span>
                                        @endif
                                    </td>
                                    <td>{{ $p->gelombang->nama_gelombang ?? '-' }}</td>
                                    <td>
                                        @if($p->pembayaran && $p->pembayaran->promo)
                                            <span class="badge bg-info">
                                                <i class="fas fa-tag me-1"></i>{{ $p->pembayaran->promo->kode_promo }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->pembayaran && $p->pembayaran->kode_transaksi)
                                            <code class="text-primary">{{ $p->pembayaran->kode_transaksi }}</code>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $p->created_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-success">Terverifikasi</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-muted mb-0">Belum ada pendaftar yang terverifikasi</p>
                    <small class="text-muted">Data akan muncul setelah admin memverifikasi pendaftar</small>
                </div>
            @endif
        </div>
    </div>
    
</div>

<!-- HAPUS TEST CHART SECTION (sudah tidak perlu) -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("Creating charts...");
        
        // 1. GRAFIK PENDAFTAR
        const pendaftarCtx = document.getElementById('chartPendaftar');
        if (pendaftarCtx) {
            try {
                const maxPendaftar = Math.max(...@json($chartDataPendaftar));
                const suggestedMax = maxPendaftar < 3 ? 3 : (maxPendaftar + 1);
                
                new Chart(pendaftarCtx, {
                    type: 'line',
                    data: {
                        labels: @json($chartLabelsPendaftar),
                        datasets: [{
                            label: 'Pendaftar Terverifikasi',
                            data: @json($chartDataPendaftar),
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' siswa';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                suggestedMax: suggestedMax,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return value + ' siswa';
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah Siswa'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal'
                                }
                            }
                        }
                    }
                });
            } catch (e) {
                console.error("Chart error:", e);
            }
        }
        
        // 2. GRAFIK PEMASUKAN
        const incomeCtx = document.getElementById('chartIncome');
        if (incomeCtx) {
            try {
                const maxIncome = Math.max(...@json($chartDataIncome));
                const suggestedMax = maxIncome < 1000000 ? 1000000 : (maxIncome * 1.2);
                
                new Chart(incomeCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($chartLabelsIncome),
                        datasets: [{
                            label: 'Pemasukan (Rp)',
                            data: @json($chartDataIncome),
                            backgroundColor: '#198754',
                            borderColor: '#146c43',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                suggestedMax: suggestedMax,
                                ticks: {
                                    callback: function(value) {
                                        if (value >= 1000000) {
                                            return 'Rp' + (value/1000000).toFixed(1) + ' jt';
                                        } else if (value >= 1000) {
                                            return 'Rp' + (value/1000).toFixed(0) + ' rb';
                                        }
                                        return 'Rp' + value;
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah (Rp)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Bulan'
                                }
                            }
                        }
                    }
                });
            } catch (e) {
                console.error("Income chart error:", e);
            }
        }
    });
</script>
@endsection