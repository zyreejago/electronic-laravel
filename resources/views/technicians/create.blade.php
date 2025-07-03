<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Teknisi Baru') }}
            </h2>
            <a href="{{ route('technicians.index') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>{{ __('Kembali ke Teknisi') }}
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-user-plus me-2"></i>{{ __('Informasi Teknisi') }}
                    </h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('technicians.store') }}" method="POST">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold text-primary">
                                <i class="fas fa-user me-2"></i>{{ __('Nama Lengkap') }}
                            </label>
                            <input type="text" class="form-control form-control-lg border-0 shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('Masukkan nama lengkap teknisi') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold text-primary">
                                <i class="fas fa-envelope me-2"></i>{{ __('Alamat Email') }}
                            </label>
                            <input type="email" class="form-control form-control-lg border-0 shadow-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Masukkan alamat email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold text-primary">
                                <i class="fas fa-phone me-2"></i>{{ __('Nomor WhatsApp') }}
                            </label>
                            <input type="text" class="form-control form-control-lg border-0 shadow-sm @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="{{ __('contoh: 08123456789') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-bold text-primary">
                                <i class="fas fa-lock me-2"></i>{{ __('Kata Sandi') }}
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg border-0 shadow-sm @error('password') is-invalid @enderror" id="password" name="password" placeholder="{{ __('Masukkan kata sandi') }}" required>
                                <button class="btn btn-outline-secondary border-0 shadow-sm" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-bold text-primary">
                                <i class="fas fa-lock me-2"></i>{{ __('Konfirmasi Kata Sandi') }}
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg border-0 shadow-sm" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Konfirmasi kata sandi') }}" required>
                                <button class="btn btn-outline-secondary border-0 shadow-sm" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="specialization" class="form-label fw-bold text-primary">
                            <i class="fas fa-tools me-2"></i>{{ __('Spesialisasi') }}
                        </label>
                        <input type="text" class="form-control form-control-lg border-0 shadow-sm @error('specialization') is-invalid @enderror" id="specialization" name="specialization" value="{{ old('specialization') }}" placeholder="{{ __('contoh: Perbaikan Smartphone, Hardware Komputer, dll.') }}" required>
                        @error('specialization')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="bio" class="form-label fw-bold text-primary">
                            <i class="fas fa-address-card me-2"></i>{{ __('Bio') }}
                        </label>
                        <textarea class="form-control border-0 shadow-sm @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4" placeholder="{{ __('Masukkan bio dan pengalaman teknisi...') }}">{{ old('bio') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text mt-2">{{ __('Berikan deskripsi singkat tentang pengalaman dan keahlian teknisi.') }}</div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input @error('is_available') is-invalid @enderror" id="is_available" name="is_available" value="1" {{ old('is_available') ? 'checked' : '' }} style="width: 3em; height: 1.5em;">
                            <label class="form-check-label fw-bold text-primary" for="is_available">
                                <i class="fas fa-calendar-check me-2"></i>{{ __('Tersedia untuk Booking') }}
                            </label>
                            @error('is_available')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text ms-5">{{ __('Aktifkan switch ini untuk menunjukkan bahwa teknisi saat ini tersedia untuk menerima booking baru.') }}</div>
                    </div>

                    <div class="alert border-0 mb-4 p-3" style="background: rgba(78, 115, 223, 0.1); color: #4e73df; border-left: 4px solid #4e73df;">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ __('Catatan Penting') }}</h6>
                                <p class="mb-0">{{ __('Akun pengguna baru akan dibuat untuk teknisi ini dengan email dan kata sandi yang diberikan. Teknisi akan secara otomatis diberikan peran "teknisi".') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('technicians.index') }}" class="btn btn-outline-secondary btn-lg px-5">
                            <i class="fas fa-times me-2"></i>{{ __('Batal') }}
                        </a>
                        <button type="submit" class="btn btn-success btn-lg px-5">
                            <i class="fas fa-user-plus me-2"></i>{{ __('Buat Teknisi') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
    @endpush
</x-app-layout>