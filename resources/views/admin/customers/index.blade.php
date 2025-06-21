<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Customers') }}
            </h2>
            <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-user-plus me-2"></i>Add New Customer
            </a>
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

        <!-- Search Form -->
        <div class="card border-0 shadow rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('admin.customers.index') }}">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0" name="search" placeholder="Search by name, email, or phone..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-users me-2"></i>All Customers
                        </h5>
                        <span class="badge bg-white text-dark px-3 py-2">
                            Total: {{ $customers->total() }} customers
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 text-uppercase small fw-bold p-3">CUSTOMER</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">CONTACT</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">BOOKINGS</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">LAST BOOKING</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">JOINED</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 45px; height: 45px; background: linear-gradient(135deg, #1cc88a, #13855c);">
                                                {{ substr($customer->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="fw-bold d-block">{{ $customer->name }}</span>
                                                <small class="text-muted">#{{ $customer->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <div class="mb-1">
                                            <i class="fas fa-envelope text-primary me-2"></i>
                                            <span>{{ $customer->email }}</span>
                                        </div>
                                        <div>
                                            <i class="fas fa-phone text-success me-2"></i>
                                            <span>{{ $customer->phone_number }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <span class="badge bg-primary rounded-pill px-3 py-2">
                                            {{ $customer->bookings_count }} bookings
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        @if($customer->bookings->count() > 0)
                                            <span class="text-muted">{{ $customer->bookings->first()->created_at->diffForHumans() }}</span>
                                        @else
                                            <span class="text-muted">No bookings</span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <span class="text-muted">{{ $customer->created_at->format('d M Y') }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-info btn-sm shadow-sm">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-warning btn-sm shadow-sm">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Are you sure you want to delete this customer?')">
                                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-top">
                    {{ $customers->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>