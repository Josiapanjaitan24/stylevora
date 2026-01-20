<!-- Footer -->
<footer class="bg-dark text-white mt-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-shopping-bag text-danger"></i> Stylevora
                </h5>
                <p class="text-muted">Toko fashion online terlengkap dengan berbagai pilihan baju dan aksesori terbaik.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h6 class="fw-bold mb-3">Navigasi</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-muted text-decoration-none">Produk</a></li>
                    @auth
                        <li><a href="{{ route('orders.index') }}" class="text-muted text-decoration-none">Pesanan Saya</a></li>
                        <li><a href="{{ route('profile.show') }}" class="text-muted text-decoration-none">Profil</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h6 class="fw-bold mb-3">Hubungi Kami</h6>
                <p class="text-muted">
                    <i class="fas fa-envelope"></i> info@stylevora.com<br>
                    <i class="fas fa-phone"></i> +62 123 456 7890<br>
                    <i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia
                </p>
            </div>
        </div>
        <hr class="bg-secondary">
        <div class="text-center pb-3">
            <p class="text-muted mb-0">&copy; 2025 Stylevora. All rights reserved.</p>
        </div>
    </div>
</footer>
