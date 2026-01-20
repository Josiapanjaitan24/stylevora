@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Manajemen Pesanan</h2>
    </div>
</div>

<div class="card border-0 shadow-sm">
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
                    @forelse($orders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>
                                {{ $order->user->name }}<br>
                                <small class="text-muted">{{ $order->user->email }}</small>
                            </td>
                            <td><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                            <td>
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
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.orders.show', $order) }}">
                                                <i class="fas fa-eye"></i> Lihat Detail
                                            </a>
                                        </li>
                                        @if($order->status === 'pending')
                                            <li>
                                                <form action="{{ route('admin.orders.confirm', $order) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Konfirmasi pesanan ini?')">
                                                        <i class="fas fa-check"></i> Konfirmasi Pesanan
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Batalkan pesanan ini?')">
                                                        <i class="fas fa-times"></i> Batalkan Pesanan
                                                    </button>
                                                </form>
                                            </li>
                                        @elseif($order->status === 'confirmed')
                                            <li>
                                                <form action="{{ route('admin.orders.ship', $order) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Tandai pesanan sebagai dikirim?')">
                                                        <i class="fas fa-truck"></i> Tandai Dikirim
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Batalkan pesanan ini?')">
                                                        <i class="fas fa-times"></i> Batalkan Pesanan
                                                    </button>
                                                </form>
                                            </li>
                                        @elseif($order->status === 'shipped')
                                            <li>
                                                <form action="{{ route('admin.orders.deliver', $order) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Tandai pesanan sebagai terkirim?')">
                                                        <i class="fas fa-box"></i> Tandai Terkirim
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-inbox" style="font-size: 40px;"></i>
                                <p class="mt-2">Belum ada pesanan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
