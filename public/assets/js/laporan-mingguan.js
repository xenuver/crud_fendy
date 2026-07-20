// FUNGSI KONFIRMASI GLOBAL
window.validateAndConfirm = function (formElement) {
    if (!formElement.checkValidity()) {
        formElement.reportValidity();
        return;
    }

    // Cek ukuran file sebelum disubmit (Maksimal 2MB per file)
    var fileInputs = formElement.querySelectorAll('input[type="file"]');
    var limitSize = 2 * 1024 * 1024; // 2MB
    for (var i = 0; i < fileInputs.length; i++) {
        if (fileInputs[i].files && fileInputs[i].files.length > 0) {
            if (fileInputs[i].files[0].size > limitSize) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'FILE TERLALU BESAR',
                        html: 'Ada file screenshot yang Anda pilih melebihi batas 2 MB.<br>Silakan perkecil (kompres) ukuran screenshot tersebut terlebih dahulu.',
                        icon: 'error',
                        background: '#0f172a',
                        color: '#fff',
                        confirmButtonColor: '#ea1917'
                    });
                } else {
                    alert('Ukuran file screenshot melebihi batas 2 MB. Silakan perkecil ukuran screenshot Anda.');
                }
                return;
            }
        }
    }

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin metrik & bukti screenshot sudah benar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea1917',
            cancelButtonColor: '#1e293b',
            confirmButtonText: 'Ya, Kirim Laporan',
            cancelButtonText: 'Periksa Kembali',
            background: '#0f172a',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.removeItem('draft_laporan_mingguan');
                // Pakai HTMLFormElement.submit() native, bukan jQuery
                HTMLFormElement.prototype.submit.call(formElement);
            }
        });
    } else {
        if (confirm('Apakah Anda yakin?')) {
            localStorage.removeItem('draft_laporan_mingguan');
            HTMLFormElement.prototype.submit.call(formElement);
        }
    }
};

// 1. GLOBAL UI TOGGLE (Ditempatkan di luar $(document).ready untuk akses instan)
window.togglePlatformUI = function () {
    var select = document.getElementById('platformSelect');
    var section = document.getElementById('shorts-section');
    var videoLabel = document.getElementById('video-label');
    var videoIcon = document.getElementById('video-icon');

    var inputShortsVids = document.getElementById('input_jumlah_shorts');
    var inputShortsViews = document.getElementById('input_views_shorts');
    var inputShortsFoto = document.getElementById('input_foto_shorts');

    var videoCol = document.getElementById('video-col');
    var liveCol = document.getElementById('live-col');
    var metricsContainer = document.getElementById('metrics-container');

    if (!select || !section) return;

    console.log("Switching platform to: " + select.value);

    // Hanya munculkan form metrik jika platform telah dipilih
    if (metricsContainer) {
        if (select.value === 'youtube' || select.value === 'tiktok') {
            metricsContainer.style.display = 'block';
        } else {
            metricsContainer.style.display = 'none';
            return; // Berhenti di sini jika kosong
        }
    }

    if (select.value === 'youtube') {
        // Force YouTube Mode
        section.setAttribute('style', 'display: block !important;');

        if (videoCol) videoCol.className = 'col-md-4 mb-3';
        if (liveCol) liveCol.className = 'col-md-4 mb-3';

        if (videoLabel) videoLabel.innerText = 'Data Statistik Video YouTube';
        if (videoIcon) videoIcon.className = 'fab fa-youtube mr-2 text-danger';

        if (inputShortsVids) inputShortsVids.setAttribute('required', 'required');
        if (inputShortsViews) inputShortsViews.setAttribute('required', 'required');
        if (inputShortsFoto) inputShortsFoto.setAttribute('required', 'required');
    } else if (select.value === 'tiktok') {
        // Force TikTok Mode
        section.setAttribute('style', 'display: none !important;');

        if (videoCol) videoCol.className = 'col-md-6 mb-3';
        if (liveCol) liveCol.className = 'col-md-6 mb-3';

        if (videoLabel) videoLabel.innerText = 'Data Statistik Video TikTok';
        if (videoIcon) videoIcon.className = 'fab fa-tiktok mr-2';

        if (inputShortsVids) inputShortsVids.removeAttribute('required');
        if (inputShortsViews) inputShortsViews.removeAttribute('required');
        if (inputShortsFoto) inputShortsFoto.removeAttribute('required');
    }
};

document.addEventListener('DOMContentLoaded', function () {
    // SANITIZE INTEGER INPUT — hanya izinkan digit, blokir semua karakter lain
    document.querySelectorAll('#formLaporan input[inputmode="numeric"]').forEach(function (input) {
        input.addEventListener('keydown', function (e) {
            var allowed = ['Backspace', 'Delete', 'Tab', 'ArrowLeft', 'ArrowRight', 'Home', 'End'];
            if (allowed.includes(e.key)) return;
            if (!/^[0-9]$/.test(e.key)) e.preventDefault();
        });
        input.addEventListener('input', function () {
            var clean = this.value.replace(/[^0-9]/g, '');
            if (this.value !== clean) this.value = clean;
        });
        input.addEventListener('paste', function (e) {
            e.preventDefault();
            var text = (e.clipboardData || window.clipboardData).getData('text');
            this.value = text.replace(/[^0-9]/g, '');
        });
    });

    // 2. DATA TABLES SETUP
    if ($('#laporanTable').length) {
        $('#laporanTable').DataTable({
            "paging": false, // Matikan paging DataTables karena pakai CI Pager
            "info": false,   // Matikan info DataTables
            "order": [[0, "asc"]],
            "language": {
                "search": "CARI DATA:",
                "zeroRecords": "Data tidak ditemukan.",
            }
        });
    }

    // 3. FITUR AUTO-SAVE (LOCALSTORAGE)
    var form = document.getElementById('formLaporan');
    var storageKey = 'draft_laporan_mingguan';

    if (form) {
        // Fungsi Muat Draft
        const loadDraft = () => {
            const savedData = localStorage.getItem(storageKey);
            if (savedData) {
                const data = JSON.parse(savedData);
                Object.keys(data).forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input && input.type !== 'file') {
                        if (key === 'platform') {
                            const option = input.querySelector(`option[value="${data[key]}"]`);
                            if (option && option.disabled) {
                                return; // Jangan isi platform yang sudah dikirim/disabled
                            }
                        }
                        input.value = data[key];
                    }
                });
            }
        };

        // Fungsi Simpan Draft
        const saveDraft = () => {
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                if (!(value instanceof File)) data[key] = value;
            });
            localStorage.setItem(storageKey, JSON.stringify(data));
        };

        // Inisialisasi Draft & UI
        loadDraft();
        window.togglePlatformUI();

        // Listener Input untuk Simpan Draft
        form.querySelectorAll('input:not([type="file"]), select, textarea').forEach(el => {
            el.addEventListener('input', saveDraft);
            // Khusus select platform, kita trigger saveDraft setiap kali UI ganti
            if (el.id === 'platformSelect') el.addEventListener('change', saveDraft);
        });

        // Bersihkan draft jika sukses (cek flash message via data-success)
        const isSuccess = form.getAttribute('data-success') === 'true';
        if (isSuccess) {
            localStorage.removeItem(storageKey);
        }
    }

    // Validasi file upload (Hanya akan dipanggil setelah DOM siap dan jQuery ada)
    $('input[type="file"]').on('change', function () {
        var file = this.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) { // Peringatan 2MB
                Swal.fire({
                    title: 'Ukuran Terlalu Besar',
                    text: 'Maksimal ukuran screenshot adalah 2MB.',
                    icon: 'error',
                    background: '#0f172a',
                    color: '#fff',
                    confirmButtonColor: '#ea1917'
                });
                this.value = '';
            }
        }
    });
});

// 4. FEEDBACK PREVIEW MODAL — set konten dulu, baru buka modal
window.previewFeedback = function (btn) {
    var feedback = btn.getAttribute('data-feedback');
    var lapId = btn.getAttribute('data-laporan-id');
    var status = btn.getAttribute('data-status');

    document.getElementById('feedbackPreviewText').textContent = feedback || '(tidak ada pesan)';
    document.getElementById('feedbackLaporanId').textContent = 'Laporan ID #' + lapId;

    var badgeHtml = '';
    if (status === 'valid') {
        badgeHtml = '<span class="badge bg-success orbitron" style="font-size:0.55rem;"><i class="fas fa-check-circle mr-1"></i> VALID</span>';
    } else if (status === 'tidak_valid') {
        badgeHtml = '<span class="badge bg-danger orbitron" style="font-size:0.55rem;"><i class="fas fa-times-circle mr-1"></i> REJECTED</span>';
    } else {
        badgeHtml = '<span class="badge bg-warning text-dark orbitron" style="font-size:0.55rem;"><i class="fas fa-hourglass-half mr-1"></i> PENDING</span>';
    }
    document.getElementById('feedbackStatusBadge').innerHTML = badgeHtml;

    $('#feedbackPreviewModal').modal('show');
};

// 5. FLATPICKR INITIALIZATION
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('datepicker-range')) {
        flatpickr("#datepicker-range", {
            mode: "range",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d M Y",
            theme: "dark",
            onClose: function (selectedDates, dateStr, instance) {
                if (dateStr.includes(" to ")) {
                    instance.element.form.submit();
                }
            }
        });
    }

    // 6. DELETE CONFIRMATION
    document.addEventListener('click', function (e) {
        var button = e.target.closest('.btn-delete-laporan');
        if (button) {
            e.preventDefault();
            var form = button.closest('form');
            Swal.fire({
                title: 'KONFIRMASI HAPUS',
                text: 'Apakah Anda yakin ingin menghapus laporan mingguan ini secara permanen?',
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
    });
});

