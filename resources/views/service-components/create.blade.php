<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Komponen Baru') }}
            </h2>
            <a href="{{ route('service-components.index') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>{{ __('Kembali ke Komponen') }}
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #36b9cc, #258391);" class="text-white p-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-microchip me-2"></i>{{ __('Informasi Komponen') }}
                    </h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('service-components.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold text-primary">
                            <i class="fas fa-tag me-2"></i>{{ __('Nama Komponen') }}
                        </label>
                        <input type="text" class="form-control form-control-lg border-0 shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('Masukkan nama komponen') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold text-primary">
                            <i class="fas fa-align-left me-2"></i>{{ __('Deskripsi') }}
                        </label>
                        <textarea class="form-control border-0 shadow-sm @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="{{ __('Masukkan deskripsi komponen') }}" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text mt-2">{{ __('Berikan deskripsi detail komponen, termasuk spesifikasi dan kompatibilitas.') }}</div>
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
                            <label for="stock" class="form-label fw-bold text-primary">
                                <i class="fas fa-boxes me-2"></i>{{ __('Stok') }}
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control form-control-lg border-0 shadow-sm @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" placeholder="0" required>
                                <span class="input-group-text border-0 bg-light">{{ __('unit') }}</span>
                            </div>
                            @error('stock')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert border-0 mb-4 p-3" style="background: rgba(78, 115, 223, 0.1); color: #4e73df; border-left: 4px solid #4e73df;">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ __('Manajemen Inventori') }}</h6>
                                <p class="mb-0">{{ __('Komponen yang ditambahkan di sini akan tersedia untuk teknisi gunakan selama perbaikan layanan. Level stok akan otomatis berkurang ketika komponen digunakan dalam booking layanan.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('service-components.index') }}" class="btn btn-outline-secondary btn-lg px-5">
                            <i class="fas fa-times me-2"></i>{{ __('Batal') }}
                        </a>
                        <button type="submit" class="btn btn-success btn-lg px-5">
                            <i class="fas fa-plus-circle me-2"></i>{{ __('Buat Komponen') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>