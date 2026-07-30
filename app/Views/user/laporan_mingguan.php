<div class="container-fluid py-4">

    <!-- HEADER STATUS SISTEM -->
    <div class="d-flex align-items-center mb-4">
        <div class="bg-danger text-white px-3 py-1 orbitron small shadow-sm"
            style="clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
            LAPORAN MINGGUAN
        </div>
        <div class="ml-3 text-secondary small orbitron" style="opacity: 0.8; letter-spacing: 1px;">
            Manajemen Data Kreator | Bloodstrike Creator Hub
        </div>
    </div>

    <link rel="stylesheet" href="<?= base_url('assets/css/mingguan.css') ?>">

    <!-- FORM INPUT LAPORAN MINGGUAN (KREATOR) -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="hud-card position-relative"
                style="<?= (!$isOpen || ($hasSubmittedYt && $hasSubmittedTt)) ? 'opacity: 0.7; overflow: hidden;' : '' ?>">

                <?php if (!$isOpen): ?>
                    <!-- Overlay: Pengiriman Laporan Ditutup -->
                    <div class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                        style="z-index: 100; top: 0; left: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); pointer-events: all; border-radius: 8px;">
                        <div class="bg-dark border border-warning p-4 text-center shadow-lg"
                            style="border-radius: 8px; max-width: 400px; border-width: 2px !important;">
                            <i class="fas fa-lock fa-3x text-warning mb-3"></i>
                            <h5 class="orbitron text-white fw-bold mb-2">AKSES DITUTUP</h5>
                            <p class="small text-secondary mb-0">Pengiriman laporan hanya dibuka setiap hari Senin s/d Rabu
                                pukul 15:00 WIB.</p>
                            <div class="mt-3">
                                <a href="<?= base_url('user') ?>" class="btn btn-outline-warning btn-sm orbitron"
                                    style="font-size: 0.6rem;">KEMBALI KE DASHBOARD</a>
                            </div>
                        </div>
                    </div>
                <?php elseif ($hasSubmittedYt && $hasSubmittedTt): ?>
                    <!-- Overlay: Semua Laporan Sudah Terkirim -->
                    <div class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                        style="z-index: 100; top: 0; left: 0; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); pointer-events: all; border-radius: 8px;">
                        <div class="bg-dark border border-success p-4 text-center shadow-lg"
                            style="border-radius: 8px; max-width: 450px; border-width: 2px !important;">
                            <i class="fas fa-check-double fa-3x text-success mb-3"></i>
                            <h5 class="orbitron text-white fw-bold mb-2">SEMUA LAPORAN TERKIRIM</h5>
                            <p class="small text-secondary mb-0">Anda telah mengirimkan laporan mingguan untuk platform
                                YouTube & TikTok. Terima kasih atas kontribusi Anda!</p>
                            <div class="mt-3">
                                <a href="<?= base_url('user') ?>" class="btn btn-outline-success btn-sm orbitron"
                                    style="font-size: 0.6rem;">KEMBALI KE DASHBOARD</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="hud-header">
                    <i class="fas fa-file-signature mr-2"></i> Kirim Laporan Mingguan Kreator
                </div>
                <div class="hud-body shadow-sm">
                    <form action="<?= base_url('user/laporan/save') ?>" method="post" enctype="multipart/form-data"
                        id="formLaporan" data-success="<?= session()->getFlashdata('success') ? 'true' : 'false' ?>">
                        <?= csrf_field() ?>

                        <div class="row align-items-center mb-4">
                            <!-- NAMA -->
                            <div class="col-md-8 mb-3 mb-md-0">
                                <label class="fw-bold text-light mb-2 small text-uppercase">Identitas Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control form-control-tactical"
                                    value="<?= esc($kreatorLogin['nama'] ?? session()->get('username')) ?>" readonly
                                    required style="background: rgba(15, 23, 42, 0.4); cursor: not-allowed;">
                            </div>
                            <!-- PLATFORM -->
                            <div class="col-md-4">
                                <label class="fw-bold text-light mb-2 small text-uppercase">Platform Utama <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark border-secondary text-white"
                                            style="border-radius: 0;"><i class="fas fa-globe"></i></span>
                                    </div>
                                    <?php
                                    // Bersihkan pilihan platform lama jika sudah terkirim
                                    $selectedPlatform = old('platform');
                                    if ($selectedPlatform === 'youtube' && $hasSubmittedYt) {
                                        $selectedPlatform = '';
                                    } elseif ($selectedPlatform === 'tiktok' && $hasSubmittedTt) {
                                        $selectedPlatform = '';
                                    }
                                    ?>
                                    <select name="platform" id="platformSelect"
                                        class="form-control form-control-tactical" required
                                        onchange="window.togglePlatformUI()" <?= !$isOpen ? 'disabled' : '' ?>>
                                        <option value="" disabled <?= empty($selectedPlatform) ? 'selected' : '' ?>>Pilih
                                            Platform</option>
                                        <option value="youtube" <?= $hasSubmittedYt ? 'disabled' : '' ?>
                                            <?= $selectedPlatform == 'youtube' ? 'selected' : '' ?>>
                                            YouTube <?= $hasSubmittedYt ? '(Sudah Dikirim)' : '' ?>
                                        </option>
                                        <option value="tiktok" <?= $hasSubmittedTt ? 'disabled' : '' ?>
                                            <?= $selectedPlatform == 'tiktok' ? 'selected' : '' ?>>
                                            TikTok <?= $hasSubmittedTt ? '(Sudah Dikirim)' : '' ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="metrics-container" style="display: <?= $selectedPlatform ? 'block' : 'none' ?>;">
                            <div class="row">
                                <!-- DATA VIDEO -->
                                <div class="col-md-4" id="video-col">
                                    <div class="p-3 mb-4 rounded"
                                        style="background: rgba(255, 255, 255, 0.03); border-left: 3px solid var(--bs-red);">
                                        <h6 class="text-white mb-4 fw-bold"><i id="video-icon"
                                                class="fas fa-video mr-2 text-danger"></i> <span id="video-label">Data
                                                Statistik Video</span></h6>
                                        <div class="mb-3">
                                            <label class="text-secondary small fw-bold mb-1">Jumlah Video Minggu Ini
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="jumlah_video"
                                                class="form-control form-control-tactical" placeholder="0"
                                                inputmode="numeric" pattern="[0-9]*" value="<?= old('jumlah_video') ?>"
                                                required <?= !$isOpen ? 'disabled' : '' ?>>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-secondary small fw-bold mb-1">Total Tayangan Video <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="total_views_video"
                                                class="form-control form-control-tactical" placeholder="0"
                                                inputmode="numeric" pattern="[0-9]*"
                                                value="<?= old('total_views_video') ?>" required <?= !$isOpen ? 'disabled' : '' ?>>
                                        </div>
                                        <div>
                                            <label class="text-secondary small fw-bold mb-1">Bukti Tangkapan Layar
                                                (Total Views) <span class="text-danger">*</span></label>
                                            <input type="file" name="foto_views_konten" class="form-control"
                                                accept="image/*" required
                                                style="background: rgba(15, 23, 42, 0.8); color: white; border: 1px solid rgba(255,255,255,0.1); border-radius: 0; padding-bottom: 35px;"
                                                <?= !$isOpen ? 'disabled' : '' ?>>
                                            <div class="orbitron text-muted mt-1"
                                                style="font-size: 0.55rem; letter-spacing: 0.5px;">
                                                <i class="fas fa-info-circle me-1"></i> Maks. 2 MB &middot; Format: JPG,
                                                PNG, WebP
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- DATA SHORTS (KHUSUS YOUTUBE) -->
                                <div class="col-md-4" id="shorts-section" style="display: none;">
                                    <div class="p-3 mb-4 rounded"
                                        style="background: rgba(255, 0, 0, 0.05); border-left: 3px solid #ff0000; height: 100%;">
                                        <h6 class="text-danger mb-4 fw-bold"><i class="fab fa-youtube mr-2"></i> Data
                                            YouTube Shorts</h6>
                                        <div class="mb-3">
                                            <label class="text-secondary small fw-bold mb-1">Jumlah Shorts Minggu Ini
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="jumlah_shorts" id="input_jumlah_shorts"
                                                class="form-control form-control-tactical" placeholder="0"
                                                inputmode="numeric" pattern="[0-9]*" value="<?= old('jumlah_shorts') ?>"
                                                <?= !$isOpen ? 'disabled' : '' ?>>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-secondary small fw-bold mb-1">Total Tayangan Shorts <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="views_shorts" id="input_views_shorts"
                                                class="form-control form-control-tactical" placeholder="0"
                                                inputmode="numeric" pattern="[0-9]*" value="<?= old('views_shorts') ?>"
                                                <?= !$isOpen ? 'disabled' : '' ?>>
                                        </div>
                                        <div>
                                            <label class="text-secondary small fw-bold mb-1">Bukti Tangkapan Layar
                                                (Shorts) <span class="text-danger">*</span></label>
                                            <input type="file" name="foto_views_shorts" id="input_foto_shorts"
                                                class="form-control" accept="image/*"
                                                style="background: rgba(15, 23, 42, 0.8); color: white; border: 1px solid rgba(255,255,255,0.1); border-radius: 0; padding-bottom: 35px;"
                                                <?= !$isOpen ? 'disabled' : '' ?>>
                                            <div class="orbitron text-muted mt-1"
                                                style="font-size: 0.55rem; letter-spacing: 0.5px;">
                                                <i class="fas fa-info-circle me-1"></i> Maks. 2 MB &middot; Format: JPG,
                                                PNG, WebP
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- DATA LIVE STREAMING -->
                                <div class="col-md-4" id="live-col">
                                    <div class="p-3 mb-4 rounded"
                                        style="background: rgba(255, 255, 255, 0.03); border-left: 3px solid #fff;">
                                        <h6 class="text-white mb-4 fw-bold"><i class="fas fa-broadcast-tower mr-2"></i>
                                            Data Live Streaming</h6>
                                        <div class="mb-3">
                                            <label class="text-secondary small fw-bold mb-1">Jumlah Live Minggu Ini
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="jumlah_live"
                                                class="form-control form-control-tactical" placeholder="0"
                                                inputmode="numeric" pattern="[0-9]*" value="<?= old('jumlah_live') ?>"
                                                required <?= !$isOpen ? 'disabled' : '' ?>>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-secondary small fw-bold mb-1">Total Penonton Live <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="total_views_live"
                                                class="form-control form-control-tactical" placeholder="0"
                                                inputmode="numeric" pattern="[0-9]*"
                                                value="<?= old('total_views_live') ?>" required <?= !$isOpen ? 'disabled' : '' ?>>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-secondary small fw-bold mb-1">Penonton Puncak Tertinggi
                                                (CCV) <span class="text-danger">*</span></label>
                                            <input type="text" name="penonton_puncak_live"
                                                class="form-control form-control-tactical" placeholder="0"
                                                inputmode="numeric" pattern="[0-9]*"
                                                value="<?= old('penonton_puncak_live') ?>" required <?= !$isOpen ? 'disabled' : '' ?>>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-secondary small fw-bold mb-1">Bukti Tangkapan Layar
                                                (Live) <span class="text-danger">*</span></label>
                                            <input type="file" name="foto_views_livestream" class="form-control"
                                                accept="image/*" required
                                                style="background: rgba(15, 23, 42, 0.8); color: white; border: 1px solid rgba(255,255,255,0.1); border-radius: 0; padding-bottom: 35px;"
                                                <?= !$isOpen ? 'disabled' : '' ?>>
                                            <div class="orbitron text-muted mt-1"
                                                style="font-size: 0.55rem; letter-spacing: 0.5px;">
                                                <i class="fas fa-info-circle me-1"></i> Maks. 2 MB &middot; Format: JPG,
                                                PNG, WebP
                                            </div>
                                        </div>
                                        <div>
                                            <label class="text-secondary small fw-bold mb-1">Bukti Penonton Puncak (CCV)
                                                <span class="text-danger">*</span></label>
                                            <input type="file" name="foto_penonton_puncak_live" class="form-control"
                                                accept="image/*" required
                                                style="background: rgba(15, 23, 42, 0.8); color: white; border: 1px solid rgba(255,255,255,0.1); border-radius: 0; padding-bottom: 35px;"
                                                <?= !$isOpen ? 'disabled' : '' ?>>
                                            <div class="orbitron text-muted mt-1"
                                                style="font-size: 0.55rem; letter-spacing: 0.5px;">
                                                <i class="fas fa-info-circle me-1"></i> Maks. 2 MB &middot; Format: JPG,
                                                PNG, WebP
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right mt-3">
                                <button type="button"
                                    onclick="window.validateAndConfirm(document.getElementById('formLaporan'))"
                                    id="btnSubmitLaporan" class="btn btn-danger px-5 py-3 fw-bold shadow-lg" ...>
                                    KIRIM <i class="fas fa-paper-plane ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL RIWAYAT LAPORAN KREATOR -->
    <div class="row">
        <div class="col-lg-12">
            <div class="hud-card mb-4" style="border-left: 3px solid var(--bs-red);">
                <div class="hud-body p-3">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-database mr-2 text-danger"></i>
                            <span class="orbitron small fw-bold text-white">RIWAYAT LAPORAN SAYA</span>
                        </div>

                        <!-- FILTER TANGGAL -->
                        <form action="<?= current_url() ?>" method="get"
                            class="d-flex flex-wrap align-items-center gap-2" id="filterFormUser">

                            <div class="d-flex align-items-center bg-dark px-2 border border-secondary"
                                style="height: 32px; border-radius: 4px;">
                                <i class="fas fa-calendar-alt small text-secondary mr-2"
                                    style="font-size: 0.65rem;"></i>
                                <input type="text" name="range_tanggal" id="datepicker-range"
                                    class="bg-transparent border-0 text-white orbitron p-0"
                                    style="font-size: 0.65rem; width: 130px; outline: none;" placeholder="TANGGAL"
                                    value="<?= ($tglMulai && $tglSelesai) ? ($tglMulai == $tglSelesai ? $tglMulai : "$tglMulai to $tglSelesai") : ($tglMulai ?? '') ?>"
                                    readonly>
                            </div>

                            <button type="submit" class="btn btn-danger btn-sm px-3"
                                style="background: var(--bs-red); border-radius: 4px; height: 32px;" title="Cari">
                                <i class="fas fa-search" style="font-size: 0.7rem;"></i>
                            </button>

                            <?php if (service('request')->getGet('range_tanggal')): ?>
                                <a href="<?= current_url() ?>"
                                    class="btn btn-outline-secondary btn-sm px-2 d-flex align-items-center orbitron"
                                    style="height: 32px; font-size: 0.6rem; border-radius: 4px;">RESET</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="hud-header d-flex justify-content-between align-items-center"
                style="background: linear-gradient(90deg, #1a1a1a 0%, #2d1212 100%); border-bottom: 1px solid rgba(234, 25, 23, 0.3);">
                <div class="orbitron text-white small fw-bold">
                    <i class="fas fa-list-ul mr-2 text-danger"></i> Daftar Laporan Saya
                </div>
            </div>
            <div class="hud-body p-0">
                <div class="table-responsive">
                    <table class="table table-tactical table-hover mb-0" id="laporanTable" style="min-width: 1100px;">
                        <thead>
                            <tr>
                                <th class="ps-4">NO</th>
                                <th>TANGGAL</th>
                                <th>PLATFORM</th>
                                <th>VIDEO (REG)</th>
                                <?php if (service('request')->getGet('platform') != 'tiktok'): ?>
                                    <th>YT SHORTS</th>
                                <?php endif; ?>
                                <th>LIVE VIEWS</th>
                                <th>PEAK CCV</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($laporans)): ?>
                                <?php $no = 1;
                                foreach ($laporans as $lap): ?>
                                    <tr>
                                        <td class="ps-4 align-middle">
                                            <span class="text-secondary orbitron" style="font-size: 0.75rem;">
                                                <?= str_pad((($pager->getCurrentPage('laporan') - 1) * $pager->getPerPage('laporan')) + $no++, 2, '0', STR_PAD_LEFT) ?>
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="text-info orbitron" style="font-size: 0.7rem; font-weight: bold;"
                                                title="Periode Kinerja Mingguan">
                                                <i class="fas fa-calendar-alt mr-1"
                                                    style="font-size: 0.65rem; color: var(--bs-red);"></i>
                                                <?= $lap['periode_kinerja'] ?>
                                            </div>
                                            <div class="text-muted small" style="font-size: 0.6rem;">
                                                Kirim:
                                                <?= date('d M Y, H:i', strtotime($lap['updated_at'] ?? $lap['created_at'])) ?>
                                                WIB
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php if ($lap['platform'] == 'youtube'): ?>
                                                <span class="badge bg-danger shadow-sm orbitron"
                                                    style="font-size: 0.55rem; padding: 4px 8px;">YOUTUBE</span>
                                            <?php else: ?>
                                                <span class="badge bg-dark border border-secondary shadow-sm orbitron"
                                                    style="font-size: 0.55rem; padding: 4px 8px;">TIKTOK</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- METRIC: VIDEO REG -->
                                        <td class="align-middle border-start border-dark"
                                            style="background: rgba(255,255,255,0.01);">
                                            <div class="text-white fw-bold small">
                                                <?= number_format($lap['total_views_video']) ?> <span class="text-muted"
                                                    style="font-size: 0.55rem;">Views</span>
                                            </div>
                                            <div class="text-secondary mb-1" style="font-size: 0.6rem;">
                                                <?= $lap['jumlah_video'] ?> Vids
                                            </div>
                                            <?php if (!empty($lap['foto_views_konten'])): ?>
                                                <a href="<?= foto_url($lap['foto_views_konten'], 'laporan') ?>" target="_blank"
                                                    class="badge bg-secondary p-1 text-white" style="font-size: 0.5rem;"><i
                                                        class="fas fa-image mr-1"></i> BUKTI</a>
                                            <?php elseif ($lap['status_validasi'] == 'tidak_valid'): ?>
                                                <span class="badge bg-dark border border-secondary text-secondary p-1"
                                                    style="font-size: 0.55rem; text-decoration: line-through; opacity: 0.6; display: inline-block; padding: 3px 5px;"
                                                    title="Bukti gambar telah kadaluwarsa/dihapus karena pengiriman ulang"><i
                                                        class="fas fa-image-slash mr-1"></i> KADALUWARSA</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- METRIC: YT SHORTS -->
                                        <?php if (service('request')->getGet('platform') != 'tiktok'): ?>
                                            <td class="align-middle">
                                                <?php if ($lap['platform'] == 'youtube'): ?>
                                                    <div class="text-danger fw-bold small">
                                                        <?= number_format($lap['views_shorts'] ?? 0) ?> <span class="text-muted"
                                                            style="font-size: 0.55rem;">Views</span>
                                                    </div>
                                                    <div class="text-secondary mb-1" style="font-size: 0.6rem;">
                                                        <?= $lap['jumlah_shorts'] ?? 0 ?> Shorts
                                                    </div>
                                                    <?php if (!empty($lap['foto_views_shorts'])): ?>
                                                        <a href="<?= foto_url($lap['foto_views_shorts'], 'laporan') ?>"
                                                            target="_blank" class="badge bg-danger p-1 text-white"
                                                            style="font-size: 0.5rem;"><i
                                                                class="fas fa-image mr-1"></i> BUKTI</a>
                                                    <?php elseif ($lap['status_validasi'] == 'tidak_valid'): ?>
                                                        <span class="badge bg-dark border border-secondary text-secondary p-1"
                                                            style="font-size: 0.55rem; text-decoration: line-through; opacity: 0.6; display: inline-block; padding: 3px 5px;"
                                                            title="Bukti gambar telah kadaluwarsa/dihapus karena pengiriman ulang"><i
                                                                class="fas fa-image-slash mr-1"></i> KADALUWARSA</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <div class="text-secondary fw-bold small" style="opacity: 0.4;">0 <span
                                                            class="text-muted" style="font-size: 0.55rem;">Views</span></div>
                                                    <div class="text-secondary mb-1" style="font-size: 0.6rem; opacity: 0.4;">0
                                                        Shorts</div>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>

                                        <!-- METRIC: LIVE VIEWS -->
                                        <td class="align-middle border-start border-dark" style="background: rgba(0,0,0,0.1);">
                                            <div class="text-warning fw-bold small">
                                                <?= number_format($lap['total_views_live']) ?> <span class="text-muted"
                                                    style="font-size: 0.55rem;">Views</span>
                                            </div>
                                            <div class="text-secondary mb-1" style="font-size: 0.6rem;">
                                                <?= $lap['jumlah_live'] ?> Live Sessions
                                            </div>
                                            <?php if (!empty($lap['foto_views_livestream'])): ?>
                                                <a href="<?= foto_url($lap['foto_views_livestream'], 'laporan') ?>"
                                                    target="_blank" class="badge bg-secondary p-1 text-white"
                                                    style="font-size: 0.5rem;"><i class="fas fa-image mr-1"></i> BUKTI</a>
                                            <?php elseif ($lap['status_validasi'] == 'tidak_valid'): ?>
                                                <span class="badge bg-dark border border-secondary text-secondary p-1"
                                                    style="font-size: 0.55rem; text-decoration: line-through; opacity: 0.6; display: inline-block; padding: 3px 5px;"
                                                    title="Bukti gambar telah kadaluwarsa/dihapus karena pengiriman ulang"><i
                                                        class="fas fa-image-slash mr-1"></i> KADALUWARSA</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- METRIC: CCV -->
                                        <td class="align-middle text-center">
                                            <div class="orbitron fw-bold text-white mb-1" style="font-size: 0.8rem;">
                                                <?= number_format($lap['penonton_puncak_live'] ?? 0) ?>
                                            </div>
                                            <?php if (!empty($lap['foto_penonton_puncak_live'])): ?>
                                                <a href="<?= foto_url($lap['foto_penonton_puncak_live'], 'laporan') ?>"
                                                    target="_blank"
                                                    class="badge bg-dark border border-secondary p-1 text-white"
                                                    style="font-size: 0.5rem;"><i class="fas fa-image mr-1"></i> CCV</a>
                                            <?php elseif ($lap['status_validasi'] == 'tidak_valid'): ?>
                                                <span class="badge bg-dark border border-secondary text-secondary p-1"
                                                    style="font-size: 0.55rem; text-decoration: line-through; opacity: 0.6; display: inline-block; padding: 3px 5px;"
                                                    title="Bukti gambar telah kadaluwarsa/dihapus karena pengiriman ulang"><i
                                                        class="fas fa-image-slash mr-1"></i> KADALUWARSA</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- STATUS & FEEDBACK -->
                                        <td class="align-middle">
                                            <?php if ($lap['status_validasi'] == 'valid'): ?>
                                                <span class="badge bg-success shadow-sm p-1 px-2 orbitron"
                                                    style="font-size: 0.55rem;"><i class="fas fa-check-circle mr-1"></i>
                                                    VALID</span>
                                            <?php elseif ($lap['status_validasi'] == 'tidak_valid'): ?>
                                                <span class="badge bg-danger shadow-sm p-1 px-2 orbitron"
                                                    style="font-size: 0.55rem;"><i class="fas fa-times-circle mr-1"></i>
                                                    REJECTED</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark shadow-sm p-1 px-2 orbitron"
                                                    style="font-size: 0.55rem;"><i class="fas fa-hourglass-half mr-1"></i>
                                                    PENDING</span>
                                            <?php endif; ?>

                                            <?php if (!empty($lap['pesan_admin'])): ?>
                                                <div class="mt-1">
                                                    <button type="button" class="badge border-0 btn-feedback-preview"
                                                        style="background: rgba(234,179,8,0.15); color: #eab308; border: 1px solid rgba(234,179,8,0.4) !important; font-size: 0.55rem; padding: 3px 7px; cursor: pointer; max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;"
                                                        data-feedback="<?= esc($lap['pesan_admin']) ?>"
                                                        data-laporan-id="<?= $lap['laporan_id'] ?>"
                                                        data-status="<?= $lap['status_validasi'] ?>"
                                                        onclick="previewFeedback(this)"
                                                        title="Klik untuk lihat feedback lengkap">
                                                        <i class="fas fa-comment-alt mr-1"></i><?= esc($lap['pesan_admin']) ?>
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted small orbitron">Belum ada data
                                        laporan yang ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (isset($pager)): ?>
                    <div class="hud-footer py-3 px-4 border-top border-dark d-flex justify-content-between align-items-center"
                        style="background: rgba(0,0,0,0.2);">
                        <div class="text-secondary small orbitron" style="font-size: 0.6rem;">
                            Menampilkan <?= count($laporans) ?> data di halaman ini
                        </div>
                        <div class="pagination-tactical">
                            <?= $pager->links('laporan', 'default_full') ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</div>

<!-- MODAL PREVIEW FEEDBACK DARI ADMIN -->
<div class="modal fade" id="feedbackPreviewModal" tabindex="-1" role="dialog" aria-hidden="true"
    style="z-index: 99999;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content"
            style="background: #0f172a; border: 1px solid rgba(234,179,8,0.3); border-radius: 8px; box-shadow: 0 20px 60px rgba(0,0,0,0.8);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.07);">
                <div class="d-flex align-items-center">
                    <div
                        style="width: 8px; height: 8px; background: #eab308; border-radius: 50%; margin-right: 10px; box-shadow: 0 0 8px rgba(234,179,8,0.6);">
                    </div>
                    <span class="orbitron text-white fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">Feedback
                        dari MiminBS</span>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal"
                    style="opacity: 0.5;">&times;</button>
            </div>
            <div class="modal-body py-4 px-4">
                <div id="feedbackStatusBadge" class="mb-3"></div>
                <div
                    style="background: rgba(234,179,8,0.05); border: 1px solid rgba(234,179,8,0.2); border-left: 3px solid #eab308; border-radius: 4px; padding: 16px 18px;">
                    <div class="orbitron text-secondary mb-2" style="font-size: 0.55rem; letter-spacing: 1px;">PESAN
                        FEEDBACK:</div>
                    <div id="feedbackPreviewText" class="text-white"
                        style="font-size: 0.85rem; line-height: 1.7; white-space: pre-wrap; word-break: break-word;">
                    </div>
                </div>
                <div class="mt-3 text-secondary" id="feedbackLaporanId" style="font-size: 0.6rem;"></div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.07);">
                <button type="button" class="btn btn-sm btn-outline-secondary orbitron"
                    style="font-size: 0.65rem; border-radius: 4px;" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<!-- FLATPICKR JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('assets/js/laporan-mingguan.js') ?>"></script>
