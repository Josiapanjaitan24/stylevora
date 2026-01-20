@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Daftar Produk</h2>
        </div>
    </div>

    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-filter"></i> Filter</h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Kategori</h6>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                            Semua Kategori
                        </a>
                        @forelse($categories as $category)
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="list-group-item list-group-item-action {{ request('category') == $category->slug ? 'active' : '' }}">
                                {{ $category->name }}
                                <span class="badge bg-secondary float-end">{{ $category->products()->count() }}</span>
                            </a>
                        @empty
                            <p class="text-muted">Tidak ada kategori</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            @if(request('search'))
                <div class="alert alert-info mb-4">
                    Hasil pencarian untuk: <strong>{{ request('search') }}</strong>
                    <a href="{{ route('products.index') }}" class="float-end">Hapus filter</a>
                </div>
            @endif

            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 mb-4">
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
                                <p class="card-text text-muted" style="font-size: 0.9rem;">{{ substr($product->description, 0, 80) }}...</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0 text-danger">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <small class="text-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                        {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                                    </small>
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
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-inbox" style="font-size: 60px;" class="mb-3"></i>
                            <h5 class="mt-3">Produk tidak ditemukan</h5>
                            <p class="text-muted">Coba ubah filter atau kata kunci pencarian Anda</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .product-card {
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }

    .list-group-item.active {
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>
@endsection
