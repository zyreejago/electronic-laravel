<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Booking (Admin)') }}
            </h2>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Bookings
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        @if(session('error'))
            <div class="alert border-0 shadow-sm rounded-3 mb-4" style="background: linear-gradient(135deg, #e74a3b, #be2617); color: white;">
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
                <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-calendar-plus me-2"></i>Create Booking for Customer
                    </h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.bookings.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <!-- Customer Selection -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_id" class="form-label fw-bold text-primary">
                                    <i class="fas fa-user me-2"></i>Customer
                                </label>
                                <select name="user_id" id="user_id" class="form-select form-select-lg border-0 shadow-sm @error('user_id') is-invalid @enderror" required>
                                    <option value="">Select a customer</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Service Selection -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="service_id" class="form-label fw-bold text-primary">
                                    <i class="fas fa-tools me-2"></i>Service
                                </label>
                                <select name="service_id" id="service_id" class="form-select form-select-lg border-0 shadow-sm @error('service_id') is-invalid @enderror" required>
                                    <option value="">Select a service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Technician Selection -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="technician_id" class="form-label fw-bold text-primary">
                                    <i class="fas fa-user-cog me-2"></i>Technician
                                </label>
                                <select name="technician_id" id="technician_id" class="form-select form-select-lg border-0 shadow-sm @error('technician_id') is-invalid @enderror" required>
                                    <option value="">Select a technician</option>
                                    @foreach($technicians as $technician)
                                        <option value="{{ $technician->id }}" {{ old('technician_id') == $technician->id ? 'selected' : '' }}>
                                            {{ $technician->user->name }} - {{ $technician->specialization }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('technician_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Service Type -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="service_type" class="form-label fw-bold text-primary">
                                    <i class="fas fa-truck me-2"></i>Service Type
                                </label>
                                <select name="service_type" id="service_type" class="form-select form-select-lg border-0 shadow-sm @error('service_type') is-invalid @enderror" required>
                                    <option value="">Select service type</option>
                                    <option value="pickup" {{ old('service_type') == 'pickup' ? 'selected' : '' }}>Pickup (+Rp 50,000)</option>
                                    <option value="dropoff" {{ old('service_type') == 'dropoff' ? 'selected' : '' }}>Drop-off</option>
                                    <option value="onsite" {{ old('service_type') == 'onsite' ? 'selected' : '' }}>On-site (+Rp 50,000)</option>
                                </select>
                                @error('service_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-12" id="address-field" style="display: none;">
                            <div class="mb-3">
                                <label for="address" class="form-label fw-bold text-primary">
                                    <i class="fas fa-map-marker-alt me-2"></i>Address
                                </label>
                                <textarea name="address" id="address" rows="3" class="form-control form-control-lg border-0 shadow-sm @error('address') is-invalid @enderror" placeholder="Enter the address for pickup or on-site service">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold text-primary">
                                    <i class="fas fa-file-alt me-2"></i>Description
                                </label>
                                <textarea name="description" id="description" rows="4" class="form-control form-control-lg border-0 shadow-sm @error('description') is-invalid @enderror" placeholder="Describe the issue or service needed" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Scheduled Date -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="scheduled_at" class="form-label fw-bold text-primary">
                                    <i class="fas fa-calendar me-2"></i>Scheduled Date & Time
                                </label>
                                <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control form-control-lg border-0 shadow-sm @error('scheduled_at') is-invalid @enderror" value="{{ old('scheduled_at') }}" min="{{ now()->addHour()->format('Y-m-d\TH:i') }}" required>
                                @error('scheduled_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Emergency Service -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_emergency" id="is_emergency" {{ old('is_emergency') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-warning" for="is_emergency">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Emergency Service (+Rp 100,000)
                                    </label>
                                </div>
                                <small class="text-muted">Check this for urgent repairs that need immediate attention</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-4 shadow">
                            <i class="fas fa-save me-2"></i>Create Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('service_type').addEventListener('change', function() {
            const addressField = document.getElementById('address-field');
            const addressInput = document.getElementById('address');
            
            if (this.value === 'pickup' || this.value === 'onsite') {
                addressField.style.display = 'block';
                addressInput.required = true;
            } else {
                addressField.style.display = 'none';
                addressInput.required = false;
                addressInput.value = '';
            }
        });
    </script>
</x-app-layout>