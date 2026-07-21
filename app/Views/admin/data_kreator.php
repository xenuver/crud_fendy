<div class="container-fluid py-4">

    <!-- HEADER STATUS ADMIN -->
    <div class="d-flex align-items-center mb-4">
        <div class="bg-danger text-white px-3 py-1 orbitron small shadow-sm" style="clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
            MANAJEMEN KREATOR
        </div>
        <div class="ms-3 text-secondary small orbitron" style="opacity: 0.8; letter-spacing: 1px;">
            Daftar Lengkap dan Pengelolaan Data Kreator
        </div>
    </div>

    <!-- KARTU UTAMA DATA KREATOR -->
    <div class="hud-card border-0 shadow-lg">
        <div class="hud-header d-flex justify-content-between align-items-center bg-dark text-white border-bottom-0 py-3">
            <div class="orbitron" style="font-size: 0.9rem; color: var(--bs-red); letter-spacing: 1px;"><i class="fas fa-database me-2"></i> DATA KREATOR</div>
        </div>
        <div class="hud-body p-0" style="background: rgba(15, 23, 42, 0.4);">
            <div class="table-responsive">
                <table id="kreatorTable" class="table table-tactical table-hover mb-0">
                    <thead style="background: rgba(234, 25, 23, 0.08);">
                        <tr>
                            <th class="py-3 px-4">NO</th>
                            <th class="py-3 px-4">PROFIL</th>
                            <th class="py-3 px-4">NAMA KREATOR</th>
                            <th class="py-3 px-4">ALAMAT / DOMISILI</th>
                            <th class="py-3 px-4">MEDIA SOSIAL</th>
                            <th class="py-3 px-4">IDENTITAS GAME (UID)</th>
                            <th class="py-3 px-4 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($kreators)) : ?>
                            <?php $no = 1; foreach ($kreators as $k) : ?>
                                <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.03); <?= $k['status'] == 'suspended' ? 'opacity: 0.5; background: rgba(0,0,0,0.2);' : '' ?>">
                                    <td class="align-middle px-4 text-muted"><?= $no++ ?></td>
                                    <td class="align-middle px-4">
                                        <div class="position-relative d-inline-block" style="width: 45px; height: 45px;">
                                        <img src="<?= base_url('assets/img/profile/blood-strike.jpg') ?>" alt="Avatar" width="45" height="45" class="rounded-circle border border-secondary shadow-sm" style="object-fit: cover;">
                                        
                                        <?php if($k['status'] == 'suspended'): ?>
                                                <div class="position-absolute bg-danger rounded-circle border border-dark d-flex align-items-center justify-content-center" style="width: 16px; height: 16px; bottom: 0; right: 0; z-index: 10;">
                                                    <i class="fas fa-ban text-white" style="font-size: 0.5rem;"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="align-middle px-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="fw-bold text-white mb-0 d-flex align-items-center" style="font-size: 0.95rem;">
                                                <i class="<?= $k['tier_icon'] ?>" style="color: <?= $k['tier_color'] ?>; font-size: 0.8rem; margin-right: 12px;" title="<?= $k['tier_label'] ?>"></i>
                                                <span><?= esc($k['nama']) ?></span>
                                            </div>
                                            <?php if($k['status'] == 'suspended'): ?>
                                                <span class="badge bg-danger orbitron" style="font-size: 0.45rem; letter-spacing: 1px; padding: 3px 7px; margin-left: 10px;">SUSPENDED</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="align-middle px-4">
                                        <div class="text-secondary small d-flex align-items-center">
                                            <i class="fas fa-map-marker-alt me-2 text-danger opacity-50"></i>
                                            <?= esc($k['alamat']) ?>
                                        </div>
                                    </td>
                                    <td class="align-middle px-4">
                                        <div class="d-flex flex-column gap-1">
                                            <?php if(!empty($k['tiktok_link'])) : ?>
                                                <?php 
                                                    $tiktok_user = explode('@', $k['tiktok_link']);
                                                    $tiktok_user = isset($tiktok_user[1]) ? '@' . explode('?', $tiktok_user[1])[0] : 'TikTok';
                                                ?>
                                                <a href="<?= esc($k['tiktok_link']) ?>" target="_blank" class="text-white opacity-75 hover-red text-decoration-none" style="font-size: 0.75rem;">
                                                    <i class="fab fa-tiktok me-1"></i> <span class="small"><?= esc($tiktok_user) ?></span>
                                                </a>
                                            <?php endif; ?>
                                            <?php if(!empty($k['youtube_link'])) : ?>
                                                <?php 
                                                    $yt_user = explode('@', $k['youtube_link']);
                                                    $yt_user = isset($yt_user[1]) ? '@' . explode('?', $yt_user[1])[0] : 'YouTube';
                                                ?>
                                                <a href="<?= esc($k['youtube_link']) ?>" target="_blank" class="text-danger opacity-75 hover-white text-decoration-none" style="font-size: 0.75rem;">
                                                    <i class="fab fa-youtube me-1"></i> <span class="small"><?= esc($yt_user) ?></span>
                                                </a>
                                            <?php endif; ?>
                                            <?php if(empty($k['tiktok_link']) && empty($k['youtube_link'])): ?>
                                                <span class="text-muted small italic" style="font-size: 0.65rem;">Belum ditautkan</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="align-middle px-4">
                                        <div class="fw-bold orbitron text-white mb-0" style="font-size: 0.85rem;"><?= esc($k['id_game']) ?></div>
                                        <div class="text-muted" style="font-size: 0.6rem;">UID GAME</div>
                                    </td>
                                    <td class="align-middle px-4 text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <form method="POST" action="<?= base_url('admin/kreator/toggle_status/' . $k['kreator_id']) ?>" style="display:inline-block; margin:0;">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btn btn-outline-<?= $k['status'] == 'active' ? 'secondary' : 'success' ?> btn-sm p-1 border-0 btn-toggle-status-kreator" title="<?= $k['status'] == 'active' ? 'Suspend Kreator' : 'Aktifkan Kreator' ?>" data-status="<?= $k['status'] ?>" data-nama="<?= esc($k['nama']) ?>">
                                                    <i class="fas fa-<?= $k['status'] == 'active' ? 'user-slash' : 'user-check' ?>"></i>
                                                </button>
                                            </form>
                                            <button class="btn btn-outline-warning btn-sm p-1 border-0" data-toggle="modal" data-target="#editKreatorModal<?= $k['kreator_id'] ?>" title="Ubah Data">
                                                <i class="fas fa-pen-nib"></i>
                                            </button>
                                            <form method="POST" action="<?= base_url('admin/kreator/delete/' . $k['kreator_id']) ?>" style="display:inline-block; margin:0;">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btn btn-outline-danger btn-sm p-1 border-0 btn-delete-kreator" title="Hapus Data">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted small orbitron">Belum ada data kreator yang terdaftar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT KREATOR (SEPARATED FROM TABLE FOR STABILITY) -->
<?php if(!empty($kreators)) : ?>
    <?php foreach ($kreators as $k) : ?>
        <div class="modal fade" id="editKreatorModal<?= $k['kreator_id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: #1e293b; color: #fff; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0; box-shadow: 0 0 40px rgba(0,0,0,0.5);">
                    <div class="modal-header border-bottom-0 pt-4 px-4">
                        <h5 class="modal-title orbitron small" style="color: var(--bs-red); letter-spacing: 1px;"><i class="fas fa-pen-square me-2"></i> PERBARUI DATA KREATOR</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="<?= base_url('admin/kreator/update') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $k['kreator_id'] ?>">
                            
                            <!-- Fields Wrapper -->
                            <div class="form-fields-wrapper">
                                <div class="mb-4">
                                    <label class="label-taktis mb-2">Lokasi Domisili Operasi</label>
                                    <textarea class="form-control form-control-tactical" name="alamat" rows="2" placeholder="Sebutkan lokasi domisili" required><?= esc($k['alamat']) ?></textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="label-taktis mb-2">ID Game Bloodstrike (UID)</label>
                                    <input type="text" class="form-control form-control-tactical" name="id_game" value="<?= esc($k['id_game']) ?>" placeholder="Masukkan ID numerik atau unik" required>
                                </div>
                                <div class="mb-4">
                                    <label class="label-taktis mb-2"><i class="fab fa-tiktok me-1"></i> Link TikTok</label>
                                    <input type="url" class="form-control form-control-tactical" name="tiktok_link" value="<?= esc($k['tiktok_link']) ?>" placeholder="https://tiktok.com/@...">
                                </div>
                                <div class="mb-4">
                                    <label class="label-taktis mb-2"><i class="fab fa-youtube me-1"></i> Link YouTube</label>
                                    <input type="url" class="form-control form-control-tactical" name="youtube_link" value="<?= esc($k['youtube_link']) ?>" placeholder="https://youtube.com/@...">
                                </div>
                            </div>
                            
                            <div class="text-end pt-2">
                                <button type="submit" class="btn-strike-sm w-100 py-2">KONFIRMASI PERUBAHAN DATA</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>



<!-- SweetAlert2 Delete Confirmation for Creator (Admin) - Vanilla JS -->
<script src="<?= base_url('assets/js/data_kreator.js?v=' . time()) ?>"></script>