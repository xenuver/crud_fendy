<div class="container-fluid py-4">

    <!-- HEADER STATUS SISTEM -->
    <div class="d-flex align-items-center mb-4">
        <div class="text-white px-3 py-1 orbitron small shadow-sm"
            style="background: linear-gradient(90deg, #b45309, #f59e0b); clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
            PANEL SUPER ADMIN
        </div>
        <div class="ml-3 text-secondary small orbitron" style="opacity: 0.8; letter-spacing: 1px;">
            Pengaturan Akun & Keamanan | Bloodstrike Creator Hub
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

    <div class="row">
        <!-- CARD INFORMASI AKUN SUPER ADMIN -->
        <div class="col-lg-6 mb-4">
            <div class="hud-card" style="border-left: 3px solid #f59e0b; background: rgba(15,23,42,0.8);">
                <div class="hud-header d-flex align-items-center" style="background: rgba(245,158,11,0.1); border-bottom: 1px solid rgba(245,158,11,0.2);">
                    <i class="fas fa-crown mr-2" style="color: #f59e0b;"></i>
                    <span class="orbitron text-white small fw-bold">PROFIL SUPER ADMIN</span>
                </div>
                <div class="hud-body p-4">
                    <form action="<?= base_url('superadmin/profile/update') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="form-group mb-3">
                            <label class="text-white small fw-bold mb-1">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control bg-dark text-white border-secondary"
                                value="<?= esc($user['username'] ?? '') ?>" required style="font-size: 0.85rem; border-radius: 4px;">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-white small fw-bold mb-1">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="no_telp" class="form-control bg-dark text-white border-secondary"
                                value="<?= esc($user['no_telp'] ?? '') ?>" required style="font-size: 0.85rem; border-radius: 4px;">
                        </div>
                        <div class="form-group mb-4">
                            <label class="text-white small fw-bold mb-1">Level Akses (Role)</label>
                            <input type="text" class="form-control bg-dark text-warning border-warning"
                                value="Super Admin (Tingkat Tertinggi)" readonly style="font-size: 0.85rem; border-radius: 4px; font-weight: bold; background: rgba(245,158,11,0.1) !important;">
                        </div>
                        <button type="submit" class="btn btn-sm orbitron text-dark fw-bold px-4"
                            style="background: #f59e0b; border-radius: 4px; border: none; font-size: 0.7rem;">
                            <i class="fas fa-save mr-1"></i> SIMPAN PROFIL
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- CARD GANTI PASSWORD -->
        <div class="col-lg-6 mb-4">
            <div class="hud-card" style="border-left: 3px solid #6366f1; background: rgba(15,23,42,0.8);">
                <div class="hud-header d-flex align-items-center" style="background: rgba(99,102,241,0.1); border-bottom: 1px solid rgba(99,102,241,0.2);">
                    <i class="fas fa-key mr-2" style="color: #6366f1;"></i>
                    <span class="orbitron text-white small fw-bold">GANTI KATA SANDI</span>
                </div>
                <div class="hud-body p-4">
                    <form action="<?= base_url('superadmin/password/update') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="form-group mb-3">
                            <label class="text-white small fw-bold mb-1">Kata Sandi Saat Ini <span class="text-danger">*</span></label>
                            <input type="password" name="password_lama" class="form-control bg-dark text-white border-secondary"
                                placeholder="Masukkan kata sandi lama..." required style="font-size: 0.85rem; border-radius: 4px;">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-white small fw-bold mb-1">Kata Sandi Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password_baru" class="form-control bg-dark text-white border-secondary"
                                placeholder="Minimal 8 karakter..." minlength="8" required style="font-size: 0.85rem; border-radius: 4px;">
                        </div>
                        <div class="form-group mb-4">
                            <label class="text-white small fw-bold mb-1">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                            <input type="password" name="konfirmasi_password" class="form-control bg-dark text-white border-secondary"
                                placeholder="Ulangi kata sandi baru..." minlength="8" required style="font-size: 0.85rem; border-radius: 4px;">
                        </div>
                        <button type="submit" class="btn btn-sm orbitron text-white fw-bold px-4"
                            style="background: #6366f1; border-radius: 4px; border: none; font-size: 0.7rem;">
                            <i class="fas fa-lock mr-1"></i> UPDATE KATA SANDI
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
