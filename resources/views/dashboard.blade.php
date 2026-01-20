@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info">
                <h4>Selamat datang, {{ auth()->user()->name }}!</h4>
                <p>Anda telah login ke Stylevora. Mulai belanja sekarang!</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="text-danger mb-2"><i class="fas fa-shopping-cart"></i></h2>
                    <h5>Keranjang</h5>
                    <p class="text-muted">{{ auth()->user()->carts()->sum('quantity') }} item</p>
                    <a href="{{ route('cart.index') }}" class="btn btn-danger btn-sm">Lihat Keranjang</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="text-primary mb-2"><i class="fas fa-box"></i></h2>
                    <h5>Pesanan</h5>
                    <p class="text-muted">{{ auth()->user()->orders()->count() }} pesanan</p>
                    <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">Lihat Pesanan</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="text-success mb-2"><i class="fas fa-bell"></i></h2>
                    <h5>Notifikasi</h5>
                    <p class="text-muted">{{ auth()->user()->notifications()->where('is_read', false)->count() }} baru</p>
                    <a href="{{ route('notifications.index') }}" class="btn btn-success btn-sm">Lihat Notifikasi</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="text-warning mb-2"><i class="fas fa-user"></i></h2>
                    <h5>Profil</h5>
                    <p class="text-muted">{{ auth()->user()->email }}</p>
                    <a href="{{ route('profile.show') }}" class="btn btn-warning btn-sm">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h3 class="fw-bold mb-3">Lanjutkan Belanja</h3>
            <a href="{{ route('products.index') }}" class="btn btn-lg btn-danger">
                <i class="fas fa-shopping-bag"></i> Jelajahi Produk
            </a>
        </div>
    </div>
</div>
@endsection
