@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Booking') }}
            </h2>
            <a href="{{ route('technician.bookings.index') }}" class="btn btn-outline-success btn-lg shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>{{ __('Kembali ke Booking') }}
            </a>
        </div>

        <!-- Booking Status Banner -->
        <div class="card border-0 shadow mb-4 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="d-flex align-items-center p-4" style="background: linear-gradient(135deg, 
                    {{ $booking->status === 'pending' ? '#f6c23e, #dda20a' : 
                       ($booking->status === 'in_progress' ? '#4e73df, #224abe' : 
                       ($booking->status === 'completed' ? '#1cc88a, #13855c' : '#e74a3b, #be2617')) }});">
                    <div class="rounded-circle bg-white p-3 me-4">
                        <i class="fas fa-{{ $booking->status === 'pending' ? 'clock' : 
                                          ($booking->status === 'in_progress' ? 'spinner fa-spin' : 
                                          ($booking->status === 'completed' ? 'check-double' : 'times-circle')) }} fa-2x" 
                           style="color: {{ $booking->status === 'pending' ? '#dda20a' : 
                                          ($booking->status === 'in_progress' ? '#224abe' : 
                                          ($booking->status === 'completed' ? '#13855c' : '#be2617')) }};"></i>
                    </div>
                    <div class="text-white">
                        <h4 class="fw-bold mb-1">Booking #{{ $booking->id }}</h4>
                        <div class="fs-5">
                            Status: <span class="fw-bold">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <div class="dropdown">
                            {{-- <button class="btn btn-light btn-lg shadow-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog me-2"></i>Actions
                            </button> --}}
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#status-update-section"><i class="fas fa-edit me-2"></i> Update Status</a></li>
                                @if($booking->service_type !== 'dropoff')
                                    <li><a class="dropdown-item" href="#address-section"><i class="fas fa-map-marker-alt me-2"></i> View Address</a></li>
                                @endif
                                <li><a class="dropdown-item" href="#"><i class="fas fa-phone me-2"></i> Contact Customer</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-exclamation-circle me-2"></i> Report Issue</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Booking Information -->
            <div class="col-lg-8">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-info-circle me-2"></i>{{ __('Informasi Booking') }}
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
                                        {{ substr($booking->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ __('Informasi Pelanggan') }}</h6>
                                        <small class="text-muted">{{ __('Booking dibuat oleh') }}</small>
                                    </div>
                                </div>
                                <div class="ps-5 mb-4">
                                    <div class="mb-2">
                                        <span class="text-muted">{{ __('Nama:') }}</span>
                                        <span class="fw-bold ms-2">{{ $booking->user->name }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">{{ __('Email:') }}</span>
                                        <span class="fw-bold ms-2">{{ $booking->user->email }}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">{{ __('Telepon:') }}</span>
                                        <span class="fw-bold ms-2">{{ $booking->user->phone_number ?? __('Tidak disediakan') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Information -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-3" 
                                         style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-tools fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ __('Informasi Layanan') }}</h6>
                                        <small class="text-muted">{{ __('Detail layanan') }}</small>
                                    </div>
                                </div>
                                <div class="ps-5 mb-4">
                                    <div class="mb-2">
                                        <span class="text-muted">{{ __('Layanan:') }}</span>
                                        <span class="fw-bold ms-2">{{ $booking->service->name }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">{{ __('Total Harga:') }}</span>
                                        @if($booking->inspection_completed_at && $booking->estimated_cost)
                                            <span class="fw-bold ms-2">Rp {{ number_format($booking->estimated_cost, 0, ',', '.') }}</span>
                                        @else
                                            <span class="fw-bold ms-2 text-muted">Belum ada pemeriksaan</span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-muted">{{ __('Jenis Layanan:') }}</span>
                                        <span class="fw-bold ms-2">{{ ucfirst($booking->service_type) }}</span>
                                    </div>
                                    @if($booking->is_emergency)
                                        <div class="mt-2">
                                            <span class="badge bg-danger"><i class="fas fa-bolt me-1"></i>{{ __('Layanan Darurat (+Rp 100,000)') }}</span>
                                        </div>
                                    @endif
                                    @if(in_array($booking->service_type, ['pickup', 'onsite']))
                                        <div class="mt-2">
                                            <span class="badge bg-info">{{ ucfirst($booking->service_type) }} {{ __('Layanan (+Rp 50,000)') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Total Price Breakdown -->
                        @if($booking->inspection_completed_at && $booking->estimated_cost)
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-3" 
                                     style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-calculator fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">{{ __('Rincian Total Harga') }}</h6>
                                    <small class="text-muted">{{ __('Perhitungan biaya detail') }}</small>
                                </div>
                            </div>
                            <div class="ps-5 mb-4">
                                <div class="p-3 bg-light rounded-3">
                                    <div class="row g-2 small">
                                        <div class="col-8 text-muted">{{ __('Estimasi Biaya Layanan:') }}</div>
                                        <div class="col-4 text-end fw-bold">Rp {{ number_format($estimatedCost, 0, ',', '.') }}</div>
                                        
                                        @if($inventoryCost > 0)
                                            <div class="col-8 text-muted">{{ __('Biaya Inventori:') }}</div>
                                            <div class="col-4 text-end fw-bold">Rp {{ number_format($inventoryCost, 0, ',', '.') }}</div>
                                        @endif
                                        
                                        @if($serviceComponentsCost > 0)
                                            <div class="col-8 text-muted">{{ __('Komponen Layanan:') }}</div>
                                            <div class="col-4 text-end fw-bold">Rp {{ number_format($serviceComponentsCost, 0, ',', '.') }}</div>
                                        @endif
                                        
                                        @if($deliveryFee > 0)
                                            <div class="col-8 text-muted">{{ ucfirst($booking->service_type) }} {{ __('Biaya:') }}</div>
                                            <div class="col-4 text-end fw-bold">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</div>
                                        @endif
                                        
                                        @if($emergencyFee > 0)
                                            <div class="col-8 text-muted">{{ __('Biaya Darurat:') }}</div>
                                            <div class="col-4 text-end fw-bold">Rp {{ number_format($emergencyFee, 0, ',', '.') }}</div>
                                        @endif
                                        
                                        @if($loyaltyDiscount > 0)
                                            <div class="col-8 text-muted text-success">{{ __('Diskon Poin Loyalitas:') }}</div>
                                            <div class="col-4 text-end fw-bold text-success">-Rp {{ number_format($loyaltyDiscount, 0, ',', '.') }}</div>
                                        @endif
                                        
                                        <hr class="my-2">
                                        <div class="col-8 fw-bold text-primary">{{ __('Total Jumlah:') }}</div>
                                        <div class="col-4 text-end fw-bold text-primary h6">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Initial Inspection Information -->
                        @if($booking->inspection_completed_at)
                            <div class="mb-4 p-4 bg-light rounded border">
                                <h6 class="mb-3">
                                    <i class="fas fa-search text-primary me-2"></i>
                                    <strong>Informasi Inspeksi Awal</strong>
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <small class="text-muted">Tanggal Inspeksi:</small><br>
                                            <span class="fw-medium">{{ $booking->inspection_completed_at->format('d M Y, H:i') }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted">Kategori Kerusakan:</small><br>
                                            <span class="fw-medium">{{ $booking->damage_category ?? '-' }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted">Estimasi Durasi:</small><br>
                                            <span class="fw-medium">{{ $booking->estimated_duration_hours ? $booking->estimated_duration_hours . ' jam' : '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <small class="text-muted">Estimasi Biaya:</small><br>
                                            <span class="fw-medium text-success">Rp {{ number_format($booking->estimated_cost ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted">Status Inspeksi:</small><br>
                                            <span class="badge bg-success">Selesai</span>
                                        </div>
                                        @if($booking->inspectedBy)
                                            <div class="mb-2">
                                                <small class="text-muted">Diperiksa oleh:</small><br>
                                                <span class="fw-medium">{{ $booking->inspectedBy->name }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if($booking->damage_description)
                                    <div class="mt-3">
                                        <small class="text-muted">Deskripsi Kerusakan:</small><br>
                                        <div class="p-2 bg-white rounded border">
                                            {{ $booking->damage_description }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="mb-4 p-4 bg-light rounded border">
                                <h6 class="mb-3">
                                    <i class="fas fa-clock text-warning me-2"></i>
                                    <strong>Informasi Inspeksi Awal</strong>
                                </h6>
                                <div class="text-center py-3">
                                    <i class="fas fa-hourglass-half text-warning fa-2x mb-2"></i>
                                    <p class="text-muted mb-0">Inspeksi awal belum dilakukan oleh admin</p>
                                    <small class="text-muted">Menunggu admin untuk melakukan inspeksi dan estimasi biaya</small>
                                </div>
                            </div>
                        @endif

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
                                        <span class="fw-bold ms-2">{{ $booking->scheduled_at->format('d M Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Scheduled Time:</span>
                                        <span class="fw-bold ms-2">{{ $booking->scheduled_at->format('H:i') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <span class="text-muted">Created At:</span>
                                        <span class="fw-bold ms-2">{{ $booking->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Last Updated:</span>
                                        <span class="fw-bold ms-2">{{ $booking->updated_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($booking->address)
                        <hr class="my-4">

                        <!-- Address Information -->
                        <div class="d-flex align-items-center mb-3" id="address-section">
                            <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2 me-3" 
                                 style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-map-marker-alt fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Address Information</h6>
                                <small class="text-muted">For pickup or on-site service</small>
                            </div>
                        </div>
                        <div class="ps-5 mb-4">
                            <div class="p-3 rounded-3 bg-light">
                                {{ $booking->address }}
                            </div>
                            <div class="mt-3">
                                <a href="https://maps.google.com/?q={{ urlencode($booking->address) }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="fas fa-map-marked-alt me-2"></i>Open in Google Maps
                                </a>
                            </div>
                        </div>
                        @endif

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

            <!-- Status Update and Checklist -->
            <div class="col-lg-4">
                <!-- Status Update -->
                <div class="card border-0 shadow rounded-4 overflow-hidden mb-4" id="status-update-section">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-edit me-2"></i>Update Status
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('technician.bookings.update-status', $booking) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="status" class="form-label fw-bold text-primary">Current Status</label>
                                <select name="status" id="status" class="form-select form-select-lg border-0 shadow-sm">
                                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $booking->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label for="notes" class="form-label fw-bold text-primary">Status Notes (Optional)</label>
                                <textarea name="notes" id="notes" class="form-control border-0 shadow-sm" rows="3" placeholder="Add notes about the current status..."></textarea>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Inventory Usage -->
                <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #f6c23e, #dda20a);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-boxes me-2"></i>Inventory Usage
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Quick Add Inventory -->
                        <div class="mb-4">
                            <button type="button" class="btn btn-warning btn-lg w-100" data-bs-toggle="modal" data-bs-target="#inventoryModal">
                                <i class="fas fa-plus me-2"></i>Add Inventory Item
                            </button>
                        </div>

                        <!-- Used Items List -->
                        @if($booking->inventoryUsages && $booking->inventoryUsages->count() > 0)
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-3">Items Used:</h6>
                                @foreach($booking->inventoryUsages as $usage)
                                    <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded-3">
                                        <div>
                                            <div class="fw-bold">{{ $usage->inventoryItem->name }}</div>
                                            <small class="text-muted">Qty: {{ $usage->quantity_used }} | {{ $usage->used_at->format('d M Y H:i') }}</small>
                                            @if($usage->notes)
                                                <div class="text-muted small mt-1">{{ $usage->notes }}</div>
                                            @endif
                                        </div>
                                        <span class="badge bg-success">Used</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No inventory items used yet for this booking.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Service Checklist -->
                {{-- <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-tasks me-2"></i>Service Checklist
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert border-0 p-3 mb-4" style="background: rgba(78, 115, 223, 0.1); color: #4e73df; border-left: 4px solid #4e73df;">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div>
                                    <p class="mb-0">Use this checklist to track your progress on this service.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="checklist">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="check1">
                                <label class="form-check-label" for="check1">Initial assessment completed</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="check2">
                                <label class="form-check-label" for="check2">Required parts identified</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="check3">
                                <label class="form-check-label" for="check3">Customer approval obtained</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="check4">
                                <label class="form-check-label" for="check4">Repair/service completed</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="check5">
                                <label class="form-check-label" for="check5">Quality check performed</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check6">
                                <label class="form-check-label" for="check6">Customer notified</label>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <!-- Inventory Usage Modal -->
    <div class="modal fade" id="inventoryModal" tabindex="-1" aria-labelledby="inventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(90deg, #f6c23e, #dda20a);">
                    <h5 class="modal-title text-white fw-bold" id="inventoryModalLabel">
                        <i class="fas fa-boxes me-2"></i>Use Inventory Item
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('technician.inventory.use') }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="inventory_item_id" class="form-label fw-bold">Select Item</label>
                                <select name="inventory_item_id" id="inventory_item_id" class="form-select" required>
                                    <option value="">Choose inventory item...</option>
                                    @php
                                        $availableItems = \App\Models\InventoryItem::where('status', 'Tersedia')
                                            ->where('stock_quantity', '>', 0)
                                            ->get();
                                    @endphp
                                    @foreach($availableItems as $item)
                                        <option value="{{ $item->id }}" data-stock="{{ $item->stock_quantity }}">
                                            {{ $item->name }} (Stock: {{ $item->stock_quantity }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="quantity_used" class="form-label fw-bold">Quantity Used</label>
                                <input type="number" name="quantity_used" id="quantity_used" class="form-control" min="1" required>
                                <div class="form-text">Available stock will be shown after selecting item</div>
                            </div>
                            <div class="col-12">
                                <label for="usage_notes" class="form-label fw-bold">Notes (Optional)</label>
                                <textarea name="notes" id="usage_notes" class="form-control" rows="3" placeholder="Add notes about the usage..."></textarea>
                            </div>
                            <div class="col-12">
                                <label for="reason" class="form-label fw-bold">Reason for Additional Inventory <span class="text-danger">*</span></label>
                                <textarea name="reason" id="reason" class="form-control" rows="3" placeholder="Explain why this inventory item is needed..." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-check me-2"></i>Use Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .dropdown-menu { 
        z-index: 1055 !important; 
    }
    
    .fa-spin {
        animation: fa-spin 2s infinite linear;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update max quantity based on selected item
        const inventorySelect = document.getElementById('inventory_item_id');
        const quantityInput = document.getElementById('quantity_used');
        
        if (inventorySelect && quantityInput) {
            inventorySelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const stock = selectedOption.getAttribute('data-stock');
                
                if (stock) {
                    quantityInput.max = stock;
                    quantityInput.placeholder = `Max: ${stock}`;
                }
            });
        }
    });
</script>
@endpush