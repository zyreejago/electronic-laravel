<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Inventori') }}
            </h2>
            <div>
                <a href="{{ route('admin.inventory.edit', $inventoryItem) }}" class="btn btn-warning btn-lg shadow-sm me-2">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary btn-lg shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
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

        <!-- Header Card dengan Informasi Barang -->
        <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center me-3" 
                                 style="width: 60px; height: 60px;">
                                <i class="fas fa-box text-white fs-4"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">{{ $inventoryItem->name }}</h4>
                                <p class="mb-0 opacity-75">{{ $inventoryItem->description ?: 'Tidak ada deskripsi' }}</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-white text-dark px-3 py-2 mb-2">
                                <i class="fas fa-boxes me-1"></i>Stok: {{ $inventoryItem->stock_quantity }}
                            </div>
                            @if($inventoryItem->isLowStock())
                                <div class="badge bg-warning text-dark px-3 py-2">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Stok Rendah
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Informasi Detail -->
            <div class="col-md-8">
                <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-info-circle me-2"></i>Informasi Detail
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Harga Satuan</label>
                                    <div class="fs-5 fw-bold text-success">
                                        {{ $inventoryItem->unit_price ? 'Rp ' . number_format($inventoryItem->unit_price, 0, ',', '.') : '-' }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Kondisi</label>
                                    <div>
                                        <span class="badge {{ $inventoryItem->condition == 'Layak Pakai' ? 'bg-success' : 'bg-warning' }} px-3 py-2">
                                            {{ $inventoryItem->condition }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Status</label>
                                    <div>
                                        <span class="badge {{ $inventoryItem->status == 'Tersedia' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                            {{ $inventoryItem->status }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Stok Minimum</label>
                                    <div class="fs-5 fw-bold">
                                        {{ $inventoryItem->minimum_stock }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Restock -->
            <div class="col-md-4">
                <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-plus me-2"></i>Restock Barang
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.inventory.restock', $inventoryItem) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Jumlah Tambahan</label>
                                <input type="number" name="quantity" class="form-control form-control-lg" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Harga Satuan</label>
                                <input type="number" name="unit_price" class="form-control form-control-lg" step="0.01" min="0" 
                                       value="{{ $inventoryItem->unit_price }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Tanggal Pembelian</label>
                                <input type="date" name="purchase_date" class="form-control form-control-lg" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Catatan</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Catatan pembelian..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm">
                                <i class="fas fa-plus me-2"></i>Tambah Stok
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pembelian -->
        <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #f6c23e, #dda20a);" class="text-white p-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-shopping-cart me-2"></i>Riwayat Pembelian
                    </h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 text-uppercase small fw-bold p-3">Tanggal</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">Admin</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">Jumlah</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">Harga Satuan</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">Total</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inventoryItem->purchases as $purchase)
                                <tr>
                                    <td class="p-3">
                                        <span class="fw-bold">{{ $purchase->purchase_date->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 35px; height: 35px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <span class="fw-bold">{{ $purchase->admin->name }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <span class="badge bg-info px-3 py-2">{{ $purchase->quantity }}</span>
                                    </td>
                                    <td class="p-3">
                                        <span class="fw-bold text-success">Rp {{ number_format($purchase->unit_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="p-3">
                                        <span class="fw-bold text-primary">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-muted">{{ $purchase->notes ?: '-' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p class="mb-0">Belum ada riwayat pembelian</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Riwayat Penggunaan -->
        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #e74a3b, #c0392b);" class="text-white p-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-tools me-2"></i>Riwayat Penggunaan
                    </h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 text-uppercase small fw-bold p-3">Tanggal</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">Teknisi</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">Booking</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">Jumlah Digunakan</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inventoryItem->usages as $usage)
                                <tr>
                                    <td class="p-3">
                                        <span class="fw-bold">{{ $usage->used_at->format('d/m/Y H:i') }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 35px; height: 35px;">
                                                <i class="fas fa-user-cog"></i>
                                            </div>
                                            <span class="fw-bold">
                                                {{ $usage->technician && $usage->technician->user ? $usage->technician->user->name : 'Data teknisi tidak ditemukan' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <a href="{{ route('admin.bookings.show', $usage->booking) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-external-link-alt me-1"></i>#{{ $usage->booking_id }}
                                        </a>
                                    </td>
                                    <td class="p-3">
                                        <span class="badge bg-warning text-dark px-3 py-2">{{ $usage->quantity_used }}</span>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-muted">{{ $usage->notes ?: '-' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p class="mb-0">Belum ada riwayat penggunaan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>