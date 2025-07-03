@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-success text-white p-4">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-history me-2"></i>Riwayat Service
            </h4>
        </div>
        <div class="card-body p-4">
            <!-- Export Options -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form method="GET" class="d-flex gap-2">
                        <select name="year" class="form-select">
                            <option value="">{{ __('Pilih Tahun') }}</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> {{ __('Filter') }}
                        </button>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('customer.bookings.export-history', request()->all()) }}" class="btn btn-success">
                        <i class="fas fa-file-excel me-1"></i> {{ __('Export Excel') }}
                    </a>
                </div>
            </div>

            <!-- History List -->
            @if($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Layanan') }}</th>
                                <th>{{ __('Tanggal') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Harga') }}</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->service->name }}</td>
                                    <td>{{ $booking->scheduled_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status === 'completed' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>{{ __('Rp') }} {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h5>{{ __('Belum Ada Riwayat') }}</h5>
                    <p class="text-muted">{{ __('Anda belum memiliki riwayat service.') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection