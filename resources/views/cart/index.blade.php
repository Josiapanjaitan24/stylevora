@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Keranjang Belanja</h2>

    @if($cartItems->isEmpty())
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-shopping-cart" style="font-size: 60px;"></i>
            <h5 class="mt-3">Keranjang Anda kosong</h5>
            <p class="text-muted">Mulai belanja dan tambahkan produk ke keranjang Anda</p>
            <a href="{{ route('products.index') }}" class="btn btn-danger">
                <i class="fas fa-shopping-bag"></i> Lanjut Belanja
            </a>
        </div>
    @else
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product->image)
                                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded me-3">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">
                                                    <a href="{{ route('products.show', $item->product->slug) }}" class="text-decoration-none">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">{{ $item->product->category->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td>
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="fw-bold">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus dari keranjang?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Lanjut Belanja
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Kosongkan keranjang?')">
                            <i class="fas fa-trash"></i> Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Ringkasan Belanja</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkos Kirim:</span>
                                <span class="text-success">Gratis</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold h5 mb-3">
                                <span>Total:</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="text-muted small">
                                <i class="fas fa-info-circle"></i> Gratis ongkos kirim untuk semua pembelian
                            </p>
                        </div>

                        <a href="{{ route('orders.create') }}" class="btn btn-danger btn-lg w-100">
                            <i class="fas fa-check"></i> Lanjut ke Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
