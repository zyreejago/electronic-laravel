<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Update Password') }}
            </h2>
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Profile
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-key me-2"></i>Change Password
                    </h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    <div class="mb-4">
                        <label for="current_password" class="form-label fw-bold text-primary">
                            <i class="fas fa-lock me-2"></i>Current Password
                        </label>
                        <input type="password" class="form-control form-control-lg border-0 shadow-sm @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold text-primary">
                            <i class="fas fa-key me-2"></i>New Password
                        </label>
                        <input type="password" class="form-control form-control-lg border-0 shadow-sm @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-bold text-primary">
                            <i class="fas fa-key me-2"></i>Confirm New Password
                        </label>
                        <input type="password" class="form-control form-control-lg border-0 shadow-sm" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="alert border-0 mb-4 p-3" style="background: rgba(28, 200, 138, 0.1); color: #13855c; border-left: 4px solid #1cc88a;">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-shield-alt fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Password Requirements</h6>
                                <p class="mb-0">Your password must be at least 8 characters long and should include a mix of letters, numbers, and special characters for better security.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-lg px-5">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-success btn-lg px-5">
                            <i class="fas fa-save me-2"></i>Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 