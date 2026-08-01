<div class="container-fluid py-4">

    <!-- HEADER STATUS SISTEM -->
    <div class="d-flex align-items-center mb-4">
        <div class="text-white px-3 py-1 orbitron small shadow-sm"
            style="background: linear-gradient(90deg, #b45309, #f59e0b); clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
            PANEL SUPER ADMIN
        </div>
        <div class="ml-3 text-secondary small orbitron" style="opacity: 0.8; letter-spacing: 1px;">
            Panel Banding Kreator | Bloodstrike Creator Hub
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert border-0 mb-4 d-flex align-items-center"
            style="background: rgba(16,185,129,0.15); border-left: 4px solid #10b981 !important;">
            <i class="fas fa-check-circle mr-3" style="color: #10b981; font-size: 1.1rem;"></i>
            <span class="text-white small"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert border-0 mb-4 d-flex align-items-center"
            style="background: rgba(239,68,68,0.15); border-left: 4px solid #ef4444 !important;">
            <i class="fas fa-exclamation-circle mr-3" style="color: #ef4444; font-size: 1.1rem;"></i>
            <span class="text-white small"><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <!-- STATS CARD -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="hud-card p-3 d-flex align-items-center" style="border-left: 3px solid #f59e0b; background: rgba(245,158,11,0.08);">
                <div class="mr-3 text-center" style="width: 48px; height: 48px; background: rgba(245,158,11,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-balance-scale" style="color: #f59e0b; font-size: 1.2rem;"></i>
                </div>
                <div>
                    <div class="orbitron" style="color: #f59e0b; font-size: 1.6rem; font-weight: bold; line-height: 1;"><?= $jumlahMenunggu ?></div>
                    <div class="text-secondary small mt-1">Banding Menunggu Keputusan</div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="hud-card p-3" style="border-left: 3px solid #6366f1; background: rgba(99,102,241,0.05);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle mr-2" style="color: #6366f1;"></i>
                    <span class="text-secondary small">
                        Sebagai <strong class="text-white">Super Admin</strong>, Anda bertugas memutuskan banding kreator yang merasa
                        laporannya ditolak admin tanpa alasan yang jelas. Keputusan Anda bersifat <strong class="text-white">final dan tidak dapat diubah</strong>.
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER TAB -->
    <div class="hud-card mb-0" style="border-left: 3px solid #f59e0b;">
        <div class="hud-body p-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <i class="fas fa-filter mr-2" style="color: #f59e0b;"></i>
                    <span class="orbitron small fw-bold text-white">DAFTAR BANDING KREATOR</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('superadmin?filter=menunggu') ?>"
                        class="btn btn-sm orbitron px-3 <?= $filter === 'menunggu' ? '' : 'btn-outline-secondary' ?>"
                        style="<?= $filter === 'menunggu' ? 'background: #f59e0b; color: #000; border: none;' : '' ?> font-size: 0.65rem; border-radius: 4px;">
                        <i class="fas fa-clock mr-1"></i> MENUNGGU
                        <?php if ($jumlahMenunggu > 0): ?>
                            <span class="badge ml-1" style="background: <?= $filter === 'menunggu' ? '#7c3300' : '#f59e0b' ?>; color: <?= $filter === 'menunggu' ? '#fff' : '#000' ?>; border-radius: 8px; font-size: 0.55rem;"><?= $jumlahMenunggu ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?= base_url('superadmin?filter=selesai') ?>"
                        class="btn btn-sm orbitron px-3 <?= $filter === 'selesai' ? '' : 'btn-outline-secondary' ?>"
                        style="<?= $filter === 'selesai' ? 'background: #6366f1; color: #fff; border: none;' : '' ?> font-size: 0.65rem; border-radius: 4px;">
                        <i class="fas fa-history mr-1"></i> RIWAYAT
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL BANDING -->
    <div class="hud-card" style="border-left: 3px solid #f59e0b;">
        <div class="hud-body p-0">
            <div class="table-responsive">
                <table class="table table-tactical table-hover mb-0" style="min-width: 1100px;">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 40px;">NO</th>
                            <th>IDENTITAS KREATOR</th>
                            <th>LAPORAN</th>
                            <th>ALASAN PENOLAKAN ADMIN</th>
                            <th>ALASAN BANDING KREATOR</th>
                            <th>STATUS</th>
                            <?php if ($filter === 'menunggu'): ?>
                                <th class="text-center pe-4">AKSI</th>
                            <?php else: ?>
                                <th>CATATAN SUPER ADMIN</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($banding)): ?>
                            <?php $no = 1; foreach ($banding as $b): ?>
                                <tr>
                                    <!-- NO -->
                                    <td class="ps-4 align-middle">
                                        <span class="text-secondary orbitron" style="font-size: 0.75rem;">
                                            <?= str_pad($no++, 2, '0', STR_PAD_LEFT) ?>
                                        </span>
                                    </td>

                                    <!-- IDENTITAS KREATOR -->
                                    <td class="align-middle">
                                        <div class="fw-bold text-white small"><?= esc($b['kreator']['nama'] ?? '-') ?></div>
                                        <div class="text-secondary" style="font-size: 0.6rem;">UID: <?= esc($b['kreator']['id_game'] ?? '-') ?></div>
                                        <div class="mt-1 d-flex gap-1">
                                            <?php if (!empty($b['kreator']['tiktok_link'])): ?>
                                                <a href="<?= esc($b['kreator']['tiktok_link']) ?>" target="_blank"
                                                    class="badge bg-dark border border-secondary text-white" style="font-size: 0.5rem;">
                                                    <i class="fab fa-tiktok mr-1"></i>TikTok
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!empty($b['kreator']['youtube_link'])): ?>
                                                <a href="<?= esc($b['kreator']['youtube_link']) ?>" target="_blank"
                                                    class="badge bg-danger text-white" style="font-size: 0.5rem;">
                                                    <i class="fab fa-youtube mr-1"></i>YouTube
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- INFO LAPORAN -->
                                    <td class="align-middle">
                                        <div class="orbitron text-info" style="font-size: 0.65rem; font-weight: bold;">
                                            <?= esc($b['nama_lengkap']) ?>
                                        </div>
                                        <div class="mt-1">
                                            <?php if ($b['platform'] === 'youtube'): ?>
                                                <span class="badge bg-danger orbitron" style="font-size: 0.5rem;">YOUTUBE</span>
                                            <?php else: ?>
                                                <span class="badge bg-dark border border-secondary orbitron" style="font-size: 0.5rem;">TIKTOK</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-muted mt-1" style="font-size: 0.6rem;">
                                            Dikirim: <?= date('d M Y', strtotime($b['created_at'])) ?>
                                        </div>
                                    </td>

                                    <!-- ALASAN PENOLAKAN ADMIN -->
                                    <td class="align-middle" style="max-width: 200px;">
                                        <?php if (!empty($b['pesan_admin'])): ?>
                                            <div class="text-warning small" style="font-size: 0.7rem; line-height: 1.4; word-break: break-word;">
                                                <i class="fas fa-quote-left mr-1" style="font-size: 0.5rem; opacity: 0.6;"></i>
                                                <?= esc($b['pesan_admin']) ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-secondary" style="font-size: 0.65rem;"><i>Tidak ada pesan dari admin</i></span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- ALASAN BANDING KREATOR -->
                                    <td class="align-middle" style="max-width: 200px;">
                                        <div class="text-white small" style="font-size: 0.7rem; line-height: 1.4; word-break: break-word;">
                                            <i class="fas fa-quote-left mr-1" style="font-size: 0.5rem; opacity: 0.6; color: #f59e0b;"></i>
                                            <?= esc($b['alasan_banding']) ?>
                                        </div>
                                    </td>

                                    <!-- STATUS BANDING -->
                                    <td class="align-middle text-center">
                                        <?php if ($b['status_banding'] === 'menunggu'): ?>
                                            <span class="badge orbitron" style="background: rgba(245,158,11,0.2); color: #f59e0b; border: 1px solid #f59e0b; font-size: 0.5rem; padding: 4px 8px;">
                                                <i class="fas fa-clock mr-1"></i>MENUNGGU
                                            </span>
                                        <?php elseif ($b['status_banding'] === 'diterima'): ?>
                                            <span class="badge orbitron" style="background: rgba(16,185,129,0.2); color: #10b981; border: 1px solid #10b981; font-size: 0.5rem; padding: 4px 8px;">
                                                <i class="fas fa-check mr-1"></i>DITERIMA
                                            </span>
                                        <?php else: ?>
                                            <span class="badge orbitron" style="background: rgba(239,68,68,0.2); color: #ef4444; border: 1px solid #ef4444; font-size: 0.5rem; padding: 4px 8px;">
                                                <i class="fas fa-times mr-1"></i>DITOLAK FINAL
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- AKSI / CATATAN -->
                                    <?php if ($filter === 'menunggu'): ?>
                                        <td class="align-middle text-center pe-4">
                                            <button type="button"
                                                class="btn btn-sm orbitron px-3 mb-1"
                                                style="background: rgba(16,185,129,0.15); color: #10b981; border: 1px solid #10b981; font-size: 0.6rem; border-radius: 4px; width: 120px;"
                                                onclick="bukaModalKeputusan(<?= $b['laporan_id'] ?>, 'diterima', '<?= esc($b['kreator']['nama'] ?? '-') ?>')">
                                                <i class="fas fa-check mr-1"></i> TERIMA BANDING
                                            </button>
                                            <br>
                                            <button type="button"
                                                class="btn btn-sm orbitron px-3"
                                                style="background: rgba(239,68,68,0.15); color: #ef4444; border: 1px solid #ef4444; font-size: 0.6rem; border-radius: 4px; width: 120px;"
                                                onclick="bukaModalKeputusan(<?= $b['laporan_id'] ?>, 'ditolak_final', '<?= esc($b['kreator']['nama'] ?? '-') ?>')">
                                                <i class="fas fa-times mr-1"></i> TOLAK FINAL
                                            </button>
                                        </td>
                                    <?php else: ?>
                                        <td class="align-middle" style="max-width: 180px;">
                                            <?php if (!empty($b['catatan_superadmin'])): ?>
                                                <div class="small" style="font-size: 0.7rem; color: <?= $b['status_banding'] === 'diterima' ? '#10b981' : '#ef4444' ?>; line-height: 1.4; word-break: break-word;">
                                                    <i class="fas fa-shield-alt mr-1"></i>
                                                    <?= esc($b['catatan_superadmin']) ?>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-secondary" style="font-size: 0.65rem;">-</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div style="opacity: 0.5;">
                                        <i class="fas fa-balance-scale mb-3" style="font-size: 2.5rem; color: #f59e0b; display: block;"></i>
                                        <div class="text-secondary small orbitron">
                                            <?= $filter === 'menunggu' ? 'Tidak ada banding yang perlu ditinjau.' : 'Belum ada riwayat keputusan banding.' ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($pager): ?>
            <div class="hud-body px-4 py-3 border-top" style="border-color: rgba(245,158,11,0.2) !important;">
                <?= $pager->links('banding', 'default_full') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ========== MODAL KEPUTUSAN BANDING ========== -->
<div class="modal fade" id="modalKeputusan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #0f172a; border: 1px solid rgba(245,158,11,0.4); border-radius: 8px;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(245,158,11,0.2);">
                <h5 class="modal-title orbitron" id="modalKeputusanTitle" style="color: #f59e0b; font-size: 0.85rem;">
                    <i class="fas fa-balance-scale mr-2"></i>KEPUTUSAN BANDING
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formKeputusan" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="keputusan" id="inputKeputusan">
                <div class="modal-body">
                    <div class="mb-3">
                        <div id="badgeKeputusan" class="badge mb-3 px-3 py-2 orbitron" style="font-size: 0.7rem; border-radius: 4px;"></div>
                        <p class="text-white small mb-1">Kreator: <strong id="namaKreatorModal" class="text-warning"></strong></p>
                        <p class="text-secondary" style="font-size: 0.75rem;" id="deskripsiKeputusan"></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-white small fw-bold mb-1">
                            Catatan Keputusan <span class="text-danger">*</span>
                        </label>
                        <textarea name="catatan_superadmin" id="catatanSuperadmin" rows="4"
                            class="form-control bg-dark text-white border-secondary"
                            style="font-size: 0.8rem; border-radius: 4px; resize: none;"
                            placeholder="Tuliskan alasan atau catatan keputusan Anda secara jelas..."
                            required></textarea>
                        <div class="text-secondary mt-1" style="font-size: 0.65rem;">
                            <i class="fas fa-info-circle mr-1"></i>Catatan ini akan terlihat oleh kreator. Wajib diisi.
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid rgba(245,158,11,0.2);">
                    <button type="button" class="btn btn-sm btn-outline-secondary orbitron" data-dismiss="modal"
                        style="font-size: 0.65rem; border-radius: 4px;">BATAL</button>
                    <button type="submit" id="btnSubmitKeputusan" class="btn btn-sm orbitron px-4"
                        style="font-size: 0.65rem; border-radius: 4px; border: none;">
                        KONFIRMASI KEPUTUSAN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function bukaModalKeputusan(laporanId, keputusan, namaKreator) {
    const form = document.getElementById('formKeputusan');
    form.action = `<?= base_url('superadmin/banding/putuskan') ?>/` + laporanId;

    document.getElementById('inputKeputusan').value = keputusan;
    document.getElementById('namaKreatorModal').textContent = namaKreator;
    document.getElementById('catatanSuperadmin').value = '';

    const badge = document.getElementById('badgeKeputusan');
    const btnSubmit = document.getElementById('btnSubmitKeputusan');
    const deskripsi = document.getElementById('deskripsiKeputusan');

    if (keputusan === 'diterima') {
        badge.textContent = '✅ TERIMA BANDING';
        badge.style.cssText = 'background: rgba(16,185,129,0.2); color: #10b981; border: 1px solid #10b981; font-size: 0.7rem; border-radius: 4px; padding: 6px 12px; display: inline-block;';
        btnSubmit.style.cssText = 'background: #10b981; color: #fff; font-size: 0.65rem; border-radius: 4px;';
        deskripsi.textContent = 'Banding diterima = laporan kreator ini akan diubah menjadi VALID dan kreator mendapat notifikasi.';
    } else {
        badge.textContent = '❌ TOLAK BANDING (FINAL)';
        badge.style.cssText = 'background: rgba(239,68,68,0.2); color: #ef4444; border: 1px solid #ef4444; font-size: 0.7rem; border-radius: 4px; padding: 6px 12px; display: inline-block;';
        btnSubmit.style.cssText = 'background: #ef4444; color: #fff; font-size: 0.65rem; border-radius: 4px;';
        deskripsi.textContent = 'Banding ditolak final = laporan tetap tidak valid dan kreator tidak bisa mengajukan banding lagi untuk laporan ini.';
    }

    $('#modalKeputusan').modal('show');
}
</script>
