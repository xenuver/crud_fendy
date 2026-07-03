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
    <style>
        :root {
            --bs-red: #ea1917;
            --bs-dark: #0f172a;
        }

        * { box-sizing: border-box; }

        body {
            background-color: var(--bs-dark);
            background-image: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.97)),
                              url('<?= base_url('assets/img/bloodstrike_actual.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            color: #fff;
            margin: 0;
            padding: 30px 15px;
        }

        .register-card {
            width: 100%;
            max-width: 480px;
            background: rgba(15, 17, 26, 0.97);
            backdrop-filter: blur(20px);
            padding: 45px 40px;
            border-bottom: 5px solid var(--bs-red);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            clip-path: polygon(0% 0%, 95% 0%, 100% 5%, 100% 100%, 5% 100%, 0% 95%);
        }

        .brush-text {
            font-family: 'Permanent Marker', cursive;
            color: var(--bs-red);
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 0;
            line-height: 1.2;
        }

        .orbitron-label {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.70rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
            display: block;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid #334155;
            color: white;
            border-radius: 0;
            padding: 12px 14px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--bs-red);
            box-shadow: 0 0 15px rgba(234, 25, 23, 0.3);
            color: white;
        }

        .form-control::placeholder { color: #475569; }

        .redeem-box {
            background: rgba(234, 25, 23, 0.07);
            border: 1px dashed rgba(234, 25, 23, 0.5);
            padding: 16px;
            margin-bottom: 24px;
            position: relative;
        }

        .redeem-box .badge-label {
            position: absolute;
            top: -10px;
            left: 14px;
            background: var(--bs-red);
            color: white;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.6rem;
            padding: 2px 10px;
            letter-spacing: 1px;
        }

        .redeem-box .form-control {
            border-color: rgba(234, 25, 23, 0.4);
            text-align: center;
            font-family: 'Orbitron', sans-serif;
            font-size: 1rem;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .redeem-box .form-control:focus {
            border-color: var(--bs-red);
            box-shadow: 0 0 20px rgba(234, 25, 23, 0.4);
        }

        .divider-line {
            border-top: 1px solid rgba(255,255,255,0.08);
            margin: 20px 0;
        }

        .btn-register {
            background: var(--bs-red);
            color: white;
            font-family: 'Orbitron', sans-serif;
            border: 2px solid #fff;
            width: 100%;
            padding: 14px;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 2px;
            transition: 0.3s;
            clip-path: polygon(8% 0%, 100% 0%, 92% 100%, 0% 100%);
            margin-top: 24px;
        }

        .btn-register:hover {
            background: #fff;
            color: var(--bs-red);
            transform: scale(1.02);
        }

        .hover-red { transition: color 0.3s ease; }
        .hover-red:hover { color: var(--bs-red) !important; }

        .info-badge {
            background: rgba(234, 25, 23, 0.1);
            border: 1px solid rgba(234, 25, 23, 0.3);
            border-radius: 4px;
            padding: 10px 14px;
            font-size: 0.78rem;
            color: #94a3b8;
            margin-bottom: 20px;
        }
    </style>
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
                <input type="text"
                       class="form-control"
                       name="redeem_code"
                       placeholder="BS-XXXXXX"
                       maxlength="9"
                       value="<?= old('redeem_code') ?? esc($requested_code ?? '') ?>"
                       required
                       autocomplete="off">
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

    <script>
        // Auto-format redeem code input: uppercase + tambah strip otomatis
        const redeemInput = document.querySelector('input[name="redeem_code"]');
        if (redeemInput) {
            redeemInput.addEventListener('input', function() {
                let val = this.value.replace(/[^A-Z0-9a-z]/gi, '').toUpperCase();
                if (val.length > 2) {
                    val = 'BS-' + val.replace(/^BS/i, '').substring(0, 6);
                }
                this.value = val;
            });
        }
    </script>
</body>
</html>
