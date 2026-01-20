<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Stylevora') }} - Admin @yield('title', 'Panel')</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            body {
                background-color: #f8f9fa;
            }
            .sidebar {
                background-color: #2c3e50;
                color: white;
                min-height: 100vh;
                padding: 20px 0;
            }
            .sidebar a {
                color: #ecf0f1;
                text-decoration: none;
                padding: 12px 20px;
                display: block;
                transition: all 0.3s;
            }
            .sidebar a:hover,
            .sidebar a.active {
                background-color: #dc3545;
                color: white;
            }
            .main-content {
                padding: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 col-lg-2 sidebar">
                    <div class="brand mb-4 px-3">
                        <h4><i class="fas fa-shopping-bag text-danger"></i> Stylevora Admin</h4>
                    </div>
                    <nav>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.orders.index' ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i> Pesanan
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.products.index' ? 'active' : '' }}">
                            <i class="fas fa-boxes"></i> Produk
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.categories.index' ? 'active' : '' }}">
                            <i class="fas fa-list"></i> Kategori
                        </a>
                        <hr class="border-secondary">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="fas fa-arrow-left"></i> Kembali ke Toko
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link w-100 text-start text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="col-md-9 col-lg-10 main-content">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
