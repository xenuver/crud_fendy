// SweetAlert2 Integration for Flash Messages (if any)
document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    const successMsg = body.getAttribute('data-success');
    const errorMsg = body.getAttribute('data-error');

    if (successMsg) {
        Swal.fire({
            icon: 'success',
            title: 'BERHASIL',
            html: successMsg,
            confirmButtonText: 'OK'
        });
    }

    if (errorMsg) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            html: errorMsg,
            confirmButtonText: 'COBA LAGI'
        });
    }

    // Inisialisasi Bootstrap Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
