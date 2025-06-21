<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Customer Details') }}
            </h2>
            <!-- Tambahkan di bagian tombol aksi -->
            <div class="d-flex gap-2 mb-3">
                <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Customer
                </a>
                <a href="{{ route('admin.customers.change-password-form', $customer) }}" class="btn btn-warning">
                    <i class="fas fa-key me-2"></i>Change Password
                </a>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="row">
            <!-- Customer Information -->
            <div class="col-md-6">
                <div class="card border-0 shadow rounded-4 mb-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Name:</strong></div>
                            <div class="col-sm-8">{{ $customer->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Email:</strong></div>
                            <div class="col-sm-8">{{ $customer->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Phone:</strong></div>
                            <div class="col-sm-8">{{ $customer->phone_number }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Joined:</strong></div>
                            <div class="col-sm-8">{{ $customer->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Total Bookings:</strong></div>
                            <div class="col-sm-8">
                                <span class="badge bg-info">{{ $customer->bookings->count() }} bookings</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loyalty Points -->
            <div class="col-md-6">
                <div class="card border-0 shadow rounded-4 mb-4">
                    <div class="card-header bg-success text-white rounded-top-4">
                        <h5 class="mb-0"><i class="fas fa-star me-2"></i>Loyalty Points</h5>
                    </div>
                    <div class="card-body p-4">
                        @if($customer->loyaltyPoints->count() > 0)
                            <div class="text-center mb-3">
                                <h3 class="text-success">{{ $customer->loyaltyPoints->sum('points') }} Points</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Points</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customer->loyaltyPoints->take(5) as $point)
                                        <tr>
                                            <td>{{ $point->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $point->points }}</td>
                                            <td>{{ ucfirst($point->type) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center">No loyalty points yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="card border-0 shadow rounded-4">
            <div class="card-header bg-info text-white rounded-top-4">
                <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Recent Bookings</h5>
            </div>
            <div class="card-body p-4">
                @if($customer->bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th>Technician</th>
                                    <th>Inspection</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->bookings()->latest()->take(5)->get() as $booking)
                                    <tr>
                                        <td>{{ $booking->scheduled_at->format('d M Y') }}</td>
                                        <td>{{ $booking->service->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $booking->technician->user->name ?? 'Not assigned' }}</td>
                                        <td>
                                            @if($booking->inspection_completed_at)
                                                <span class="badge bg-success">Completed</span>
                                                @if($booking->estimated_cost)
                                                    <br><small class="text-muted">Est: Rp {{ number_format($booking->estimated_cost, 0, ',', '.') }}</small>
                                                @endif
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No bookings found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No bookings yet</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>