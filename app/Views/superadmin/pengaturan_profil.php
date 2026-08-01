<div class="container-fluid py-4" style="font-family: 'Inter', system-ui, -apple-system, sans-serif;">

    <!-- HEADER STATUS SISTEM -->
    <div class="d-flex align-items-center mb-4">
        <div class="text-white px-3 py-1 orbitron small shadow-sm"
            style="background: linear-gradient(90deg, #b45309, #f59e0b); clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
            PANEL SUPER ADMIN
        </div>
        <div class="ml-3 text-secondary small font-sans" style="opacity: 0.8; letter-spacing: 0.5px;">
            Pengaturan Akun, Keamanan & Email Notification | Bloodstrike Creator Hub
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert border-0 mb-4 d-flex align-items-center"
            style="background: rgba(16,185,129,0.15); border-left: 4px solid #10b981 !important;">
            <i class="fas fa-check-circle mr-3" style="color: #10b981; font-size: 1.1rem;"></i>
            <span class="text-white small font-sans"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert border-0 mb-4 d-flex align-items-center"
            style="background: rgba(239,68,68,0.15); border-left: 4px solid #ef4444 !important;">
            <i class="fas fa-exclamation-circle mr-3" style="color: #ef4444; font-size: 1.1rem;"></i>
            <span class="text-white small font-sans"><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- CARD INFORMASI AKUN SUPER ADMIN -->
        <div class="col-lg-6 mb-4">
            <div class="hud-card" style="border-left: 3px solid #f59e0b; background: rgba(15,23,42,0.8);">
                <div class="hud-header d-flex align-items-center" style="background: rgba(245,158,11,0.1); border-bottom: 1px solid rgba(245,158,11,0.2); padding: 12px 16px;">
                    <i class="fas fa-crown mr-2" style="color: #f59e0b;"></i>
                    <span class="font-sans text-white small fw-bold">PROFIL SUPER ADMIN</span>
                </div>
                <div class="hud-body p-4">
                    <form action="<?= base_url('superadmin/profile/update') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="form-group mb-3">
                            <label class="text-white small fw-bold mb-1 font-sans">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control bg-dark text-white border-secondary font-sans"
                                value="<?= esc($user['username'] ?? '') ?>" required style="font-size: 0.85rem; border-radius: 4px;">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-white small fw-bold mb-1 font-sans">Alamat Email Notifikasi <span class="text-warning">(Penerima Email)</span></label>
                            <input type="email" name="email" class="form-control bg-dark text-white border-secondary font-sans"
                                value="<?= esc($user['email'] ?? '') ?>" placeholder="Contoh: fendy@gmail.com" style="font-size: 0.85rem; border-radius: 4px;">
                            <div class="text-secondary mt-1 font-sans" style="font-size: 0.7rem;">
                                <i class="fas fa-info-circle mr-1"></i>Email pengingat laporan pending akan dikirimkan ke alamat email ini.
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-white small fw-bold mb-1 font-sans">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="no_telp" class="form-control bg-dark text-white border-secondary font-sans"
                                value="<?= esc($user['no_telp'] ?? '') ?>" required style="font-size: 0.85rem; border-radius: 4px;">
                        </div>
                        <div class="form-group mb-4">
                            <label class="text-white small fw-bold mb-1 font-sans">Level Akses (Role)</label>
                            <input type="text" class="form-control bg-dark text-warning border-warning font-sans"
                                value="Super Admin (Tingkat Tertinggi)" readonly style="font-size: 0.85rem; border-radius: 4px; font-weight: bold; background: rgba(245,158,11,0.1) !important;">
                        </div>
                        <button type="submit" class="btn btn-sm font-sans text-dark fw-bold px-4"
                            style="background: #f59e0b; border-radius: 4px; border: none; font-size: 0.75rem;">
                            <i class="fas fa-save mr-1"></i> SIMPAN PROFIL
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- CARD PENGATURAN RESEND API KEY (BEBAS COOLIFY) -->
        <div class="col-lg-6 mb-4">
            <div class="hud-card mb-4" style="border-left: 3px solid #10b981; background: rgba(15,23,42,0.8);">
                <div class="hud-header d-flex align-items-center" style="background: rgba(16,185,129,0.1); border-bottom: 1px solid rgba(16,185,129,0.2); padding: 12px 16px;">
                    <i class="fas fa-paper-plane mr-2" style="color: #10b981;"></i>
                    <span class="font-sans text-white small fw-bold">PENGATURAN RESEND API KEY (BEBAS COOLIFY)</span>
                </div>
                <div class="hud-body p-4">
                    <form action="<?= base_url('superadmin/profile/resend-key') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="form-group mb-3">
                            <label class="text-white small fw-bold mb-1 font-sans">Resend API Key <span class="text-success">(Kunci Rahasia re_...)</span></label>
                            <input type="text" name="resend_key" class="form-control bg-dark text-white border-secondary font-sans"
                                value="<?= esc($resendKey) ?>" placeholder="Tempelkan kode API Key Resend di sini (re_...)" style="font-size: 0.85rem; border-radius: 4px;">
                            <div class="text-secondary mt-2 font-sans" style="font-size: 0.75rem; line-height: 1.5;">
                                <i class="fas fa-lightbulb text-warning mr-1"></i>
                                Anda dapat mengisikan kunci Resend API (`re_...`) langsung di sini **tanpa perlu ribet setting di Coolify**. Kunci ini akan digunakan otomatis oleh sistem pengingat email.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm font-sans text-white fw-bold px-4"
                            style="background: #10b981; border-radius: 4px; border: none; font-size: 0.75rem;">
                            <i class="fas fa-key mr-1"></i> SIMPAN RESEND API KEY
                        </button>
                    </form>
                </div>
            </div>

            <!-- CARD GANTI PASSWORD -->
            <div class="hud-card" style="border-left: 3px solid #6366f1; background: rgba(15,23,42,0.8);">
                <div class="hud-header d-flex align-items-center" style="background: rgba(99,102,241,0.1); border-bottom: 1px solid rgba(99,102,241,0.2); padding: 12px 16px;">
                    <i class="fas fa-key mr-2" style="color: #6366f1;"></i>
                    <span class="font-sans text-white small fw-bold">GANTI KATA SANDI</span>
                </div>
                <div class="hud-body p-4">
                    <form action="<?= base_url('superadmin/password/update') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="form-group mb-3">
                            <label class="text-white small fw-bold mb-1 font-sans">Kata Sandi Saat Ini <span class="text-danger">*</span></label>
                            <input type="password" name="password_lama" class="form-control bg-dark text-white border-secondary font-sans"
                                placeholder="Masukkan kata sandi lama..." required style="font-size: 0.85rem; border-radius: 4px;">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-white small fw-bold mb-1 font-sans">Kata Sandi Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password_baru" class="form-control bg-dark text-white border-secondary font-sans"
                                placeholder="Minimal 8 karakter..." minlength="8" required style="font-size: 0.85rem; border-radius: 4px;">
                        </div>
                        <div class="form-group mb-4">
                            <label class="text-white small fw-bold mb-1 font-sans">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                            <input type="password" name="konfirmasi_password" class="form-control bg-dark text-white border-secondary font-sans"
                                placeholder="Ulangi kata sandi baru..." minlength="8" required style="font-size: 0.85rem; border-radius: 4px;">
                        </div>
                        <button type="submit" class="btn btn-sm font-sans text-white fw-bold px-4"
                            style="background: #6366f1; border-radius: 4px; border: none; font-size: 0.75rem;">
                            <i class="fas fa-shield-alt mr-1"></i> UPDATE KATA SANDI
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
