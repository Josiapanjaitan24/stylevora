@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Profil Saya</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Profile Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Profil</h5>
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            @if($user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                                    <i class="fas fa-user" style="font-size: 60px; color: #ccc;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Nama</label>
                                <p class="fs-5 fw-bold">{{ $user->name }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">Email</label>
                                <p class="fs-5">{{ $user->email }}</p>
                            </div>
                            @if($user->phone)
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Nomor Telepon</label>
                                    <p class="fs-5">{{ $user->phone }}</p>
                                </div>
                            @endif
                            @if($user->address)
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Alamat</label>
                                    <p class="fs-5">{{ $user->address }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <h2 class="text-danger fw-bold">{{ $user->orders()->count() }}</h2>
                            <p class="text-muted mb-0">Total Pesanan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <h2 class="text-success fw-bold">Rp {{ number_format($user->orders()->sum('total_price'), 0, ',', '.') }}</h2>
                            <p class="text-muted mb-0">Total Pengeluaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <h2 class="text-primary fw-bold">{{ $user->orders()->where('status', 'delivered')->count() }}</h2>
                            <p class="text-muted mb-0">Pesanan Terima</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Pesanan Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($user->orders()->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
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
                                    @foreach($user->orders()->latest()->limit(5)->get() as $order)
                                        <tr>
                                            <td class="fw-bold">{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
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
                                            <td>
                                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                                Lihat Semua Pesanan
                            </a>
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Belum ada pesanan</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Account Status -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Status Akun</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Email Verified</label><br>
                        @if($user->email_verified_at)
                            <span class="badge bg-success">
                                <i class="fas fa-check"></i> Terverifikasi
                            </span>
                        @else
                            <span class="badge bg-warning">
                                <i class="fas fa-clock"></i> Menunggu Verifikasi
                            </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Tipe Akun</label><br>
                        @if($user->is_admin)
                            <span class="badge bg-danger">Admin</span>
                        @else
                            <span class="badge bg-secondary">User</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Bergabung Sejak</label><br>
                        <span>{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Menu Cepat</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('profile.edit') }}" class="btn btn-block btn-outline-primary d-block mb-2">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>
                    <a href="{{ route('orders.index') }}" class="btn btn-block btn-outline-primary d-block mb-2">
                        <i class="fas fa-box"></i> Pesanan Saya
                    </a>
                    <a href="{{ route('notifications.index') }}" class="btn btn-block btn-outline-primary d-block mb-2">
                        <i class="fas fa-bell"></i> Notifikasi
                    </a>
                    <a href="{{ route('cart.index') }}" class="btn btn-block btn-outline-primary d-block">
                        <i class="fas fa-shopping-cart"></i> Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
