<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MASUK | PORTAL AKSES</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/bloodstrike_actual.jpg') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Orbitron:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>
<body>
    <div class="login-card shadow-lg">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="<?= base_url('/') ?>" class="text-decoration-none text-white small orbitron-font hover-red" style="font-size: 0.7rem; letter-spacing: 1px;">
                <i class="fas fa-chevron-left me-1"></i> KEMBALI
            </a>
        </div>
        <h3 class="brush-text">MASUK</h3>
        <p class="text-center orbitron-font text-white mb-4" style="font-size: 0.65rem; letter-spacing: 2px;">OTORISASI DIPERLUKAN</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger py-2 small rounded-0" style="background: rgba(234, 25, 23, 0.2); border: 1px solid var(--bs-red); color: #fff;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success py-2 small rounded-0" style="background: rgba(34, 197, 94, 0.2); border: 1px solid #22c55e; color: #fff;">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/login') ?>" method="post">
            <?= csrf_field() ?>
            <!-- Login Fields Wrapper -->
            <div class="form-fields-wrapper">
                <div class="mb-4">
                    <label class="orbitron-label">NOMOR TELEPON ATAU NAMA PENGGUNA</label>
                    <input type="text" name="login" class="form-control" placeholder="Masukkan Nomor Telepon atau Username" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="orbitron-label">KATA SANDI</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan Kata Sandi" required>
                </div>
            </div>
            <button type="submit" class="btn btn-portal">MASUK KE PORTAL</button>
        </form>
        
        <!-- Registration hidden by request -->
        <!-- <div class="auth-hint text-center">
            <p class="small text-secondary mb-0">Belum punya akun? <a href="<?= base_url('register') ?>" class="text-white fw-bold text-decoration-none" style="border-bottom: 2px solid var(--bs-red);">DAFTAR SEKARANG</a></p>
        </div> -->
    </div>
</body>
</html>
