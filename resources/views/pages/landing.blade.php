<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Online | SMK Antartika 1 Sidoarjo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #0b5ed7;
            --accent-color: #ffc107;
            --text-light: rgba(255, 255, 255, 0.9);
        }

        body {
            font-family: "Poppins", sans-serif;
            scroll-behavior: smooth;
            padding-top: 80px; /* Offset for fixed navbar */
        }

        /* Enhanced Navbar Styles */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), #0b5ed7);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 12px 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(13, 110, 253, 0.95);
            backdrop-filter: blur(10px);
            padding: 8px 0;
        }

        /* Logo Styles */
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-img {
            height: 80px; /* Adjust based on your logo size */
            width: auto;
            object-fit: contain;
            transition: all 0.3s ease;
        }

        .navbar.scrolled .logo-img {
            height: 70px; /* Slightly smaller when scrolled */
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.4rem;
            color: white !important;
            margin: 0;
            line-height: 1;
        }

        .logo-subtext {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
            line-height: 1;
        }

        .logo-wrapper {
            display: flex;
            flex-direction: column;
        }

        .navbar-toggler {
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 6px 10px;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.25);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .nav-link {
            color: var(--text-light) !important;
            font-weight: 500;
            padding: 8px 16px !important;
            margin: 0 4px;
            border-radius: 20px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link i {
            font-size: 1.1rem;
        }

        .nav-link:hover,
        .nav-link.active {
            color: white !important;
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .nav-link:hover {
            color: var(--accent-color) !important;
        }

        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 8px 0;
            margin-top: 8px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item:hover {
            background-color: var(--primary-color);
            color: white;
            padding-left: 25px;
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .btn-login {
            background: white;
            color: var(--primary-color);
            border-radius: 30px;
            font-weight: 600;
            padding: 10px 24px;
            transition: all 0.3s ease;
            border: 2px solid white;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-login i {
            font-size: 1.1rem;
        }

        /* Hero and other sections remain the same */
        .hero {
            position: relative;
            color: white;
            padding: 120px 0;
            text-align: center;
            background-image: url('/images/sekolah.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            margin-top: -80px; /* Negative margin to compensate for body padding */
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.25));
            z-index: 0;
        }

        .hero .container {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-weight: 700;
            font-size: 2.8rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .section-title {
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 40px;
        }

        section {
            scroll-margin-top: 80px; /* Adjusted for better scrolling */
        }

        /* Mobile adjustments */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: var(--primary-color);
                border-radius: 10px;
                padding: 15px;
                margin-top: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            }
            
            .nav-link {
                margin: 5px 0;
                padding: 10px 15px !important;
            }
            
            .dropdown-menu {
                background: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                margin: 5px 0;
            }
            
            .btn-login {
                margin-top: 10px;
                justify-content: center;
            }
            
            .logo-img {
                height: 35px; /* Slightly smaller on mobile */
            }
            
            .logo-text {
                font-size: 1.2rem;
            }
            
            .logo-subtext {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 576px) {
            .logo-text {
                font-size: 1rem;
            }
            
            .logo-subtext {
                display: none; /* Hide subtext on very small screens */
            }
        }
    </style>
</head>

<body>

    {{-- Enhanced Navbar with Logo --}}
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="#beranda">
                <div class="logo-container">
                    <!-- Ganti dengan path gambar logo Anda -->
                    <img src="{{ asset('images/logo1-removebg-preview.png') }}" 
                         alt="Logo SMK Antartika 1 Sidoarjo" 
                         class="logo-img"
                         onerror="this.style.display='none'; document.getElementById('fallbackLogo').style.display='flex';">
                    
                    <!-- Fallback jika gambar tidak ditemukan -->
                    <div id="fallbackLogo" style="display: none; align-items: center; justify-content: center; 
                         width: 40px; height: 40px; background: white; border-radius: 8px; padding: 5px;">
                        <span style="color: #0d6efd; font-weight: bold; font-size: 0.8rem;">SMK</span>
                    </div>
                    
                    <div class="logo-wrapper">
                        <span class="logo-text">SMK Antartika 1</span>
                        <span class="logo-subtext">Sidoarjo</span>
                    </div>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#beranda">
                            <i class="bi bi-house-door"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#jurusan">
                            <i class="bi bi-book"></i>Jurusan
                        </a>
                    </li>

                    <!-- Enhanced Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" 
                           aria-expanded="false">
                            <i class="bi bi-info-circle"></i>Informasi
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#informasi">
                                    <i class="bi bi-calendar-event"></i>Gelombang & Promo
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#pendaftaran">
                                    <i class="bi bi-list-check"></i>Tata Cara
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#faq">
                                    <i class="bi bi-question-circle"></i>FAQ
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#tentang">
                                    <i class="bi bi-building"></i>Tentang
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#kontak">
                                    <i class="bi bi-telephone"></i>Kontak
                                </a>
                            </li>
                        </ul>
                    </li>

                    @if(auth()->check())
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-login" href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                                <i class="bi bi-person-circle"></i> 
                                <span class="d-none d-md-inline">{{ auth()->user()->username }}</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-login" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> 
                                <span class="d-none d-md-inline">Login</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section id="beranda" class="hero">
        <div class="container">
            <h1>Selamat Datang di PPDB Online SMK Antartika 1 Sidoarjo</h1>
            <p>Daftar Sekarang dan Wujudkan Impianmu Bersama Kami</p>
            <div class="mt-4">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">Daftar Sekarang</a>
                <a href="#pendaftaran" class="btn btn-outline-light btn-lg">Lihat Tata Cara</a>
            </div>
        </div>
    </section>

    <!-- Rest of your content remains exactly the same -->
    <!-- GELOMBANG + PROMO (DIGABUNG) -->
    <section id="informasi" class="py-5 bg-white">
        <div class="container text-center">
            <h2 class="section-title">Informasi Pendaftaran</h2>

            <div class="row justify-content-center g-4 mt-4">

                <!-- GELOMBANG -->
                <div class="col-md-5">
                    <div class="card shadow-sm p-4 h-100">
                        <h4 class="fw-bold text-primary text-center">Gelombang Aktif</h4>

                        @if($gelombang)
                        @foreach ($gelombang as $g)
                        <h5 class="mt-3">{{ $g->nama_gelombang }}</h5>
                        <p class="mb-1">
                            <i class="bi bi-calendar-check"></i>
                            {{ $g->tanggal_mulai }} s/d {{ $g->tanggal_selesai }}
                        </p>
                        <p class="text-muted">{{ $g->catatan }}</p>
                        @endforeach

                        @else
                        <p class="text-muted mt-3">Belum ada gelombang aktif.</p>
                        @endif
                    </div>
                </div>

                <!-- PROMO -->
                <div class="col-md-5">
                    <div class="card shadow-sm p-4 h-100">
                        <h4 class="fw-bold text-success text-center">Promo Pendaftaran</h4>

                        @forelse($promos as $p)
                        <hr>
                        <h5 class="mt-3 text-capitalize">{{ $p->jenis_promo }}</h5>
                        <p class="mb-1">
                            <i class="bi bi-tag"></i>
                            Diskon: <strong>{{ number_format($p->nominal_potongan) }}</strong>
                        </p>
                        <p class="text-muted">{{ $p-> kode_promo }}</p>
                        @empty
                        <p class="text-muted mt-3">Belum ada promo aktif.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- =================== JURUSAN =================== --}}
    <section id="jurusan" class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="section-title">Jurusan Kami</h2>
            <div class="row g-4">

                @php
                $jurusan = [
                ['RPL', 'Rekayasa Perangkat Lunak', 'bi bi-laptop'],
                ['TKR', 'Teknik Kendaraan Ringan', 'bi bi-truck'],
                ['TPM', 'Teknik Pemesinan', 'bi bi-gear'],
                ['TITL', 'Teknik Instalasi Tenaga Listrik', 'bi bi-lightning-charge'],
                ['TEI', 'Teknik Elektronika Industri', 'bi bi-cpu'],
                ];
                @endphp

                @foreach($jurusan as $j)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center">
                            <i class="{{ $j[2] }} display-4 text-primary mb-3"></i>
                            <h5 class="fw-bold">{{ $j[1] }}</h5>
                            <p class="text-muted">Jurusan {{ $j[0] }} membekali siswa dengan kemampuan unggul di
                                bidangnya.</p>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- TATA CARA PENDAFTARAN -->
                <section id="pendaftaran" class="py-5">
                    <div class="container text-center">
                        <h2 class="section-title">Tata Cara Pendaftaran</h2>

                        <div class="row g-4 justify-content-center">

                            <div class="col-md-3">
                                <div class="card shadow-sm border-0 p-4">
                                    <i class="bi bi-person-plus fs-1 text-primary mb-3"></i>
                                    <h5 class="fw-bold">1. Buat Akun</h5>
                                    <p class="text-muted">Klik <strong>"Daftar"</strong> lalu buat akun PPDB terlebih
                                        dahulu.</p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card shadow-sm border-0 p-4">
                                    <i class="bi bi-file-earmark-text fs-1 text-primary mb-3"></i>
                                    <h5 class="fw-bold">2. Isi Formulir</h5>
                                    <p class="text-muted">Lengkapi formulir data diri dan sekolah asal.</p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card shadow-sm border-0 p-4">
                                    <i class="bi bi-upload fs-1 text-primary mb-3"></i>
                                    <h5 class="fw-bold">3. Upload Dokumen</h5>
                                    <p class="text-muted">Unggah rapor, KK, akta kelahiran, dan dokumen lainnya.</p>
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="card shadow-sm border-0 p-4">
                                    <i class="bi bi-people-fill fs-1 text-primary mb-3"></i>
                                    <h5 class="fw-bold">4. Isi Data Orang tua & Wali</h5>
                                    <p class="text-muted">Lengkapi formulir data orang tua atau wali, nanti akan diberi option dan pilih salah satu.</p>
                                </div>
                            </div>


                             <div class="col-md-3">
                                <div class="card shadow-sm border-0 p-4">
                                    <i class="bi bi-credit-card-2-back-fill fs-1 text-primary mb-3"></i>
                                    <h5 class="fw-bold">5. Pembayaran</h5>
                                    <p class="text-muted">Lakukan Pembayaran.</p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card shadow-sm border-0 p-4">
                                    <i class="bi bi-check-circle fs-1 text-primary mb-3"></i>
                                    <h5 class="fw-bold">6. Verifikasi</h5>
                                    <p class="text-muted">Admin akan memeriksa data dan mengonfirmasi pendaftaran.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

                <!-- FAQ -->
                <section id="faq" class="py-5 bg-white">
                    <div class="container">
                        <h2 class="section-title text-center">Pertanyaan Umum (FAQ)</h2>

                        <div class="accordion mt-4" id="faqAccordion">

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="q1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#a1">
                                        Bagaimana cara mendaftar PPDB?
                                    </button>
                                </h2>
                                <div id="a1" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        Klik tombol <strong>"Daftar Sekarang"</strong> lalu ikuti langkah-langkahnya.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="q2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#a2">
                                        Apakah bisa mendaftar menggunakan HP?
                                    </button>
                                </h2>
                                <div id="a2" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        Ya! Website PPDB SMK Antartika 1 Sidoarjo sudah mobile friendly.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="q3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#a3">
                                        Bagaimana jika lupa password?
                                    </button>
                                </h2>
                                <div id="a3" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        Klik menu <strong>"Lupa Password"</strong> di halaman login.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

                <!-- TENTANG -->
                <section id="tentang" class="py-5 bg-light">
                    <div class="container text-center">
                        <h2 class="section-title">Tentang Sekolah</h2>
                        <p class="lead text-muted">
                            SMK Antartika 1 Sidoarjo memiliki fasilitas lengkap dan tenaga pendidik profesional.
                            Kami berkomitmen mencetak lulusan siap kerja, kompeten, dan berdaya saing tinggi.
                        </p>
                    </div>
                </section>

                <!-- KONTAK -->
                <section id="kontak" class="py-5">
                    <div class="container text-center">
                        <h2 class="section-title">Hubungi Kami</h2>

                        <p class="lead">
                            📍 Jl. Raya Siwalanpanji, Buduran, Sidoarjo<br>
                            📞 (031) 8962851<br>
                            ✉️ smks.antartika1.sda@gmail.com
                        </p>

                        <div class="mt-3">
                            <a href="#" class="btn btn-outline-primary me-1"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="btn btn-outline-primary me-1"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="btn btn-outline-primary"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                </section>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                
                <script>
                    // Navbar scroll effect
                    window.addEventListener('scroll', function() {
                        const navbar = document.getElementById('mainNavbar');
                        if (window.scrollY > 50) {
                            navbar.classList.add('scrolled');
                        } else {
                            navbar.classList.remove('scrolled');
                        }
                    });

                    // Active nav link on scroll
                    const sections = document.querySelectorAll('section');
                    const navLinks = document.querySelectorAll('.nav-link');

                    window.addEventListener('scroll', function() {
                        let current = '';
                        sections.forEach(section => {
                            const sectionTop = section.offsetTop;
                            const sectionHeight = section.clientHeight;
                            if (scrollY >= (sectionTop - 150)) {
                                current = section.getAttribute('id');
                            }
                        });

                        navLinks.forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === `#${current}`) {
                                link.classList.add('active');
                            }
                        });
                    });

                    // Close mobile menu when clicking a link
                    const navLinksMobile = document.querySelectorAll('.navbar-nav .nav-link');
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    
                    navLinksMobile.forEach(link => {
                        link.addEventListener('click', () => {
                            if (navbarCollapse.classList.contains('show')) {
                                const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                                bsCollapse.hide();
                            }
                        });
                    });
                </script>
</body>

</html>

<footer class="text-center p-3 bg-primary text-white">
    © {{ date('Y') }} SMK Antartika 1 Sidoarjo | PPDB Online
</footer>