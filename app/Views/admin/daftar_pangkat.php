<div class="container-fluid py-4">

    <!-- HEADER STATUS ADMIN -->
    <div class="d-flex align-items-center mb-4">
        <div class="bg-danger text-white px-3 py-1 orbitron small shadow-sm"
            style="clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
            DAFTAR PANGKAT KREATOR
        </div>
        <div class="ms-3 text-secondary small orbitron" style="opacity: 0.8; letter-spacing: 1px;">
            Sistem Kualifikasi Pangkat Kreator Bloodstrike
        </div>
    </div>

    <!-- RINGKASAN PANGKAT (3 Kolom Berjejer Rapi) -->
    <div class="row mb-4">
        <div class="col-4 col-md-4 mb-3 mb-md-0 px-2 px-md-3">
            <div class="hud-card h-100 shadow-lg p-3 p-md-4" style="border-left: 4px solid #FFD700; background: rgba(15, 23, 42, 0.6);">
                <div class="small fw-bold mb-2 orbitron" style="color: #FFD700; font-size: 0.7rem; letter-spacing: 0.5px;">TIER 1 (GOLD)</div>
                <div class="orbitron h4 h-md-3 text-white mb-0 font-weight-bold">
                    <?= count(array_filter($kreators, function ($k) {
                        return $k['tier_label'] == 'Tier 1'; })) ?> 
                    <span class="small text-muted" style="font-size: 0.65rem;">KREATOR</span>
                </div>
            </div>
        </div>
        <div class="col-4 col-md-4 mb-3 mb-md-0 px-2 px-md-3">
            <div class="hud-card h-100 shadow-lg p-3 p-md-4" style="border-left: 4px solid #C0C0C0; background: rgba(15, 23, 42, 0.6);">
                <div class="small fw-bold mb-2 orbitron" style="color: #C0C0C0; font-size: 0.7rem; letter-spacing: 0.5px;">TIER 2 (SILVER)</div>
                <div class="orbitron h4 h-md-3 text-white mb-0 font-weight-bold">
                    <?= count(array_filter($kreators, function ($k) {
                        return $k['tier_label'] == 'Tier 2'; })) ?> 
                    <span class="small text-muted" style="font-size: 0.65rem;">KREATOR</span>
                </div>
            </div>
        </div>
        <div class="col-4 col-md-4 mb-3 mb-md-0 px-2 px-md-3">
            <div class="hud-card h-100 shadow-lg p-3 p-md-4" style="border-left: 4px solid #CD7F32; background: rgba(15, 23, 42, 0.6);">
                <div class="small fw-bold mb-2 orbitron" style="color: #CD7F32; font-size: 0.7rem; letter-spacing: 0.5px;">TIER 3 (BRONZE)</div>
                <div class="orbitron h4 h-md-3 text-white mb-0 font-weight-bold">
                    <?= count(array_filter($kreators, function ($k) {
                        return $k['tier_label'] == 'Tier 3'; })) ?> 
                    <span class="small text-muted" style="font-size: 0.65rem;">KREATOR</span>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL PENJENJANGAN GLOBAL -->
    <div class="hud-card border-0 shadow-lg">
        <div class="hud-header d-flex flex-wrap align-items-center justify-content-between bg-dark text-white border-bottom-0 p-3" style="gap: 10px;">
            <div class="d-flex align-items-center flex-wrap" style="gap: 12px;">
                <div class="orbitron font-weight-bold" style="font-size: 0.9rem; color: var(--bs-red); letter-spacing: 1px;">
                    <i class="fas fa-medal mr-2"></i> PERINGKAT KREATOR
                </div>

                <form action="<?= current_url() ?>" method="get" class="mb-0">
                    <div class="d-flex align-items-center px-3"
                        style="background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.15); height: 34px; border-radius: 4px;">
                        <i class="fas fa-filter text-secondary mr-2" style="font-size: 0.75rem;"></i>
                        <select name="tier" class="bg-transparent border-0 text-white orbitron p-0"
                            style="font-size: 0.7rem; width: 130px; outline: none; cursor: pointer;"
                            onchange="this.form.submit()">
                            <option value="" class="bg-dark">SEMUA TIER</option>
                            <option value="Tier 1" class="bg-dark" <?= ($tierFilter ?? '') == 'Tier 1' ? 'selected' : '' ?>>TIER 1 (GOLD)</option>
                            <option value="Tier 2" class="bg-dark" <?= ($tierFilter ?? '') == 'Tier 2' ? 'selected' : '' ?>>TIER 2 (SILVER)</option>
                            <option value="Tier 3" class="bg-dark" <?= ($tierFilter ?? '') == 'Tier 3' ? 'selected' : '' ?>>TIER 3 (BRONZE)</option>
                            <option value="Kreator Baru" class="bg-dark" <?= ($tierFilter ?? '') == 'Kreator Baru' ? 'selected' : '' ?>>KREATOR BARU</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="small orbitron text-secondary" style="font-size: 0.65rem;">
                Berdasarkan Laporan Valid
            </div>
        </div>
        <div class="hud-body p-0" style="background: rgba(15, 23, 42, 0.4);">
            <div class="table-responsive">
                <table class="table table-tactical table-hover mb-0" id="tieringTable" style="min-width: 650px;">
                    <thead style="background: rgba(234, 25, 23, 0.08);">
                        <tr>
                            <th class="py-3 px-4 text-center">PERINGKAT</th>
                            <th class="py-3 px-4">PROFIL KREATOR</th>
                            <th class="py-3 px-4 text-center">IDENTITAS GAME (UID)</th>
                            <th class="py-3 px-4">PANGKAT (TIER)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kreators)): ?>
                            <?php $no = 1;
                            foreach ($kreators as $k): ?>
                                <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.03);">
                                    <td class="align-middle px-4 text-center">
                                        <?php if ($no <= 3): ?>
                                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center orbitron mx-auto"
                                                style="width: 30px; height: 30px; font-size: 0.8rem;"><?= $no++ ?></div>
                                        <?php else: ?>
                                            <span class="text-muted orbitron"><?= $no++ ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle px-4 py-3">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="flex-shrink: 0;">
                                                <img src="<?= base_url('assets/img/profile/blood-strike.jpg') ?>"
                                                    class="rounded-circle border border-secondary shadow-sm"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                            </div>
                                            <div style="min-width: 0;">
                                                <div class="fw-bold text-white mb-1"
                                                    style="font-size: 0.9rem; line-height: 1.2; word-break: break-word;">
                                                    <?= esc($k['nama']) ?></div>
                                                <div class="text-secondary small" style="font-size: 0.7rem;">Terdaftar:
                                                    <?= date('d M Y', strtotime($k['created_at'] ?? 'now')) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle px-4 text-center">
                                        <span class="badge bg-dark border border-secondary text-secondary p-2 orbitron"
                                            style="font-size: 0.7rem; min-width: 90px; letter-spacing: 0.5px;"><?= esc($k['id_game']) ?></span>
                                    </td>
                                    <td class="align-middle px-4">
                                        <div class="d-flex align-items-center">
                                            <i class="<?= $k['tier_icon'] ?> me-2"
                                                style="color: <?= $k['tier_color'] ?>; text-shadow: <?= $k['tier_glow'] ?>; font-size: 1.1rem;"></i>
                                            <span class="fw-bold orbitron"
                                                style="color: <?= $k['tier_color'] ?>; text-shadow: <?= $k['tier_glow'] ?>; font-size: 0.85rem;"><?= esc($k['tier_label']) ?></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted small orbitron">Data peringkat belum
                                    tersedia.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DATA TABLES SETUP -->
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>

<script src="<?= base_url('assets/js/daftar_pangkat.js') ?>"></script>