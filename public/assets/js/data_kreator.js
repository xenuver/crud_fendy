document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi DataTable (Scripts sudah dimuat di footer)
    if ($.fn.DataTable) {
        $('#kreatorTable').DataTable({
            "pageLength": 10,
            "language": {
                "search": "Cari Kreator:",
                "searchPlaceholder": "Ketik nama kreator...",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                "zeroRecords": "Data tidak ditemukan",
                "infoEmpty": "Basis data kosong",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Berikutnya"
                }
            },
            "drawCallback": function(settings) {
                $('.dataTables_paginate .paginate_button').addClass('orbitron small');
            }
        });
    }

    // Global Click Handler untuk Delete & Status Toggle Kreator
    document.addEventListener('click', function (e) {
        // 1. Hapus Data Kreator
        var button = e.target.closest('.btn-delete-kreator');
        if (button) {
            e.preventDefault();
            var form = button.closest('form');
            Swal.fire({
                title: 'HAPUS DATA KREATOR',
                text: 'Apakah Anda yakin ingin menghapus data kreator ini secara permanen dari database?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ea1917',
                cancelButtonColor: '#1e293b',
                confirmButtonText: 'YA, HAPUS',
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
                    form.submit();
                }
            });
        }

        // 2. Toggle Status Suspend/Aktifkan Kreator
        var toggleBtn = e.target.closest('.btn-toggle-status-kreator');
        if (toggleBtn) {
            e.preventDefault();
            var form = toggleBtn.closest('form');
            var currentStatus = toggleBtn.getAttribute('data-status');
            var namaKreator = toggleBtn.getAttribute('data-nama');
            
            var isSuspend = (currentStatus === 'active');
            var actionTitle = isSuspend ? 'SUSPEND KREATOR' : 'AKTIFKAN KREATOR';
            var actionText = isSuspend 
                ? 'Apakah Anda yakin ingin menangguhkan (suspend) kreator "' + namaKreator + '"? Kreator yang ditangguhkan tidak akan dapat mengakses dasbor.' 
                : 'Apakah Anda yakin ingin mengaktifkan kembali kreator "' + namaKreator + '"?';
            var actionConfirm = isSuspend ? 'YA, SUSPEND' : 'YA, AKTIFKAN';
            
            Swal.fire({
                title: actionTitle,
                text: actionText,
                icon: isSuspend ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: '#ea1917',
                cancelButtonColor: '#1e293b',
                confirmButtonText: actionConfirm,
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
                    form.submit();
                }
            });
        }
    });
});
