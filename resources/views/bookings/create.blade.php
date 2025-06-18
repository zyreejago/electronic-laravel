<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Booking') }}
            </h2>
            <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary btn-lg shadow-sm">
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
                        <i class="fas fa-calendar-plus me-2"></i>Booking Information
                    </h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
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

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="technician_id" class="form-label fw-bold text-primary">
                                    <i class="fas fa-user-cog me-2"></i>Preferred Technician (Optional)
                                </label>
                                <select name="technician_id" id="technician_id" class="form-select form-select-lg border-0 shadow-sm @error('technician_id') is-invalid @enderror">
                                    <option value="">No preference</option>
                                    @foreach($technicians as $technician)
                                        <option value="{{ $technician->id }}" {{ old('technician_id') == $technician->id ? 'selected' : '' }}>
                                            {{ $technician->user->name ?? 'No Name' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('technician_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="service_type" class="form-label fw-bold text-primary">
                                    <i class="fas fa-truck me-2"></i>Service Type
                                </label>
                                <select name="service_type" id="service_type" class="form-select form-select-lg border-0 shadow-sm @error('service_type') is-invalid @enderror" required>
                                    <option value="">Select service type</option>
                                    <option value="pickup" {{ old('service_type') == 'pickup' ? 'selected' : '' }}>Pickup Service</option>
                                    <option value="dropoff" {{ old('service_type') == 'dropoff' ? 'selected' : '' }}>Drop-off Service</option>
                                    <option value="onsite" {{ old('service_type') == 'onsite' ? 'selected' : '' }}>On-site Service</option>
                                </select>
                                @error('service_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="scheduled_at" class="form-label fw-bold text-primary">
                                    <i class="fas fa-calendar-alt me-2"></i>Preferred Date and Time
                                </label>
                                <input type="datetime-local" name="scheduled_at" id="scheduled_at" 
                                       class="form-control form-control-lg border-0 shadow-sm @error('scheduled_at') is-invalid @enderror"
                                       value="{{ old('scheduled_at') }}" required>
                                @error('scheduled_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12" id="addressField" style="display: none;">
                            <div class="mb-3">
                                <label for="address" class="form-label fw-bold text-primary">
                                    <i class="fas fa-map-marker-alt me-2"></i>Address
                                </label>
                                <textarea name="address" id="address" class="form-control border-0 shadow-sm @error('address') is-invalid @enderror" rows="3" placeholder="Enter your complete address for pickup or on-site service...">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="components" class="form-label fw-bold text-primary">
                                    <i class="fas fa-cogs me-2"></i>Tambahkan Komponen (Opsional)
                                </label>
                                <div class="row">
                                    @foreach($components as $component)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input component-checkbox" type="checkbox" value="{{ $component->id }}" id="component_{{ $component->id }}" name="components[{{ $component->id }}][checked]">
                                                <label class="form-check-label" for="component_{{ $component->id }}">
                                                    {{ $component->name }} <span class="text-muted">(Rp {{ number_format($component->price, 0, ',', '.') }})</span>
                                                </label>
                                                <input type="number" min="1" value="1" class="form-control form-control-sm mt-1 component-qty" name="components[{{ $component->id }}][qty]" style="width: 80px; display: none;" placeholder="Qty">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" id="is_emergency" name="is_emergency">
                                <label class="form-check-label fw-bold text-danger" for="is_emergency">
                                    <i class="fas fa-bolt me-2"></i>Emergency Service (Prioritas, +Rp 100.000)
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="alert alert-info" id="estimateBox">
                                <strong>Estimasi Total Biaya:</strong> <span id="estimateTotal">Rp 0</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold text-primary">
                                    <i class="fas fa-comment-alt me-2"></i>Additional Notes
                                </label>
                                <textarea name="description" id="description" class="form-control border-0 shadow-sm @error('description') is-invalid @enderror" rows="4" placeholder="Describe your issue or provide any additional information that might help us...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="alert border-0 p-3 mt-4" style="background: rgba(78, 115, 223, 0.1); color: #4e73df; border-left: 4px solid #4e73df;">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Booking Information</h6>
                                <p class="mb-0">Your booking will be reviewed by our team and a confirmation will be sent to your email. For pickup and on-site services, please provide a complete address.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary btn-lg px-5">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-calendar-check me-2"></i>Create Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceTypeSelect = document.getElementById('service_type');
        const addressField = document.getElementById('addressField');

        function toggleAddressField() {
            const selectedType = serviceTypeSelect.value;
            if (selectedType === 'pickup' || selectedType === 'onsite') {
                addressField.style.display = 'block';
                document.getElementById('address').required = true;
            } else {
                addressField.style.display = 'none';
                document.getElementById('address').required = false;
            }
        }

        serviceTypeSelect.addEventListener('change', toggleAddressField);
        toggleAddressField(); // Initial check

        // Estimasi biaya
        const serviceSelect = document.getElementById('service_id');
        const estimateBox = document.getElementById('estimateBox');
        const estimateTotal = document.getElementById('estimateTotal');
        const componentCheckboxes = document.querySelectorAll('.component-checkbox');
        const componentQtyInputs = document.querySelectorAll('.component-qty');
        const componentsData = @json($components->keyBy('id'));
        const servicesData = @json($services->keyBy('id'));

        function updateEstimate() {
            let total = 0;
            // Service price
            const serviceId = serviceSelect.value;
            if (serviceId && servicesData[serviceId]) {
                total += parseInt(servicesData[serviceId].price);
            }
            // Components
            componentCheckboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    const compId = checkbox.value;
                    const qtyInput = checkbox.closest('.form-check').querySelector('.component-qty');
                    const qty = parseInt(qtyInput.value) || 1;
                    total += (parseInt(componentsData[compId].price) * qty);
                }
            });
            // Delivery fee
            const type = serviceTypeSelect.value;
            if (type === 'pickup' || type === 'onsite') {
                total += 50000;
            }
            // Emergency fee
            const emergencyCheckbox = document.getElementById('is_emergency');
            if (emergencyCheckbox && emergencyCheckbox.checked) {
                total += 100000;
            }
            estimateTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        // Show/hide qty input
        componentCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const qtyInput = this.closest('.form-check').querySelector('.component-qty');
                qtyInput.style.display = this.checked ? 'inline-block' : 'none';
                updateEstimate();
            });
        });
        componentQtyInputs.forEach(function(input) {
            input.addEventListener('input', updateEstimate);
        });
        serviceSelect.addEventListener('change', updateEstimate);
        serviceTypeSelect.addEventListener('change', updateEstimate);
        if (emergencyCheckbox) {
            emergencyCheckbox.addEventListener('change', updateEstimate);
        }
        updateEstimate();
    });
    </script>
    @endpush
</x-app-layout>