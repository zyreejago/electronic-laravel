@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Inventori Tersedia</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Deskripsi</th>
                                    <th>Stok Tersedia</th>
                                    <th>Kondisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                    <tr>
                                        <td><strong>{{ $item->name }}</strong></td>
                                        <td>{{ $item->description ?: '-' }}</td>
                                        <td>
                                            <span class="badge bg-success fs-6">
                                                {{ $item->stock_quantity }}
                                            </span>
                                            @if($item->isLowStock())
                                                <br><small class="text-warning"><i class="fas fa-exclamation-triangle"></i> Stok Rendah</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $item->condition }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    data-bs-toggle="modal" data-bs-target="#useModal{{ $item->id }}">
                                                <i class="fas fa-tools"></i> Gunakan
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Gunakan Barang -->
                                    <div class="modal fade" id="useModal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('technician.inventory.use') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="inventory_item_id" value="{{ $item->id }}">
                                                    
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Gunakan {{ $item->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Booking ID <span class="text-danger">*</span></label>
                                                            <input type="number" name="booking_id" class="form-control" 
                                                                   placeholder="Masukkan ID booking" required>
                                                            <small class="form-text text-muted">ID booking yang sedang dikerjakan</small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jumlah yang Digunakan <span class="text-danger">*</span></label>
                                                            <input type="number" name="quantity_used" class="form-control" 
                                                                   min="1" max="{{ $item->stock_quantity }}" required>
                                                            <small class="form-text text-muted">Maksimal: {{ $item->stock_quantity }}</small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Catatan</label>
                                                            <textarea name="notes" class="form-control" rows="3" 
                                                                      placeholder="Catatan penggunaan (opsional)"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Gunakan Barang</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada barang yang tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection