<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Pemesanan') }}
            </h2>
            <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>{{ __('Pemesanan Baru') }}
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert border-0 shadow-sm rounded-3 mb-4" style="background: linear-gradient(135deg, #1cc88a, #13855c); color: white;">
                <div class="d-flex align-items-center">
                    <div class="p-2 me-3 bg-white bg-opacity-25 rounded-circle">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <strong>{{ __('Berhasil!') }}</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <!-- Filters and Search -->
        <div class="card border-0 shadow mb-4 rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div class="bg-primary text-white p-3 text-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-filter me-2"></i>{{ __('Filter Pemesanan') }}
                    </h5>
                </div>
            </div>
            <div class="card-body p-4 bg-light bg-gradient">
                <form class="row g-3">
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label fw-bold text-primary">{{ __('Status') }}</label>
                        <select class="form-select form-select-lg border-0 shadow-sm" id="statusFilter" name="status">
                            <option value="">{{ __('Semua Status') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Menunggu') }}</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>{{ __('Dikonfirmasi') }}</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Selesai') }}</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('Dibatalkan') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="dateFilter" class="form-label fw-bold text-primary">{{ __('Rentang Tanggal') }}</label>
                        <select class="form-select form-select-lg border-0 shadow-sm" id="dateFilter" name="date_range">
                            <option value="">{{ __('Semua Waktu') }}</option>
                            <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>{{ __('Hari Ini') }}</option>
                            <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>{{ __('Minggu Ini') }}</option>
                            <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>{{ __('Bulan Ini') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="searchInput" class="form-label fw-bold text-primary">{{ __('Pencarian') }}</label>
                        <div class="input-group input-group-lg shadow-sm">
                            <span class="input-group-text bg-white border-0">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                            <input type="text" class="form-control border-0" id="searchInput" name="search" placeholder="{{ __('Cari berdasarkan ID, pelanggan, atau layanan...') }}" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                            <i class="fas fa-search me-2"></i> {{ __('Cari') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-calendar-check me-2"></i>{{ __('Semua Pemesanan') }}
                        </h5>
                        <div class="d-flex gap-2">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-sort me-1"></i> {{ __('Urutkan') }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="sortDropdown">
                                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}"><i class="fas fa-sort-amount-down me-2"></i> {{ __('Terbaru Dulu') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}"><i class="fas fa-sort-amount-up me-2"></i> {{ __('Terlama Dulu') }}</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'upcoming']) }}"><i class="fas fa-calendar-day me-2"></i> {{ __('Pemesanan Mendatang') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                @if($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 text-uppercase small fw-bold p-3">ID</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">CUSTOMER</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">SERVICE</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">TECHNICIAN</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">DATE & TIME</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">STATUS</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3 text-end">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td class="p-3">
                                            <span class="fw-bold">#{{ $booking->id }}</span>
                                            @if($booking->is_emergency)
                                                <span class="badge bg-danger ms-2"><i class="fas fa-bolt me-1"></i>{{ __('Darurat') }}</span>
                                            @endif
                                        </td>
                                        <td class="p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 45px; height: 45px; background: linear-gradient(135deg, #4e73df, #224abe);">
                                                    {{ substr($booking->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold">{{ $booking->user->name }}</h6>
                                                    <small class="text-muted">{{ $booking->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-tools"></i>
                                                </div>
                                                <span class="fw-bold">{{ $booking->service->name }}</span>
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            @if($booking->technician)
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-2" 
                                                         style="width: 35px; height: 35px; background: linear-gradient(135deg, #1cc88a, #13855c);">
                                                        {{ substr($booking->technician->user->name, 0, 1) }}
                                                    </div>
                                                    <span class="fw-bold">{{ $booking->technician->user->name }}</span>
                                                </div>
                                            @else
                                                <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: linear-gradient(135deg, #f6c23e, #dda20a); color: white;">
                                                    <i class="fas fa-user-clock me-1"></i> Unassigned
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-3">
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 me-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $booking->scheduled_at->format('d M Y') }}</div>
                                                        <div class="small text-muted">
                                                            <i class="far fa-clock me-1"></i>{{ $booking->scheduled_at->format('H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            <span class="badge rounded-pill text-white px-3 py-2 fw-bold" 
                                                  style="background: linear-gradient(135deg, 
                                                  {{ $booking->status === 'pending' ? '#f6c23e, #dda20a' : 
                                                     ($booking->status === 'confirmed' ? '#4e73df, #224abe' : 
                                                     ($booking->status === 'completed' ? '#1cc88a, #13855c' : '#e74a3b, #be2617')) }});">
                                                @if($booking->status === 'pending')
                                                    <i class="fas fa-clock me-1"></i>
                                                @elseif($booking->status === 'confirmed')
                                                    <i class="fas fa-check-circle me-1"></i>
                                                @elseif($booking->status === 'completed')
                                                    <i class="fas fa-check-double me-1"></i>
                                                @elseif($booking->status === 'cancelled')
                                                    <i class="fas fa-times-circle me-1"></i>
                                                @endif
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($booking->status === 'pending')
                                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#assignTechnicianModal{{ $booking->id }}" title="Assign Technician">
                                                        <i class="fas fa-user-plus"></i>
                                                    </button>
                                                @endif
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $booking->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuButton{{ $booking->id }}">
                                                        <li><a class="dropdown-item" href="{{ route('admin.bookings.show', $booking) }}"><i class="fas fa-eye me-2"></i> View Details</a></li>
                                                        @if($booking->status === 'pending')
                                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit Booking</a></li>
                                                        @endif
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i> Cancel Booking</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-top">
                        {{ $bookings->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="rounded-circle bg-light p-4 mx-auto mb-3" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-times fa-3x text-muted"></i>
                        </div>
                        <h5 class="fw-bold">No Bookings Found</h5>
                        <p class="text-muted mb-4">There are no bookings matching your search criteria.</p>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary">
                            <i class="fas fa-sync-alt me-2"></i>Reset Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Assign Technician Modals -->
    @foreach($bookings as $booking)
        @if($booking->status === 'pending')
            <div class="modal fade" id="assignTechnicianModal{{ $booking->id }}" tabindex="-1" aria-labelledby="assignTechnicianModalLabel{{ $booking->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                        <div class="modal-header text-white p-4 border-bottom-0" style="background: linear-gradient(135deg, #1cc88a, #13855c);">
                            <h5 class="modal-title fw-bold" id="assignTechnicianModalLabel{{ $booking->id }}">
                                <i class="fas fa-user-plus me-2"></i>Assign Technician
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.bookings.assign', $booking) }}" method="POST">
                            @csrf
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label for="technician_id_{{ $booking->id }}" class="form-label fw-bold">Select Technician</label>
                                    <select name="technician_id" id="technician_id_{{ $booking->id }}" class="form-select" required>
                                        <option value="">-- Select Technician --</option>
                                        @foreach($technicians as $technician)
                                            <option value="{{ $technician->id }}">{{ $technician->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 p-4">
                                <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-check me-2"></i> Assign Technician
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    
    @push('scripts')
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    @endpush
</x-app-layout>