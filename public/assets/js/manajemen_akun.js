document.addEventListener('DOMContentLoaded', function() {
    console.log("manajemen_akun.js: DOMContentLoaded triggered");

    // 1. Inisialisasi DataTable
    if ($('#dataTable').length && $.fn.DataTable) {
        $('#dataTable').DataTable({
            "paging": false,
            "info": false,
            "language": {
                "search": "CARI AKUN:",
                "zeroRecords": "Akun tidak ditemukan."
            }
        });
    }

    // 2. Global Click Handler untuk Delete & Actions
    document.addEventListener('click', function (e) {
        console.log("manajemen_akun.js: Document clicked, target:", e.target);

        // Delete User Account
        var deleteUserBtn = e.target.closest('.btn-delete-user');
        if (deleteUserBtn) {
            console.log("manajemen_akun.js: Matches .btn-delete-user");
            e.preventDefault();
            var form = deleteUserBtn.closest('form');
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'HAPUS AKUN PENGGUNA',
                    text: 'Apakah Anda yakin ingin menghapus akun ini secara permanen?',
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
            } else {
                if (confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen?')) {
                    form.submit();
                }
            }
        }

        // Delete Redeem Code
        var deleteCodeBtn = e.target.closest('.btn-delete-code');
        if (deleteCodeBtn) {
            e.preventDefault();
            var form = deleteCodeBtn.closest('form');
            var confirmText = deleteCodeBtn.getAttribute('data-confirm-text') || 'Yakin ingin menghapus kode ini?';
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'HAPUS REDEEM CODE',
                    text: confirmText,
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
            } else {
                if (confirm(confirmText)) {
                    form.submit();
                }
            }
        }
    });
});

// Copy link registrasi ke clipboard
function copyLink(url, btn) {
    navigator.clipboard.writeText(url).then(function() {
        if (btn) {
            const icon = btn.querySelector('i');
            const oldClass = icon.className;
            icon.className = 'fas fa-check';
            btn.style.color = '#4ade80';
            setTimeout(function() {
                icon.className = oldClass;
                btn.style.color = '';
            }, 2000);
        } else {
            const icon = document.getElementById('copyLinkIcon');
            icon.classList.remove('fa-copy');
            icon.classList.add('fa-check');
            icon.style.color = '#4ade80';
            setTimeout(function() {
                icon.classList.remove('fa-check');
                icon.classList.add('fa-copy');
                icon.style.color = '';
            }, 2000);
        }
    });
}

// Copy text dari textarea tersembunyi ke clipboard
function copyFromTextarea(textareaId, btn, iconId, originalText) {
    const textarea = document.getElementById(textareaId);
    if (!textarea) return;

    navigator.clipboard.writeText(textarea.value).then(function() {
        btn.innerHTML = '<i class="fas fa-check text-success" id="' + iconId + '"></i> Berhasil Disalin!';
        setTimeout(function() {
            btn.innerHTML = '<i class="' + (iconId === 'bulkCopyIcon' ? 'fas fa-copy' : 'fas fa-link') + '" id="' + iconId + '"></i> ' + originalText;
        }, 2000);
    });
}

// Konfirmasi generate redeem code dengan jumlah yang dipilih
function confirmGenerate(form) {
    const qty = document.getElementById('jumlahGenerate').value;
    return confirm('Apakah Anda yakin ingin me-generate ' + qty + ' Redeem Code baru?');
}
