@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0"><i class="fas fa-key"></i> Lupa Password</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Button -->
                        <button type="submit" class="btn btn-danger btn-lg w-100">
                            <i class="fas fa-envelope"></i> Kirim Link Reset
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
