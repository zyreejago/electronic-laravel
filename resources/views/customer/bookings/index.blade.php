@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4" style="background: linear-gradient(135deg, #4e73df, #224abe);">
                    <div class="d-flex align-items-center text-white">
                        <div class="me-3">
                            <i class="fas fa-calendar-check fa-3x"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">My Bookings</h2>
                            <p class="mb-0 fs-5">Kelola semua booking Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow mb-4 rounded-4 overflow-hidden">
        <div class="card-header p-0">
            <div class="bg-primary text-white p-3 text-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-filter me-2"></i>Filter Bookings
                </h5>
            </div>
        </div>
        <div class="card-body p-4 bg-light bg-gradient">
            <form class="row g-3">
                <div class="col-md-4">
                    <label for="statusFilter" class="form-label fw-bold text-primary">Status</label>
                    <select class="form-select form-select-lg border-0 shadow-sm" id="statusFilter" name="status">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="dateFilter" class="form-label fw-bold text-primary">Tanggal</label>
                    <select class="form-select form-select-lg border-0 shadow-sm" id="dateFilter" name="date_range">
                        <option value="">Semua Waktu</option>
                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                        <i class="fas fa-search me-2"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bookings List -->
    <div class="card border-0 shadow rounded-4 overflow-hidden">
        <div class="card-header p-0">
            <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-list me-2"></i>Daftar Booking
                    </h5>
                    <a href="{{ route('bookings.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i> Booking Baru
                    </a>
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
                                <th class="border-0 text-uppercase small fw-bold p-3">TECHNICIAN</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">STATUS</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">TANGGAL</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">HARGA</th>
                                <th class="border-0 text-uppercase small fw-bold p-3 text-end">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td class="p-3">
                                        <span class="fw-bold">#{{ $booking->id }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3">
                                                <i class="fas fa-tools"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $booking->service->name }}</h6>
                                                <small class="text-muted">{{ $booking->service_type }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        @if($booking->technician)
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 35px; height: 35px; background: linear-gradient(135deg, #1cc88a, #13855c);">
                                                    {{ substr($booking->technician->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $booking->technician->user->name }}</div>
                                                    <small class="text-muted">{{ $booking->technician->specialization }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Belum ditugaskan</span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <span class="badge rounded-pill text-white px-3 py-2 fw-bold" 
                                              style="background: linear-gradient(135deg, 
                                              {{ $booking->status === 'pending' ? '#f6c23e, #dda20a' : 
                                                 ($booking->status === 'confirmed' ? '#36b9cc, #258391' :
                                                 ($booking->status === 'in_progress' ? '#4e73df, #224abe' : 
                                                 ($booking->status === 'completed' ? '#1cc88a, #13855c' : '#e74a3b, #be2617'))) }});">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 me-2">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $booking->scheduled_at->format('d M Y') }}</div>
                                                <div class="small text-muted">{{ $booking->scheduled_at->format('H:i') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <span class="fw-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="p-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($booking->status === 'completed')
                                                <a href="{{ route('customer.bookings.download-handover', $booking) }}" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Download Handover">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
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
                    <h5 class="fw-bold">Belum Ada Booking</h5>
                    <p class="text-muted mb-4">Anda belum memiliki booking atau tidak ada booking yang sesuai dengan filter.</p>
                    <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Buat Booking Baru
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection