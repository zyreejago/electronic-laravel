<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Inventori') }}
            </h2>
            <div>
                <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary btn-lg shadow-sm me-2">
                    <i class="fas fa-plus me-2"></i>Tambah Barang
                </a>
                <a href="{{ route('admin.inventory.monthly-report') }}" class="btn btn-info btn-lg shadow-sm">
                    <i class="fas fa-chart-bar me-2"></i>Laporan Bulanan
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

        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-boxes me-2"></i>Daftar Inventori
                        </h5>
                        <span class="badge bg-white text-dark px-3 py-2">
                            Total: {{ $items->count() }} items
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 text-uppercase small fw-bold p-3">BARANG</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">STOK MINIM</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">HARGA</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">KONDISI</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">STATUS</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr class="{{ $item->isLowStock() ? 'table-warning' : '' }}">
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 45px; height: 45px; background: linear-gradient(135deg, #1cc88a, #13855c);">
                                                <i class="fas fa-box"></i>
                                            </div>
                                            <div>
                                                <span class="fw-bold d-block">{{ $item->name }}</span>
                                                <small class="text-muted">{{ Str::limit($item->description, 30) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold {{ $item->isLowStock() ? 'text-warning' : 'text-success' }}">{{ $item->current_stock }}</span>
                                            <small class="text-muted ms-1">{{ $item->minimum_stock }}</small>
                                        </div>
                                        @if($item->isLowStock())
                                            <small class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i>Stok Rendah</small>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <span class="fw-bold">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="p-3">
                                        <span class="badge bg-{{ $item->condition === 'baik' ? 'success' : ($item->condition === 'rusak' ? 'danger' : 'warning') }} px-3 py-2">
                                            {{ ucfirst($item->condition) }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <span class="badge bg-{{ $item->status === 'tersedia' ? 'success' : 'secondary' }} px-3 py-2">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.inventory.show', $item) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            {{-- <a href="{{ route('admin.inventory.edit', $item) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#restockModal{{ $item->id }}">
                                                <i class="fas fa-plus"></i>
                                            </button> --}}
                                            <form action="{{ route('admin.inventory.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Restock Modal -->
                                <div class="modal fade" id="restockModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Restock {{ $item->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.inventory.restock', $item) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Jumlah Tambahan</label>
                                                        <input type="number" class="form-control" name="quantity" min="1" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Harga Beli per Unit</label>
                                                        <input type="number" class="form-control" name="purchase_price" step="0.01" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Supplier</label>
                                                        <input type="text" class="form-control" name="supplier">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Restock</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-5">
                                        <div class="text-muted">
                                            <i class="fas fa-box-open fa-3x mb-3"></i>
                                            <p class="mb-0">Belum ada item inventori</p>
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