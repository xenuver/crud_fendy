<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAFTAR KREATOR | BLOODSTRIKE HUB</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/bloodstrike_actual.jpg') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Orbitron:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/register.css') ?>">
</head>
<body>
    <div class="register-card shadow-lg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="<?= base_url('/login') ?>" class="text-decoration-none text-white small hover-red" style="font-size: 0.7rem; letter-spacing: 1px; font-family: 'Orbitron', sans-serif;">
                <i class="fas fa-chevron-left me-1"></i> KEMBALI
            </a>
        </div>

        <h3 class="brush-text">DAFTAR</h3>
        <p class="text-center text-white mb-4" style="font-size: 0.65rem; letter-spacing: 2px; font-family: 'Orbitron', sans-serif;">AKTIVASI AKUN KREATOR</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert rounded-0 py-2 small mb-3" style="background: rgba(234, 25, 23, 0.15); border: 1px solid var(--bs-red); color: #fff;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert rounded-0 py-2 small mb-3" style="background: rgba(34, 197, 94, 0.15); border: 1px solid #22c55e; color: #fff;">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="info-badge">
            <i class="fas fa-info-circle me-2" style="color: var(--bs-red);"></i>
            Pendaftaran hanya bisa dilakukan dengan <strong>Redeem Code</strong> yang diberikan oleh Admin. Hubungi Admin jika belum memiliki kode.
        </div>

        <form action="<?= base_url('auth/register') ?>" method="post" autocomplete="off">
            <?= csrf_field() ?>

            <!-- Redeem Code -->
            <div class="redeem-box mb-4">
                <span class="badge-label">KODE REDEEM</span>
                <?php $isLocked = !empty($requested_code); ?>
                <input type="text"
                       class="form-control <?= $isLocked ? 'text-success fw-bold' : '' ?>"
                       name="redeem_code"
                       placeholder="BS-XXXXXX"
                       maxlength="9"
                       value="<?= esc($requested_code ?? old('redeem_code') ?? '') ?>"
                       <?= $isLocked ? 'readonly title="Kode sudah terkunci dari link Admin"' : '' ?>
                       required
                       autocomplete="off"
                       style="<?= $isLocked ? 'cursor: not-allowed; opacity: 0.85;' : '' ?>">
                <?php if ($isLocked): ?>
                    <small class="text-success d-block mt-1" style="font-size: 0.65rem; letter-spacing: 1px;">
                        <i class="fas fa-lock me-1"></i> Kode terkunci — tidak dapat diubah
                    </small>
                <?php endif; ?>
            </div>

            <div class="divider-line"></div>

            <!-- Identity Fields Wrapper -->
            <div class="form-fields-wrapper">
                <!-- Username -->
                <div class="mb-3">
                    <label class="orbitron-label">Username</label>
                    <input type="text"
                           class="form-control"
                           name="username"
                           placeholder="Nama pengguna unik Anda"
                           value="<?= old('username') ?>"
                           minlength="3"
                           maxlength="20"
                           required>
                </div>

                <!-- Nomor Telepon -->
                <div class="mb-3">
                    <label class="orbitron-label">Nomor Telepon</label>
                    <input type="text"
                           class="form-control"
                           name="no_telp"
                           placeholder="Contoh: 081234567890"
                           value="<?= old('no_telp') ?>"
                           minlength="8"
                           maxlength="18"
                           required>
                </div>

                <!-- ID Game -->
                <div class="mb-3">
                    <label class="orbitron-label">ID Game (UID BloodStrike)</label>
                    <input type="text"
                           class="form-control"
                           name="id_game"
                           placeholder="Masukkan UID BloodStrike Anda"
                           value="<?= old('id_game') ?>"
                           minlength="5"
                           required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="orbitron-label">Kata Sandi</label>
                    <input type="password"
                           class="form-control"
                           name="password"
                           placeholder="Minimal 8 karakter"
                           minlength="8"
                           required>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus me-2"></i> BUAT AKUN
            </button>
        </form>
    </div>

    <script src="<?= base_url('assets/js/register.js') ?>"></script>
</body>
</html>
