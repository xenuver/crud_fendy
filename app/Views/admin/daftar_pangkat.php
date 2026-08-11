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
            <div class="hud-card h-100 shadow-lg p-3 p-md-4" style="border-left: 4px solid #FFD700; background: linear-gradient(135deg, rgba(45,36,0,0.5) 0%, rgba(15,23,42,0.8) 100%);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold orbitron" style="color: #FFD700; font-size: 0.7rem; letter-spacing: 0.5px;"><i class="fas fa-crown mr-1"></i> TIER 1 (GOLD)</span>
                    <i class="fas fa-medal text-warning d-none d-sm-inline" style="opacity: 0.6;"></i>
                </div>
                <div class="orbitron h4 h-md-3 text-white mb-0 font-weight-bold">
                    <?= count(array_filter($kreators, function ($k) {
                        return $k['tier_label'] == 'Tier 1'; })) ?> 
                    <span class="small text-muted" style="font-size: 0.65rem;">KREATOR</span>
                </div>
            </div>
        </div>
        <div class="col-4 col-md-4 mb-3 mb-md-0 px-2 px-md-3">
            <div class="hud-card h-100 shadow-lg p-3 p-md-4" style="border-left: 4px solid #C0C0C0; background: linear-gradient(135deg, rgba(30,30,30,0.5) 0%, rgba(15,23,42,0.8) 100%);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold orbitron" style="color: #C0C0C0; font-size: 0.7rem; letter-spacing: 0.5px;"><i class="fas fa-medal mr-1"></i> TIER 2 (SILVER)</span>
                    <i class="fas fa-medal text-secondary d-none d-sm-inline" style="opacity: 0.6;"></i>
                </div>
                <div class="orbitron h4 h-md-3 text-white mb-0 font-weight-bold">
                    <?= count(array_filter($kreators, function ($k) {
                        return $k['tier_label'] == 'Tier 2'; })) ?> 
                    <span class="small text-muted" style="font-size: 0.65rem;">KREATOR</span>
                </div>
            </div>
        </div>
        <div class="col-4 col-md-4 mb-3 mb-md-0 px-2 px-md-3">
            <div class="hud-card h-100 shadow-lg p-3 p-md-4" style="border-left: 4px solid #CD7F32; background: linear-gradient(135deg, rgba(40,20,10,0.5) 0%, rgba(15,23,42,0.8) 100%);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold orbitron" style="color: #CD7F32; font-size: 0.7rem; letter-spacing: 0.5px;"><i class="fas fa-award mr-1"></i> TIER 3 (BRONZE)</span>
                    <i class="fas fa-award d-none d-sm-inline" style="color: #CD7F32; opacity: 0.6;"></i>
                </div>
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
                    <i class="fas fa-trophy mr-2"></i> PERINGKAT KREATOR
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
                <table class="table table-tactical table-hover mb-0" id="tieringTable" style="min-width: 680px;">
                    <thead style="background: rgba(234, 25, 23, 0.08);">
                        <tr>
                            <th class="py-3 px-3 text-center" style="width: 100px;">PERINGKAT</th>
                            <th class="py-3 px-3">PROFIL KREATOR</th>
                            <th class="py-3 px-3 text-center" style="width: 180px;">IDENTITAS GAME (UID)</th>
                            <th class="py-3 px-3" style="width: 180px;">PANGKAT (TIER)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kreators)): ?>
                            <?php $no = 1;
                            foreach ($kreators as $k): ?>
                                <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.03);">
                                    <td class="align-middle px-3 text-center">
                                        <?php if ($no == 1): ?>
                                            <span class="badge bg-warning text-dark orbitron px-2 py-1 font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                                <i class="fas fa-crown mr-1"></i> #1
                                            </span>
                                        <?php elseif ($no == 2): ?>
                                            <span class="badge bg-secondary text-white orbitron px-2 py-1 font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                                <i class="fas fa-medal mr-1"></i> #2
                                            </span>
                                        <?php elseif ($no == 3): ?>
                                            <span class="badge border border-warning text-warning orbitron px-2 py-1 font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px; background: rgba(205, 127, 50, 0.15);">
                                                <i class="fas fa-award mr-1"></i> #3
                                            </span>
                                        <?php else: ?>
                                            <span class="text-secondary orbitron small font-weight-bold">#<?= $no ?></span>
                                        <?php endif; $no++; ?>
                                    </td>
                                    <td class="align-middle px-3 py-3">
                                        <div class="d-flex align-items-center" style="gap: 12px;">
                                            <div style="flex-shrink: 0;">
                                                <img src="<?= base_url('assets/img/profile/blood-strike.jpg') ?>"
                                                    class="rounded-circle border border-secondary shadow-sm"
                                                    style="width: 38px; height: 38px; object-fit: cover;">
                                            </div>
                                            <div style="min-width: 0;">
                                                <div class="fw-bold text-white mb-1"
                                                    style="font-size: 0.88rem; line-height: 1.2; word-break: break-word;">
                                                    <?= esc($k['nama']) ?></div>
                                                <div class="text-secondary small" style="font-size: 0.68rem;">Terdaftar:
                                                    <?= date('d M Y', strtotime($k['created_at'] ?? 'now')) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle px-3 text-center">
                                        <span class="badge bg-dark border border-secondary text-white px-3 py-2 orbitron"
                                            style="font-size: 0.72rem; letter-spacing: 1px; border-color: rgba(255,255,255,0.15) !important;">
                                            UID: <?= esc($k['id_game']) ?>
                                        </span>
                                    </td>
                                    <td class="align-middle px-3">
                                        <div class="d-flex align-items-center">
                                            <i class="<?= $k['tier_icon'] ?> mr-2"
                                                style="color: <?= $k['tier_color'] ?>; text-shadow: <?= $k['tier_glow'] ?>; font-size: 1.15rem;"></i>
                                            <span class="badge orbitron font-weight-bold px-2 py-1"
                                                style="background: rgba(15,23,42,0.8); border: 1px solid <?= $k['tier_color'] ?>; color: <?= $k['tier_color'] ?>; font-size: 0.72rem; letter-spacing: 0.5px;">
                                                <?= esc($k['tier_label']) ?>
                                            </span>
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