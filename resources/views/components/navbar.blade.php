<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm" style="padding: 0.25rem 0; margin: 0; top: 0; z-index: 1030;">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}" style="margin-bottom: 0;">
            <i class="fas fa-shopping-bag text-danger"></i> Stylevora
        </a>

        <!-- Toggle Button for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto" style="gap: 0.5rem;">
                <!-- Categories Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" style="padding: 0.5rem 0.75rem;">
                        <i class="fas fa-list"></i> Kategori
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                        <li><a class="dropdown-item" href="{{ route('products.index') }}">Semua Kategori</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @forelse($categories ?? [] as $category)
                            <li><a class="dropdown-item" href="{{ route('products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                        @empty
                            <li><a class="dropdown-item disabled" href="#">Tidak ada kategori</a></li>
                        @endforelse
                    </ul>
                </li>

                <!-- Search Bar -->
                <li class="nav-item">
                    <form class="d-flex" action="{{ route('products.index') }}" method="GET" style="width: 250px;">
                        <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                        <button class="btn btn-sm btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </li>

                @auth
                    <!-- Cart Icon -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}" style="padding: 0.5rem 0.75rem;">
                            <i class="fas fa-shopping-cart fs-5"></i>
                            @if(auth()->user()->carts()->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ auth()->user()->carts()->sum('quantity') }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <!-- Notification Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" style="padding: 0.5rem 0.75rem;">
                            <i class="fas fa-bell fs-5"></i>
                            @php
                                $unreadCount = auth()->user()->notifications()->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="max-height: 400px; overflow-y: auto;">
                            @forelse(auth()->user()->notifications()->latest()->limit(5)->get() as $notification)
                                <li>
                                    <a class="dropdown-item {{ !$notification->is_read ? 'fw-bold' : '' }}" href="{{ route('notifications.read', $notification->id) }}">
                                        <strong>{{ $notification->title }}</strong><br>
                                        <small class="text-muted">{{ substr($notification->message, 0, 40) }}...</small><br>
                                        <small class="text-secondary">{{ $notification->created_at->diffForHumans() }}</small>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @empty
                                <li><a class="dropdown-item disabled" href="#">Tidak ada notifikasi</a></li>
                            @endforelse
                            <li><a class="dropdown-item text-center small text-primary" href="{{ route('notifications.index') }}">Lihat semua notifikasi</a></li>
                        </ul>
                    </li>

                    <!-- User Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" style="padding: 0.5rem 0.75rem;">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <i class="fas fa-user-circle fs-5"></i>
                            @endif
                            <span class="ms-2">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><h6 class="dropdown-header">{{ auth()->user()->email }}</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user"></i> Profil Saya</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-box"></i> Pesanan Saya</a></li>
                            @if(auth()->user()->is_admin)
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.dashboard') }}"><i class="fas fa-cog"></i> Admin Panel</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- Login & Register (for non-authenticated users) -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary btn-sm ms-2" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary btn-sm ms-2" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
