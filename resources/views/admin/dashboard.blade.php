@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h2 class="fw-bold mb-4">Dashboard Admin</h2>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="text-danger fw-bold">{{ $totalOrders }}</h2>
                <p class="text-muted">Total Pesanan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="text-success fw-bold">{{ $totalProducts }}</h2>
                <p class="text-muted">Total Produk</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="text-primary fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                <p class="text-muted">Pendapatan Selesai</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <a href="{{ route('admin.orders.index') . '?status=pending' }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-warning fw-bold">{{ \App\Models\Order::where('status', 'pending')->count() }}</h2>
                    <p class="text-muted">Pesanan Tertunda</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Row 2: Confirmed Orders, Cancelled Orders, dan Total Revenue from Confirmed -->
<div class="row">
    <div class="col-md-3 mb-4">
        <a href="{{ route('admin.orders.index') . '?status=confirmed' }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-info fw-bold">{{ $confirmedOrders }}</h2>
                    <p class="text-muted">Pesanan Dikonfirmasi</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 mb-4">
        <a href="{{ route('admin.orders.index') . '?status=cancelled' }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-danger fw-bold">{{ $cancelledOrders }}</h2>
                    <p class="text-muted">Pesanan Dibatalkan</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body">
                <h6 class="text-muted mb-3"><i class="fas fa-money-bill-wave"></i> Total Pendapatan (Sementara)</h6>
                <h2 class="text-success fw-bold">Rp {{ number_format($confirmedRevenue, 0, ',', '.') }}</h2>
                <small class="text-muted">Termasuk pesanan yang dikonfirmasi, dikirim, dan terima</small>
            </div>
        </div>
    </div>
</div>

<!-- Pending Orders Section -->
@php $pendingOrders = \App\Models\Order::where('status', 'pending')->with('user')->latest()->get(); @endphp
@if($pendingOrders->count() > 0)
    <div class="alert alert-warning mt-4">
        <h5 class="mb-3"><i class="fas fa-exclamation-circle"></i> Ada {{ $pendingOrders->count() }} Pesanan yang Menunggu Konfirmasi</h5>
        <div class="table-responsive">
            <table class="table table-sm mb-0">
                <tbody>
                    @foreach($pendingOrders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->order_number }}</strong><br>
                                <small class="text-muted">{{ $order->user->name }} - {{ $order->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="text-end">
                                <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                            </td>
                            <td class="text-end" style="min-width: 220px;">
                                <form action="{{ route('admin.orders.confirm', $order) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi pesanan ini?')">
                                        <i class="fas fa-check"></i> Konfirmasi
                                    </button>
                                </form>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Pesanan Terbaru</h5>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td class="fw-bold">{{ $order->order_number }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>
                                @switch($order->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Tertunda</span>
                                        @break
                                    @case('confirmed')
                                        <span class="badge bg-info">Dikonfirmasi</span>
                                        @break
                                    @case('shipped')
                                        <span class="badge bg-primary">Dikirim</span>
                                        @break
                                    @case('delivered')
                                        <span class="badge bg-success">Terima</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada pesanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
