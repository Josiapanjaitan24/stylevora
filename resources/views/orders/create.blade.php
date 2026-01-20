@extends('layouts.app')

@section('title', 'Checkout Pesanan')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Checkout Pesanan</h2>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="row">
            <!-- Order Items -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Detail Pesanan</h5>
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
                                    @php $subtotal = 0; @endphp
                                    @foreach($cartItems as $item)
                                        @php $itemTotal = $item->product->price * $item->quantity; $subtotal += $itemTotal; @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $item->product->name }}</strong><br>
                                                <small class="text-muted">{{ $item->product->category->name }}</small>
                                            </td>
                                            <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td class="fw-bold">Rp {{ number_format($itemTotal, 0, ',', '.') }}</td>
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
                            <label for="shipping_address" class="form-label fw-bold">Alamat Pengiriman <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" id="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="3" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', auth()->user()->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label fw-bold">Catatan Pesanan (Opsional)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="Contoh: Mohon dikemas dengan hati-hati">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Metode Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="qris" value="qris" checked required onchange="updatePaymentInfo()">
                                <label class="form-check-label" for="qris">
                                    <strong>QRIS</strong> - Scan kode QR untuk pembayaran
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="transfer_bank" value="transfer_bank" required onchange="updatePaymentInfo()">
                                <label class="form-check-label" for="transfer_bank">
                                    <strong>Transfer Bank</strong> - Transfer manual ke rekening kami
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" required onchange="updatePaymentInfo()">
                                <label class="form-check-label" for="cod">
                                    <strong>COD (Cash On Delivery)</strong> - Bayar saat barang tiba
                                </label>
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <div id="qrisInfo" class="alert alert-primary mt-3">
                            <h6 class="mb-2"><i class="fas fa-qrcode"></i> QRIS</h6>
                            <p class="mb-0">Scan kode QR menggunakan aplikasi e-wallet favorit Anda untuk melakukan pembayaran.</p>
                        </div>

                        <div id="bankInfo" class="alert alert-info mt-3" style="display: none;">
                            <h6 class="mb-2"><i class="fas fa-university"></i> Transfer Bank</h6>
                            <p class="mb-2">Silakan transfer ke rekening berikut:</p>
                            <div class="bg-light p-2 rounded mb-2">
                                <strong>Bank:</strong> Mandiri<br>
                                <strong>Nomor Rekening:</strong> 1830003982807<br>
                                <strong>Atas Nama:</strong> JOSIA PANJAITAN
                            </div>
                            <p class="text-muted small mb-0">Gunakan nomor pesanan Anda sebagai keterangan pembayaran.</p>
                        </div>

                        <div id="codInfo" class="alert alert-warning mt-3" style="display: none;">
                            <h6 class="mb-2"><i class="fas fa-truck"></i> Cash On Delivery (COD)</h6>
                            <p class="mb-0">Anda dapat membayar langsung saat barang tiba di tangan Anda. Pastikan uang tunai Anda siap.</p>
                        </div>

                        <p class="text-muted small mt-3">
                            <i class="fas fa-info-circle"></i> Pilih salah satu metode pembayaran di atas
                        </p>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
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
                                <span>Total Pembayaran:</span>
                                <span class="text-danger">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger btn-lg w-100 mb-2">
                            <i class="fas fa-check"></i> Buat Pesanan
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-lg w-100">
                            <i class="fas fa-arrow-left"></i> Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function updatePaymentInfo() {
    const qrisInfo = document.getElementById('qrisInfo');
    const bankInfo = document.getElementById('bankInfo');
    const codInfo = document.getElementById('codInfo');
    
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    // Hide all info sections
    qrisInfo.style.display = 'none';
    bankInfo.style.display = 'none';
    codInfo.style.display = 'none';
    
    // Show selected info section
    if (paymentMethod === 'qris') {
        qrisInfo.style.display = 'block';
    } else if (paymentMethod === 'transfer_bank') {
        bankInfo.style.display = 'block';
    } else if (paymentMethod === 'cod') {
        codInfo.style.display = 'block';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePaymentInfo();
});
</script>
@endsection
