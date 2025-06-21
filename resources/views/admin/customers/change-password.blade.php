<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Change Password - ') . $customer->name }}
            </h2>
            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-secondary btn-lg shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Customer
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        @if($errors->any())
            <div class="alert border-0 shadow-sm rounded-3 mb-4" style="background: linear-gradient(135deg, #e74a3b, #be2617); color: white;">
                <div class="d-flex align-items-center">
                    <div class="p-2 me-3 bg-white bg-opacity-25 rounded-circle">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <strong>Error!</strong> Please check the form below.
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="card border-0 shadow rounded-4">
            <div class="card-header bg-warning text-dark rounded-top-4">
                <h5 class="mb-0"><i class="fas fa-key me-2"></i>Change Customer Password</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.customers.change-password', $customer) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <form method="POST" action="{{ route('admin.customers.reset-password', $customer) }}" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Reset password to default (password123)?')">
                                <i class="fas fa-undo me-2"></i>Reset to Default
                            </button>
                        </form>
                        
                        <div>
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-secondary me-2">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Change Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>