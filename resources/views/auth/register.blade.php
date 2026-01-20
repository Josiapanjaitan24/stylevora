@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0"><i class="fas fa-user-plus"></i> Daftar Akun Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
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

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Requirements -->
                        <div class="alert alert-info small mb-3">
                            <strong>Persyaratan Password:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Minimal 8 karakter</li>
                                <li>Harus mengandung huruf besar</li>
                                <li>Harus mengandung angka</li>
                            </ul>
                        </div>

                        <!-- Register Button -->
                        <button type="submit" class="btn btn-danger btn-lg w-100">
                            <i class="fas fa-user-plus"></i> Daftar
                        </button>
                    </form>

                    <hr class="my-4">

                    <!-- Links -->
                    <div class="text-center">
                        <p class="text-muted">
                            Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none">Login disini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
