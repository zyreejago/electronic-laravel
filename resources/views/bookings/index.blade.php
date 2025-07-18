<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Booking Saya') }}
            </h2>
            {{-- <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>New Booking
            </a> --}}
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
                        <i class="fas fa-filter me-2"></i>{{ __('Filter Booking') }}
                    </h5>
                </div>
            </div>
            <div class="card-body p-4 bg-light bg-gradient">
                <form class="row g-3">
                    <div class="col-md-4">
                        <label for="statusFilter" class="form-label fw-bold text-primary">{{ __('Status') }}</label>
                        <select class="form-select form-select-lg border-0 shadow-sm" id="statusFilter" name="status">
                            <option value="">{{ __('Semua Status') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Menunggu') }}</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ __('Sedang Berlangsung') }}</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Selesai') }}</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('Dibatalkan') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="dateFilter" class="form-label fw-bold text-primary">{{ __('Rentang Tanggal') }}</label>
                        <select class="form-select form-select-lg border-0 shadow-sm" id="dateFilter" name="date_range">
                            <option value="">{{ __('Sepanjang Waktu') }}</option>
                            <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>{{ __('Hari Ini') }}</option>
                            <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>{{ __('Minggu Ini') }}</option>
                            <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>{{ __('Bulan Ini') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                            <i class="fas fa-search me-2"></i> {{ __('Terapkan Filter') }}
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
                            <i class="fas fa-calendar-check me-2"></i>{{ __('Booking Saya') }}
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
                                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}"><i class="fas fa-sort-numeric-down-alt me-2"></i> {{ __('Harga: Tinggi ke Rendah') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}"><i class="fas fa-sort-numeric-up me-2"></i> {{ __('Harga: Rendah ke Tinggi') }}</a></li>
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
                                    <th class="border-0 text-uppercase small fw-bold p-3">SERVICE</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">STATUS</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">SCHEDULED DATE</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">TOTAL PRICE</th>
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
                                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-tools"></i>
                                                </div>
                                                <span class="fw-bold">{{ $booking->service->name }}</span>
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            <span class="badge rounded-pill text-white px-3 py-2 fw-bold" 
                                                  style="background: linear-gradient(135deg, 
                                                  {{ $booking->status === 'pending' ? '#f6c23e, #dda20a' : 
                                                     ($booking->status === 'in_progress' ? '#4e73df, #224abe' : 
                                                     ($booking->status === 'completed' ? '#1cc88a, #13855c' : '#e74a3b, #be2617')) }});">
                                                @if($booking->status === 'pending')
                                                    <i class="fas fa-clock me-1"></i>
                                                @elseif($booking->status === 'in_progress')
                                                    <i class="fas fa-spinner me-1"></i>
                                                @elseif($booking->status === 'completed')
                                                    <i class="fas fa-check-double me-1"></i>
                                                @elseif($booking->status === 'cancelled')
                                                    <i class="fas fa-times-circle me-1"></i>
                                                @endif
                                                {{ ucfirst($booking->status) }}
                                            </span>
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
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                </div>
                                                @if($booking->inspection_completed_at && $booking->estimated_cost)
                                                    @php
                                                        $inventoryCost = $booking->inventoryUsages ? $booking->inventoryUsages->sum(function($usage) {
                                                            return $usage->quantity_used * ($usage->inventoryItem ? $usage->inventoryItem->unit_price : 0);
                                                        }) : 0;
                                                        $totalPrice = $booking->estimated_cost + $inventoryCost;
                                                    @endphp
                                                    <span class="fw-bold">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="fw-bold text-muted">{{ __('Menunggu Inspeksi') }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="p-3 text-end">
                                            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i> {{ __('Lihat Detail') }}
                                            </a>
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
                        <h5 class="fw-bold">{{ __('Tidak Ada Booking') }}</h5>
                        <p class="text-muted mb-4">{{ __('Anda belum membuat booking atau tidak ada booking yang sesuai dengan kriteria filter.') }}</p>
                        <div class="d-flex justify-content-center gap-3">
                            {{-- <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Create New Booking
                            </a> --}}
                            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-sync-alt me-2"></i>{{ __('Reset Filter') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>