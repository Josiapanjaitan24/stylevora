@extends('layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Pesanan Saya</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-box" style="font-size: 60px;"></i>
            <h5 class="mt-3">Belum ada pesanan</h5>
            <p class="text-muted">Mulai belanja untuk membuat pesanan pertama Anda</p>
            <a href="{{ route('products.index') }}" class="btn btn-danger">
                <i class="fas fa-shopping-bag"></i> Mulai Belanja
            </a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="fw-bold">{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
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
                                    @case('cancelled')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
