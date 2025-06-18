<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Service App') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        
        <!-- Custom Styles -->
        <style>
            .hero-section {
                background: linear-gradient(135deg, #4e73df, #224abe);
                color: white;
                padding: 100px 0;
                border-radius: 0 0 50px 50px;
            }
            
            .feature-card {
                border: none;
                border-radius: 15px;
                overflow: hidden;
                transition: all 0.3s ease;
                height: 100%;
            }
            
            .feature-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            }
            
            .feature-icon {
                width: 70px;
                height: 70px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                margin-bottom: 20px;
                font-size: 30px;
            }
            
            .cta-section {
                background: linear-gradient(135deg, #1cc88a, #13855c);
                color: white;
                padding: 80px 0;
                border-radius: 50px 50px 0 0;
            }
        </style>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
                        <i class="fas fa-tools me-2"></i>{{ config('app.name', 'Service App') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="#features">
                                    <i class="fas fa-star me-1"></i> Fitur
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#services">
                                    <i class="fas fa-cogs me-1"></i> Layanan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#about">
                                    <i class="fas fa-info-circle me-1"></i> Tentang Kami
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contact">
                                    <i class="fas fa-phone me-1"></i> Kontak
                                </a>
                            </li>
                        </ul>
                        
                        @if (Route::has('login'))
                            <div class="d-flex">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary me-2">
                                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                                        <i class="fas fa-sign-in-alt me-1"></i> Login
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-primary">
                                            <i class="fas fa-user-plus me-1"></i> Register
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-4 fw-bold mb-4">Layanan Servis Terbaik untuk Perangkat Elektronik Anda</h1>
                        <p class="lead mb-4">Kami menyediakan layanan perbaikan dan perawatan untuk berbagai perangkat elektronik dengan teknisi berpengalaman dan harga terjangkau.</p>
                        <div class="d-flex gap-3">
                            <a href="{{ route('services.index') }}" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-tools me-2"></i>Lihat Layanan
                            </a>
                            <a href="{{ route('bookings.create') }}" class="btn btn-outline-light btn-lg px-4">
                                <i class="fas fa-calendar-plus me-2"></i>Buat Janji
                            </a>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6 d-none d-lg-block">
                        <img src="/images/hero-image.svg" alt="Service Illustration" class="img-fluid">
                    </div> -->
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-5" id="features">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Mengapa Memilih Kami?</h2>
                    <p class="text-muted">Kami menawarkan layanan terbaik dengan berbagai keunggulan</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card feature-card shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon bg-primary bg-opacity-10 text-primary mx-auto">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <h4 class="mb-3">Teknisi Profesional</h4>
                                <p class="text-muted">Tim teknisi kami terdiri dari profesional berpengalaman yang terlatih untuk menangani berbagai masalah perangkat elektronik.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card feature-card shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon bg-success bg-opacity-10 text-success mx-auto">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <h4 class="mb-3">Harga Terjangkau</h4>
                                <p class="text-muted">Kami menawarkan layanan berkualitas dengan harga yang kompetitif dan transparan tanpa biaya tersembunyi.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card feature-card shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon bg-info bg-opacity-10 text-info mx-auto">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h4 class="mb-3">Layanan Cepat</h4>
                                <p class="text-muted">Kami berkomitmen untuk menyelesaikan perbaikan dengan cepat dan efisien agar Anda dapat menggunakan perangkat kembali sesegera mungkin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="py-5 bg-light" id="services">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Layanan Kami</h2>
                    <p class="text-muted">Berbagai layanan yang kami tawarkan untuk kebutuhan Anda</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card feature-card shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 me-3">
                                        <i class="fas fa-laptop"></i>
                                    </div>
                                    <h5 class="mb-0">Perbaikan Laptop</h5>
                                </div>
                                <p class="text-muted">Layanan perbaikan untuk berbagai masalah laptop seperti kerusakan hardware, software, dan upgrade komponen.</p>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Perbaikan motherboard</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Penggantian layar</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Upgrade RAM & SSD</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4">
                        <div class="card feature-card shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-success bg-opacity-10 text-success p-3 me-3">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <h5 class="mb-0">Perbaikan Smartphone</h5>
                                </div>
                                <p class="text-muted">Layanan perbaikan untuk smartphone dengan berbagai kerusakan hardware maupun software.</p>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Penggantian layar</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Perbaikan baterai</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Perbaikan software</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4">
                        <div class="card feature-card shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3 me-3">
                                        <i class="fas fa-tv"></i>
                                    </div>
                                    <h5 class="mb-0">Perbaikan Elektronik</h5>
                                </div>
                                <p class="text-muted">Layanan perbaikan untuk berbagai perangkat elektronik rumah tangga dan kantor.</p>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Perbaikan TV</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Perbaikan printer</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Perbaikan AC</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <a href="{{ route('services.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-list-ul me-2"></i>Lihat Semua Layanan
                    </a>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="py-5" id="how-it-works">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Cara Kerja</h2>
                    <p class="text-muted">Proses sederhana untuk mendapatkan layanan dari kami</p>
                </div>
                
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="row g-5">
                            <div class="col-md-4 text-center">
                                <div class="rounded-circle bg-primary text-white mx-auto mb-4" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 36px;">1</div>
                                <h4>Buat Janji</h4>
                                <p class="text-muted">Buat janji melalui website atau hubungi kami untuk mendapatkan layanan</p>
                            </div>
                            
                            <div class="col-md-4 text-center">
                                <div class="rounded-circle bg-primary text-white mx-auto mb-4" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 36px;">2</div>
                                <h4>Diagnosa</h4>
                                <p class="text-muted">Teknisi kami akan mendiagnosa masalah pada perangkat Anda</p>
                            </div>
                            
                            <div class="col-md-4 text-center">
                                <div class="rounded-circle bg-primary text-white mx-auto mb-4" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 36px;">3</div>
                                <h4>Perbaikan</h4>
                                <p class="text-muted">Kami memperbaiki perangkat Anda dan mengembalikannya dalam kondisi optimal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-5 bg-light" id="testimonials">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Testimoni Pelanggan</h2>
                    <p class="text-muted">Apa kata pelanggan kami tentang layanan yang kami berikan</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card feature-card shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex mb-4">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="mb-4">"Layanan sangat cepat dan profesional. Laptop saya yang rusak berat bisa diperbaiki dalam waktu singkat. Sangat merekomendasikan!"</p>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <span class="fw-bold">AS</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Ahmad Santoso</h6>
                                        <small class="text-muted">Jakarta</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card feature-card shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex mb-4">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="mb-4">"Harga sangat terjangkau dengan kualitas layanan yang luar biasa. Teknisi sangat ramah dan menjelaskan masalah dengan detail."</p>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <span class="fw-bold">SW</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Siti Wulandari</h6>
                                        <small class="text-muted">Bandung</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card feature-card shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex mb-4">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                </div>
                                <p class="mb-4">"Smartphone saya yang terkena air bisa diperbaiki dengan baik. Proses booking online sangat mudah dan responsif. Terima kasih!"</p>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <span class="fw-bold">BP</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Budi Pratama</h6>
                                        <small class="text-muted">Surabaya</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section" id="contact">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 mx-auto text-center">
                        <h2 class="display-5 fw-bold mb-4">Siap untuk memperbaiki perangkat Anda?</h2>
                        <p class="lead mb-4">Buat janji sekarang dan dapatkan layanan terbaik dari teknisi profesional kami</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('bookings.create') }}" class="btn btn-light btn-lg px-5">
                                <i class="fas fa-calendar-plus me-2"></i>Buat Janji
                            </a>
                            <a href="tel:+6281234567890" class="btn btn-outline-light btn-lg px-5">
                                <i class="fas fa-phone me-2"></i>Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-white py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <h5 class="mb-4 fw-bold">
                            <i class="fas fa-tools me-2"></i>{{ config('app.name', 'Service App') }}
                        </h5>
                        <p>Layanan perbaikan dan perawatan perangkat elektronik terbaik dengan teknisi profesional dan harga terjangkau.</p>
                        <div class="d-flex gap-3 mt-4">
                            <a href="#" class="text-white">
                                <i class="fab fa-facebook fa-lg"></i>
                            </a>
                            <a href="#" class="text-white">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                            <a href="#" class="text-white">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                            <a href="#" class="text-white">
                                <i class="fab fa-youtube fa-lg"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-2">
                        <h6 class="fw-bold mb-4">Layanan</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none">Perbaikan Laptop</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none">Perbaikan Smartphone</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none">Perbaikan TV</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none">Perbaikan Printer</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Perbaikan AC</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-lg-2">
                        <h6 class="fw-bold mb-4">Tautan</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none">Beranda</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none">Tentang Kami</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none">Layanan</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none">Testimoni</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Kontak</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-lg-4">
                        <h6 class="fw-bold mb-4">Kontak Kami</h6>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <div class="d-flex">
                                    <i class="fas fa-map-marker-alt me-3 mt-1"></i>
                                    <span>Jl. Raya Servis No. 123, Jakarta Selatan, Indonesia</span>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex">
                                    <i class="fas fa-phone me-3 mt-1"></i>
                                    <span>+62 812-3456-7890</span>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex">
                                    <i class="fas fa-envelope me-3 mt-1"></i>
                                    <span>info@serviceapp.com</span>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <i class="fas fa-clock me-3 mt-1"></i>
                                    <span>Senin - Sabtu: 08:00 - 20:00<br>Minggu: 09:00 - 15:00</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Service App') }}. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><a href="#" class="text-white text-decoration-none">Kebijakan Privasi</a></li>
                            <li class="list-inline-item ms-3"><a href="#" class="text-white text-decoration-none">Syarat & Ketentuan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>