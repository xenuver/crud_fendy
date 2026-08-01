<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <div class="bg-danger text-white px-3 py-1 orbitron small shadow-sm"
            style="clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
            PENGATURAN PROFIL
        </div>
        <div class="ml-3 text-secondary small orbitron" style="opacity: 0.8; letter-spacing: 1px;">
            Kelola Identitas dan Tautan Media Sosial Anda
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="hud-card border-0 shadow-lg">
                <div class="hud-header bg-dark text-white p-3">
                    <div class="orbitron small" style="color: var(--bs-red); letter-spacing: 1px;">
                        <i class="fas fa-user-edit mr-2"></i> PERBARUI INFORMASI PROFIL
                    </div>
                </div>
                <div class="hud-body p-4" style="background: rgba(15, 23, 42, 0.4);">

                    <?php if (!$kreator): ?>
                        <div class="alert alert-warning orbitron mb-4"
                            style="background: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid #ffc107; border-radius: 0;">
                            <i class="fas fa-info-circle mr-2"></i> Profil Anda belum terhubung dengan data Kreator. Silakan
                            hubungi admin.
                        </div>
                    <?php else: ?>
                        <form action="<?= base_url(session()->get('role') . '/profile/update') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="text-white-50 small fw-bold mb-2">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama"
                                            value="<?= esc($kreator['nama']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-white-50 small fw-bold mb-2">ID Game (UID)
                                            <?php if (isset($canUpdateUid) && $canUpdateUid): ?>
                                                <span class="badge ms-2"
                                                    style="background: rgba(40, 167, 69, 0.2); color: #28a745; border: 1px solid #28a745; font-size: 0.55rem; padding: 3px 8px;">
                                                    <i class="fas fa-check-circle mr-1"></i> Siap Diperbarui
                                                </span>
                                            <?php elseif (isset($daysRemaining) && $daysRemaining > 0): ?>
                                                <span class="badge ms-2"
                                                    style="background: rgba(220, 53, 69, 0.2); color: #dc3545; border: 1px solid #dc3545; font-size: 0.55rem; padding: 3px 8px;">
                                                    <i class="fas fa-clock mr-1"></i> Bisa diubah dalam <?= $daysRemaining ?>
                                                    hari
                                                </span>
                                            <?php endif; ?>
                                        </label>
                                        <?php if (isset($canUpdateUid) && $canUpdateUid): ?>
                                            <input type="text" class="form-control form-control-tactical" name="id_game"
                                                value="<?= esc($kreator['id_game']) ?>" required minlength="5">
                                            <div class="small mt-1" style="color: #64748b; font-size: 0.65rem;">
                                                <i class="fas fa-info-circle mr-1"></i> UID bisa diubah 1x setiap 30 hari.
                                                Pastikan UID yang dimasukkan benar.
                                            </div>
                                        <?php else: ?>
                                            <input type="text" class="form-control form-control-tactical opacity-50"
                                                value="<?= esc($kreator['id_game']) ?>" readonly>
                                            <div class="small mt-1" style="color: #f59e0b; font-size: 0.65rem;">
                                                <i class="fas fa-lock mr-1"></i> UID terakhir diubah pada
                                                <?= isset($kreator['last_uid_update']) ? date('d M Y', strtotime($kreator['last_uid_update'])) : '-' ?>.
                                                Bisa diubah lagi dalam <?= $daysRemaining ?? 0 ?> hari.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-0">
                                        <label class="text-white-50 small fw-bold mb-2">ALAMAT / DOMISILI</label>
                                        <textarea class="form-control form-control-tactical" name="alamat" rows="2"
                                            required><?= esc($kreator['alamat']) ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-top: 1px dashed rgba(255,255,255,0.1);" class="my-4">

                            <!-- Email Notifikasi -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="label-taktis mb-2"><i class="fas fa-envelope mr-2 text-warning"></i> EMAIL NOTIFIKASI</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-secondary text-warning"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control form-control-tactical" name="email"
                                            value="<?= esc($kreator['email'] ?? '') ?>"
                                            placeholder="emailkamu@gmail.com">
                                    </div>
                                    <div class="small text-muted mt-1">📧 Email ini dipakai untuk notifikasi otomatis status laporan mingguanmu.</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="label-taktis mb-2"><i class="fab fa-tiktok mr-2"></i> LINK CHANNEL
                                        TIKTOK</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-secondary text-white"><i
                                                class="fab fa-tiktok"></i></span>
                                        <input type="url" class="form-control form-control-tactical" name="tiktok_link"
                                            value="<?= esc($kreator['tiktok_link']) ?>"
                                            placeholder="https://www.tiktok.com/@username">
                                    </div>
                                    <div class="small text-muted mt-1">Contoh: https://www.tiktok.com/@nama_anda</div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="label-taktis mb-2"><i class="fab fa-youtube mr-2"></i> LINK CHANNEL
                                        YOUTUBE</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-secondary text-white"><i
                                                class="fab fa-youtube text-danger"></i></span>
                                        <input type="url" class="form-control form-control-tactical" name="youtube_link"
                                            value="<?= esc($kreator['youtube_link']) ?>"
                                            placeholder="https://www.youtube.com/@channel">
                                    </div>
                                    <div class="small text-muted mt-1">Contoh: https://www.youtube.com/@channel_anda</div>
                                </div>
                            </div>

                            <div class="text-end pt-3">
                                <button type="submit" class="btn-strike-sm px-5 py-2">
                                    <i class="fas fa-save mr-2"></i> SIMPAN PERUBAHAN PROFIL
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- GANTI KATA SANDI -->
            <div class="hud-card border-0 shadow-lg mt-4">
                <div class="hud-header bg-dark text-white p-3">
                    <div class="orbitron small" style="color: var(--bs-red); letter-spacing: 1px;">
                        <i class="fas fa-lock mr-2"></i> PENGATURAN KEAMANAN AKUN
                    </div>
                </div>
                <div class="hud-body p-4" style="background: rgba(15, 23, 42, 0.4);">
                    <form action="<?= base_url(session()->get('role') . '/password/update') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="label-taktis mb-2">KATA SANDI SAAT INI</label>
                                <input type="password" class="form-control form-control-tactical" name="password_lama"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="label-taktis mb-2">KATA SANDI BARU</label>
                                <input type="password" class="form-control form-control-tactical" name="password_baru"
                                    required minlength="8">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="label-taktis mb-2">KONFIRMASI KATA SANDI BARU</label>
                                <input type="password" class="form-control form-control-tactical"
                                    name="konfirmasi_password" required minlength="8">
                            </div>
                        </div>
                        <div class="text-end pt-3">
                            <button type="submit" class="btn-strike-sm px-5 py-2"
                                style="background: #eab308; color: #0f172a; border: none; font-weight: bold;">
                                <i class="fas fa-key mr-2"></i> GANTI KATA SANDI
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="hud-card border-0 shadow-lg mb-4">
                <div class="hud-header bg-dark text-white p-3">
                    <div class="orbitron small" style="color: var(--bs-red); letter-spacing: 1px;">
                        <i class="fas fa-info-circle mr-2"></i> INSTRUKSI PROFIL
                    </div>
                </div>
                <div class="hud-body p-4 text-muted small" style="background: rgba(15, 23, 42, 0.4); line-height: 1.8;">
                    <p class="mb-3"><span class="text-white fw-bold">Tautan Media Sosial:</span> Pastikan tautan yang
                        Anda masukkan valid dan mengarah langsung ke profil utama Anda. Data ini digunakan untuk
                        memvalidasi performa konten Anda secara eksternal.</p>
                    <p class="mb-0"><span class="text-white fw-bold">Sinkronisasi:</span> Setiap perubahan yang Anda
                        simpan di sini akan langsung diperbarui di dashboard secara real-time.</p>
                </div>
            </div>
        </div>
    </div>
</div>