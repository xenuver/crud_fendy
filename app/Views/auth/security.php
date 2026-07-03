<div class="container-fluid">
    <h1 class="h3 mb-4 text-white orbitron"><?= $judul; ?></h1>

    <div class="row">
        <div class="col-lg-6">


            <div class="card shadow-sm" style="background: rgba(30, 41, 59, 0.8); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; backdrop-filter: blur(10px);">
                <div class="card-header border-0 pb-0" style="background: transparent;">
                    <h5 class="mb-0 text-white"><i class="fas fa-lock text-danger me-2"></i> Perbarui Kata Sandi</h5>
                    <hr class="border-secondary mb-0 mt-3">
                </div>
                <div class="card-body text-white">
                    <form action="<?= base_url('keamanan-akun/update') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Kata Sandi Lama</label>
                            <input type="password" class="form-control bg-dark text-white border-secondary" id="old_password" name="old_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Kata Sandi Baru</label>
                            <input type="password" class="form-control bg-dark text-white border-secondary" id="new_password" name="new_password" required minlength="8" placeholder="Minimal 8 karakter">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" class="form-control bg-dark text-white border-secondary" id="confirm_password" name="confirm_password" required minlength="8">
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-danger" style="background-color: #ea1917; border: none; clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%); padding: 8px 30px; font-weight: 600; letter-spacing: 1px;">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
