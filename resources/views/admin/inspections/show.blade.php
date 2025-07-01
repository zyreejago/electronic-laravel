@extends('layouts.app')

@section('content')
<x-slot name="header">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pemeriksaan Awal') }}
        </h2>
        <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-outline-primary btn-lg shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Back to Booking
        </a>
    </div>
</x-slot>

<div class="container py-4">
    <!-- Header Banner -->
    <div class="card border-0 shadow mb-4 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="d-flex align-items-center p-4" style="background: linear-gradient(135deg, #17a2b8, #138496);">
                <div class="rounded-circle bg-white p-3 me-4">
                    <i class="fas fa-search fa-2x" style="color: #138496;"></i>
                </div>
                <div class="text-white">
                    <h4 class="fw-bold mb-1">Pemeriksaan Awal - Booking #{{ $booking->id }}</h4>
                    <div class="fs-5">
                        Status: <span class="fw-bold">{{ $booking->inspection_completed_at ? 'Completed' : 'Pending' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow rounded-4">
                <div class="card-body p-4">
                    <!-- Booking Information -->
                    <div class="row g-4 mb-4">
                        <!-- Customer Information -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-3" 
                                     style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Customer Information</h6>
                                    <small class="text-muted">Booking made by</small>
                                </div>
                            </div>
                            <div class="ps-5 mb-4">
                                <div class="mb-2">
                                    <span class="text-muted">Name:</span>
                                    <span class="fw-bold ms-2">{{ $booking->user->name ?? '-' }}</span>
                                </div>
                                <div class="mb-2">
                                    <span class="text-muted">Email:</span>
                                    <span class="fw-bold ms-2">{{ $booking->user->email ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-muted">Phone:</span>
                                    <span class="fw-bold ms-2">{{ $booking->user->phone_number ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Service Information -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" 
                                     style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-tools fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Service Information</h6>
                                    <small class="text-muted">Service details</small>
                                </div>
                            </div>
                            <div class="ps-5 mb-4">
                                <div class="mb-2">
                                    <span class="text-muted">Service:</span>
                                    <span class="fw-bold ms-2">{{ $booking->service->name ?? '-' }}</span>
                                </div>
                                <div class="mb-2">
                                    <span class="text-muted">Created At:</span>
                                    <span class="fw-bold ms-2">{{ $booking->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div>
                                    <span class="text-muted">Initial Description:</span>
                                    <span class="fw-bold ms-2">{{ $booking->description ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Inspection Form -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 me-3" 
                             style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clipboard-check fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Detail Pemeriksaan</h6>
                            <small class="text-muted">Lengkapi form pemeriksaan awal</small>
                        </div>
                    </div>

                    <div class="ps-5">
                        <form action="{{ route('admin.inspections.update', $booking) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label for="damage_description" class="form-label fw-bold">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    Jenis Kerusakan Detail
                                </label>
                                <textarea class="form-control @error('damage_description') is-invalid @enderror" 
                                          id="damage_description" name="damage_description" rows="4" 
                                          placeholder="Jelaskan kerusakan secara detail..."
                                          style="border-radius: 10px;">{{ old('damage_description', $booking->damage_description) }}</textarea>
                                @error('damage_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Assign Technician Field -->
                            <div class="mb-4">
                                <label for="technician_id" class="form-label fw-bold">
                                    <i class="fas fa-user-cog text-primary me-2"></i>
                                    Assign Teknisi
                                </label>
                                <select class="form-select @error('technician_id') is-invalid @enderror" 
                                        id="technician_id" name="technician_id" required
                                        style="border-radius: 10px;">
                                    <option value="">-- Pilih Teknisi --</option>
                                    @foreach($technicians as $technician)
                                        <option value="{{ $technician->id }}" 
                                                {{ old('technician_id', $booking->technician_id) == $technician->id ? 'selected' : '' }}>
                                            {{ $technician->user->name }} - {{ $technician->specialization }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('technician_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="estimated_cost" class="form-label fw-bold">
                                        <i class="fas fa-money-bill-wave text-success me-2"></i>
                                        Estimasi Biaya (Rp)
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-rupiah-sign text-muted"></i>
                                        </span>
                                        <input type="number" class="form-control border-start-0 @error('estimated_cost') is-invalid @enderror" 
                                               id="estimated_cost" name="estimated_cost" 
                                               value="{{ old('estimated_cost', $booking->estimated_cost) }}" 
                                               placeholder="0"
                                               style="border-radius: 0 10px 10px 0;">
                                        @error('estimated_cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="estimated_duration_hours" class="form-label fw-bold">
                                        <i class="fas fa-clock text-info me-2"></i>
                                        Estimasi Waktu (Jam)
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-hourglass-half text-muted"></i>
                                        </span>
                                        <input type="number" class="form-control border-start-0 @error('estimated_duration_hours') is-invalid @enderror" 
                                               id="estimated_duration_hours" name="estimated_duration_hours" 
                                               value="{{ old('estimated_duration_hours', $booking->estimated_duration_hours) }}" 
                                               placeholder="0"
                                               style="border-radius: 0 10px 10px 0;">
                                        @error('estimated_duration_hours')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center pt-3">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-outline-secondary btn-lg px-4" style="border-radius: 10px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-4" style="border-radius: 10px;">
                                    <i class="fas fa-save me-2"></i>Simpan Pemeriksaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .input-group-text {
        border: 1px solid #ced4da;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }
    
    .card {
        transition: all 0.3s ease;
    }
</style>
@endpush
@endsection