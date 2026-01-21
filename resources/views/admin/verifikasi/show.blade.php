@extends('layouts.admin')

@section('title', 'Detail Verifikasi - ' . $calonSiswa->nama_lengkap)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Verifikasi</h1>
        <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="row">
        <!-- Data Pribadi -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-user me-2"></i>Data Pribadi
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th width="40%">Nama Lengkap</th>
                            <td>{{ $calonSiswa->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>NISN</th>
                            <td>{{ $calonSiswa->nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $calonSiswa->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                            <th>TTL</th>
                            <td>{{ $calonSiswa->tempat_lahir }}, {{ $calonSiswa->tanggal_lahir?->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Asal Sekolah</th>
                            <td>{{ $calonSiswa->asal_sekolah }}</td>
                        </tr>
                        <tr>
                            <th>No. HP</th>
                            <td>{{ $calonSiswa->no_hp }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Pendaftaran -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-file-alt me-2"></i>Data Pendaftaran
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th width="40%">No. Pendaftaran</th>
                            <td>{{ $calonSiswa->nomor_pendaftaran ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td>{{ $calonSiswa->jurusan->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $calonSiswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Gelombang</th>
                            <td>{{ $calonSiswa->gelombang->nama_gelombang ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Bayar</th>
                            <td>
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Lunas
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Bayar</th>
                            <td>{{ $calonSiswa->pembayaran->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Dokumen -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-warning text-dark">
            <i class="fas fa-file-pdf me-2"></i>Dokumen Pendaftaran
        </div>
        <div class="card-body">
            @if($calonSiswa->dokumen->count() > 0)
            <div class="row">
                @foreach($calonSiswa->dokumen as $dokumen)
                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3">
                        <h6 class="mb-2">{{ $dokumen->jenis_dokumen }}</h6>
                        <!-- Tombol Preview di Tab Baru -->
                        <a href="{{ Storage::url($dokumen->path_file) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>Preview
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-muted">Tidak ada dokumen yang diupload.</p>
            @endif
        </div>
    </div>

    <!-- Riwayat Revisi -->
    @php
    $revisiList = $calonSiswa->revisi()->latest()->get();
    @endphp
    @if($revisiList->count() > 0)
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-info text-white">
            <i class="fas fa-history me-2"></i>Riwayat Revisi ({{ $revisiList->count() }})
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal Request</th>
                            <th>Field/Dokumen yang Direvisi</th>
                            <th>Catatan</th>
                            <th>Status</th>
                            <th>Diselesaikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($revisiList as $revisi)
                        <tr>
                            <td>{{ $revisi->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                @php
                                $fieldLabels = [
                                'nama_lengkap' => 'Nama Lengkap',
                                'nisn' => 'NISN',
                                'jenis_kelamin' => 'Jenis Kelamin',
                                'tempat_lahir' => 'Tempat Lahir',
                                'tanggal_lahir' => 'Tanggal Lahir',
                                'asal_sekolah' => 'Asal Sekolah',
                                'agama' => 'Agama',
                                'nik' => 'NIK',
                                'anak_ke' => 'Anak Ke-',
                                'alamat' => 'Alamat',
                                'desa' => 'Desa',
                                'kelurahan' => 'Kelurahan',
                                'kecamatan' => 'Kecamatan',
                                'kota' => 'Kota',
                                'no_hp' => 'No. HP',
                                ];
                                $dokumenLabels = [
                                'kartu_keluarga' => 'Kartu Keluarga',
                                'akta_kelahiran' => 'Akta Kelahiran',
                                'foto_3x4' => 'Foto 3x4',
                                'surat_keterangan_lulus' => 'SKL',
                                'ijazah_sd' => 'Ijazah SD',
                                'ktp_orang_tua' => 'KTP Ortu',
                                ];
                                @endphp
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($revisi->field_revisi ?? [] as $field)
                                    <span class="badge bg-primary">{{ $fieldLabels[$field] ?? $field }}</span>
                                    @endforeach
                                    @foreach($revisi->dokumen_revisi ?? [] as $dok)
                                    <span class="badge bg-warning text-dark"><i class="fas fa-file me-1"></i>{{ $dokumenLabels[$dok] ?? $dok }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <small class="text-muted" style="max-width: 200px; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                    title="{{ $revisi->catatan_revisi }}">
                                    {{ Str::limit($revisi->catatan_revisi, 50) }}
                                </small>
                            </td>
                            <td>
                                @if($revisi->status_revisi === 'menunggu')
                                <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Menunggu</span>
                                @else
                                <span class="badge bg-success"><i class="fas fa-check me-1"></i>Selesai</span>
                                @endif
                            </td>
                            <td>
                                @if($revisi->selesai_at)
                                <small>{{ $revisi->selesai_at->format('d M Y, H:i') }}</small>
                                @else
                                <small class="text-muted">-</small>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Aksi Verifikasi -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-check-circle me-2"></i>Aksi Verifikasi
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('admin.verifikasi.approve', $calonSiswa->id) }}" method="POST">
                        @csrf
                        <!-- <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan Verifikasi (Opsional)</label>
                            <textarea name="catatan" id="catatan" rows="3" class="form-control"
                                placeholder="Berikan catatan jika diperlukan..."></textarea>
                        </div> -->
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-check me-2"></i>Verifikasi & Terima
                        </button>
                    </form>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-warning btn-lg w-100" data-bs-toggle="modal"
                        data-bs-target="#revisiModal">
                        <i class="fas fa-edit me-2"></i>Minta Revisi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Revisi -->
<div class="modal fade" id="revisiModal" tabindex="-1" aria-labelledby="revisiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="revisiModalLabel">Minta Revisi Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.verifikasi.mintaRevisi', $calonSiswa->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label"><strong>Pilih Data yang Perlu Direvisi</strong></label>
                        <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]"
                                            value="nama_lengkap" id="field_nama">
                                        <label class="form-check-label" for="field_nama">Nama Lengkap</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]" value="nisn"
                                            id="field_nisn">
                                        <label class="form-check-label" for="field_nisn">NISN</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]"
                                            value="jenis_kelamin" id="field_jk">
                                        <label class="form-check-label" for="field_jk">Jenis Kelamin</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]"
                                            value="tempat_lahir" id="field_tempat">
                                        <label class="form-check-label" for="field_tempat">Tempat Lahir</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]"
                                            value="tanggal_lahir" id="field_tgl">
                                        <label class="form-check-label" for="field_tgl">Tanggal Lahir</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]"
                                            value="asal_sekolah" id="field_sekolah">
                                        <label class="form-check-label" for="field_sekolah">Asal Sekolah</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]" value="agama"
                                            id="field_agama">
                                        <label class="form-check-label" for="field_agama">Agama</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]" value="nik"
                                            id="field_nik">
                                        <label class="form-check-label" for="field_nik">NIK</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]" value="anak_ke"
                                            id="field_anak">
                                        <label class="form-check-label" for="field_anak">Anak Ke-</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]" value="alamat"
                                            id="field_alamat">
                                        <label class="form-check-label" for="field_alamat">Alamat</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]" value="desa"
                                            id="field_desa">
                                        <label class="form-check-label" for="field_desa">Desa</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]" value="kelurahan"
                                            id="field_kelurahan">
                                        <label class="form-check-label" for="field_kelurahan">Kelurahan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]" value="kecamatan"
                                            id="field_kecamatan">
                                        <label class="form-check-label" for="field_kecamatan">Kecamatan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]" value="kota"
                                            id="field_kota">
                                        <label class="form-check-label" for="field_kota">Kota</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_revisi[]" value="no_hp"
                                            id="field_hp">
                                        <label class="form-check-label" for="field_hp">No. HP</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('field_revisi')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><strong>Pilih Dokumen yang Perlu Diupload Ulang</strong></label>
                        <div class="border rounded p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dokumen_revisi[]"
                                            value="kartu_keluarga" id="dok_kk">
                                        <label class="form-check-label" for="dok_kk">Kartu Keluarga</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dokumen_revisi[]"
                                            value="akta_kelahiran" id="dok_akta">
                                        <label class="form-check-label" for="dok_akta">Akta Kelahiran</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dokumen_revisi[]"
                                            value="foto_3x4" id="dok_foto">
                                        <label class="form-check-label" for="dok_foto">Foto 3x4</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dokumen_revisi[]"
                                            value="surat_keterangan_lulus" id="dok_skl">
                                        <label class="form-check-label" for="dok_skl">Surat Keterangan Lulus</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dokumen_revisi[]"
                                            value="ijazah_sd" id="dok_ijazah">
                                        <label class="form-check-label" for="dok_ijazah">Ijazah SD</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dokumen_revisi[]"
                                            value="ktp_orang_tua" id="dok_ktp">
                                        <label class="form-check-label" for="dok_ktp">KTP Orang Tua</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('dokumen_revisi')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan_revisi" class="form-label"><strong>Catatan Revisi</strong></label>
                        <textarea name="catatan_revisi" id="catatan_revisi" rows="4" class="form-control"
                            placeholder="Jelaskan apa yang perlu direvisi dan mengapa..." required></textarea>
                        @error('catatan_revisi')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Permintaan Revisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection