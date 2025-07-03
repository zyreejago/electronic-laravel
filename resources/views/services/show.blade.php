<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $service->name }}
            </h2>
            @if(auth()->user()->isAdmin())
                <div class="d-flex gap-3">
                    <a href="{{ route('services.edit', $service) }}" class="btn btn-warning btn-lg shadow-sm">
                        <i class="fas fa-edit me-2"></i>{{ __('Edit Layanan') }}
                    </a>
                    <form action="{{ route('services.destroy', $service) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg shadow-sm" onclick="return confirm('{{ __('Apakah Anda yakin ingin menghapus layanan ini?') }}')">
                            <i class="fas fa-trash-alt me-2"></i>{{ __('Hapus Layanan') }}
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('bookings.create', ['service' => $service->id]) }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="fas fa-calendar-plus me-2"></i>{{ __('Booking Sekarang') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-info-circle me-2"></i>{{ __('Detail Layanan') }}
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 me-3" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-wrench fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1">{{ $service->name }}</h4>
                                <div class="text-muted">{{ __('Layanan Elektronik') }}</div>
                            </div>
                        </div>

                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0 py-3 d-flex justify-content-between">
                                <div class="text-muted">
                                    <i class="fas fa-tag me-2"></i>{{ __('Category') }}:
                                </div>
                                <span class="fw-bold">{{ ucfirst($service->category ?? 'General') }}</span>
                            </div>
                            <div class="list-group-item border-0 px-0 py-3 d-flex justify-content-between">
                                <div class="text-muted">
                                    <i class="fas fa-money-bill-wave me-2"></i>{{ __('Harga Dasar') }}:
                                </div>
                                <span class="fw-bold">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="list-group-item border-0 px-0 py-3 d-flex justify-content-between">
                                <div class="text-muted">
                                    <i class="fas fa-clock me-2"></i>{{ __('Duration') }}:
                                </div>
                                <span class="fw-bold">{{ $service->duration }} minutes</span>
                            </div>
                            <div class="list-group-item border-0 px-0 py-3 d-flex justify-content-between">
                                <div class="text-muted">
                                    <i class="fas fa-check-circle me-2"></i>{{ __('Status') }}:
                                </div>
                                <span class="badge rounded-pill px-3 py-2 fw-bold {{ $service->is_available ? 'bg-success' : 'bg-danger' }}">
                                    {{ $service->is_available ? __('Tersedia') : __('Tidak Tersedia') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-align-left me-2"></i>{{ __('Description') }}
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="lead">{{ $service->description }}</p>

                        <div class="alert border-0 mt-4 p-3" style="background: rgba(78, 115, 223, 0.1); color: #4e73df; border-left: 4px solid #4e73df;">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-info-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ __('Informasi Layanan') }}</h6>
                                    <p class="mb-0">{{ __('Layanan ini dilakukan oleh teknisi berkualitas kami. Durasi aktual dapat bervariasi tergantung pada kompleksitas masalah.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($service->bookings && $service->bookings->count() > 0 && auth()->user()->isAdmin())
            <div class="card border-0 shadow rounded-4 overflow-hidden mt-4">
                <div class="card-header p-0">
                    <div style="background: linear-gradient(90deg, #36b9cc, #258391);" class="text-white p-4">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-history me-2"></i>{{ __('Booking Terbaru') }}
                        </h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 text-uppercase small fw-bold p-3">{{ __('PELANGGAN') }}</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">{{ __('STATUS') }}</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">{{ __('TANGGAL') }}</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">{{ __('TOTAL HARGA') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($service->bookings->take(5) as $booking)
                                    <tr>
                                        <td class="p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 45px; height: 45px; background: linear-gradient(135deg, #4e73df, #224abe);">
                                                    {{ substr($booking->user->name, 0, 1) }}
                                                </div>
                                                <span class="fw-bold">{{ $booking->user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            @php
                                                $statusColors = [
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger',
                                                    'in_progress' => 'primary',
                                                    'pending' => 'warning'
                                                ];
                                                $statusColor = $statusColors[$booking->status] ?? 'secondary';
                                                $statusIcon = [
                                                    'completed' => 'check-circle',
                                                    'cancelled' => 'times-circle',
                                                    'in_progress' => 'spinner',
                                                    'pending' => 'clock'
                                                ][$booking->status] ?? 'info-circle';
                                            @endphp
                                            <span class="badge rounded-pill text-white px-3 py-2 fw-bold" 
                                                  style="background: linear-gradient(135deg, 
                                                  {{ $statusColor === 'primary' ? '#4e73df, #224abe' : 
                                                     ($statusColor === 'success' ? '#1cc88a, #13855c' : 
                                                     ($statusColor === 'warning' ? '#f6c23e, #dda20a' : 
                                                     ($statusColor === 'danger' ? '#e74a3b, #be2617' : '#858796, #60616f'))) }});">
                                                <i class="fas fa-{{ $statusIcon }} me-1"></i> {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="p-3">
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
                                        </td>
                                        <td class="p-3 fw-bold">
                                            Rp {{ number_format($booking->total_price ?? $service->price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>