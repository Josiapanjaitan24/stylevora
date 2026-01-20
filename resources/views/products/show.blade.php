@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-6 mb-4">
            @if($product->image)
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 500px; object-fit: cover;">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 500px;">
                    <i class="fas fa-image text-muted" style="font-size: 100px;"></i>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <!-- Category -->
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="badge bg-info mb-2">{{ $product->category->name }}</a>

                    <!-- Title -->
                    <h1 class="h3 fw-bold mb-2">{{ $product->name }}</h1>

                    <!-- Rating (Optional) -->
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                            (4.5/5) - 120 ulasan
                        </small>
                    </div>

                    <!-- Price -->
                    <h2 class="text-danger fw-bold mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>

                    <!-- Stock Status -->
                    <div class="mb-3">
                        @if($product->stock > 0)
                            <span class="badge bg-success">Stok: {{ $product->stock }}&nbsp;tersedia</span>
                        @else
                            <span class="badge bg-danger">Stok: Habis</span>
                        @endif
                    </div>

                    <!-- Description -->
                    <h5 class="fw-bold mb-2">Deskripsi</h5>
                    <p class="text-muted mb-4">{{ $product->description }}</p>

                    <!-- Add to Cart Form -->
                    @auth
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="quantity" class="form-label fw-bold">Jumlah</label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" id="decreaseQty">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->stock }}">
                                            <button class="btn btn-outline-secondary" type="button" id="increaseQty">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-danger btn-lg w-100 mb-2">
                                    <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-lg w-100 mb-2" disabled>
                                Produk Habis
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-danger btn-lg w-100 mb-2">
                            <i class="fas fa-sign-in-alt"></i> Login untuk Membeli
                        </a>
                    @endauth

                    <button class="btn btn-outline-danger btn-lg w-100">
                        <i class="fas fa-heart"></i> Tambah ke Wishlist
                    </button>

                    <!-- Additional Info -->
                    <div class="mt-4 pt-4 border-top">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Pengiriman</strong><br>
                                <small class="text-muted">
                                    <i class="fas fa-truck"></i> Gratis ongkir untuk pembelian > Rp 100.000
                                </small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Garansi</strong><br>
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt"></i> Jaminan kepuasan 100%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="fw-bold mb-4">Produk Terkait</h3>
            </div>
        </div>

        <div class="row">
            @foreach($relatedProducts as $relatedProduct)
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm h-100 product-card">
                        @if($relatedProduct->image)
                            <img src="{{ asset($relatedProduct->image) }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 250px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                <i class="fas fa-image text-muted" style="font-size: 60px;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                            <p class="text-muted small">{{ $relatedProduct->category->name }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 text-danger">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .product-card {
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }
</style>

<script>
    document.getElementById('decreaseQty').addEventListener('click', function() {
        let qty = document.getElementById('quantity');
        if (parseInt(qty.value) > 1) {
            qty.value = parseInt(qty.value) - 1;
        }
    });

    document.getElementById('increaseQty').addEventListener('click', function() {
        let qty = document.getElementById('quantity');
        let max = parseInt(qty.max);
        if (parseInt(qty.value) < max) {
            qty.value = parseInt(qty.value) + 1;
        }
    });
</script>
@endsection
