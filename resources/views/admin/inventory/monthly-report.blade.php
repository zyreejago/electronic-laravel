@extends('layouts.app')

@section('content')
<!-- Page Heading dengan tombol export -->
<header class="bg-white shadow-sm py-3 mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
                {{ __('Laporan Inventori Bulanan') }}
            </h2>
            <div>
                <a href="{{ route('admin.inventory.export-report', ['month' => $month, 'format' => 'excel']) }}" 
                   class="btn btn-success btn-lg shadow-sm me-2">
                    <i class="fas fa-file-excel me-2"></i>Export Excel
                </a>
                <a href="{{ route('admin.inventory.export-report', ['month' => $month, 'format' => 'pdf']) }}" 
                   class="btn btn-danger btn-lg shadow-sm me-2">
                    <i class="fas fa-file-pdf me-2"></i>Export PDF
                </a>
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary btn-lg shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</header>

<div class="container py-4">
    @if(session('success'))
        <div class="alert border-0 shadow-sm rounded-3 mb-4" style="background: linear-gradient(135deg, #1cc88a, #13855c); color: white;">
            <div class="d-flex align-items-center">
                <div class="p-2 me-3 bg-white bg-opacity-25 rounded-circle">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <strong>Success!</strong> {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert border-0 shadow-sm rounded-3 mb-4" style="background: linear-gradient(135deg, #e74a3b, #c0392b); color: white;">
            <div class="d-flex align-items-center">
                <div class="p-2 me-3 bg-white bg-opacity-25 rounded-circle">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <strong>Error!</strong> {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="card border-0 shadow rounded-4 overflow-hidden">
        <div class="card-header p-0">
            <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1"><i class="fas fa-chart-bar me-2"></i>Laporan Inventori Bulanan</h4>
                        <p class="mb-0 opacity-75">Periode: {{ date('F Y', strtotime($month . '-01')) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <!-- Filter Bulan -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body">
                    <form method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar me-1"></i>Pilih Bulan:
                                </label>
                                <input type="month" name="month" class="form-control" value="{{ $month }}" 
                                       onchange="this.form.submit()">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ringkasan Penggunaan -->
            @if($usages->count() > 0)
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h6 class="mb-0"><i class="fas fa-tools me-2"></i>Penggunaan Barang oleh Teknisi</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Nama Barang</th>
                                        <th class="border-0">Total Digunakan</th>
                                        <th class="border-0">Jumlah Penggunaan</th>
                                        <th class="border-0">Teknisi Terakhir</th>
                                        <th class="border-0">Tanggal Terakhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usages as $itemId => $itemUsages)
                                        @php
                                            $firstUsage = $itemUsages->first();
                                            $totalUsed = $itemUsages->sum('quantity_used');
                                            $lastUsage = $itemUsages->sortByDesc('used_at')->first();
                                        @endphp
                                        <tr>
                                            <td class="fw-semibold">{{ $firstUsage->inventoryItem->name }}</td>
                                            <td><span class="badge bg-info">{{ $totalUsed }}</span></td>
                                            <td>{{ $itemUsages->count() }} kali</td>
                                            <td>
                                                @if($lastUsage->technician && $lastUsage->technician->user)
                                                    {{ $lastUsage->technician->user->name }}
                                                @else
                                                    <span class="text-muted">Data teknisi tidak ditemukan</span>
                                                @endif
                                            </td>
                                            <td>{{ $lastUsage->used_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Ringkasan Pembelian -->
            @if($purchases->count() > 0)
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-success text-white rounded-top-4">
                        <h6 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Pembelian/Restock Barang</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Nama Barang</th>
                                        <th class="border-0">Total Dibeli</th>
                                        <th class="border-0">Total Biaya</th>
                                        <th class="border-0">Jumlah Pembelian</th>
                                        <th class="border-0">Tanggal Terakhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchases as $itemId => $itemPurchases)
                                        @php
                                            $firstPurchase = $itemPurchases->first();
                                            $totalQuantity = $itemPurchases->sum('quantity');
                                            $totalCost = $itemPurchases->sum('total_price');
                                            $lastPurchase = $itemPurchases->sortByDesc('purchase_date')->first();
                                        @endphp
                                        <tr>
                                            <td class="fw-semibold">{{ $firstPurchase->inventoryItem->name }}</td>
                                            <td><span class="badge bg-success">{{ $totalQuantity }}</span></td>
                                            <td class="fw-semibold text-success">Rp {{ number_format($totalCost, 0, ',', '.') }}</td>
                                            <td>{{ $itemPurchases->count() }} kali</td>
                                            <td>{{ $lastPurchase->purchase_date->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            @if($usages->count() == 0 && $purchases->count() == 0)
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-info-circle fa-3x text-muted"></i>
                        </div>
                        <h5 class="text-muted">Tidak ada aktivitas inventori</h5>
                        <p class="text-muted mb-0">Tidak ada data penggunaan atau pembelian pada bulan ini.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection