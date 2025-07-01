<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Booking Detail') }}
            </h2>
            <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary btn-lg shadow-sm">
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
                        <h4 class="fw-bold mb-1">Booking #{{ $booking->id }}
                            @if($booking->is_emergency)
                                <span class="badge bg-danger ms-2"><i class="fas fa-bolt me-1"></i>Emergency</span>
                            @endif
                        </h4>
                        <div class="fs-5">
                            Status: <span class="fw-bold">{{ ucfirst($booking->status) }}</span>
                            @if($booking->status_updated_by)
                                <small class="d-block mt-1">
                                    Updated by: {{ $booking->statusUpdater->name }}
                                </small>
                            @endif
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
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" 
                                         style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Customer Information</h6>
                                        <small class="text-muted">Booking details</small>
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
                                        <span class="fw-bold ms-2">{{ $booking->service->name }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">Price:</span>
                                        @if($booking->inspection_completed_at && $booking->estimated_cost)
                                            <span class="fw-bold ms-2">Rp {{ number_format($booking->estimated_cost, 0, ',', '.') }}</span>
                                        @else
                                            <span class="fw-bold ms-2 text-muted">Menunggu pemeriksaan awal</span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-muted">Service Type:</span>
                                        <span class="fw-bold ms-2">{{ ucfirst($booking->service_type) }}</span>
                                    </div>
                                    @if($booking->status === 'pending' && auth()->user()->role === 'user' && auth()->id() === $booking->user_id)
                                        <div class="mt-3">
                                            <form action="{{ route('loyalty-points.use', $booking) }}" method="POST" class="d-flex align-items-center">
                                                @csrf
                                                <div class="me-2">
                                                    <label for="points" class="form-label mb-0">Use Loyalty Points:</label>
                                                    <input type="number" name="points" id="points" class="form-control form-control-sm" 
                                                           min="0" max="{{ auth()->user()->loyaltyPoints->sum('points') }}" 
                                                           value="0" style="width: 100px;">
                                                </div>
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-star me-1"></i>Redeem
                                                </button>
                                            </form>
                                            <small class="text-muted">Available points: {{ auth()->user()->loyaltyPoints->sum('points') }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- <hr class="my-4"> --}}

                        <!-- Service Components and Costs -->
                        {{-- <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-3" 
                                 style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-list-alt fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Service Components & Costs</h6>
                                <small class="text-muted">Detailed breakdown of costs</small>
                            </div>
                        </div> --}}
                        <div class="ps-5 mb-4">
                            <!-- Base Service Cost - Hapus atau comment bagian ini -->
                            {{-- <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Base Service Cost:</span>
                                    <span class="fw-bold">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</span>
                                </div>
                            </div> --}}

                            <!-- Service Components -->
                            @if($booking->serviceComponents->count() > 0)
                                <div class="mb-3">
                                    <div class="text-muted mb-2">Replaced Components:</div>
                                    @foreach($booking->serviceComponents as $component)
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">
                                                {{ $component->name }} ({{ $component->pivot->quantity }}x)
                                            </span>
                                            <span class="fw-bold">
                                                Rp {{ number_format($component->pivot->quantity * $component->pivot->price_at_time, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Inventory/Spare Parts Cost -->
                            {{-- @if($booking->inventoryUsages->count() > 0)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Spare Parts Cost:</span>
                                        <span class="fw-bold">Rp {{ number_format($booking->inventory_cost, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endif --}}

                            <!-- Delivery Fee -->
                            {{-- @if($booking->service_type === 'pickup' || $booking->service_type === 'onsite')
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Delivery Fee:</span>
                                        <span class="fw-bold">Rp {{ number_format(50000, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Loyalty Points Discount -->
                            @if($booking->loyalty_points_used)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Loyalty Points Discount:</span>
                                        <span class="fw-bold text-success">- Rp {{ number_format($booking->loyalty_points_used * 100, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endif --}}

                            {{-- <hr class="my-3"> --}}

                            <!-- Total Cost -->
                            {{-- <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Total Cost:</span>
                                @if($booking->inspection_completed_at && $booking->estimated_cost)
                                    @php
                                        $serviceComponentsCost = $booking->serviceComponents->sum(function($c) { 
                                            return $c->pivot->quantity * $c->pivot->price_at_time; 
                                        });
                                        $inventoryCost = $booking->inventory_cost ?? 0;
                                        $estimatedCost = $booking->estimated_cost ?? 0;
                                        $deliveryFee = 0;
                                        $emergencyFee = 0;
                                        
                                        if($booking->service_type === 'pickup' || $booking->service_type === 'onsite') {
                                            $deliveryFee = 50000;
                                        }
                                        
                                        if($booking->is_emergency) {
                                            $emergencyFee = 100000;
                                        }
                                        
                                        $totalCost = $estimatedCost + $inventoryCost + $serviceComponentsCost + $deliveryFee + $emergencyFee - (($booking->loyalty_points_used ?? 0) * 100);
                                    @endphp
                                    <span class="fw-bold fs-5">Rp {{ number_format($totalCost, 0, ',', '.') }}</span>
                                @else
                                    <span class="fw-bold fs-5 text-muted">Menunggu pemeriksaan awal</span>
                                @endif
                            </div> --}}
                        </div>

                        <!-- Inventory Usage Section -->
                        @if($booking->inventoryUsages->count() > 0)
                            <hr class="my-4">
                            
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2 me-3" 
                                     style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-boxes fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Spare Parts yang Digunakan</h6>
                                    <small class="text-muted">Inventory items used during service</small>
                                </div>
                            </div>
                            
                            <div class="ps-5 mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total Price</th>
                                                <th>Status</th>
                                                <th>Technician</th>
                                                <th>Used At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($booking->inventoryUsages as $usage)
                                                <tr class="{{ $usage->status === 'pending_approval' ? 'table-warning' : '' }}">
                                                    <td>{{ $usage->inventoryItem ? $usage->inventoryItem->name : 'Item Tidak Ditemukan' }}</td>
                                                    <td>{{ $usage->quantity_used }}</td>
                                                    <td>Rp {{ $usage->inventoryItem ? number_format($usage->inventoryItem->unit_price, 0, ',', '.') : '0' }}</td>
                                                    <td>Rp {{ $usage->inventoryItem ? number_format($usage->quantity_used * $usage->inventoryItem->unit_price, 0, ',', '.') : '0' }}</td>
                                                    <td>
                                                        @if($usage->status === 'pending_approval')
                                                            <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Pending Approval</span>
                                                        @elseif($usage->status === 'approved')
                                                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Approved</span>
                                                        @elseif($usage->status === 'rejected')
                                                            <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Rejected</span>
                                                        @else
                                                            <span class="badge bg-info"><i class="fas fa-info me-1"></i>Used</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $usage->technician ? $usage->technician->user->name : 'N/A' }}</td>
                                                    <td>{{ $usage->used_at ? $usage->used_at->format('d M Y H:i') : 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="3" class="fw-bold">Total Biaya Spare Parts:</td>
                                                <td class="fw-bold">Rp {{ number_format($booking->inventory_cost, 0, ',', '.') }}</td>
                                                <td colspan="3"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- Pending Inventory Approval Section -->
                        @php
                            $pendingInventoryUsages = $booking->inventoryUsages->where('status', 'pending_approval');
                        @endphp
                        @if($pendingInventoryUsages->count() > 0 && auth()->user()->role === 'user' && auth()->id() === $booking->user_id)
                            <hr class="my-4">
                            
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-2 me-3" 
                                     style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Persetujuan Spare Parts Tambahan</h6>
                                    <small class="text-muted">Teknisi memerlukan persetujuan untuk menggunakan spare parts tambahan</small>
                                </div>
                            </div>
                            
                            <div class="ps-5 mb-4">
                                @foreach($pendingInventoryUsages as $usage)
                                    <div class="card border-warning mb-3">
                                        <div class="card-header bg-warning bg-opacity-10">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0 fw-bold">{{ $usage->inventoryItem ? $usage->inventoryItem->name : 'Item Tidak Ditemukan' }}</h6>
                                                <span class="badge bg-warning">Menunggu Persetujuan</span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-2"><strong>Quantity:</strong> {{ $usage->quantity_used }}</p>
                                                    <p class="mb-2"><strong>Unit Price:</strong> Rp {{ $usage->inventoryItem ? number_format($usage->inventoryItem->unit_price, 0, ',', '.') : '0' }}</p>
                                                    <p class="mb-2"><strong>Total Cost:</strong> Rp {{ $usage->inventoryItem ? number_format($usage->quantity_used * $usage->inventoryItem->unit_price, 0, ',', '.') : '0' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-2"><strong>Technician:</strong> {{ $usage->technician ? $usage->technician->user->name : 'N/A' }}</p>
                                                    <p class="mb-2"><strong>Requested At:</strong> {{ $usage->created_at ? $usage->created_at->format('d M Y H:i') : 'N/A' }}</p>
                                                    @if($usage->notes)
                                                        <p class="mb-2"><strong>Notes:</strong> {{ $usage->notes }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($usage->reason)
                                                <div class="alert alert-info mt-3">
                                                    <strong>Reason for Additional Inventory:</strong><br>
                                                    {{ $usage->reason }}
                                                </div>
                                            @endif
                                            <div class="d-flex gap-2 mt-3">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $usage->id }}">
                                    <i class="fas fa-check me-1"></i>Setujui
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $usage->id }}">
                                    <i class="fas fa-times me-1"></i>Tolak
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Approve Modal -->
                    <div class="modal fade" id="approveModal{{ $usage->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-success bg-opacity-10">
                                    <h5 class="modal-title text-success">
                                        <i class="fas fa-check me-2"></i>Setujui Penggunaan Spare Part
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('inventory-usage.approve', $usage) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="alert alert-success border-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <div>
                                                    <strong>Konfirmasi Persetujuan</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <p>Anda akan menyetujui penggunaan spare part:</p>
                                        <div class="card border-success">
                                            <div class="card-body">
                                                <h6 class="card-title text-success">{{ $usage->inventoryItem ? $usage->inventoryItem->name : 'Item Tidak Ditemukan' }}</h6>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <small class="text-muted">Quantity:</small><br>
                                                        <strong>{{ $usage->quantity_used }}</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted">Total Cost:</small><br>
                                                        <strong>Rp {{ $usage->inventoryItem ? number_format($usage->quantity_used * $usage->inventoryItem->unit_price, 0, ',', '.') : '0' }}</strong>
                                                    </div>
                                                </div>
                                                @if($usage->reason)
                                                    <div class="mt-2">
                                                        <small class="text-muted">Alasan:</small><br>
                                                        <span class="text-dark">{{ $usage->reason }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-0">Biaya ini akan ditambahkan ke total tagihan Anda.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i>Batal
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check me-1"></i>Ya, Setujui
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Reject Modal -->
                    <div class="modal fade" id="rejectModal{{ $usage->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tolak Penggunaan Spare Part</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('inventory-usage.reject', $usage) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <p>Anda akan menolak penggunaan spare part: <strong>{{ $usage->inventoryItem ? $usage->inventoryItem->name : 'Item Tidak Ditemukan' }}</strong></p>
                                        <div class="mb-3">
                                            <label for="rejection_reason{{ $usage->id }}" class="form-label">Alasan Penolakan:</label>
                                            <textarea class="form-control" id="rejection_reason{{ $usage->id }}" name="rejection_reason" rows="3" required placeholder="Berikan alasan mengapa Anda menolak penggunaan spare part ini..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Tolak</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                            </div>
                        @endif

                        <hr class="my-4">

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
                            @else
                                <div class="alert alert-info">Laporan perbaikan akan muncul di sini setelah diisi oleh teknisi.</div>
                            @endif
                        </div>

                        <hr class="my-4">

                        <!-- Initial Inspection Section -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" 
                                 style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-search fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Pemeriksaan Awal</h6>
                                <small class="text-muted">Hasil pemeriksaan awal oleh teknisi</small>
                            </div>
                        </div>
                        <div class="ps-5 mb-4">
                            @if($booking->inspection_completed_at)
                                <div class="alert alert-success">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <strong>Status:</strong> <span class="badge bg-success">Pemeriksaan Selesai</span><br>
                                            <small class="text-muted">Diselesaikan pada: {{ $booking->inspection_completed_at->format('d M Y H:i') }}</small>
                                        </div>
                                        @if($booking->damage_description)
                                            <div class="col-md-12 mb-3">
                                                <strong>Deskripsi Kerusakan:</strong><br>
                                                <div class="mt-2">{!! nl2br(e($booking->damage_description)) !!}</div>
                                            </div>
                                        @endif
                                        @if($booking->estimated_cost)
                                            <div class="col-md-6 mb-3">
                                                <strong>Estimasi Biaya:</strong><br>
                                                <span class="fs-5 text-primary">Rp {{ number_format($booking->estimated_cost, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                        @if($booking->estimated_duration_hours)
                                            <div class="col-md-6 mb-3">
                                                <strong>Estimasi Durasi:</strong><br>
                                                <span class="fs-5 text-info">{{ $booking->estimated_duration_hours }} jam</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-clock me-2"></i>Pemeriksaan awal belum dilakukan. Teknisi akan melakukan pemeriksaan setelah booking dikonfirmasi.
                                </div>
                            @endif
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
                        <div class="d-flex align-items-center mb-3">
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
                                {{-- <small class="text-muted">Customer's notes</small> --}}
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
                <!-- Technician Information -->
                <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-user-cog me-2"></i>Technician Information
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if($booking->technician)
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                     style="width: 60px; height: 60px; background: linear-gradient(135deg, #1cc88a, #13855c);">
                                    {{ substr($booking->technician->user->name ?? 'T', 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $booking->technician->user->name }}</h6>
                                    <small class="text-muted">{{ $booking->technician->specialization ?? 'Technician' }}</small>
                                </div>
                            </div>
                            
                            @if($booking->rating)
                                <div class="alert border-0 p-3 mb-3" style="background: rgba(246, 194, 62, 0.1); color: #dda20a; border-left: 4px solid #f6c23e;">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Your Rating: {{ $booking->rating->rating }}/5</h6>
                                            @if($booking->rating->review)
                                                <p class="mb-0">"{{ $booking->rating->review }}"</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="alert border-0 p-3" style="background: rgba(28, 200, 138, 0.1); color: #13855c; border-left: 4px solid #1cc88a;">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0">This technician has been assigned to handle your service booking.</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3 mx-auto mb-3" 
                                     style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-clock fa-3x"></i>
                                </div>
                                <h6 class="fw-bold">No Technician Assigned</h6>
                                <p class="text-muted mb-0">A technician will be assigned to your booking soon.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Status Timeline -->
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
                                    <div class="text-muted small">{{ $booking->created_at->format('d M Y H:i') }}</div>
                                    <div class="text-muted mt-2">You created this booking.</div>
                                </div>
                            </div>

                            @if($booking->status !== 'pending')
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-indicator bg-info">
                                            <i class="fas fa-spinner"></i>
                                        </div>
                                    </div>
                                    <div class="timeline-item-content">
                                        <div class="fw-bold">In Progress</div>
                                        <div class="text-muted small">{{ $booking->updated_at->format('d M Y H:i') }}</div>
                                        <div class="text-muted mt-2">Your booking is being processed.</div>
                                    </div>
                                </div>
                            @endif

                            @if($booking->status === 'completed')
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-indicator bg-success">
                                            <i class="fas fa-check-double"></i>
                                        </div>
                                    </div>
                                    <div class="timeline-item-content">
                                        <div class="fw-bold">Service Completed</div>
                                        <div class="text-muted small">{{ $booking->updated_at->format('d M Y H:i') }}</div>
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
                                        <div class="text-muted small">{{ $booking->updated_at->format('d M Y H:i') }}</div>
                                        <div class="text-muted mt-2">This booking was cancelled.</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-4">
                    @if(auth()->user()->role === 'technician' && $booking->technician_id === auth()->user()->technician->id)
                        <div class="card border-0 shadow rounded-4 overflow-hidden">
                            <div class="card-header p-0">
                                <div style="background: linear-gradient(90deg, #36b9cc, #258391);" class="text-white p-4">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-cog me-2"></i>Technician Actions
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('bookings.update-status', $booking) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label for="status" class="form-label fw-bold text-primary">Update Status</label>
                                        <select name="status" id="status" class="form-select form-select-lg border-0 shadow-sm">
                                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ $booking->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i>Update Status
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if($booking->status === 'completed' && !$booking->rating && auth()->user()->role === 'user' && auth()->id() === $booking->user_id)
                        <div class="d-grid">
                            <a href="{{ route('bookings.rate', $booking) }}" class="btn btn-warning btn-lg">
                                <i class="fas fa-star me-2"></i>Rate This Booking
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Payment Information -->
                @if($booking->status === 'pending' && auth()->user()->role === 'user' && auth()->id() === $booking->user_id)
                    <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                        <div class="card-header p-0">
                            <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                                <h5 class="card-title mb-0 fw-bold">
                                    <i class="fas fa-credit-card me-2"></i>Payment Information
                                </h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="card-body p-4">
                                @php
                                    // Perhitungan total yang konsisten
                                    $serviceComponentsCost = $booking->serviceComponents->sum(function($c) { 
                                        return $c->pivot->quantity * $c->pivot->price_at_time; 
                                    });
                                    $inventoryCost = $booking->inventory_cost ?? 0;
                                    $estimatedCost = $booking->estimated_cost ?? 0;
                                    $deliveryFee = 0;
                                    $emergencyFee = 0;
                                    
                                    // Delivery fee
                                    if($booking->service_type === 'pickup' || $booking->service_type === 'onsite') {
                                        $deliveryFee = 50000;
                                    }
                                    
                                    // Emergency fee
                                    if($booking->is_emergency) {
                                        $emergencyFee = 100000;
                                    }
                                    
                                    $subtotal = $estimatedCost + $inventoryCost + $serviceComponentsCost + $deliveryFee + $emergencyFee;
                                    $loyaltyDiscount = ($booking->loyalty_points_used ?? 0) * 100;
                                    $totalAmount = $subtotal - $loyaltyDiscount;
                                @endphp
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Estimated Service Cost:</span>
                                    <span class="fw-bold">Rp {{ number_format($estimatedCost, 0, ',', '.') }}</span>
                                </div>
                                
                                @if($inventoryCost > 0)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Inventory Cost:</span>
                                        <span class="fw-bold">Rp {{ number_format($inventoryCost, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                
                                @if($serviceComponentsCost > 0)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Service Components:</span>
                                        <span class="fw-bold">Rp {{ number_format($serviceComponentsCost, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                
                                @if($deliveryFee > 0)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">{{ $booking->service_type === 'pickup' ? 'Pickup' : 'Onsite' }} Fee:</span>
                                        <span class="fw-bold">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                
                                @if($emergencyFee > 0)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Emergency Fee:</span>
                                        <span class="fw-bold">Rp {{ number_format($emergencyFee, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                
                                @if($loyaltyDiscount > 0)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Loyalty Points Used:</span>
                                        <span class="fw-bold text-success">- Rp {{ number_format($loyaltyDiscount, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Total Amount:</span>
                                    <span class="fw-bold fs-5">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                                </div>
                            <div class="d-grid mt-4">
                                <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                    <i class="fas fa-credit-card me-2"></i>Pay Now
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if($booking->status === 'completed' && !$booking->is_paid && auth()->user()->role === 'user' && auth()->id() === $booking->user_id)
                    <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                        <div class="card-header p-0">
                            <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                                <h5 class="card-title mb-0 fw-bold">
                                    <i class="fas fa-credit-card me-2"></i>Pembayaran E-Wallet
                                </h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('bookings.pay', $booking) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Pilih E-Wallet:</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ewallet_type" id="ewallet_ovo" value="ovo" required {{ old('ewallet_type', $booking->ewallet_type) == 'ovo' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ewallet_ovo">
                                                OVO
                                            </label>
                                            <div class="ewallet-number mt-1 text-muted small" id="ewallet_ovo_number" style="display:none;">
                                                {{ \App\Models\Setting::getValue('ewallet_ovo_number', '-') }}
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ewallet_type" id="ewallet_dana" value="dana" required {{ old('ewallet_type', $booking->ewallet_type) == 'dana' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ewallet_dana">
                                                Dana
                                            </label>
                                            <div class="ewallet-number mt-1 text-muted small" id="ewallet_dana_number" style="display:none;">
                                                {{ \App\Models\Setting::getValue('ewallet_dana_number', '-') }}
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ewallet_type" id="ewallet_gopay" value="gopay" required {{ old('ewallet_type', $booking->ewallet_type) == 'gopay' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ewallet_gopay">
                                                GoPay
                                            </label>
                                            <div class="ewallet-number mt-1 text-muted small" id="ewallet_gopay_number" style="display:none;">
                                                {{ \App\Models\Setting::getValue('ewallet_gopay_number', '-') }}
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ewallet_type" id="ewallet_spay" value="spay" required {{ old('ewallet_type', $booking->ewallet_type) == 'spay' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ewallet_spay">
                                                ShopeePay
                                            </label>
                                            <div class="ewallet-number mt-1 text-muted small" id="ewallet_spay_number" style="display:none;">
                                                {{ \App\Models\Setting::getValue('ewallet_spay_number', '-') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="payment_proof" class="form-label fw-bold">Upload Bukti Transfer:</label>
                                    <input type="file" class="form-control" name="payment_proof" id="payment_proof" accept="image/*" required>
                                    <small class="text-muted">Format gambar (JPG, PNG, dsb).</small>
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-upload me-2"></i>Konfirmasi Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                {{-- @if($booking->is_paid) --}}
                    
                {{-- @endif --}}
            </div>
            <div class="d-grid mb-4">
                        <a href="{{ route('bookings.invoice', $booking) }}" class="btn btn-outline-primary btn-lg" target="_blank">
                            <i class="fas fa-file-invoice me-2"></i>Lihat Invoice
                        </a>
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

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function showEwalletNumber() {
            document.querySelectorAll('.ewallet-number').forEach(function(el) {
                el.style.display = 'none';
            });
            const checked = document.querySelector('input[name="ewallet_type"]:checked');
            if (checked) {
                const id = checked.value;
                const numberDiv = document.getElementById('ewallet_' + id + '_number');
                if (numberDiv) numberDiv.style.display = 'block';
            }
        }
        document.querySelectorAll('input[name="ewallet_type"]').forEach(function(radio) {
            radio.addEventListener('change', showEwalletNumber);
        });
        showEwalletNumber();
    });
    </script>
    @endpush
</x-app-layout>
                            