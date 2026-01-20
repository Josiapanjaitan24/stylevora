@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h2 class="fw-bold">Notifikasi Saya</h2>
        </div>
        <div class="col-lg-4 text-lg-end">
            @if($notifications->total() > 0 && auth()->user()->notifications()->where('is_read', false)->count() > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if($notifications->isEmpty())
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-bell" style="font-size: 60px;"></i>
            <h5 class="mt-3">Tidak ada notifikasi</h5>
            <p class="text-muted">Notifikasi tentang pesanan Anda akan muncul di sini</p>
        </div>
    @else
        <div class="row">
            @foreach($notifications as $notification)
                <div class="col-lg-8 mb-3">
                    <div class="card border-0 shadow-sm {{ !$notification->is_read ? 'bg-light' : '' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h5 class="card-title {{ !$notification->is_read ? 'fw-bold' : '' }}">
                                        {{ $notification->title }}
                                        @if(!$notification->is_read)
                                            <span class="badge bg-primary ms-2">Baru</span>
                                        @endif
                                    </h5>
                                    <p class="card-text text-muted">{{ $notification->message }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="ms-3">
                                    @switch($notification->type)
                                        @case('order_status')
                                            <i class="fas fa-box text-primary" style="font-size: 30px;"></i>
                                            @break
                                        @case('promotion')
                                            <i class="fas fa-tag text-success" style="font-size: 30px;"></i>
                                            @break
                                        @default
                                            <i class="fas fa-bell text-warning" style="font-size: 30px;"></i>
                                    @endswitch
                                </div>
                            </div>

                            @if($notification->order_id)
                                <div class="mt-3 pt-3 border-top">
                                    <a href="{{ route('notifications.read', $notification->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Lihat Pesanan
                                    </a>
                                </div>
                            @elseif(!$notification->is_read)
                                <div class="mt-3">
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-check"></i> Tandai Dibaca
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
