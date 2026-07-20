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



    <?php if (session()->get('role') == 'user'): ?>
        <!-- TAMPILAN USER: FORM INPUT LAPORAN MINGGUAN -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="hud-card position-relative"
                    style="<?= (!$isOpen || ($hasSubmittedYt && $hasSubmittedTt)) ? 'opacity: 0.7; overflow: hidden;' : '' ?>">

                    <?php if (!$isOpen): ?>
                        <!-- Overlay Pesan Akses yang Memblokir Klik -->
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
                    <?php elseif (isset($hasSubmittedYt) && $hasSubmittedYt && isset($hasSubmittedTt) && $hasSubmittedTt): ?>
                        <!-- Overlay Semua Laporan Terkirim -->
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
                                        $selectedPlatform = old('platform');
                                        if ($selectedPlatform === 'youtube' && ($hasSubmittedYt ?? false)) {
                                            $selectedPlatform = '';
                                        } elseif ($selectedPlatform === 'tiktok' && ($hasSubmittedTt ?? false)) {
                                            $selectedPlatform = '';
                                        }
                                        ?>
                                        <select name="platform" id="platformSelect"
                                            class="form-control form-control-tactical" required
                                            onchange="window.togglePlatformUI()" <?= !$isOpen ? 'disabled' : '' ?>>
                                            <option value="" disabled <?= empty($selectedPlatform) ? 'selected' : '' ?>>Pilih
                                                Platform</option>
                                            <option value="youtube" <?= (isset($hasSubmittedYt) && $hasSubmittedYt) ? 'disabled' : '' ?>     <?= $selectedPlatform == 'youtube' ? 'selected' : '' ?>>
                                                YouTube
                                                <?= (isset($hasSubmittedYt) && $hasSubmittedYt) ? '(Sudah Dikirim)' : '' ?>
                                            </option>
                                            <option value="tiktok" <?= (isset($hasSubmittedTt) && $hasSubmittedTt) ? 'disabled' : '' ?>     <?= $selectedPlatform == 'tiktok' ? 'selected' : '' ?>>
                                                TikTok
                                                <?= (isset($hasSubmittedTt) && $hasSubmittedTt) ? '(Sudah Dikirim)' : '' ?>
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
                                                    (Video) <span class="text-danger">*</span></label>
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
                                                <label class="text-secondary small fw-bold mb-1">Jumlah Penonton Puncak
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
    <?php endif; ?>

    <!-- AREA TABEL HISTORI LAPORAN -->
    <div class="row">
        <div class="col-lg-12">
            <div class="hud-card mb-4" style="border-left: 3px solid var(--bs-red);">
                <div class="hud-body p-3">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-database mr-2 text-danger"></i>
                            <span class="orbitron small fw-bold text-white">REKAP LAPORAN MINGGUAN</span>
                        </div>

                        <!-- FILTER BAR TERUNIFIKASI -->
                        <form action="<?= current_url() ?>" method="get"
                            class="d-flex flex-wrap align-items-center gap-2" id="filterFormAdmin">

                            <?php if (session()->get('role') == 'admin'): ?>
                                <!-- PLATFORM -->
                                <div class="d-flex align-items-center bg-dark px-2 border border-secondary"
                                    style="height: 32px; border-radius: 4px;">
                                    <i class="fas fa-filter small text-secondary mr-2" style="font-size: 0.65rem;"></i>
                                    <select name="platform" class="bg-transparent border-0 text-white orbitron small p-0"
                                        style="font-size: 0.65rem; width: 85px; outline: none;"
                                        onchange="this.form.submit()">
                                        <option value="" class="bg-dark">PLATFORM</option>
                                        <option value="youtube" class="bg-dark"
                                            <?= service('request')->getGet('platform') == 'youtube' ? 'selected' : '' ?>>
                                            YOUTUBE</option>
                                        <option value="tiktok" class="bg-dark"
                                            <?= service('request')->getGet('platform') == 'tiktok' ? 'selected' : '' ?>>TIKTOK
                                        </option>
                                    </select>
                                </div>

                                <!-- STATUS -->
                                <div class="d-flex align-items-center bg-dark px-2 border border-secondary"
                                    style="height: 32px; border-radius: 4px;">
                                    <i class="fas fa-check-circle small text-secondary mr-2"
                                        style="font-size: 0.65rem;"></i>
                                    <select name="status" class="bg-transparent border-0 text-white orbitron small p-0"
                                        style="font-size: 0.65rem; width: 85px; outline: none;"
                                        onchange="this.form.submit()">
                                        <option value="" class="bg-dark">STATUS</option>
                                        <option value="pending" class="bg-dark"
                                            <?= service('request')->getGet('status') == 'pending' ? 'selected' : '' ?>>PENDING
                                        </option>
                                        <option value="valid" class="bg-dark"
                                            <?= service('request')->getGet('status') == 'valid' ? 'selected' : '' ?>>VALID
                                        </option>
                                        <option value="tidak_valid" class="bg-dark"
                                            <?= service('request')->getGet('status') == 'tidak_valid' ? 'selected' : '' ?>>
                                            INVALID</option>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <!-- DATE RANGE -->
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

                            <?php if (session()->get('role') == 'admin'): ?>
                                <a href="<?= base_url('admin/laporan/exportWeekly?' . http_build_query(service('request')->getGet())) ?>"
                                    class="btn btn-success btn-sm px-3 d-flex align-items-center orbitron"
                                    style="background: #198754; border-radius: 4px; height: 32px; font-size: 0.65rem;">
                                    <i class="fas fa-file-excel mr-2"></i> EKSPOR (.XLSX)
                                </a>
                            <?php endif; ?>

                            <?php if (service('request')->getGet('range_tanggal') || service('request')->getGet('platform') || service('request')->getGet('status')): ?>
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
                    <i class="fas fa-list-ul mr-2 text-danger"></i> Daftar Laporan Kreator
                </div>
            </div>
            <div class="hud-body p-0">
                <div class="table-responsive">
                    <table class="table table-tactical table-hover mb-0" id="laporanTable" style="min-width: 1300px;">
                        <thead>
                            <tr>
                                <th class="ps-4">NO</th>
                                <th>TANGGAL</th>
                                <th>IDENTITAS KREATOR</th>
                                <th>PLATFORM</th>
                                <th>VIDEO (REG)</th>
                                <?php if (service('request')->getGet('platform') != 'tiktok'): ?>
                                    <th>YT SHORTS</th>
                                <?php endif; ?>
                                <th>LIVE VIEWS</th>
                                <th>PEAK CCV</th>
                                <th>STATUS</th>
                                <?php if (session()->get('role') == 'admin'): ?>
                                    <th class="text-center pe-4">AKSI</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($laporans)): ?>
                                <?php $no = 1;
                                foreach ($laporans as $lap): ?>
                                    <?php
                                    $namaChannel = "Channel Lupa/Hilang";
                                    $krData = null;
                                    foreach ($kreators as $kr) {
                                        if ($kr['kreator_id'] == $lap['kreator_id']) {
                                            $namaChannel = $kr['nama'];
                                            $krData = $kr;
                                            break;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td class="ps-4 align-middle">
                                            <span class="text-secondary orbitron" style="font-size: 0.75rem;">
                                                <?= str_pad((($pager->getCurrentPage('laporan') - 1) * $pager->getPerPage('laporan')) + $no++, 2, '0', STR_PAD_LEFT) ?>
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <?php
                                            $lapTime = strtotime($lap['created_at']);
                                            $mondayOfSub = strtotime('monday this week', $lapTime);
                                            $startPerf = date('d M', strtotime('-7 days', $mondayOfSub));
                                            $endPerf = date('d M Y', strtotime('-1 day', $mondayOfSub));
                                            ?>
                                            <div class="text-info orbitron" style="font-size: 0.7rem; font-weight: bold;"
                                                title="Periode Kinerja Mingguan">
                                                <i class="fas fa-calendar-alt mr-1"
                                                    style="font-size: 0.65rem; color: var(--bs-red);"></i><?= $startPerf ?> -
                                                <?= $endPerf ?>
                                            </div>
                                            <div class="text-muted small" style="font-size: 0.6rem;">
                                                Kirim:
                                                <?= date('d M Y, H:i', strtotime($lap['updated_at'] ?? $lap['created_at'])) ?>
                                                WIB
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center mb-1">
                                                <?php if ($krData && isset($krData['tier_label'])): ?>
                                                    <i class="<?= $krData['tier_icon'] ?> mr-2"
                                                        style="font-size: 0.75rem; color: var(--bs-red);"
                                                        title="<?= $krData['tier_label'] ?>"></i>
                                                <?php endif; ?>
                                                <span class="fw-bold text-white small"><?= esc($lap['nama_lengkap']) ?></span>
                                            </div>
                                            <div class="text-secondary" style="font-size: 0.6rem;">UID:
                                                <?= esc($krData['id_game'] ?? '-') ?>
                                            </div>
                                            <div class="d-flex gap-2 mt-1">
                                                <?php if ($krData && !empty($krData['tiktok_link'])): ?>
                                                    <a href="<?= esc($krData['tiktok_link']) ?>" target="_blank"
                                                        class="text-secondary hover-red" style="font-size: 0.65rem;"><i
                                                            class="fab fa-tiktok"></i></a>
                                                <?php endif; ?>
                                                <?php if ($krData && !empty($krData['youtube_link'])): ?>
                                                    <a href="<?= esc($krData['youtube_link']) ?>" target="_blank"
                                                        class="text-danger hover-white" style="font-size: 0.65rem;"><i
                                                            class="fab fa-youtube"></i></a>
                                                <?php endif; ?>
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
                                                    title="Bukti gambar telah kedaluwarsa/dihapus karena pengiriman ulang"><i
                                                        class="fas fa-image-slash mr-1"></i> KEDALUWARSA</span>
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
                                                        <a href="<?= foto_url($lap['foto_views_shorts'], 'laporan') ?>" target="_blank"
                                                            class="badge bg-danger p-1 text-white" style="font-size: 0.5rem;"><i
                                                                class="fas fa-image mr-1"></i> BUKTI</a>
                                                    <?php elseif ($lap['status_validasi'] == 'tidak_valid'): ?>
                                                        <span class="badge bg-dark border border-secondary text-secondary p-1"
                                                            style="font-size: 0.55rem; text-decoration: line-through; opacity: 0.6; display: inline-block; padding: 3px 5px;"
                                                            title="Bukti gambar telah kedaluwarsa/dihapus karena pengiriman ulang"><i
                                                                class="fas fa-image-slash mr-1"></i> KEDALUWARSA</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <div class="text-secondary fw-bold small" style="opacity: 0.4;">0 <span
                                                            class="text-muted" style="font-size: 0.55rem;">Views</span></div>
                                                    <div class="text-secondary mb-1" style="font-size: 0.6rem; opacity: 0.4;">0 Shorts
                                                    </div>
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
                                                <a href="<?= foto_url($lap['foto_views_livestream'], 'laporan') ?>" target="_blank"
                                                    class="badge bg-secondary p-1 text-white" style="font-size: 0.5rem;"><i
                                                        class="fas fa-image mr-1"></i> BUKTI</a>
                                            <?php elseif ($lap['status_validasi'] == 'tidak_valid'): ?>
                                                <span class="badge bg-dark border border-secondary text-secondary p-1"
                                                    style="font-size: 0.55rem; text-decoration: line-through; opacity: 0.6; display: inline-block; padding: 3px 5px;"
                                                    title="Bukti gambar telah kedaluwarsa/dihapus karena pengiriman ulang"><i
                                                        class="fas fa-image-slash mr-1"></i> KEDALUWARSA</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- METRIC: CCV -->
                                        <td class="align-middle text-center">
                                            <div class="orbitron fw-bold text-white mb-1" style="font-size: 0.8rem;">
                                                <?= number_format($lap['penonton_puncak_live'] ?? 0) ?>
                                            </div>
                                            <?php if (!empty($lap['foto_penonton_puncak_live'])): ?>
                                                <a href="<?= foto_url($lap['foto_penonton_puncak_live'], 'laporan') ?>"
                                                    target="_blank" class="badge bg-dark border border-secondary p-1 text-white"
                                                    style="font-size: 0.5rem;"><i class="fas fa-image mr-1"></i> CCV</a>
                                            <?php elseif ($lap['status_validasi'] == 'tidak_valid'): ?>
                                                <span class="badge bg-dark border border-secondary text-secondary p-1"
                                                    style="font-size: 0.55rem; text-decoration: line-through; opacity: 0.6; display: inline-block; padding: 3px 5px;"
                                                    title="Bukti gambar telah kedaluwarsa/dihapus karena pengiriman ulang"><i
                                                        class="fas fa-image-slash mr-1"></i> KEDALUWARSA</span>
                                            <?php endif; ?>
                                        </td>

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
                                                        data-status="<?= $lap['status_validasi'] ?>" onclick="previewFeedback(this)"
                                                        title="Klik untuk lihat feedback lengkap">
                                                        <i class="fas fa-comment-alt mr-1"></i><?= esc($lap['pesan_admin']) ?>
                                                    </button>
                                                </div>
                                            <?php endif; ?>

                                        </td>

                                        <?php if (session()->get('role') == 'admin'): ?>
                                            <td class="align-middle text-center pe-4">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button class="btn btn-warning btn-sm p-1 orbitron"
                                                        style="font-size: 0.6rem; height: 26px; width: 26px;" data-toggle="modal"
                                                        data-target="#reviewModal<?= $lap['laporan_id'] ?>" title="Review">
                                                        <i class="fas fa-search-plus"></i>
                                                    </button>
                                                    <form method="POST"
                                                        action="<?= base_url('admin/laporan/delete/' . $lap['laporan_id']) ?>"
                                                        style="display:inline-block; margin:0;">
                                                        <?= csrf_field() ?>
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm p-1 btn-delete-laporan"
                                                            style="height: 26px; width: 26px;" title="Delete">
                                                            <i class="fas fa-trash-alt" style="font-size: 0.65rem;"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center py-5 text-muted small orbitron">Belum ada data
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

<!-- Modal Review Section -->
<?php if (session()->get('role') == 'admin' && !empty($laporans)): ?>
    <?php foreach ($laporans as $lap): ?>
        <div class="modal fade" id="reviewModal<?= $lap['laporan_id'] ?>" tabindex="-1" role="dialog" aria-hidden="true"
            style="z-index: 9999;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content"
                    style="background: #1a1a1a; border: 1px solid #333; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                    <form action="<?= base_url('admin/laporan/verify/' . $lap['laporan_id']) ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="modal-header border-0 shadow-sm">
                            <div class="h6 mb-0 text-white fw-bold orbitron small">VERIFIKASI LAPORAN
                                #LM<?= $lap['laporan_id'] ?></div>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body py-4">
                            <div class="mb-4">
                                <label class="text-secondary small fw-bold mb-2 d-block text-uppercase orbitron"
                                    style="font-size: 0.6rem;">Status Validasi</label>
                                <select name="status" class="form-control bg-dark text-white border-secondary orbitron small"
                                    required style="border-radius: 4px; height: 40px;">
                                    <option value="valid" <?= $lap['status_validasi'] == 'valid' ? 'selected' : '' ?>>SETUJU /
                                        VALID</option>
                                    <option value="tidak_valid" <?= $lap['status_validasi'] == 'tidak_valid' ? 'selected' : '' ?>>
                                        TOLAK / INVALID</option>
                                    <option value="pending" <?= $lap['status_validasi'] == 'pending' ? 'selected' : '' ?>>TUNDA /
                                        PENDING</option>
                                </select>
                            </div>

                            <div class="mb-0">
                                <label class="text-secondary small fw-bold mb-2 d-block text-uppercase orbitron"
                                    style="font-size: 0.6rem;">Pesan Feedback</label>
                                <textarea name="pesan" class="form-control bg-dark text-white border-secondary shadow-none"
                                    rows="3" style="border-radius: 4px;"
                                    placeholder="Masukkan feedback untuk kreator..."><?= esc($lap['pesan_admin'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-sm btn-link text-secondary text-decoration-none orbitron small"
                                data-dismiss="modal">BATAL</button>
                            <button type="submit" class="btn btn-sm btn-danger px-4 shadow-sm orbitron"
                                style="background: var(--bs-red); border: none; font-size: 0.7rem; height: 35px;">KIRIM
                                FEEDBACK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- FLATPICKR JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('assets/js/laporan-mingguan.js') ?>"></script>