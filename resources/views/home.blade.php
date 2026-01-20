@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row bg-light rounded-lg p-5 mb-5">
        <div class="col-lg-6 d-flex align-items-center">
            <div>
                <h1 class="display-4 fw-bold mb-3">Selamat Datang di Stylevora</h1>
                <p class="lead text-muted mb-4">Temukan koleksi fashion terlengkap dan terpercaya dengan harga terbaik.</p>
                <div>
                    <a href="{{ route('products.index') }}" class="btn btn-danger btn-lg me-2">
                        <i class="fas fa-shopping-bag"></i> Belanja Sekarang
                    </a>
                    @auth
                    @else
                        <a href="{{ route('register') }}" class="btn btn-outline-danger btn-lg">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <i class="fas fa-shopping-bags" style="font-size: 200px; color: #dc3545; opacity: 0.1;"></i>
        </div>
    </div>

    <!-- Categories Section -->
    <h2 class="fw-bold mb-4">Kategori Populer</h2>
    <div class="row mb-5">
        @forelse($categories as $category)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm hover-shadow" style="cursor: pointer;" onclick="window.location.href='{{ route('products.index', ['category' => $category->slug]) }}'">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="text-muted small">{{ $category->products()->count() }} produk</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada kategori.</p>
        @endforelse
    </div>

    <!-- Featured Products Section -->
    <h2 class="fw-bold mb-4">Produk Terbaru</h2>
    <div class="row">
        @forelse($products as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 product-card">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                            <i class="fas fa-image text-muted" style="font-size: 60px;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="text-muted small">{{ $product->category->name }}</p>
                        <p class="card-text text-muted">{{ substr($product->description, 0, 60) }}...</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-danger">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <small class="text-success">{{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}</small>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada produk.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }

    .product-card {
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }
</style>
@endsection
