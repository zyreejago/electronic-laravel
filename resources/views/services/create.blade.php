<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Layanan Baru') }}
            </h2>
            <a href="{{ route('services.index') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>{{ __('Kembali ke Layanan') }}
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-plus-circle me-2"></i>{{ __('Informasi Layanan') }}
                    </h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('services.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold text-primary">
                            <i class="fas fa-tag me-2"></i>{{ __('Nama Layanan') }}
                        </label>
                        <input type="text" class="form-control form-control-lg border-0 shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('Masukkan nama layanan') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold text-primary">
                            <i class="fas fa-align-left me-2"></i>{{ __('Deskripsi') }}
                        </label>
                        <textarea class="form-control border-0 shadow-sm @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="{{ __('Masukkan deskripsi layanan') }}" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-bold text-primary">
                                <i class="fas fa-money-bill-wave me-2"></i>{{ __('Harga (Rp)') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light">Rp</span>
                                <input type="number" class="form-control form-control-lg border-0 shadow-sm @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="0" required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="duration" class="form-label fw-bold text-primary">
                                <i class="fas fa-clock me-2"></i>{{ __('Durasi (menit)') }}
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control form-control-lg border-0 shadow-sm @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration') }}" placeholder="0" required>
                                <span class="input-group-text border-0 bg-light">minutes</span>
                            </div>
                            @error('duration')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('services.index') }}" class="btn btn-outline-secondary btn-lg px-5">
                            <i class="fas fa-times me-2"></i>{{ __('Batal') }}
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-save me-2"></i>{{ __('Buat Layanan') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>