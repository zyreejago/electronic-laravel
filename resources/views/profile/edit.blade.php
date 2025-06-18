<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="row g-4">
            <!-- Profile Information -->
            <div class="col-lg-8">
                <div class="card border-0 shadow rounded-4 overflow-hidden">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-user-circle me-2"></i>Profile Information
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-4">
                            {{ __("Update your account's profile information and email address.") }}
                        </p>

                        @if (session('success'))
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

                        <form method="post" action="{{ route('profile.update') }}" class="mt-4">
                            @csrf
                            @method('patch')

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold text-primary">
                                            <i class="fas fa-user me-2"></i>Name
                                        </label>
                                        <input type="text" class="form-control form-control-lg border-0 shadow-sm @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-bold text-primary">
                                            <i class="fas fa-envelope me-2"></i>Email
                                        </label>
                                        <input type="email" class="form-control form-control-lg border-0 shadow-sm @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone_number" class="form-label fw-bold text-primary">
                                            <i class="fas fa-phone me-2"></i>Phone Number
                                        </label>
                                        <input type="text" class="form-control form-control-lg border-0 shadow-sm @error('phone_number') is-invalid @enderror" 
                                               id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" autocomplete="tel">
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-bold text-primary">
                                            <i class="fas fa-map-marker-alt me-2"></i>Address
                                        </label>
                                        <input type="text" class="form-control form-control-lg border-0 shadow-sm @error('address') is-invalid @enderror" 
                                               id="address" name="address" value="{{ old('address', $user->address) }}" autocomplete="street-address">
                                        @error('address')
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
                                        <h6 class="fw-bold mb-1">Profile Information</h6>
                                        <p class="mb-0">Your profile information is used to personalize your experience and for communication regarding your bookings and services.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Password Update -->
                <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-lock me-2"></i>Update Password
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-3">
                            {{ __('Ensure your account is using a long, random password to stay secure.') }}
                        </p>
                        <div class="d-grid">
                            <a href="{{ route('password.edit') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-key me-2"></i>Change Password
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="card border-0 shadow rounded-4 overflow-hidden">
                    <div class="card-header p-0">
                        <div style="background: linear-gradient(90deg, #e74a3b, #be2617);" class="text-white p-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-trash-alt me-2"></i>Delete Account
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-3">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                        </p>
                        <div class="d-grid">
                            <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                <i class="fas fa-user-slash me-2"></i>Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                <div class="modal-header text-white p-4 border-bottom-0" style="background: linear-gradient(135deg, #e74a3b, #be2617);">
                    <h5 class="modal-title fw-bold" id="deleteAccountModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert border-0 p-3 mb-4" style="background: rgba(231, 74, 59, 0.1); color: #e74a3b; border-left: 4px solid #e74a3b;">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-exclamation-circle fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Warning!</h6>
                                <p class="mb-0">This action cannot be undone. All your data will be permanently deleted.</p>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-4">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>
                    
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')
                        
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-danger">Password Confirmation</label>
                            <input type="password" class="form-control form-control-lg border-0 shadow-sm @error('password', 'userDeletion') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Enter your password" required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fas fa-trash-alt me-2"></i>Delete Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>