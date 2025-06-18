<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports & Analytics') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <!-- Date Range Filter -->
        <div class="card border-0 shadow mb-4 rounded-4 overflow-hidden">
            <div class="card-body p-4 bg-light bg-gradient">
                <form class="row g-3">
                    <div class="col-md-4">
                        <label for="dateFrom" class="form-label fw-bold text-primary">
                            <i class="fas fa-calendar-alt me-2"></i>From Date
                        </label>
                        <input type="date" class="form-control form-control-lg border-0 shadow-sm" id="dateFrom" name="date_from" value="{{ request('date_from', now()->subMonths(3)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="dateTo" class="form-label fw-bold text-primary">
                            <i class="fas fa-calendar-alt me-2"></i>To Date
                        </label>
                        <input type="date" class="form-control form-control-lg border-0 shadow-sm" id="dateTo" name="date_to" value="{{ request('date_to', now()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                            <i class="fas fa-filter me-2"></i>Apply Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <div class="card-body p-0">
                        <div class="d-flex h-100">
                            <div class="p-4 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #4e73df, #224abe); width: 100px;">
                                <i class="fas fa-calendar-check fa-2x text-white"></i>
                            </div>
                            <div class="p-4 flex-grow-1">
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">TOTAL BOOKINGS</h6>
                                <h2 class="display-5 fw-bold mb-1">{{ $totalBookings }}</h2>
                                <p class="mb-0 text-success">
                                    <i class="fas fa-arrow-up me-1"></i>
                                    <span class="fw-bold">12%</span> from last month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <div class="card-body p-0">
                        <div class="d-flex h-100">
                            <div class="p-4 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #1cc88a, #13855c); width: 100px;">
                                <i class="fas fa-check-circle fa-2x text-white"></i>
                            </div>
                            <div class="p-4 flex-grow-1">
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">COMPLETED</h6>
                                <h2 class="display-5 fw-bold mb-1">{{ $completedBookings }}</h2>
                                <p class="mb-0 text-success">
                                    <i class="fas fa-arrow-up me-1"></i>
                                    <span class="fw-bold">8%</span> from last month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <div class="card-body p-0">
                        <div class="d-flex h-100">
                            <div class="p-4 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #f6c23e, #dda20a); width: 100px;">
                                <i class="fas fa-clock fa-2x text-white"></i>
                            </div>
                            <div class="p-4 flex-grow-1">
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">PENDING</h6>
                                <h2 class="display-5 fw-bold mb-1">{{ $pendingBookings }}</h2>
                                <p class="mb-0 text-danger">
                                    <i class="fas fa-arrow-down me-1"></i>
                                    <span class="fw-bold">3%</span> from last month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <div class="card-body p-0">
                        <div class="d-flex h-100">
                            <div class="p-4 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #36b9cc, #258391); width: 100px;">
                                <i class="fas fa-money-bill-wave fa-2x text-white"></i>
                            </div>
                            <div class="p-4 flex-grow-1">
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">REVENUE</h6>
                                <h2 class="display-5 fw-bold mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                                <p class="mb-0 text-success">
                                    <i class="fas fa-arrow-up me-1"></i>
                                    <span class="fw-bold">15%</span> from last month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- Monthly Bookings Chart -->
            <div class="col-lg-8">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <div class="card-header bg-white p-4 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-primary">
                                <i class="fas fa-chart-line me-2"></i>Monthly Bookings
                            </h5>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary active">6 Months</button>
                                <button type="button" class="btn btn-outline-primary">1 Year</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="monthlyBookingsChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Services -->
            <div class="col-lg-4">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="fas fa-trophy me-2"></i>Top Services
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex flex-column gap-4">
                            @foreach($topServices as $index => $service)
                                @php
                                    $colors = ['primary', 'success', 'info', 'warning', 'danger'];
                                    $color = $colors[$index % 5];
                                    $percentage = number_format($service->bookings_count / $totalBookings * 100, 1);
                                @endphp
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" 
                                             style="width: 40px; height: 40px; background: linear-gradient(135deg, 
                                             {{ $color === 'primary' ? '#4e73df, #224abe' : 
                                                ($color === 'success' ? '#1cc88a, #13855c' : 
                                                ($color === 'info' ? '#36b9cc, #258391' : 
                                                ($color === 'warning' ? '#f6c23e, #dda20a' : '#e74a3b, #be2617'))) }});">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold">{{ $service->name }}</h6>
                                            <span class="badge rounded-pill text-white px-3 py-2" 
                                                  style="background: linear-gradient(135deg, 
                                                  {{ $color === 'primary' ? '#4e73df, #224abe' : 
                                                     ($color === 'success' ? '#1cc88a, #13855c' : 
                                                     ($color === 'info' ? '#36b9cc, #258391' : 
                                                     ($color === 'warning' ? '#f6c23e, #dda20a' : '#e74a3b, #be2617'))) }});">
                                                {{ $service->bookings_count }}
                                            </span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $percentage }}%;" 
                                                 aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technician Performance -->
        <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white p-4 border-0">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-users-cog me-2"></i>Technician Performance
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 text-uppercase small fw-bold p-3">TECHNICIAN</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">COMPLETED JOBS</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">AVERAGE RATING</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">ON-TIME COMPLETION</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">TOTAL REVENUE</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">PERFORMANCE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($technicianStats as $stat)
                                <tr>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 45px; height: 45px; background: linear-gradient(135deg, #4e73df, #224abe);">
                                                {{ substr($stat['name'], 0, 1) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $stat['name'] }}</h6>
                                                <small class="text-muted">Technician</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <span class="badge rounded-pill bg-primary px-3 py-2 fw-bold">
                                            {{ $stat['completed_jobs'] }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold me-2">{{ number_format($stat['average_rating'], 1) }}</span>
                                            <div class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor($stat['average_rating']))
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i - 0.5 <= $stat['average_rating'])
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 me-2">
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar 
                                                        {{ $stat['on_time_percentage'] >= 90 ? 'bg-success' : ($stat['on_time_percentage'] >= 70 ? 'bg-warning' : 'bg-danger') }}" 
                                                        role="progressbar" style="width: {{ $stat['on_time_percentage'] }}%;" 
                                                        aria-valuenow="{{ $stat['on_time_percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <span class="fw-bold">{{ number_format($stat['on_time_percentage'], 1) }}%</span>
                                        </div>
                                    </td>
                                    <td class="p-3 fw-bold">
                                        Rp {{ number_format($stat['total_revenue'], 0, ',', '.') }}
                                    </td>
                                    <td class="p-3">
                                        <span class="badge rounded-pill text-white px-3 py-2 fw-bold" 
                                              style="background: linear-gradient(135deg, 
                                              {{ $stat['on_time_percentage'] >= 90 && $stat['average_rating'] >= 4.5 ? '#1cc88a, #13855c' : 
                                                 ($stat['on_time_percentage'] >= 70 && $stat['average_rating'] >= 3.5 ? '#f6c23e, #dda20a' : '#e74a3b, #be2617') }});">
                                            {{ $stat['on_time_percentage'] >= 90 && $stat['average_rating'] >= 4.5 ? 'Excellent' : 
                                               ($stat['on_time_percentage'] >= 70 && $stat['average_rating'] >= 3.5 ? 'Good' : 'Needs Improvement') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Monthly Bookings Chart
        const ctx = document.getElementById('monthlyBookingsChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthlyBookings->pluck('month')),
                datasets: [{
                    label: 'Number of Bookings',
                    data: @json($monthlyBookings->pluck('count')),
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4e73df',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>