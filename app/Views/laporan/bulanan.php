<div class="container-fluid py-4">

    <!-- HEADER STATUS SISTEM -->
    <div class="d-flex align-items-center mb-4">
        <div class="bg-danger text-white px-3 py-1 orbitron small shadow-sm"
            style="clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
            LAPORAN BULANAN
        </div>
        <div class="ms-3 text-secondary small orbitron" style="opacity: 0.8; letter-spacing: 1px;">
            <?= date('F', mktime(0, 0, 0, $bulan, 10)) ?> <?= $tahun ?>
        </div>
    </div>
    <style>
        /* Sticky Header */
        .table-responsive {
            max-height: 75vh;
            overflow-y: auto;
        }

        #bulananTable thead th {
            position: sticky;
            top: 0;
            z-index: 50;
            background: #1a1a1a !important;
            box-shadow: inset 0 -1px 0 rgba(234, 25, 23, 0.3);
        }

        .table-tactical td {
            padding-top: 0.6rem !important;
            padding-bottom: 0.6rem !important;
        }
    </style>

    <!-- FILTER BAR TERUNIFIKASI -->
    <div class="hud-card mb-4" style="border-left: 3px solid var(--bs-red);">
        <div class="hud-body p-3">
            <form action="<?= base_url('admin/laporan/bulanan') ?>" method="get"
                class="d-flex flex-wrap align-items-center gap-3">

                <!-- BULAN -->
                <div class="d-flex align-items-center bg-dark px-3 border border-secondary"
                    style="height: 40px; border-radius: 4px;">
                    <i class="fas fa-calendar-alt text-secondary me-2"></i>
                    <select name="bulan" class="bg-transparent border-0 text-white orbitron small"
                        style="outline: none; font-size: 0.75rem;" onchange="this.form.submit()">
                        <?php foreach ($months as $m => $name): ?>
                            <option value="<?= $m ?>" class="bg-dark" <?= $bulan == $m ? 'selected' : '' ?>><?= $name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TAHUN -->
                <div class="d-flex align-items-center bg-dark px-3 border border-secondary"
                    style="height: 40px; border-radius: 4px;">
                    <i class="fas fa-clock text-secondary me-2"></i>
                    <select name="tahun" class="bg-transparent border-0 text-white orbitron small"
                        style="outline: none; font-size: 0.75rem;" onchange="this.form.submit()">
                        <?php for ($i = date('Y'); $i >= 2024; $i--): ?>
                            <option value="<?= $i ?>" class="bg-dark" <?= $tahun == $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="ms-auto d-flex gap-2">
                    <a href="<?= base_url('admin/laporan/export?bulan=' . $bulan . '&tahun=' . $tahun) ?>"
                        class="btn btn-danger btn-sm orbitron px-4 d-flex align-items-center"
                        style="height: 40px; font-size: 0.7rem;">
                        <i class="fas fa-file-excel me-2"></i> EKSPOR EXCEL (.XLSX)
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL UTAMA -->
    <div class="hud-card border-0">
        <div class="hud-header d-flex justify-content-between align-items-center"
            style="background: linear-gradient(90deg, #1a1a1a 0%, #2d1212 100%); border-bottom: 1px solid rgba(234, 25, 23, 0.3);">
            <div class="orbitron text-white small fw-bold">
                <i class="fas fa-database me-2 text-danger"></i> DETIL PERFORMA BULANAN
            </div>
        </div>
        <div class="hud-body p-0">
            <div class="table-responsive">
                <table class="table table-tactical table-hover mb-0" id="bulananTable" style="min-width: 1200px;">
                    <thead>
                        <tr>
                            <th class="ps-4">POS</th>
                            <th>KREATOR</th>
                            <th>YT VIDEO</th>
                            <th>YT SHORTS</th>
                            <th>YT LIVE</th>
                            <th>TT KONTEN</th>
                            <th>TT LIVE</th>
                            <th>PEAK CCV</th>
                            <th>TIER</th>
                            <th class="pe-4 text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($results)): ?>
                            <?php foreach ($results as $index => $r): ?>
                                <tr>
                                    <td class="ps-4 align-middle">
                                        <span class="text-secondary orbitron"
                                            style="font-size: 0.75rem;"><?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?></span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="fw-bold text-white small"><?= esc($r['nama']) ?></div>
                                        <div class="text-secondary" style="font-size: 0.6rem;">UID: <?= esc($r['id_game']) ?>
                                        </div>
                                    </td>
                                    <!-- YOUTUBE DETIL -->
                                    <td class="align-middle border-start border-dark"
                                        style="background: rgba(255, 255, 255, 0.01);">
                                        <div class="text-white fw-bold small"><?= number_format($r['yt_views']) ?></div>
                                        <div class="text-muted small" style="font-size: 0.55rem;"><?= $r['yt_vids'] ?> Vids
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="text-danger fw-bold small"><?= number_format($r['yt_shorts_views']) ?></div>
                                        <div class="text-muted small" style="font-size: 0.55rem;"><?= $r['yt_shorts_count'] ?>
                                            Shorts</div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="text-warning fw-bold small"><?= number_format($r['yt_live_views']) ?></div>
                                        <div class="text-muted small" style="font-size: 0.55rem;">Live Views</div>
                                    </td>
                                    <!-- TIKTOK DETIL -->
                                    <td class="align-middle border-start border-dark" style="background: rgba(0, 0, 0, 0.2);">
                                        <div class="text-white fw-bold small"><?= number_format($r['tt_views']) ?></div>
                                        <div class="text-muted small" style="font-size: 0.55rem;"><?= $r['tt_vids'] ?> Posts
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="text-info fw-bold small"><?= number_format($r['tt_live_views']) ?></div>
                                        <div class="text-muted small" style="font-size: 0.55rem;">Live Views</div>
                                    </td>
                                    <!-- CCV & TIER -->
                                    <td class="align-middle border-start border-dark text-center">
                                        <div class="orbitron fw-bold text-white" style="font-size: 0.85rem;">
                                            <?= number_format($r['max_ccv'] ?: 0) ?>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <i class="<?= $r['tier_icon'] ?> me-2"
                                                style="font-size: 0.8rem; color: var(--bs-red);"></i>
                                            <span class="orbitron text-white"
                                                style="font-size: 0.65rem; white-space: nowrap;"><?= esc($r['tier_label']) ?></span>
                                        </div>
                                    </td>
                                    <td class="pe-4 align-middle text-center">
                                        <span class="badge bg-dark border border-success text-success orbitron p-1 px-2"
                                            style="font-size: 0.5rem;">
                                            <i class="fas fa-check-double"></i>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted small orbitron">Belum ada data laporan
                                    valid pada periode ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#bulananTable').DataTable({
            "pageLength": 25,
            "ordering": false,
            "language": {
                "search": "FILTER KREATOR:",
                "zeroRecords": "DATA TIDAK DITEMUKAN",
                "info": "MENAMPILKAN _PAGE_ DARI _PAGES_ OPERASI",
                "infoEmpty": "ARSIP KOSONG"
            }
        });
    });
</script>