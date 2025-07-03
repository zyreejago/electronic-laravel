<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Teknisi') }}
            </h2>
            <a href="{{ route('technicians.index') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>{{ __('Kembali ke Teknisi') }}
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-user-edit me-2"></i>{{ __('Edit Teknisi: ') }}{{ $technician->user->name }}
                    </h5>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4 p-3 rounded-3" style="background: rgba(78, 115, 223, 0.05);">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                         style="width: 60px; height: 60px; background: linear-gradient(135deg, #4e73df, #224abe);">
                        {{ substr($technician->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">{{ $technician->user->name }}</h5>
                        <div class="text-muted">
                            <i class="fas fa-envelope me-2"></i>{{ $technician->user->email }}
                        </div>
                    </div>
                    <div class="ms-auto">
                        <span class="badge rounded-pill text-white px-3 py-2 fw-bold" 
                              style="background: linear-gradient(135deg, {{ $technician->is_available ? '#1cc88a, #13855c' : '#e74a3b, #be2617' }});">
                            <i class="fas fa-{{ $technician->is_available ? 'check-circle' : 'times-circle' }} me-1"></i>
                            {{ $technician->is_available ? __('Tersedia') : __('Tidak Tersedia') }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('technicians.update', $technician) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold text-primary">
                                <i class="fas fa-user me-2"></i>{{ __('Nama Lengkap') }}
                            </label>
                            <input type="text" class="form-control form-control-lg border-0 shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $technician->user->name) }}" placeholder="{{ __('Masukkan nama lengkap teknisi') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold text-primary">
                                <i class="fas fa-envelope me-2"></i>{{ __('Alamat Email') }}
                            </label>
                            <input type="email" class="form-control form-control-lg border-0 shadow-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $technician->user->email) }}" placeholder="{{ __('Masukkan alamat email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="specialization" class="form-label fw-bold text-primary">
                            <i class="fas fa-tools me-2"></i>{{ __('Spesialisasi') }}
                        </label>
                        <input type="text" class="form-control form-control-lg border-0 shadow-sm @error('specialization') is-invalid @enderror" id="specialization" name="specialization" value="{{ old('specialization', $technician->specialization) }}" placeholder="{{ __('contoh: Perbaikan Smartphone, Hardware Komputer, dll.') }}" required>
                        @error('specialization')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="bio" class="form-label fw-bold text-primary">
                            <i class="fas fa-address-card me-2"></i>{{ __('Bio') }}
                        </label>
                        <textarea class="form-control border-0 shadow-sm @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4" placeholder="{{ __('Masukkan bio dan pengalaman teknisi...') }}">{{ old('bio', $technician->bio) }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text mt-2">{{ __('Berikan deskripsi singkat tentang pengalaman dan keahlian teknisi.') }}</div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input @error('is_available') is-invalid @enderror" id="is_available" name="is_available" value="1" {{ old('is_available', $technician->is_available) ? 'checked' : '' }} style="width: 3em; height: 1.5em;">
                            <label class="form-check-label fw-bold text-primary" for="is_available">
                                <i class="fas fa-calendar-check me-2"></i>{{ __('Tersedia untuk Booking') }}
                            </label>
                            @error('is_available')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text ms-5">{{ __('Aktifkan tombol ini untuk menunjukkan bahwa teknisi saat ini tersedia untuk menerima booking baru.') }}</div>
                    </div>

                    <div class="alert border-0 mb-4 p-3" style="background: rgba(246, 194, 62, 0.1); color: #dda20a; border-left: 4px solid #f6c23e;">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ __('Ubah Kata Sandi') }}</h6>
                                <p class="mb-0">{{ __('Jika Anda perlu mereset kata sandi teknisi, silakan gunakan bagian manajemen pengguna. Perubahan kata sandi tidak ditangani dalam form ini.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('technicians.index') }}" class="btn btn-outline-secondary btn-lg px-5">
                            <i class="fas fa-times me-2"></i>{{ __('Batal') }}
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-save me-2"></i>{{ __('Perbarui Teknisi') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>