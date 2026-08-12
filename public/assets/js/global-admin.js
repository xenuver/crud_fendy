$(document).ready(function() {
    // Inisialisasi Tooltips Bootstrap
    $('[data-toggle="tooltip"]').tooltip();

    // SweetAlert2 Logout Confirmation
    $('#btn-logout').on('click', function(e) {
        e.preventDefault();
        var logoutUrl = $(this).attr('href');
        
        Swal.fire({
            title: 'KONFIRMASI KELUAR',
            text: 'Apakah Anda yakin ingin keluar dari sistem?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea1917',
            cancelButtonColor: '#1e293b',
            confirmButtonText: 'YA, KELUAR',
            cancelButtonText: 'BATAL',
            background: '#0f172a',
            color: '#fff',
            customClass: {
                popup: 'swal-tactical',
                title: 'swal-tactical-title',
                htmlContainer: 'swal-tactical-text',
                confirmButton: 'swal-tactical-btn-confirm',
                cancelButton: 'swal-tactical-btn-cancel'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = logoutUrl;
            }
        });
    });

    // Skrip Pencarian Global Taktis (Topbar)
    $('#globalSearchInput').on('keyup', function() {
        var searchTerm = $(this).val();
        
        // Cari semua tabel yang menggunakan plugin DataTable di halaman ini
        if ($.fn.DataTable) {
            $.fn.dataTable.tables({ visible: true, api: true }).search(searchTerm).draw();
        }
    });

    // Tambahkan efek glow saat fokus pada input taktis
    $('.form-control-tactical').on('focus', function() {
        $(this).closest('.input-group, .form-control-tactical').css('box-shadow', '0 0 15px var(--bs-accent-glow)');
        $(this).closest('.input-group, .form-control-tactical').css('border-color', 'var(--bs-red)');
    }).on('blur', function() {
        $(this).closest('.input-group, .form-control-tactical').css('box-shadow', 'none');
        $(this).closest('.input-group, .form-control-tactical').css('border-color', 'rgba(255, 255, 255, 0.1)');
    });

    // SweetAlert2 Integration for Flash Messages (Success / Error)
    const body = document.body;
    const successMsg = body.getAttribute('data-success');
    const errorMsg = body.getAttribute('data-error');

    if (successMsg) {
        Swal.fire({
            title: 'BERHASIL',
            html: successMsg,
            icon: 'success',
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#ea1917',
            customClass: {
                popup: 'swal-tactical',
                title: 'swal-tactical-title',
                htmlContainer: 'swal-tactical-text',
                confirmButton: 'swal-tactical-btn-confirm'
            },
            buttonsStyling: false
        });
    }

    if (errorMsg) {
        Swal.fire({
            title: 'GAGAL',
            html: errorMsg,
            icon: 'error',
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#ea1917',
            customClass: {
                popup: 'swal-tactical',
                title: 'swal-tactical-title',
                htmlContainer: 'swal-tactical-text',
                confirmButton: 'swal-tactical-btn-confirm'
            },
            buttonsStyling: false
        });
    }
});

// Helper Navigasi Scroll Tabel Horizontal (iPad & Mobile)
window.scrollTable = function(tableId, direction) {
    var table = document.getElementById(tableId);
    if (!table) return;
    var container = table.closest('.table-responsive') || table.closest('.dataTables_wrapper') || table.parentElement;
    if (container) {
        var amount = direction === 'left' ? -350 : 350;
        container.scrollBy({ left: amount, behavior: 'smooth' });
    }
};

