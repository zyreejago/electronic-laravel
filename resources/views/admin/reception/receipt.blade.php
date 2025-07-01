<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tanda Terima Penerimaan Barang') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="card border-0 shadow rounded-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Tanda Terima Berhasil Dibuat</h5>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> Penerimaan barang telah dicatat dengan nomor servis: <strong>#{{ $booking->id }}</strong>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-primary">Informasi Pelanggan</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%">Nama</td>
                                <td>: {{ $booking->user->name }}</td>
                            </tr>
                            <tr>
                                <td>No. Telepon</td>
                                <td>: {{ $booking->user->phone_number }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>: {{ $booking->user->email }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold text-primary">Informasi Servis</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%">Nomor Servis</td>
                                <td>: <strong>#{{ $booking->id }}</strong></td>
                            </tr>
                            <tr>
                                <td>Jenis Barang</td>
                                <td>: {{ $booking->service->name }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Masuk</td>
                                <td>: {{ $booking->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>: <span class="badge bg-warning">{{ ucfirst($booking->status) }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary">Detail Barang</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="20%">Kategori Kerusakan</td>
                                <td>: {{ $booking->damage_category }}</td>
                            </tr>
                            <tr>
                                <td>Kondisi Fisik</td>
                                <td>: {{ $booking->item_condition ?? 'Tidak disebutkan' }}</td>
                            </tr>
                            <tr>
                                <td>Deskripsi Keluhan</td>
                                <td>: {{ $booking->description }}</td>
                            </tr>
                            <tr>
                                <td>Aksesoris</td>
                                <td>: {{ $booking->accessories_included ?? 'Tidak ada' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                {{-- <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.reception.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Penerimaan Baru
                    </a>
                    <div>
                        <a href="{{ route('admin.reception.print', $booking) }}" class="btn btn-success me-2" target="_blank">
                            <i class="fas fa-print me-2"></i>Cetak Tanda Terima
                        </a>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary">
                            <i class="fas fa-list me-2"></i>Lihat Semua Booking
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>