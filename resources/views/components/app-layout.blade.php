<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body>
    <div class="min-vh-100 bg-light">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
                    <i class="fas fa-tools me-2"></i>{{ config('app.', 'Service App') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-home me-1"></i> {{ __('Beranda') }}
                            </a>
                        </li>
                        
                        @auth
                            @if(auth()->user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('services.*') ? 'active fw-bold' : '' }}" href="{{ route('services.index') }}">
                                        <i class="fas fa-cogs me-1"></i> {{ __('Layanan') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('technicians.*') ? 'active fw-bold' : '' }}" href="{{ route('technicians.index') }}">
                                        <i class="fas fa-users-cog me-1"></i> {{ __('Teknisi') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('service-components.*') ? 'active fw-bold' : '' }}" href="{{ route('service-components.index') }}">
                                        <i class="fas fa-microchip me-1"></i> {{ __('Komponen') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.bookings.index') }}">
                                        <i class="fas fa-calendar-check me-1"></i> {{ __('Booking') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active fw-bold' : '' }}" href="{{ route('admin.reports') }}">
                                        <i class="fas fa-chart-line me-1"></i> {{ __('Laporan') }}
                                    </a>
                                </li>
                            @elseif(auth()->user()->isTechnician())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('technician.bookings.*') ? 'active fw-bold' : '' }}" href="{{ route('technician.bookings.index') }}">
                                        <i class="fas fa-calendar-check me-1"></i> {{ __('Booking Saya') }}
                                    </a>
                                </li>
                            @else
                                <!-- <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('services.*') ? 'active fw-bold' : '' }}" href="{{ route('services.index') }}">
                                        <i class="fas fa-tools me-1"></i> Services
                                    </a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active fw-bold' : '' }}" href="{{ route('bookings.index') }}">
                                        <i class="fas fa-calendar-check me-1"></i> {{ __('Booking Saya') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('loyalty-points.*') ? 'active fw-bold' : '' }}" href="{{ route('loyalty-points.index') }}">
                                        <i class="fas fa-star me-1"></i> {{ __('Poin Loyalitas') }}
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    
                    <div class="d-flex">
                        @auth
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user me-2"></i> {{ __('Profil') }}
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i> {{ __('Keluar') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                                <i class="fas fa-sign-in-alt me-1"></i> {{ __('Masuk') }}
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus me-1"></i> {{ __('Daftar') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow-sm py-3">
                <div class="container">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="container mt-4">
                <div class="alert alert-success border-0 shadow-sm rounded-3" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="p-2 me-3 bg-white bg-opacity-25 rounded-circle">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong>Success!</strong> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="container mt-4">
                <div class="alert alert-danger border-0 shadow-sm rounded-3" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="p-2 me-3 bg-white bg-opacity-25 rounded-circle">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow-sm mt-5 py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Service App') }}. {{ __('Semua hak dilindungi.') }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="d-flex justify-content-md-end gap-3">
                            <a href="#" class="text-decoration-none text-secondary">
                                <i class="fab fa-facebook fa-lg"></i>
                            </a>
                            <a href="#" class="text-decoration-none text-secondary">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                            <a href="#" class="text-decoration-none text-secondary">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                            <a href="#" class="text-decoration-none text-secondary">
                                <i class="fab fa-linkedin fa-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>