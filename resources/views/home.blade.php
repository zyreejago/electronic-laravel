<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Home') }}
            </h2>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="row g-4">
            @auth
                @if(auth()->user()->isAdmin())
                    <!-- Admin Dashboard -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                            <div class="card-header p-0">
                                <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-user-shield me-2"></i>Admin Dashboard
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    <a href="{{ route('services.index') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-cogs"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Manage Services</h6>
                                                <small class="text-muted">Add, edit, and delete services</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a>
                                    <a href="{{ route('technicians.index') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-users-cog"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Manage Technicians</h6>
                                                <small class="text-muted">Add, edit, and delete technicians</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.reception.create') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-clipboard-check"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Penerimaan Barang</h6>
                                                <small class="text-muted">Form penerimaan dan registrasi barang</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.customers.index') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-users-cog"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Manage Users</h6>
                                                <small class="text-muted">Add, edit, and delete technicians</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a>
                                    <a href="{{ route('service-components.index') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-microchip"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Manage Components</h6>
                                                <small class="text-muted">Manage service components and inventory</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.bookings.index') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">View All Bookings</h6>
                                                <small class="text-muted">Manage and track all service bookings</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.reports') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">View Reports</h6>
                                                <small class="text-muted">Access analytics and reports</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.inventory.index') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-boxes"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Daftar Stok</h6>
                                                <small class="text-muted">Kelola inventori dan stok barang</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="col-md-6 col-lg-8">
                        <div class="row g-4 mb-4">
                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                                    <div class="card-body p-0">
                                        <div class="d-flex h-100">
                                            <div class="p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #4e73df, #224abe); width: 80px;">
                                                <i class="fas fa-calendar-check fa-2x text-white"></i>
                                            </div>
                                            <div class="p-3 flex-grow-1">
                                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">BOOKINGS</h6>
                                                <h2 class="display-6 fw-bold mb-0">{{ \App\Models\Booking::count() }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                                    <div class="card-body p-0">
                                        <div class="d-flex h-100">
                                            <div class="p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #1cc88a, #13855c); width: 80px;">
                                                <i class="fas fa-users fa-2x text-white"></i>
                                            </div>
                                            <div class="p-3 flex-grow-1">
                                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">USERS</h6>
                                                <h2 class="display-6 fw-bold mb-0">{{ \App\Models\User::count() }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                                    <div class="card-body p-0">
                                        <div class="d-flex h-100">
                                            <div class="p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #f6c23e, #dda20a); width: 80px;">
                                                <i class="fas fa-tools fa-2x text-white"></i>
                                            </div>
                                            <div class="p-3 flex-grow-1">
                                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">SERVICES</h6>
                                                <h2 class="display-6 fw-bold mb-0">{{ \App\Models\Service::count() }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                                    <div class="card-body p-0">
                                        <div class="d-flex h-100">
                                            <div class="p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #e74a3b, #be2617); width: 80px;">
                                                <i class="fas fa-microchip fa-2x text-white"></i>
                                            </div>
                                            <div class="p-3 flex-grow-1">
                                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">COMPONENTS</h6>
                                                <h2 class="display-6 fw-bold mb-0">{{ \App\Models\ServiceComponent::count() }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow rounded-4 overflow-hidden">
                            <div class="card-header p-0">
                                <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-tasks me-2"></i>Recent Activities
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @php
                                        $recentBookings = \App\Models\Booking::latest()->take(5)->get();
                                        $route = auth()->user()->isAdmin() ? 'admin.bookings.show' : (auth()->user()->isTechnician() ? 'technician.bookings.show' : 'bookings.show');
                                    @endphp
                                    @forelse($recentBookings as $booking)
                                        <div class="list-group-item border-0 p-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 45px; height: 45px; background: linear-gradient(135deg, 
                                                     {{ $booking->status === 'pending' ? '#f6c23e, #dda20a' : 
                                                        ($booking->status === 'confirmed' ? '#4e73df, #224abe' : 
                                                        ($booking->status === 'completed' ? '#1cc88a, #13855c' : '#e74a3b, #be2617')) }});">
                                                    <i class="fas fa-{{ $booking->status === 'pending' ? 'clock' : 
                                                                      ($booking->status === 'confirmed' ? 'check-circle' : 
                                                                      ($booking->status === 'completed' ? 'check-double' : 'times-circle')) }}"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold">New booking for {{ $booking->service->name ?? 'Unknown Service' }}</h6>
                                                    <div class="text-muted small">
                                                        <span>{{ $booking->user->name ?? 'Unknown User' }}</span> • 
                                                        <span>{{ $booking->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                                <a href="{{ route($route, $booking) }}" class="btn btn-sm btn-outline-primary ms-auto">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="list-group-item border-0 p-4 text-center">
                                            <p class="text-muted mb-0">No recent activities found.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(auth()->user()->isTechnician())
                    <!-- Technician Dashboard -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                            <div class="card-header p-0">
                                <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-user-cog me-2"></i>Technician Dashboard
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    <a href="{{ route('technician.bookings.index') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">View My Bookings</h6>
                                                <small class="text-muted">Manage your assigned service bookings</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Technician Stats -->
                    <div class="col-md-6">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                                    <div class="card-body p-0">
                                        <div class="d-flex h-100">
                                            <div class="p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #1cc88a, #13855c); width: 80px;">
                                                <i class="fas fa-calendar-check fa-2x text-white"></i>
                                            </div>
                                            <div class="p-3 flex-grow-1">
                                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">MY BOOKINGS</h6>
                                                <h2 class="display-6 fw-bold mb-0">{{ auth()->user()->technician ? auth()->user()->technician->bookings()->count() : 0 }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                                    <div class="card-body p-0">
                                        <div class="d-flex h-100">
                                            <div class="p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #f6c23e, #dda20a); width: 80px;">
                                                <i class="fas fa-check-double fa-2x text-white"></i>
                                            </div>
                                            <div class="p-3 flex-grow-1">
                                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">COMPLETED</h6>
                                                <h2 class="display-6 fw-bold mb-0">{{ auth()->user()->technician ? auth()->user()->technician->bookings()->where('status', 'completed')->count() : 0 }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card border-0 shadow rounded-4 overflow-hidden">
                                    <div class="card-header p-0">
                                        <div style="background: linear-gradient(90deg, #36b9cc, #258391);" class="text-white p-4">
                                            <h5 class="card-title mb-0 fw-bold">
                                                <i class="fas fa-history me-2"></i>Recent Schedule
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="card-body p-4">
                                        @php
                                            $recentBookings = auth()->user()->technician ? auth()->user()->technician->bookings()->latest()->take(10)->get() : collect();
                                        @endphp
                                        @if($recentBookings->count() > 0)
                                            <div class="list-group">
                                                @foreach($recentBookings as $booking)
                                                    <div class="list-group-item border-0 p-3 mb-3 rounded-3" style="background-color: rgba(54, 185, 204, 0.1);">
                                                        <div class="d-flex align-items-center">
                                                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                                                 style="width: 40px; height: 40px; background: linear-gradient(135deg, 
                                                                 {{ $booking->status === 'pending' ? '#f6c23e, #dda20a' : 
                                                                    ($booking->status === 'in_progress' ? '#36b9cc, #258391' : 
                                                                    ($booking->status === 'confirmed' ? '#4e73df, #224abe' : 
                                                                    ($booking->status === 'completed' ? '#1cc88a, #13855c' : '#e74a3b, #be2617'))) }});">
                                                                <i class="fas fa-{{ $booking->status === 'pending' ? 'clock' : 
                                                                                  ($booking->status === 'in_progress' ? 'spinner fa-spin' : 
                                                                                  ($booking->status === 'confirmed' ? 'check-circle' : 
                                                                                  ($booking->status === 'completed' ? 'check-double' : 'times-circle'))) }}"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 fw-bold">{{ $booking->service->name ?? 'Unknown Service' }}</h6>
                                                                <small class="text-muted">{{ $booking->scheduled_at->format('d M Y H:i') }} - {{ $booking->user->name }}</small>
                                                            </div>
                                                            <span class="badge rounded-pill text-white px-3 py-2 ms-auto fw-bold" 
                                                                  style="background: linear-gradient(135deg, 
                                                                  {{ $booking->status === 'pending' ? '#f6c23e, #dda20a' : 
                                                                     ($booking->status === 'confirmed' ? '#4e73df, #224abe' : 
                                                                     ($booking->status === 'in_progress' ? '#36b9cc, #258391' : 
                                                                     ($booking->status === 'completed' ? '#1cc88a, #13855c' : '#e74a3b, #be2617'))) }});">
                                                                {{ ucfirst($booking->status) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <div class="rounded-circle bg-light p-3 mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-calendar-day fa-3x text-muted"></i>
                                                </div>
                                                <h6 class="fw-bold">No Recent Bookings</h6>
                                                <p class="text-muted mb-0">You have no recent bookings.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- User Dashboard -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                            <div class="card-header p-0">
                                <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-user me-2"></i>User Dashboard
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    <!-- <a href="{{ route('services.index') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-tools"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Browse Services</h6>
                                                <small class="text-muted">View available electronic repair services</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a> -->
                                    <a href="{{ route('bookings.index') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">My Bookings</h6>
                                                <small class="text-muted">View and manage your service bookings</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a>
                                    <a href="{{ route('loyalty-points.index') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">My Loyalty Points</h6>
                                                <small class="text-muted">Check your loyalty points and rewards</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a>
                                    <a href="{{ route('customer.dashboard') }}" class="list-group-item list-group-item-action border-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-dashboard"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">All Dashboard</h6>
                                                <small class="text-muted">Check your all dashboard</small>
                                            </div>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Stats and Recent Bookings -->
                    <div class="col-md-6">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                                    <div class="card-body p-0">
                                        <div class="d-flex h-100">
                                            <div class="p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #4e73df, #224abe); width: 80px;">
                                                <i class="fas fa-calendar-check fa-2x text-white"></i>
                                            </div>
                                            <div class="p-3 flex-grow-1">
                                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">MY BOOKINGS</h6>
                                                <h2 class="display-6 fw-bold mb-0">{{ auth()->user()->bookings()->count() }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                                    <div class="card-body p-0">
                                        <div class="d-flex h-100">
                                            <div class="p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #f6c23e, #dda20a); width: 80px;">
                                                <i class="fas fa-star fa-2x text-white"></i>
                                            </div>
                                            <div class="p-3 flex-grow-1">
                                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">LOYALTY POINTS</h6>
                                                <h2 class="display-6 fw-bold mb-0">{{ auth()->user()->loyalty_points ?? 0 }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card border-0 shadow rounded-4 overflow-hidden">
                                    <div class="card-header p-0">
                                        <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                                            <h5 class="card-title mb-0 fw-bold">
                                                <i class="fas fa-history me-2"></i>Recent Bookings
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="card-body p-4">
                                        @php
                                            $userBookings = auth()->user()->bookings()->latest()->take(3)->get();
                                        @endphp
                                        @if($userBookings->count() > 0)
                                            <div class="list-group">
                                                @foreach($userBookings as $booking)
                                                    <div class="list-group-item border-0 p-3 mb-3 rounded-3" style="background-color: rgba(28, 200, 138, 0.1);">
                                                        <div class="d-flex align-items-center">
                                                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                                                 style="width: 40px; height: 40px; background: linear-gradient(135deg, 
                                                                 {{ $booking->status === 'pending' ? '#f6c23e, #dda20a' : 
                                                                    ($booking->status === 'in_progress' ? '#36b9cc, #258391' : 
                                                                    ($booking->status === 'confirmed' ? '#4e73df, #224abe' : 
                                                                    ($booking->status === 'completed' ? '#1cc88a, #13855c' : '#e74a3b, #be2617'))) }});">
                                                                <i class="fas fa-{{ $booking->status === 'pending' ? 'clock' : 
                                                                                  ($booking->status === 'in_progress' ? 'spinner fa-spin' : 
                                                                                  ($booking->status === 'confirmed' ? 'check-circle' : 
                                                                                  ($booking->status === 'completed' ? 'check-double' : 'times-circle'))) }}"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 fw-bold">{{ $booking->service->name ?? 'Unknown Service' }}</h6>
                                                                <small class="text-muted">{{ $booking->scheduled_at->format('d M Y H:i') }}</small>
                                                            </div>
                                                            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary ms-auto">
                                                                <i class="fas fa-eye me-1"></i> View
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="text-center mt-3">
                                                <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-list me-2"></i>View All Bookings
                                                </a>
                                            </div>
                                        @else
                                            <div class="text-center py-5">
                                                <h5 class="fw-bold">No Bookings Found</h5>
                                                <p class="text-muted mb-4">You haven't made any bookings yet.</p>
                                                <a href="{{ route('services.index') }}" class="btn btn-success">
                                                    <i class="fas fa-plus me-2"></i>Book a Service
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Guest Welcome -->
                <div class="col-md-8 mx-auto">
                    <div class="card border-0 shadow rounded-4 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                                    <h3 class="fw-bold mb-4">Welcome to Electronic Service Management</h3>
                                    <p class="text-muted mb-4">Our platform provides comprehensive electronic repair services with professional technicians and quality components.</p>
                                    <div class="d-grid gap-3">
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-sign-in-alt me-2"></i>Log in
                                        </a>
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                                            <i class="fas fa-user-plus me-2"></i>Register
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 d-none d-md-block" style="background: linear-gradient(135deg, #4e73df, #224abe); min-height: 400px;">
                                    <div class="d-flex flex-column justify-content-center align-items-center h-100 text-white p-4">
                                        <div class="rounded-circle bg-white p-4 mb-4">
                                            <i class="fas fa-tools fa-4x text-primary"></i>
                                        </div>
                                        <h4 class="fw-bold mb-3">Our Services</h4>
                                        <ul class="list-unstyled">
                                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i>Computer Repair</li>
                                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i>Smartphone Repair</li>
                                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i>TV & Home Electronics</li>
                                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i>Gaming Console Repair</li>
                                            <li><i class="fas fa-check-circle me-2"></i>And much more...</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>