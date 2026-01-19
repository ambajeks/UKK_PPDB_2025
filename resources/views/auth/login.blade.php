@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="auth-card p-4 p-md-5" style="max-width: 420px; width:100%; margin:auto;">

        <h3 class="text-center text-dark fw-bold mb-4">Masuk ke Akun</h3>

        <!-- Tampilkan error alert -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Login gagal!</strong> 
                @foreach($errors->all() as $error)
                    <br>{{ $error }}
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tampilkan session status (jika ada) -->
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Login (username/email) -->
            <div class="mb-3">
                <label class="text-dark fw-semibold">Username atau Email</label>
                <input type="text" name="login" class="form-control auth-input @error('login') is-invalid @enderror" 
                       value="{{ old('login') }}" required autofocus>
                @error('login')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
<div class="mb-4">
    <label class="text-dark fw-semibold">Password</label>
    <div class="position-relative">
        <input type="password" name="password" 
            id="password"
            class="form-control auth-input @error('password') is-invalid @enderror pe-5" 
            required>
        <button type="button" 
            onclick="togglePasswordVisibility('password', 'password-eye')"
            class="btn btn-link position-absolute top-50 end-0 translate-middle-y p-0 me-3 border-0 bg-transparent">
            <svg id="password-eye" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#000000" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </button>
    </div>
    @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<script>
function togglePasswordVisibility(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const eyeIcon = document.getElementById(iconId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // Ganti icon menjadi mata tertutup (slash)
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
        `;
    } else {
        passwordInput.type = 'password';
        // Ganti icon menjadi mata terbuka
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        `;
    }
}
</script>

            <button class="btn btn-primary auth-btn w-100 mb-3">Masuk</button>

            <div class="auth-link text-center text-dark">
                <a href="{{ route('password.request') }}">Lupa password?</a>
            </div>

            <div class="auth-link text-center mt-3 text-dark">
                Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
            </div>

            <div class="auth-link text-center mt-3 text-dark">
                <a href="{{ url('/') }}">Kembali ke Halaman Utama</a>
            </div>

        </form>

    </div>
@endsection