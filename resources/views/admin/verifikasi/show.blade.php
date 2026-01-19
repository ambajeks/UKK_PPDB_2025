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
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan Verifikasi (Opsional)</label>
                                <textarea name="catatan" id="catatan" rows="3" class="form-control"
                                    placeholder="Berikan catatan jika diperlukan..."></textarea>
                            </div>
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
                        <div class="mb-3">
                            <label for="field_revisi" class="form-label"><strong>Pilih Field yang Perlu
                                    Direvisi</strong></label>
                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
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
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="field_revisi[]" value="dokumen"
                                        id="field_dokumen">
                                    <label class="form-check-label" for="field_dokumen">Dokumen</label>
                                </div>
                            </div>
                            @error('field_revisi')
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