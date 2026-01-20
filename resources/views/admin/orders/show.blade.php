@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
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

        <!-- Customer Information -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Informasi Pelanggan</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Nama</strong><br>
                    {{ $order->user->name }}
                </div>
                <div class="mb-3">
                    <strong>Email</strong><br>
                    {{ $order->user->email }}
                </div>
                <div class="mb-3">
                    <strong>Nomor Telepon</strong><br>
                    {{ $order->phone }}
                </div>
                <div class="mb-3">
                    <strong>Alamat Pengiriman</strong><br>
                    {{ $order->shipping_address }}
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
                        <span class="badge bg-primary">QRIS</span>
                    @elseif($order->payment_method === 'transfer_bank')
                        <span class="badge bg-info">Transfer Bank</span>
                    @elseif($order->payment_method === 'cod')
                        <span class="badge bg-warning">COD</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Status -->
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
                    <div class="timeline-item {{ $order->status === 'delivered' ? 'active' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6 class="fw-bold">Pesanan Terkirim</h6>
                            <p class="text-muted">{{ $order->delivered_at ? $order->delivered_at->format('d M Y H:i') : 'Menunggu...' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Order Summary -->
        <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
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
                        <span class="text-success">Gratis</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Pajak:</span>
                        <span>Rp 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold h5">
                        <span>Total:</span>
                        <span class="text-danger">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="mb-3">
                    <small class="text-muted d-block mb-2">Status Pesanan:</small>
                    @if($order->status === 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($order->status === 'confirmed')
                        <span class="badge bg-info">Dikonfirmasi</span>
                    @elseif($order->status === 'shipped')
                        <span class="badge bg-primary">Dikirim</span>
                    @elseif($order->status === 'delivered')
                        <span class="badge bg-success">Terkirim</span>
                    @elseif($order->status === 'cancelled')
                        <span class="badge bg-danger">Dibatalkan</span>
                    @endif
                </div>

                <!-- Action Buttons -->
                @if($order->status === 'pending')
                    <form action="{{ route('admin.orders.confirm', $order) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Konfirmasi pesanan ini?')">
                            <i class="fas fa-check"></i> Konfirmasi Pesanan
                        </button>
                    </form>
                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Batalkan pesanan ini?')">
                            <i class="fas fa-times"></i> Batalkan
                        </button>
                    </form>
                @elseif($order->status === 'confirmed')
                    <form action="{{ route('admin.orders.ship', $order) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100" onclick="return confirm('Tandai sebagai dikirim?')">
                            <i class="fas fa-truck"></i> Tandai Dikirim
                        </button>
                    </form>
                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Batalkan pesanan ini?')">
                            <i class="fas fa-times"></i> Batalkan
                        </button>
                    </form>
                @elseif($order->status === 'shipped')
                    <form action="{{ route('admin.orders.deliver', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Tandai sebagai terkirim?')">
                            <i class="fas fa-box"></i> Tandai Terkirim
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
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
    position: relative;
}

.timeline-marker {
    width: 20px;
    height: 20px;
    background-color: #e0e0e0;
    border-radius: 50%;
    border: 3px solid white;
    position: absolute;
    left: -10px;
    top: 5px;
}

.timeline-item.active .timeline-marker {
    background-color: #28a745;
}

.timeline-content {
    padding-left: 30px;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -4px;
    top: 30px;
    width: 2px;
    height: 30px;
    background-color: #e0e0e0;
}

.timeline-item.active::before {
    background-color: #28a745;
}

.timeline-item:last-child::before {
    display: none;
}
</style>
@endsection
