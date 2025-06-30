<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Booking Detail') }}
            </h2>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Bookings
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        <!-- Booking Status Banner -->
        <div class="card border-0 shadow mb-4 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="d-flex align-items-center p-4" style="background: linear-gradient(135deg, 
                    {{ $booking->status === 'pending' ? '#f6c23e, #dda20a' : 
                       ($booking->status === 'confirmed' ? '#4e73df, #224abe' : 
                       ($booking->status === 'completed' ? '#1cc88a, #13855c' : '#e74a3b, #be2617')) }});">
                    <div class="rounded-circle bg-white p-3 me-4">
                        <i class="fas fa-{{ $booking->status === 'pending' ? 'clock' : 
                                          ($booking->status === 'confirmed' ? 'check-circle' : 
                                          ($booking->status === 'completed' ? 'check-double' : 'times-circle')) }} fa-2x" 
                           style="color: {{ $booking->status === 'pending' ? '#dda20a' : 
                                          ($booking->status === 'confirmed' ? '#224abe' : 
                                          ($booking->status === 'completed' ? '#13855c' : '#be2617')) }};"></i>
                    </div>
                    <div class="text-white">
                        <h4 class="fw-bold mb-1">Booking #{{ $booking->id }}
                            @if($booking->is_emergency)
                                <span class="badge bg-danger ms-2"><i class="fas fa-bolt me-1"></i>Emergency</span>
                            @endif
                        </h4>
                        <div class="fs-5">
                            Status: <span class="fw-bold">{{ ucfirst($booking->status) }}</span>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="bookingActions" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bookingActions">
                                @if($booking->status === 'pending')
                                    <li>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#assignTechnicianModal">
                                            Assign Technician
                                        </button>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                Cancel Booking
                                            </button>
                                        </form>
                                    </li>
                                @elseif($booking->status === 'in_progress')
                                    <li>
                                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="dropdown-item text-success" onclick="return confirm('Are you sure you want to mark this booking as completed?')">
                                                Mark as Completed
                                            </button>
                                        </form>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Customer and Service Information -->
            <div class="col-lg-8">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-info-circle me-2"></i>Booking Information
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Customer Information -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                         style="width: 45px; height: 45px; background: linear-gradient(135deg, #4e73df, #224abe);">
                                        {{ substr($booking->user->name ?? 'U', 0, 1) }}
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
                                        <span class="text-muted">Price:</span>
                                        <span class="fw-bold ms-2">Rp {{ number_format($booking->service->price ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Duration:</span>
                                        <span class="fw-bold ms-2">{{ $booking->service->duration ?? 0 }} minutes</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Scheduling Information -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 me-3" 
                                 style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-calendar-alt fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Scheduling Information</h6>
                                <small class="text-muted">Date and time details</small>
                            </div>
                        </div>
                        <div class="ps-5 mb-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <span class="text-muted">Scheduled Date:</span>
                                        <span class="fw-bold ms-2">{{ $booking->scheduled_at ? $booking->scheduled_at->format('d M Y') : '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Scheduled Time:</span>
                                        <span class="fw-bold ms-2">{{ $booking->scheduled_at ? $booking->scheduled_at->format('H:i') : '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <span class="text-muted">Created At:</span>
                                        <span class="fw-bold ms-2">{{ $booking->created_at ? $booking->created_at->format('d M Y H:i') : '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Last Updated:</span>
                                        <span class="fw-bold ms-2">{{ $booking->updated_at ? $booking->updated_at->format('d M Y H:i') : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Description -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2 me-3" 
                                 style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-comment-alt fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Description</h6>
                                <small class="text-muted">Customer's notes</small>
                            </div>
                        </div>
                        <div class="ps-5">
                            <div class="p-3 rounded-3 bg-light">
                                {{ $booking->description ?: 'No description provided.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technician and Status Information -->
            <div class="col-lg-4">
                <!-- Initial Inspection Button -->
                <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #6f42c1, #5a2d91);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-search me-2"></i>Pemeriksaan Awal
                            </h5>
                        </div>
                        <!-- Pemeriksaan Awal Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-search me-2"></i>Pemeriksaan Awal
                                </h6>
                            </div>
                            <div class="card-body">
                                @if($booking->inspection_completed_at)
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="alert alert-success">
                                                <strong>Status:</strong> <span class="badge bg-success">Pemeriksaan Selesai</span><br>
                                                <small>Diselesaikan pada: {{ $booking->inspection_completed_at->format('d M Y H:i') }}</small>
                                                @if($booking->inspectedBy)
                                                    <br><small>Oleh: {{ $booking->inspectedBy->name }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        @if($booking->damage_description)
                                            <div class="col-md-12 mb-3">
                                                <strong>Deskripsi Kerusakan:</strong>
                                                <div class="mt-2 p-3 bg-light rounded">{!! nl2br(e($booking->damage_description)) !!}</div>
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            @if($booking->estimated_cost)
                                                <strong>Estimasi Biaya:</strong><br>
                                                <span class="h5 text-primary">Rp {{ number_format($booking->estimated_cost, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            @if($booking->estimated_duration_hours)
                                                <strong>Estimasi Durasi:</strong><br>
                                                <span class="h5 text-info">{{ $booking->estimated_duration_hours }} jam</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.inspections.show', $booking) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-edit me-2"></i>Edit Pemeriksaan
                                        </a>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-clock me-2"></i>Pemeriksaan awal belum dilakukan.
                                    </div>
                                    @if($booking->technician_id)
                                        <a href="{{ route('admin.inspections.show', $booking) }}" class="btn btn-primary">
                                            <i class="fas fa-search me-2"></i>Mulai Pemeriksaan Awal
                                        </a>
                                    @else
                                        <small class="text-muted">Assign teknisi terlebih dahulu untuk memulai pemeriksaan.</small>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if($booking->inspection_completed_at)
                            <div class="alert alert-success border-0 p-3" style="background: rgba(28, 200, 138, 0.1); color: #13855c; border-left: 4px solid #1cc88a;">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div>
                                        <p class="mb-1 fw-bold">Pemeriksaan Telah Selesai</p>
                                        <p class="mb-0 small">Diselesaikan pada: {{ $booking->inspection_completed_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <div class="rounded-circle bg-purple bg-opacity-10 text-purple p-3 mx-auto mb-3" 
                                     style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; color: #6f42c1;">
                                    <i class="fas fa-clipboard-check fa-2x"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Pemeriksaan Awal Diperlukan</h6>
                                <p class="text-muted mb-3 small">Lakukan pemeriksaan awal untuk menentukan kerusakan dan estimasi biaya.</p>
                            </div>
                        @endif
                        
                        <div class="d-grid">
                            <a href="{{ route('admin.inspections.show', $booking->id) }}" class="btn btn-lg" 
                               style="background: linear-gradient(135deg, #6f42c1, #5a2d91); border: none; color: white;">
                                <i class="fas fa-{{ $booking->inspection_completed_at ? 'eye' : 'clipboard-check' }} me-2"></i>
                                {{ $booking->inspection_completed_at ? 'Lihat Hasil Pemeriksaan' : 'Mulai Pemeriksaan Awal' }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Inventory Usage Information -->
                <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #f6c23e, #dda20a);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-boxes me-2"></i>Inventory Usage
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if($booking->inventoryUsages && $booking->inventoryUsages->count() > 0)
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-3">Items Used by Technician:</h6>
                                @foreach($booking->inventoryUsages as $usage)
                                    <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded-3">
                                        <div>
                                            <div class="fw-bold">{{ $usage->inventoryItem->name }}</div>
                                            <small class="text-muted">
                                                Qty: {{ $usage->quantity_used }} | 
                                                Used by: {{ $usage->technician->user->name ?? 'Unknown Technician' }} | 
                                                {{ $usage->used_at->format('d M Y H:i') }}
                                            </small>
                                            @if($usage->notes)
                                                <div class="text-muted small mt-1">{{ $usage->notes }}</div>
                                            @endif
                                        </div>
                                        <span class="badge bg-success">Used</span>
                                    </div>
                                @endforeach
                                
                                <!-- Summary -->
                                <div class="mt-4 p-3 bg-primary bg-opacity-10 rounded-3">
                                    <div class="row text-center">
                                        <div class="col-md-6">
                                            <div class="fw-bold text-primary">{{ $booking->inventoryUsages->count() }}</div>
                                            <small class="text-muted">Different Items</small>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fw-bold text-primary">{{ $booking->inventoryUsages->sum('quantity_used') }}</div>
                                            <small class="text-muted">Total Quantity</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3 mx-auto mb-3" 
                                     style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-box-open fa-3x"></i>
                                </div>
                                <h6 class="fw-bold">No Inventory Used</h6>
                                <p class="text-muted mb-0">No inventory items have been used for this booking yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card border-0 shadow rounded-4 overflow-hidden">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #f6c23e, #dda20a);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-history me-2"></i>Booking Timeline
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-item-marker">
                                    <div class="timeline-item-marker-indicator bg-primary">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                </div>
                                <div class="timeline-item-content">
                                    <div class="fw-bold">Booking Created</div>
                                    <div class="text-muted small">{{ $booking->created_at ? $booking->created_at->format('d M Y H:i') : '-' }}</div>
                                    <div class="text-muted mt-2">Customer created this booking.</div>
                                </div>
                            </div>

                            @if($booking->status !== 'pending')
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-indicator bg-success">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                    <div class="timeline-item-content">
                                        <div class="fw-bold">Technician Assigned</div>
                                        <div class="text-muted small">{{ $booking->updated_at ? $booking->updated_at->format('d M Y H:i') : '-' }}</div>
                                        <div class="text-muted mt-2">{{ $booking->technician ? $booking->technician->user->name : 'A technician' }} was assigned to this booking.</div>
                                    </div>
                                </div>
                            @endif

                            @if($booking->status === 'completed')
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-indicator bg-info">
                                            <i class="fas fa-check-double"></i>
                                        </div>
                                    </div>
                                    <div class="timeline-item-content">
                                        <div class="fw-bold">Service Completed</div>
                                        <div class="text-muted small">{{ $booking->updated_at ? $booking->updated_at->format('d M Y H:i') : '-' }}</div>
                                        <div class="text-muted mt-2">The service was successfully completed.</div>
                                    </div>
                                </div>
                            @endif

                            @if($booking->status === 'cancelled')
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-indicator bg-danger">
                                            <i class="fas fa-times"></i>
                                        </div>
                                    </div>
                                    <div class="timeline-item-content">
                                        <div class="fw-bold">Booking Cancelled</div>
                                        <div class="text-muted small">{{ $booking->updated_at ? $booking->updated_at->format('d M Y H:i') : '-' }}</div>
                                        <div class="text-muted mt-2">This booking was cancelled.</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Payment & Verification Section -->
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-3" 
                         style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-credit-card fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Payment Status</h6>
                        <small class="text-muted">E-Wallet Payment & Verification</small>
                    </div>
                </div>
                <div class="ps-5 mb-4">
                    <div class="mb-2">
                        <span class="text-muted">Status Pembayaran:</span>
                        <span class="fw-bold ms-2">
                            @if($booking->is_paid)
                                <span class="badge bg-success">Paid</span>
                            @elseif($booking->payment_proof)
                                <span class="badge bg-warning text-dark">Waiting Verification</span>
                            @else
                                <span class="badge bg-danger">Unpaid</span>
                            @endif
                        </span>
                    </div>
                    @if($booking->ewallet_type)
                        <div class="mb-2">
                            <span class="text-muted">E-Wallet:</span>
                            <span class="fw-bold ms-2 text-uppercase">{{ $booking->ewallet_type }}</span>
                        </div>
                    @endif
                    @if($booking->payment_proof)
                        <div class="mb-2">
                            <span class="text-muted">Payment Proof:</span>
                            <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" class="ms-2">
                                <img src="{{ asset('storage/' . $booking->payment_proof) }}" alt="Payment Proof" style="max-width: 120px; max-height: 120px; border-radius: 8px; border: 1px solid #eee;">
                            </a>
                        </div>
                    @endif
                    @if($booking->payment_proof && !$booking->is_paid)
                        <form action="{{ route('admin.bookings.verify-payment', $booking) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle me-2"></i>Verifikasi Pembayaran
                            </button>
                        </form>
                    @endif
                    @if($booking->is_paid)
                        <div class="d-grid mb-4">
                            <a href="{{ route('bookings.invoice', $booking) }}" class="btn btn-outline-primary btn-lg" target="_blank">
                                <i class="fas fa-file-invoice me-2"></i>Lihat Invoice
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Repair Report Section -->
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-3" 
                         style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-tools fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Repair Report</h6>
                        <small class="text-muted">Laporan hasil perbaikan oleh teknisi</small>
                    </div>
                </div>
                <div class="ps-5 mb-4">
                    @if($booking->repair_report)
                        <div class="alert alert-success">
                            <strong>Laporan Perbaikan:</strong><br>
                            <div class="mt-2">{!! nl2br(e($booking->repair_report)) !!}</div>
                        </div>
                        @if($booking->serviceComponents->count() > 0)
                            <div class="alert alert-info mt-3">
                                <strong>Komponen yang Diganti:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($booking->serviceComponents as $component)
                                        <li>{{ $component->name }} ({{ $component->pivot->quantity }}x) - Rp {{ number_format($component->pivot->price_at_time, 0, ',', '.') }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">Laporan perbaikan akan muncul di sini setelah diisi oleh teknisi.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Timeline styling */
        .timeline {
            position: relative;
            padding-left: 1.5rem;
        }
        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0.75rem;
            height: 100%;
            width: 1px;
            background-color: #e3e6ec;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 2rem;
        }
        .timeline-item:last-child {
            padding-bottom: 0;
        }
        .timeline-item-marker {
            position: absolute;
            left: -1.5rem;
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .timeline-item-marker-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 100%;
            color: #fff;
        }
        .timeline-item-content {
            padding-left: 0.75rem;
        }
    </style>
</x-app-layout>

                        <hr class="my-4">

                        <!-- Total Price Breakdown -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-3" 
                                 style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-calculator fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Total Harga</h6>
                                <small class="text-muted">Breakdown biaya lengkap</small>
                            </div>
                        </div>
                        <div class="ps-5 mb-4">
                            <div class="card border-0 bg-light">
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted">Harga Service Dasar:</span>
                                                <span class="fw-bold">Rp {{ number_format($booking->service->price ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                            
                                            @if(in_array($booking->service_type, ['pickup', 'onsite']))
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="text-muted">Biaya {{ ucfirst($booking->service_type) }}:</span>
                                                    <span class="fw-bold">Rp {{ number_format(50000, 0, ',', '.') }}</span>
                                                </div>
                                            @endif
                                            
                                            @if($booking->is_emergency)
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="text-muted">Biaya Emergency:</span>
                                                    <span class="fw-bold text-danger">Rp {{ number_format(100000, 0, ',', '.') }}</span>
                                                </div>
                                            @endif
                                            
                                            @if($booking->serviceComponents && $booking->serviceComponents->count() > 0)
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="text-muted">Komponen Tambahan:</span>
                                                    <span class="fw-bold">Rp {{ number_format($booking->serviceComponents->sum(function($component) { return $component->pivot->quantity * $component->pivot->price_at_time; }), 0, ',', '.') }}</span>
                                                </div>
                                                <div class="ms-3 mb-2">
                                                    @foreach($booking->serviceComponents as $component)
                                                        <small class="text-muted d-block">• {{ $component->name }} ({{ $component->pivot->quantity }}x) - Rp {{ number_format($component->pivot->price_at_time, 0, ',', '.') }}</small>
                                                    @endforeach
                                                </div>
                                            @endif
                                            
                                            @if($booking->loyalty_points_used > 0)
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="text-muted">Diskon Loyalty Points ({{ $booking->loyalty_points_used }} pts):</span>
                                                    <span class="fw-bold text-success">-Rp {{ number_format($booking->loyalty_points_used * 100, 0, ',', '.') }}</span>
                                                </div>
                                            @endif
                                            
                                            <hr class="my-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="h6 fw-bold mb-0">Total Harga:</span>
                                                <span class="h5 fw-bold text-primary mb-0">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>