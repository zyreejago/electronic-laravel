@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Detail') }}
        </h2>
        <a href="{{ route('technician.bookings.index') }}" class="btn btn-outline-success btn-lg shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Back to Bookings
        </a>
    </div>

    <div class="container py-4">
        <!-- Booking Status Banner -->
        <div class="card border-0 shadow mb-4 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="d-flex align-items-center p-4" style="background: linear-gradient(135deg, 
                    {{ $booking->status === 'pending' ? '#f6c23e, #dda20a' : 
                       ($booking->status === 'in_progress' ? '#4e73df, #224abe' : 
                       ($booking->status === 'completed' ? '#1cc88a, #13855c' : '#e74a3b, #be2617')) }});">
                    <div class="rounded-circle bg-white p-3 me-4">
                        <i class="fas fa-{{ $booking->status === 'pending' ? 'clock' : 
                                          ($booking->status === 'in_progress' ? 'spinner' : 
                                          ($booking->status === 'completed' ? 'check-double' : 'times-circle')) }} fa-2x" 
                           style="color: {{ $booking->status === 'pending' ? '#dda20a' : 
                                          ($booking->status === 'in_progress' ? '#224abe' : 
                                          ($booking->status === 'completed' ? '#13855c' : '#be2617')) }};"></i>
                    </div>
                    <div class="text-white">
                        <h4 class="fw-bold mb-1">Booking #{{ $booking->id }}</h4>
                        <div class="fs-5">
                            Status: <span class="fw-bold">{{ ucfirst($booking->status) }}</span>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-light btn-lg shadow-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog me-2"></i>Actions
                            </button>
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
                                        {{ substr($booking->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Customer Information</h6>
                                        <small class="text-muted">Booking made by</small>
                                    </div>
                                </div>
                                <div class="ps-5 mb-4">
                                    <div class="mb-2">
                                        <span class="text-muted">Name:</span>
                                        <span class="fw-bold ms-2">{{ $booking->user->name }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">Email:</span>
                                        <span class="fw-bold ms-2">{{ $booking->user->email }}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Phone:</span>
                                        <span class="fw-bold ms-2">{{ $booking->user->phone ?? 'Not provided' }}</span>
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
                                        <h6 class="fw-bold mb-0">Service Information</h6>
                                        <small class="text-muted">Service details</small>
                                    </div>
                                </div>
                                <div class="ps-5 mb-4">
                                    <div class="mb-2">
                                        <span class="text-muted">Service:</span>
                                        <span class="fw-bold ms-2">{{ $booking->service->name }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">Price:</span>
                                        <span class="fw-bold ms-2">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Service Type:</span>
                                        <span class="fw-bold ms-2">{{ ucfirst($booking->service_type) }}</span>
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

                <!-- Service Checklist -->
                <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
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
                </div>

                <!-- Required Parts -->
                <!-- <div class="card border-0 shadow rounded-4 overflow-hidden">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #f6c23e, #dda20a);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-tools me-2"></i>Required Parts
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control border-0 shadow-sm" placeholder="Add a required part..." id="newPartInput">
                                <button class="btn btn-warning" type="button" id="addPartBtn">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <ul class="list-group" id="partsList">
                            <!-- Parts will be added here dynamically -->
                        <!-- </ul>
                        
                        <div class="text-center py-3" id="noPartsMessage">
                            <p class="text-muted mb-0">No parts added yet. Add parts that are required for this service.</p>
                        </div>
                    </div> -->
                <!-- </div> --> 
            </div>
        </div>
    </div>

    @push('scripts')
    <style>
        .dropdown-menu { z-index: 1055 !important; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Parts list functionality
            const newPartInput = document.getElementById('newPartInput');
            const addPartBtn = document.getElementById('addPartBtn');
            const partsList = document.getElementById('partsList');
            const noPartsMessage = document.getElementById('noPartsMessage');
            
            addPartBtn.addEventListener('click', function() {
                const partName = newPartInput.value.trim();
                if (partName) {
                    // Hide the "no parts" message
                    noPartsMessage.style.display = 'none';
                    
                    // Create new list item
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    
                    // Part name with checkbox
                    const partDiv = document.createElement('div');
                    partDiv.className = 'd-flex align-items-center';
                    
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.className = 'form-check-input me-2';
                    
                    const partText = document.createElement('span');
                    partText.textContent = partName;
                    
                    partDiv.appendChild(checkbox);
                    partDiv.appendChild(partText);
                    
                    // Delete button
                    const deleteBtn = document.createElement('button');
                    deleteBtn.className = 'btn btn-sm btn-outline-danger';
                    deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
                    deleteBtn.addEventListener('click', function() {
                        li.remove();
                        if (partsList.children.length === 0) {
                            noPartsMessage.style.display = 'block';
                        }
                    });
                    
                    li.appendChild(partDiv);
                    li.appendChild(deleteBtn);
                    
                    partsList.appendChild(li);
                    newPartInput.value = '';
                }
            });
            
            // Allow pressing Enter to add a part
            newPartInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addPartBtn.click();
                }
            });
        });
    </script>
    @endpush

    <script>
    function updateProgressValue(value) {
        document.getElementById('progressValue').textContent = value + '%';
    }
    </script>
@endsection