@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-eye me-2"></i>Detail Booking #{{ $booking->id }}
                        </h4>
                        <a href="{{ route('customer.bookings.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Booking Details Content -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3">Informasi Service</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Service:</td>
                                    <td>{{ $booking->service->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tipe:</td>
                                    <td>{{ ucfirst($booking->service_type) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status:</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : ($booking->status === 'in_progress' ? 'info' : 'warning')) }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal:</td>
                                    <td>{{ $booking->scheduled_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3">Teknisi</h5>
                            @if($booking->technician)
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                         style="width: 60px; height: 60px; background: linear-gradient(135deg, #1cc88a, #13855c);">
                                        {{ substr($booking->technician->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $booking->technician->user->name }}</h6>
                                        <p class="mb-1 text-muted">{{ $booking->technician->specialization }}</p>
                                        <p class="mb-0 small text-muted">{{ $booking->technician->user->phone_number }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Teknisi belum ditugaskan
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Total Price Breakdown -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="mb-0">💰 Rincian Biaya</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table class="table table-sm mb-0">
                                                <tr>
                                                    <td>Biaya Service Dasar:</td>
                                                    <td class="text-end">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</td>
                                                </tr>
                                                @if($booking->serviceComponents->count() > 0)
                                                <tr>
                                                    <td>Komponen Tambahan:</td>
                                                    <td class="text-end">Rp {{ number_format($booking->serviceComponents->sum(function($c) { return $c->pivot->quantity * $c->pivot->price_at_time; }), 0, ',', '.') }}</td>
                                                </tr>
                                                @endif
                                                @if(in_array($booking->service_type, ['pickup', 'onsite']))
                                                <tr>
                                                    <td>Biaya {{ ucfirst($booking->service_type) }}:</td>
                                                    <td class="text-end">Rp 50.000</td>
                                                </tr>
                                                @endif
                                                @if($booking->is_emergency)
                                                <tr>
                                                    <td>Biaya Emergency:</td>
                                                    <td class="text-end">Rp 100.000</td>
                                                </tr>
                                                @endif
                                                @if($booking->loyalty_points_used > 0)
                                                <tr>
                                                    <td>Diskon Loyalty Points:</td>
                                                    <td class="text-end text-success">-Rp {{ number_format($booking->loyalty_points_used * 100, 0, ',', '.') }}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td>Biaya Service (Hasil Pemeriksaan):</td>
                                                    <td class="text-end">
                                                        @if($booking->inspection_completed_at && $booking->estimated_cost)
                                                            Rp {{ number_format($booking->estimated_cost, 0, ',', '.') }}
                                                        @else
                                                            <span class="text-muted">Menunggu pemeriksaan awal</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($booking->is_emergency)
                                                <tr>
                                                    <td>Biaya Emergency:</td>
                                                    <td class="text-end">Rp 100.000</td>
                                                </tr>
                                                @endif
                                                @if($booking->loyalty_points_used > 0)
                                                <tr>
                                                    <td>Diskon Loyalty Points:</td>
                                                    <td class="text-end text-success">-Rp {{ number_format($booking->loyalty_points_used * 100, 0, ',', '.') }}</td>
                                                </tr>
                                                @endif
                                                <tr class="table-primary fw-bold">
                                                    <td>Total yang Harus Dibayar:</td>
                                                    <td class="text-end">
                                                        @if($booking->inspection_completed_at && $booking->estimated_cost)
                                                            @php
                                                                $total = $booking->estimated_cost;
                                                                $total += $booking->serviceComponents->sum(function($c) { return $c->pivot->quantity * $c->pivot->price_at_time; });
                                                                if(in_array($booking->service_type, ['pickup', 'onsite'])) $total += 50000;
                                                                if($booking->is_emergency) $total += 100000;
                                                                $total -= ($booking->loyalty_points_used * 100);
                                                            @endphp
                                                            Rp {{ number_format($total, 0, ',', '.') }}
                                                        @else
                                                            <span class="text-muted">Menunggu pemeriksaan awal</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Usage Details -->
                    @if($booking->inventoryUsages->count() > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">🔧 Spare Parts yang Digunakan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nama Item</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Total Harga</th>
                                                    <th>Teknisi</th>
                                                    <th>Waktu Penggunaan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($booking->inventoryUsages as $usage)
                                                <tr>
                                                    <td>{{ $usage->inventoryItem ? $usage->inventoryItem->name : 'Item Tidak Ditemukan' }}</td>
                                                    <td>{{ $usage->quantity_used }}</td>
                                                    <td>Rp {{ $usage->inventoryItem ? number_format($usage->inventoryItem->unit_price, 0, ',', '.') : '0' }}</td>
                                                    <td>Rp {{ $usage->inventoryItem ? number_format($usage->quantity_used * $usage->inventoryItem->unit_price, 0, ',', '.') : '0' }}</td>
                                                    <td>{{ $usage->technician->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $usage->used_at->format('d M Y H:i') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr class="table-info fw-bold">
                                                    <td colspan="3">Total Biaya Spare Parts:</td>
                                                    <td>Rp {{ number_format($booking->inventory_cost, 0, ',', '.') }}</td>
                                                    <td colspan="2"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Temporary debugging - hapus setelah selesai -->
@if(config('app.debug'))
<div class="alert alert-info">
    <strong>Debug Info:</strong><br>
    Booking ID: {{ $booking->id }}<br>
    Inventory Usages Count: {{ $booking->inventoryUsages->count() }}<br>
    Inventory Cost: {{ $booking->inventory_cost }}<br>
    @foreach($booking->inventoryUsages as $usage)
        Usage {{ $usage->id }}: Item {{ $usage->inventoryItem ? $usage->inventoryItem->name : 'NULL' }}, Qty: {{ $usage->quantity_used }}<br>
    @endforeach
</div>
@endif