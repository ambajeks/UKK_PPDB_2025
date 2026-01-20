@extends('layouts.admin')

@section('title', 'Edit Profil Admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4">
                <h5 class="mb-0"><i class="bi bi-person-circle"></i> Edit Profil Admin</h5>
            </div>

            <div class="card-body p-4">

                <!-- INFO -->
                <div class="alert alert-info small shadow-sm">
                    Anda hanya perlu mengedit bagian yang ingin diganti.  
                    Bagian email & no hp tidak bisa diubah.
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <!-- FOTO PROFIL -->
                    <div class="text-center mb-4">

                        <img src="{{ Auth::user()->avatar 
                            ? asset('storage/' . Auth::user()->avatar) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) }}"
                            class="rounded-circle shadow-sm border"
                            width="130" height="130">

                        <div class="mt-3">
                            <label class="form-label fw-semibold">Ubah Foto Profil</label>
                            <input type="file" name="avatar"
                                   class="form-control @error('avatar') is-invalid @enderror">
                            @error('avatar') 
                                <small class="text-danger">{{ $message }}</small> 
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- DATA TIDAK BISA DIUBAH -->
                    <h6 class="fw-bold mb-3 text-secondary">Informasi Akun</h6>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" 
                               value="{{ Auth::user()->email }}" readonly>
                    </div>

                    <!-- No HP -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Telepon</label>
                        <input type="text" class="form-control" 
                               value="{{ Auth::user()->no_hp }}" readonly>
                    </div>

                    <hr class="my-4">

                    <!-- USERNAME -->
                    <h6 class="fw-bold mb-3 text-secondary">Nama Pengguna</h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama (opsional)</label>
                        <input type="text" name="username"
                               class="form-control"
                               value="{{ old('username', Auth::user()->username) }}">
                    </div>

                    <hr class="my-4">

                    <!-- PASSWORD -->
<h6 class="fw-bold mb-3 text-secondary">
    <i class="bi bi-lock"></i> Ganti Password (opsional)
</h6>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const button = field.nextElementSibling;
        const icon = button.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>   

<div class="mb-3">
    <label class="form-label">Password Lama</label>
    <div class="input-group">
        <input type="password" name="current_password" class="form-control" id="current_password">
        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
            <i class="bi bi-eye"></i>
        </button>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Password Baru</label>
    <div class="input-group">
        <input type="password" name="password" class="form-control" id="password">
        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
            <i class="bi bi-eye"></i>
        </button>
    </div>
</div>

<div class="mb-4">
    <label class="form-label">Konfirmasi Password Baru</label>
    <div class="input-group">
        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
            <i class="bi bi-eye"></i>
        </button>
    </div>
</div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary px-4">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>

                        <button class="btn btn-primary px-4" type="submit">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
