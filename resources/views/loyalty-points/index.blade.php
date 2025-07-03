<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Poin Loyalitas') }}
            </h2>
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
                        <strong>{{ __('Berhasil!') }}</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <!-- Points Summary Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <div class="card-body p-0">
                        <div class="d-flex h-100">
                            <div class="p-4 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #4e73df, #224abe); width: 100px;">
                                <i class="fas fa-star fa-3x text-white"></i>
                            </div>
                            <div class="p-4 flex-grow-1">
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">CURRENT POINTS BALANCE</h6>
                                <h2 class="display-4 fw-bold mb-0">{{ $currentPoints }}</h2>
                                <p class="text-muted mt-2 mb-0">Total points accumulated</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <div class="card-body p-0">
                        <div class="d-flex h-100">
                            <div class="p-4 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #36b9cc, #258391); width: 100px;">
                                <i class="fas fa-gift fa-3x text-white"></i>
                            </div>
                            <div class="p-4 flex-grow-1">
                                <h6 class="text-uppercase text-muted mb-1 small fw-bold">POINTS TO NEXT REWARD</h6>
                                <h2 class="display-4 fw-bold mb-0">{{ $pointsToNextReward }}</h2>
                                <p class="text-muted mt-2 mb-0">Keep going to earn rewards!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rewards Information -->
        <!-- <div class="card border-0 shadow mb-4 rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #f6c23e, #dda20a);" class="text-white p-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-award me-2"></i>Available Rewards
                    </h5>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4 text-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 mx-auto mb-3" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-percentage fa-2x"></i>
                                </div>
                                <h5 class="fw-bold">10% Discount</h5>
                                <p class="text-muted mb-3">Get 10% off your next service booking</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-primary">500 points</span>
                                    <button class="btn btn-sm btn-outline-primary" {{ $currentPoints >= 500 ? '' : 'disabled' }}>
                                        {{ $currentPoints >= 500 ? 'Redeem' : 'Not Enough Points' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4 text-center">
                                <div class="rounded-circle bg-success bg-opacity-10 text-success p-3 mx-auto mb-3" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-tools fa-2x"></i>
                                </div>
                                <h5 class="fw-bold">Free Service</h5>
                                <p class="text-muted mb-3">Get a free basic service check-up</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-success">1000 points</span>
                                    <button class="btn btn-sm btn-outline-success" {{ $currentPoints >= 1000 ? '' : 'disabled' }}>
                                        {{ $currentPoints >= 1000 ? 'Redeem' : 'Not Enough Points' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4 text-center">
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3 mx-auto mb-3" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-truck fa-2x"></i>
                                </div>
                                <h5 class="fw-bold">Free Pickup</h5>
                                <p class="text-muted mb-3">Free pickup service for your next booking</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-warning">750 points</span>
                                    <button class="btn btn-sm btn-outline-warning" {{ $currentPoints >= 750 ? '' : 'disabled' }}>
                                        {{ $currentPoints >= 750 ? 'Redeem' : 'Not Enough Points' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Transaction History -->
        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-history me-2"></i>{{ __('Riwayat Transaksi') }}
                    </h5>
                </div>
            </div>
            <div class="card-body p-0">
                @if($transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 text-uppercase small fw-bold p-3">DATE</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">DESCRIPTION</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">POINTS</th>
                                    <th class="border-0 text-uppercase small fw-bold p-3">TYPE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-light p-2 me-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-calendar-day text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $transaction->created_at->format('M d, Y') }}</div>
                                                    <div class="small text-muted">{{ $transaction->created_at->format('H:i') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            <span class="fw-bold">{{ $transaction->description }}</span>
                                        </td>
                                        <td class="p-3">
                                            <span class="badge rounded-pill px-3 py-2 fw-bold {{ $transaction->points > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $transaction->points > 0 ? '+' : '' }}{{ $transaction->points }}
                                            </span>
                                        </td>
                                        <td class="p-3">
                                            <span class="badge rounded-pill text-white px-3 py-2 fw-bold" 
                                                  style="background: linear-gradient(135deg, 
                                                  {{ $transaction->type === 'earn' ? '#1cc88a, #13855c' : '#f6c23e, #dda20a' }});">
                                                <i class="fas fa-{{ $transaction->type === 'earn' ? 'plus-circle' : 'minus-circle' }} me-1"></i>
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-top">
                        {{ $transactions->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="rounded-circle bg-light p-4 mx-auto mb-3" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-history fa-3x text-muted"></i>
                        </div>
                        <h5 class="fw-bold">No Transactions Yet</h5>
                        <p class="text-muted mb-0">You haven't earned or redeemed any points yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- How to Earn Points -->
        <!-- <div class="card border-0 shadow mt-4 rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-question-circle me-2"></i>How to Earn Points
                    </h5>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="d-flex">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 me-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-calendar-check fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Book Services</h6>
                                <p class="text-muted mb-0">Earn 100 points for every service booking you complete</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-3 me-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-star fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Leave Reviews</h6>
                                <p class="text-muted mb-0">Earn 50 points when you rate and review a completed service</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex">
                            <div class="rounded-circle bg-info bg-opacity-10 text-info p-3 me-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user-plus fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Refer Friends</h6>
                                <p class="text-muted mb-0">Earn 200 points for each friend who signs up and books a service</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</x-app-layout>