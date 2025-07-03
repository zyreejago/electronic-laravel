@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow rounded-4 overflow-hidden">
                <div class="card-header p-0">
                    <div style="background: linear-gradient(90deg, #1cc88a, #13855c);" class="text-white p-4">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-user-plus me-2"></i>{{ __('Daftar') }}
                        </h5>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold text-primary">
                                        <i class="fas fa-user me-2"></i>{{ __('Nama Lengkap') }}
                                    </label>
                                    <input id="name" type="text" class="form-control form-control-lg border-0 shadow-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold text-primary">
                                        <i class="fas fa-envelope me-2"></i>{{ __('Alamat Email') }}
                                    </label>
                                    <input id="email" type="email" class="form-control form-control-lg border-0 shadow-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-bold text-primary">
                                        <i class="fas fa-lock me-2"></i>{{ __('Kata Sandi') }}
                                    </label>
                                    <input id="password" type="password" class="form-control form-control-lg border-0 shadow-sm @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label fw-bold text-primary">
                                        <i class="fas fa-lock me-2"></i>{{ __('Konfirmasi Kata Sandi') }}
                                    </label>
                                    <input id="password-confirm" type="password" class="form-control form-control-lg border-0 shadow-sm" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label for="phone_number" class="form-label fw-bold text-primary">
                                        <i class="fas fa-phone me-2"></i>{{ __('Nomor Telepon (WhatsApp)') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 bg-light">+62</span>
                                        <input id="phone_number" type="text" class="form-control form-control-lg border-0 shadow-sm @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="tel" placeholder="8123456789">
                                    </div>
                                    @error('phone_number')
                                        <div class="invalid-feedback d-block">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fab fa-whatsapp text-success me-1"></i>Kami akan menggunakan nomor ini untuk update layanan melalui WhatsApp
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-user-plus me-2"></i>{{ __('Buat Akun') }}
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light p-4 text-center">
                    <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Masuk di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection