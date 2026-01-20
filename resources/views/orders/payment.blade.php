@extends('layouts.app')

@section('title', 'Pembayaran Pesanan ' . $order->order_number)

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold">Pembayaran Pesanan</h2>
            <p class="text-muted fs-5">No. Pesanan: <strong>{{ $order->order_number }}</strong></p>
        </div>
    </div>

    <div class="row">
        <!-- Payment Method Section -->
        <div class="col-lg-8">
            @if($order->payment_method === 'qris')
                <!-- QRIS Payment -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-qrcode"></i> Pembayaran QRIS</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="text-muted mb-4">Scan kode QR di bawah ini menggunakan aplikasi e-wallet Anda untuk melakukan pembayaran</p>
                        
                        <div class="bg-light rounded p-4 mb-4" style="display: inline-block;">
                            <div style="width: 280px; height: 280px; background: white; border: 2px solid #ddd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <div class="text-muted">
                                    <img
                                        src="{{ asset('images/qrcode.png') }}"
                                        alt="QRIS Payment"
                                        class="img-fluid"
                                        />
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <h6 class="mb-2"><i class="fas fa-info-circle"></i> Cara Pembayaran QRIS:</h6>
                            <ol class="mb-0 text-start" style="max-width: 400px; margin: 0 auto;">
                                <li>Buka aplikasi e-wallet Anda (GCash, Dana, OVO, GoPay, LinkAja, dll)</li>
                                <li>Pilih menu "Scan QR" atau kamera</li>
                                <li>Arahkan ke QR Code di atas</li>
                                <li>Masukkan nominal: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></li>
                                <li>Selesaikan pembayaran</li>
                            </ol>
                        </div>

                        <div class="alert alert-success mt-3">
                            <strong>Pembayaran akan otomatis terverifikasi</strong><br>
                            <small>Sistem kami akan mendeteksi pembayaran Anda dalam beberapa menit</small>
                        </div>
                    </div>
                </div>

            @elseif($order->payment_method === 'transfer_bank')
                <!-- Bank Transfer Payment -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-university"></i> Pembayaran Transfer Bank</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">Silakan transfer ke rekening bank kami sesuai dengan data di bawah ini:</p>

                        <div class="alert alert-warning">
                            <h6 class="mb-3"><strong>Jumlah yang harus dibayar:</strong></h6>
                            <div style="font-size: 28px; font-weight: bold; color: #dc3545;">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="bg-light rounded p-4 mb-4">
                            <h6 class="mb-3"><strong>Detail Rekening Penerima:</strong></h6>
                            
                            <div class="mb-3">
                                <small class="text-muted">BANK</small><br>
                                <strong class="fs-5">BCA (Bank Central Asia)</strong>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">NOMOR REKENING</small><br>
                                <strong class="fs-5 text-danger">1234567890</strong>
                                <button class="btn btn-sm btn-outline-primary ms-2" onclick="copyToClipboard('1234567890')">
                                    <i class="fas fa-copy"></i> Salin
                                </button>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">ATAS NAMA</small><br>
                                <strong class="fs-5">PT STYLEVORA INDONESIA</strong>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h6 class="mb-2"><i class="fas fa-info-circle"></i> Petunjuk Transfer:</h6>
                            <ol class="mb-0 text-start">
                                <li>Login ke aplikasi atau ATM bank Anda</li>
                                <li>Pilih "Transfer ke Bank Lain" atau "Transfer Antar Bank"</li>
                                <li>Masukkan nomor rekening: <strong>1234567890</strong></li>
                                <li>Masukkan nominal: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></li>
                                <li>Pada kolom Keterangan/Berita, tuliskan: <strong>{{ $order->order_number }}</strong></li>
                                <li>Selesaikan transaksi dan catat bukti pembayaran</li>
                            </ol>
                        </div>

                        <div class="alert alert-success mt-3">
                            <strong><i class="fas fa-clock"></i> Proses Verifikasi:</strong><br>
                            <small>Kami akan memverifikasi pembayaran Anda dalam waktu 1-2 jam jam kerja setelah transfer diterima</small>
                        </div>
                    </div>
                </div>

            @elseif($order->payment_method === 'cod')
                <!-- Cash On Delivery Payment -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-truck"></i> Pembayaran COD (Cash On Delivery)</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">Anda memilih untuk membayar saat barang tiba. Berikut adalah informasi penting:</p>

                        <div class="alert alert-warning">
                            <h6 class="mb-3"><strong>Jumlah yang harus dibayar saat barang tiba:</strong></h6>
                            <div style="font-size: 28px; font-weight: bold; color: #dc3545;">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="bg-light rounded p-4 mb-4">
                            <h6 class="mb-3"><strong>Informasi Pengiriman:</strong></h6>
                            
                            <div class="mb-3">
                                <small class="text-muted">ALAMAT PENGIRIMAN</small><br>
                                <strong>{{ $order->shipping_address }}</strong>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">NOMOR TELEPON</small><br>
                                <strong>{{ $order->phone }}</strong>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h6 class="mb-2"><i class="fas fa-info-circle"></i> Petunjuk Pembayaran COD:</h6>
                            <ol class="mb-0 text-start">
                                <li>Barang akan dikirim ke alamat yang Anda daftarkan</li>
                                <li>Kurir akan menghubungi Anda sebelum tiba di lokasi</li>
                                <li>Periksa barang sebelum membayar</li>
                                <li>Jika barang sesuai, lakukan pembayaran dengan uang tunai</li>
                                <li>Ambil barang dan bukti pengiriman</li>
                            </ol>
                        </div>

                        <div class="alert alert-success mt-3">
                            <strong><i class="fas fa-check-circle"></i> Status Pesanan:</strong><br>
                            <small>Pesanan Anda telah dicatat. Tunggu konfirmasi kami dan barang akan segera diproses untuk pengiriman.</small>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <!-- Order Items -->
                    <h6 class="fw-bold mb-3">Item Pesanan:</h6>
                    <div class="mb-3" style="max-height: 300px; overflow-y: auto;">
                        @foreach($order->items as $item)
                            <div class="d-flex justify-content-between align-items-start mb-2 pb-2 border-bottom">
                                <div>
                                    <strong class="d-block">{{ $item->product->name }}</strong>
                                    <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                                </div>
                                <strong class="text-end">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</strong>
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    <!-- Order Details -->
                    <h6 class="fw-bold mb-3">Detail Pesanan:</h6>
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
                        <div class="d-flex justify-content-between fw-bold h5 mt-3 pt-2 border-top">
                            <span>Total Pembayaran:</span>
                            <span class="text-danger">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Payment Method Badge -->
                    <div class="mb-3">
                        <small class="text-muted d-block mb-2">Metode Pembayaran:</small>
                        @if($order->payment_method === 'qris')
                            <span class="badge bg-primary">QRIS</span>
                        @elseif($order->payment_method === 'transfer_bank')
                            <span class="badge bg-info">Transfer Bank</span>
                        @elseif($order->payment_method === 'cod')
                            <span class="badge bg-warning">COD</span>
                        @endif
                    </div>

                    <!-- Status -->
                    <div class="alert alert-light mb-3">
                        <small class="text-muted">Status Pesanan:</small><br>
                        <strong>
                            @if($order->status === 'pending')
                                <span class="badge bg-warning">Menunggu Pembayaran</span>
                            @elseif($order->status === 'confirmed')
                                <span class="badge bg-info">Dikonfirmasi</span>
                            @elseif($order->status === 'shipped')
                                <span class="badge bg-primary">Dikirim</span>
                            @elseif($order->status === 'delivered')
                                <span class="badge bg-success">Terkirim</span>
                            @endif
                        </strong>
                    </div>

                    <!-- Action Buttons -->
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="fas fa-receipt"></i> Lihat Detail Pesanan
                    </a>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-list"></i> Daftar Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Nomor rekening telah disalin ke clipboard!');
    });
}
</script>
@endsection
