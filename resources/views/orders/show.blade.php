@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Detail Pesanan</h2>
            <p class="text-muted">No. Pesanan: <strong>{{ $order->order_number }}</strong></p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Items -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Item Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->product->name }}</strong><br>
                                            <small class="text-muted">{{ $item->product->category->name }}</small>
                                        </td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="fw-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Alamat Pengiriman</strong><br>
                        {{ $order->shipping_address }}
                    </div>
                    <div class="mb-3">
                        <strong>Nomor Telepon</strong><br>
                        {{ $order->phone }}
                    </div>
                    @if($order->notes)
                        <div class="mb-3">
                            <strong>Catatan</strong><br>
                            {{ $order->notes }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Metode Pembayaran</strong><br>
                        @if($order->payment_method === 'qris')
                            <span class="badge bg-primary">QRIS</span> - Scan kode QR untuk pembayaran
                            <div class="alert alert-primary mt-3 mb-0">
                                <p class="mb-0">Scan kode QR berikut menggunakan aplikasi e-wallet favorit Anda:</p>
                            </div>
                        @elseif($order->payment_method === 'transfer_bank')
                            <span class="badge bg-info">Transfer Bank</span> - Transfer manual ke rekening kami
                            <div class="alert alert-info mt-3 mb-0">
                                <p class="mb-2"><strong>Rekening Tujuan:</strong></p>
                                <p class="mb-1">Bank: <strong>BCA</strong></p>
                                <p class="mb-1">Nomor: <strong>1234567890</strong></p>
                                <p class="mb-2">Atas Nama: <strong>PT Stylevora Indonesia</strong></p>
                                <p class="text-muted small mb-0">Keterangan: {{ $order->order_number }}</p>
                            </div>
                        @elseif($order->payment_method === 'cod')
                            <span class="badge bg-warning">COD (Cash On Delivery)</span> - Bayar saat barang tiba
                            <div class="alert alert-warning mt-3 mb-0">
                                <p class="mb-0">Anda akan membayar <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> saat barang tiba di tangan Anda.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Status Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Status Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Status Pending -->
                        <div class="timeline-item {{ in_array($order->status, ['pending', 'confirmed', 'shipped', 'delivered']) ? 'active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="fw-bold">Pesanan Dibuat</h6>
                                <p class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Status Confirmed -->
                        <div class="timeline-item {{ in_array($order->status, ['confirmed', 'shipped', 'delivered']) ? 'active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="fw-bold">Pesanan Dikonfirmasi</h6>
                                <p class="text-muted">{{ $order->confirmed_at ? $order->confirmed_at->format('d M Y H:i') : 'Menunggu...' }}</p>
                            </div>
                        </div>

                        <!-- Status Shipped -->
                        <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? 'active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="fw-bold">Pesanan Dikirim</h6>
                                <p class="text-muted">{{ $order->shipped_at ? $order->shipped_at->format('d M Y H:i') : 'Menunggu...' }}</p>
                            </div>
                        </div>

                        <!-- Status Delivered -->
                        <div class="timeline-item {{ $order->status == 'delivered' ? 'active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="fw-bold">Pesanan Diterima</h6>
                                <p class="text-muted">{{ $order->delivered_at ? $order->delivered_at->format('d M Y H:i') : 'Menunggu...' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkos Kirim:</span>
                            <span>Gratis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold h5">
                            <span>Total:</span>
                            <span class="text-danger">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mb-3 p-3 bg-light rounded">
                        <strong>Status Saat Ini</strong><br>
                        @switch($order->status)
                            @case('pending')
                                <span class="badge bg-warning">Tertunda</span>
                                <p class="text-muted small mt-2">Pesanan Anda sedang menunggu konfirmasi dari admin. Biasanya akan dikonfirmasi dalam 1x24 jam.</p>
                                @break
                            @case('confirmed')
                                <span class="badge bg-info">Dikonfirmasi</span>
                                <p class="text-muted small mt-2">Pesanan telah dikonfirmasi. Admin sedang mempersiapkan pesanan Anda untuk dikirim.</p>
                                @break
                            @case('shipped')
                                <span class="badge bg-primary">Dikirim</span>
                                <p class="text-muted small mt-2">Pesanan telah dikirim. Periksa status pengiriman secara berkala.</p>
                                @break
                            @case('delivered')
                                <span class="badge bg-success">Terima</span>
                                <p class="text-muted small mt-2">Pesanan telah diterima. Terima kasih telah berbelanja di Stylevora!</p>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger">Dibatalkan</span>
                                <p class="text-muted small mt-2">Pesanan telah dibatalkan.</p>
                                @break
                        @endswitch
                    </div>

                    @if(in_array($order->status, ['pending', 'confirmed']))
                        <form action="{{ route('orders.cancel', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Batalkan pesanan ini?')">
                                <i class="fas fa-times"></i> Batalkan Pesanan
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Contact Support -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Hubungi Kami</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-2">
                        <i class="fas fa-envelope"></i> josia.panjaitan24@gmail.com
                    </p>
                    <p class="text-muted small mb-2">
                        <i class="fas fa-phone"></i> +6282163514102
                    </p>
                    <p class="text-muted small">
                        <i class="fas fa-clock"></i> Senin - Jumat, 09:00 - 18:00
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Pesanan Saya
            </a>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 30px;
        opacity: 0.5;
    }

    .timeline-item.active {
        opacity: 1;
    }

    .timeline-marker {
        width: 30px;
        height: 30px;
        background-color: #e9ecef;
        border-radius: 50%;
        margin-right: 20px;
        flex-shrink: 0;
        position: relative;
    }

    .timeline-item.active .timeline-marker {
        background-color: #dc3545;
        box-shadow: 0 0 0 8px rgba(220, 53, 69, 0.1);
    }

    .timeline-content {
        flex: 1;
    }
</style>
@endsection
