@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow rounded-4 overflow-hidden">
                <div class="card-header p-0">
                    <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i>{{ __('Masuk') }}
                        </h5>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-primary">
                                <i class="fas fa-envelope me-2"></i>{{ __('Alamat Email') }}
                            </label>
                            <input id="email" type="email" class="form-control form-control-lg border-0 shadow-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-primary">
                                <i class="fas fa-lock me-2"></i>{{ __('Kata Sandi') }}
                            </label>
                            <input id="password" type="password" class="form-control form-control-lg border-0 shadow-sm @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Ingat Saya') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-between align-items-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-sign-in-alt me-2"></i>{{ __('Masuk') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                    <i class="fas fa-question-circle me-1"></i>{{ __('Lupa Kata Sandi?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light p-4 text-center">
                    <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Daftar sekarang</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection