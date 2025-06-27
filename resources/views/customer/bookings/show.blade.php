@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-eye me-2"></i>Detail Booking #{{ $booking->id }}
                        </h4>
                        <a href="{{ route('customer.bookings.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Booking Details Content -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3">Informasi Service</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Service:</td>
                                    <td>{{ $booking->service->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tipe:</td>
                                    <td>{{ ucfirst($booking->service_type) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status:</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : ($booking->status === 'in_progress' ? 'info' : 'warning')) }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal:</td>
                                    <td>{{ $booking->scheduled_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Harga:</td>
                                    <td class="fw-bold text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3">Teknisi</h5>
                            @if($booking->technician)
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                         style="width: 60px; height: 60px; background: linear-gradient(135deg, #1cc88a, #13855c);">
                                        {{ substr($booking->technician->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $booking->technician->user->name }}</h6>
                                        <p class="mb-1 text-muted">{{ $booking->technician->specialization }}</p>
                                        <p class="mb-0 small text-muted">{{ $booking->technician->user->phone_number }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Teknisi belum ditugaskan
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection