// Main JavaScript for Stylevora

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips and popovers
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Close alert after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        if (!alert.classList.contains('alert-info')) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        }
    });

    // Format currency input
    const currencyInputs = document.querySelectorAll('.currency-input');
    currencyInputs.forEach(input => {
        input.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            this.value = new Intl.NumberFormat('id-ID').format(value);
        });
    });

    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                e.preventDefault();
            }
        });
    });
});

// Helper function to format currency
function formatCurrency(value) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(value);
}

// Add to cart confirmation
function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    if (quantity && quantity > 0) {
        document.getElementById('addToCartForm').submit();
    } else {
        alert('Masukkan jumlah produk yang valid');
    }
}
