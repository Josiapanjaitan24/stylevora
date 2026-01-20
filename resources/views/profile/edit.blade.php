@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Edit Profil</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Avatar -->
                        <div class="mb-4">
                            <label for="avatar" class="form-label fw-bold">Foto Profil</label>
                            <div class="text-center mb-3">
                                @if($user->avatar)
                                    <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                                        <i class="fas fa-user" style="font-size: 60px; color: #ccc;"></i>
                                    </div>
                                @endif
                            </div>
                            <input type="file" name="avatar" id="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, GIF (Maks. 2MB)</small>
                            @error('avatar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Nomor Telepon</label>
                            <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" placeholder="+62 8xx xxxx xxxx">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold">Alamat</label>
                            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="4">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Change Password -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Keamanan</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        Untuk mengubah password, gunakan fitur "Lupa Password" di halaman login.
                    </p>
                    <a href="{{ route('password.request') }}" class="btn btn-outline-warning btn-sm w-100">
                        <i class="fas fa-key"></i> Ubah Password
                    </a>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Pengaturan Akun</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">
                        <i class="fas fa-info-circle"></i> Anda tidak dapat mengubah email yang sudah terverifikasi. Hubungi support jika Anda memerlukan bantuan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
