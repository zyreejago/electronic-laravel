@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4" style="background: linear-gradient(135deg, #4e73df, #224abe);">
                    <div class="d-flex align-items-center text-white">
                        <div class="me-3">
                            <i class="fas fa-tachometer-alt fa-3x"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">{{ __('Dashboard Pelanggan') }}</h2>
                            <p class="mb-0 fs-5">{{ __('Selamat datang') }}, {{ auth()->user()->name }}!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 me-3">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-primary">{{ $totalBookings }}</h3>
                            <p class="text-muted mb-0">{{ __('Total Booking') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success p-3 me-3">
                            <i class="fas fa-check-double fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-success">{{ $completedBookings }}</h3>
                            <p class="text-muted mb-0">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3 me-3">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-warning">{{ $pendingBookings }}</h3>
                            <p class="text-muted mb-0">Menunggu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info p-3 me-3">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-info">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
                            <p class="text-muted mb-0">{{ __('Total Pengeluaran') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Bookings -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-history me-2 text-primary"></i>{{ __('Booking Terbaru') }}
                        </h5>
                        <a href="{{ route('customer.bookings.index') }}" class="btn btn-outline-primary btn-sm">
                            {{ __('Lihat Semua') }}
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @forelse($recentBookings as $booking)
                        <div class="border-bottom p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">
                                        <a href="{{ route('customer.bookings.show', $booking) }}" class="text-decoration-none">
                                            #{{ $booking->id }} - {{ $booking->service->name }}
                                        </a>
                                    </h6>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $booking->scheduled_at->format('d M Y H:i') }}
                                    </p>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-user-cog me-1"></i>
                                        {{ $booking->technician->user->name ?? 'Belum ditugaskan' }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : ($booking->status === 'in_progress' ? 'info' : 'warning')) }} mb-2">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <div class="fw-bold text-primary">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                            <p class="mb-0">{{ __('Belum ada booking') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Pending Additional Work & Notifications -->
        <div class="col-lg-4">
            <!-- Pending Additional Work -->
            @if($pendingAdditionalWork->count() > 0)
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>{{ __('Pekerjaan Tambahan') }}
                        </h6>
                        <a href="{{ route('customer.additional-work.index') }}" class="btn btn-outline-warning btn-sm">
                            {{ __('Lihat Semua') }}
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @foreach($pendingAdditionalWork->take(3) as $request)
                        <div class="border-bottom p-3">
                            <h6 class="fw-bold mb-1">{{ $request->title }}</h6>
                            <p class="text-muted small mb-2">{{ Str::limit($request->description, 60) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-warning">{{ __('Menunggu Respon') }}</span>
                                <span class="fw-bold text-primary">Rp {{ number_format($request->estimated_cost, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Recent Notifications -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-bell me-2 text-info"></i>{{ __('Notifikasi Terbaru') }}
                        </h6>
                        <a href="{{ route('notifications.index') }}" class="btn btn-outline-info btn-sm">
                            {{ __('Lihat Semua') }}
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @forelse($recentNotifications as $notification)
                        <div class="border-bottom p-3">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 me-3 flex-shrink-0">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">{{ $notification->data['title'] ?? __('Notifikasi') }}</h6>
                                    <p class="text-muted small mb-1">{{ Str::limit($notification->data['message'] ?? '', 80) }}</p>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-3 text-center text-muted">
                            <i class="fas fa-bell-slash fa-2x mb-2"></i>
                            <p class="mb-0 small">{{ __('Belum ada notifikasi') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>Aksi Cepat
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('bookings.create') }}" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-plus me-2"></i>{{ __('Booking Baru') }}
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('customer.bookings.history') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-history me-2"></i>{{ __('Riwayat Service') }}
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('loyalty-points.index') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-star me-2"></i>Loyalty Points
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary w-100 py-3">
                                <i class="fas fa-user-edit me-2"></i>{{ __('Edit Profil') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection