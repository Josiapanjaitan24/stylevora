@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0"><i class="fas fa-sign-in-alt"></i> Login</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="form-check-label">Ingat saya</label>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="btn btn-danger btn-lg w-100">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </form>

                    <hr class="my-4">

                    <!-- Links -->
                    <div class="text-center">
                        <p class="text-muted mb-2">
                            Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none">Daftar sekarang</a>
                        </p>
                        <p class="text-muted">
                            <a href="{{ route('password.request') }}" class="text-decoration-none">Lupa password?</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
