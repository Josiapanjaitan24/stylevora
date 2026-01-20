@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0"><i class="fas fa-key"></i> Reset Password</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('password.store') }}" method="POST">
                        @csrf

                        <!-- Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password Baru</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Button -->
                        <button type="submit" class="btn btn-danger btn-lg w-100">
                            <i class="fas fa-check"></i> Reset Password
                        </button>
                    </form>

                    <hr class="my-4">

                    <!-- Links -->
                    <div class="text-center">
                        <p class="text-muted">
                            <a href="{{ route('login') }}" class="text-decoration-none">Kembali ke Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
