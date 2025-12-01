@extends('layouts.app')
@section('content')
<h3>Isi Formulir Pendaftaran</h3>
<form action="{{ route('formulir.store') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label class="form-label">Nama Lengkap</label>
    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
  </div>
  <!-- tambahkan field lain sesuai model -->
  <div class="mb-3">
    <label class="form-label">NISN</label>
    <input type="text" name="nisn" class="form-control" value="{{ old('nisn') }}">
  </div>
  <!-- Gelombang otomatis ditentukan oleh sistem -->
  <button class="btn btn-primary">Kirim</button>
</form>
@endsection