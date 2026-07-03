<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOOD STRIKE | PUSAT KREATOR</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/bloodstrike_actual.jpg') ?>">
    
    <!-- SEO & Media Monitoring Tags -->
    <meta name="description" content="Portal resmi kreator Bloodstrike - NetEase Games. Kirim laporan mingguan, pantau performa konton, dan tingkatkan Tier Anda menjadi Kreator Elit.">
    <meta name="keywords" content="Bloodstrike, NetEase, Creator Hub, Gaming Creator, FPS Indonesia">
    <meta property="og:title" content="BLOOD STRIKE | PUSAT KREATOR">
    <meta property="og:description" content="Bergabunglah dengan komunitas kreator resmi Bloodstrike. Tunjukkan talentamu dan raih reward eksklusif.">
    <meta property="og:image" content="<?= base_url('assets/img/bloodstrike_actual.jpg') ?>">
    <meta property="og:type" content="website">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bs-red: #ea1917;
            --bs-dark: #0f172a;
            --bs-card-bg: rgba(15, 23, 42, 0.8);
            --bs-accent-glow: rgba(234, 25, 23, 0.4);
            --bs-text-muted: #94a3b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bs-dark);
            color: #ffffff;
            margin: 0;
            overflow-x: hidden;
            line-height: 1.6;
        }

        .brush-font { font-family: 'Permanent Marker', cursive; }
        .orbitron-font { font-family: 'Orbitron', sans-serif; }

        /* Background Effects */
        .hero-bg {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.7) 0%, rgba(15, 23, 42, 0.98) 100%), 
                        url('<?= base_url('assets/img/bloodstrike_actual.jpg') ?>');
            background-size: cover;
            background-position: center;
            z-index: -1;
        }

        .scanlines {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03));
            background-size: 100% 4px, 3px 100%;
            pointer-events: none;
            z-index: 100;
            opacity: 0.2;
        }

        .navbar {
            background: rgba(15, 23, 41, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 2px solid var(--bs-red);
            padding: 1.2rem 0;
            box-shadow: 0 5px 30px rgba(0,0,0,0.5);
            z-index: 1000;
        }

        /* Hero Section */
        .hero-section {
            padding: 140px 0 60px;
            text-align: center;
        }

        .netease-logo-wrapper {
            margin-bottom: 25px;
        }

        .netease-logo {
            max-height: 140px;
            filter: invert(1) hue-rotate(180deg) brightness(1.5);
            mix-blend-mode: screen;
            transition: 0.3s;
        }

        .hero-title {
            font-size: clamp(2.5rem, 8vw, 4.2rem);
            margin-bottom: 1.2rem;
            text-shadow: 0 0 20px rgba(234, 25, 23, 0.6);
            letter-spacing: -1px;
        }

        .hero-description {
            font-size: 1.1rem;
            max-width: 800px;
            margin: 0 auto 2.5rem;
            color: #e2e8f0;
            background: rgba(0,0,0,0.4);
            padding: 25px;
            border-left: 4px solid var(--bs-red);
            backdrop-filter: blur(10px);
        }

        .btn-strike {
            background: var(--bs-red);
            color: white;
            padding: 14px 45px;
            font-size: 1.2rem;
            font-weight: 700;
            text-decoration: none;
            clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-block;
            border: 2px solid #fff;
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 2px;
        }

        .btn-strike:hover {
            background: #fff;
            color: var(--bs-red);
            transform: scale(1.05);
            box-shadow: 0 0 30px #fff;
        }

        /* Stats Section */
        .stats-container {
            background: rgba(0,0,0,0.6);
            border-top: 1px solid rgba(255,255,255,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 30px 0;
            margin-bottom: 40px;
        }

        .stat-card {
            text-align: center;
            padding: 15px;
        }

        .stat-value {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--bs-red);
            display: block;
            text-shadow: 0 0 15px var(--bs-accent-glow);
        }

        .stat-label {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.7rem;
            letter-spacing: 2px;
            color: #94a3b8;
            text-transform: uppercase;
        }

        /* Titles */
        .section-title {
            font-size: 1.8rem;
            margin-bottom: 2.5rem;
            color: #fff;
            position: relative;
            display: inline-block;
            padding-bottom: 12px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0; left: 25%; width: 50%;
            height: 3px;
            background: var(--bs-red);
            box-shadow: 0 0 10px var(--bs-red);
        }

        /* Cards */
        .info-card {
            background: var(--bs-card-bg);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 30px 25px;
            border-radius: 0;
            height: 100%;
            transition: 0.4s;
        }

        .info-card i {
            font-size: 2.2rem;
            color: var(--bs-red);
            margin-bottom: 20px;
            display: block;
        }

        .tier-card {
            padding: 30px 25px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(15, 23, 42, 0.9);
            transition: 0.3s;
            height: 100%;
        }

        .tier-card.tier-1 { border-top: 4px solid #FFD700; }
        .tier-card.tier-2 { border-top: 4px solid #C0C0C0; }
        .tier-card.tier-3 { border-top: 4px solid #CD7F32; }

        .tier-card:hover { border-color: #fff; transform: scale(1.05); }

        .tier-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        /* FAQ */
        .accordion-item {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 10px;
            border-radius: 0 !important;
        }

        .accordion-button {
            background: transparent;
            color: #fff;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.85rem;
            padding: 18px;
            border-radius: 0 !important;
        }

        .accordion-button:not(.collapsed) {
            background: rgba(234, 25, 23, 0.1);
            color: var(--bs-red);
            box-shadow: none;
        }

        .accordion-body { color: #94a3b8; font-size: 0.9rem; line-height: 1.7; }

        .hover-red { transition: 0.3s; }
        .hover-red:hover { color: var(--bs-red) !important; transform: scale(1.2); }

        footer {
            padding: 60px 0 30px;
            background: #000;
            border-top: 2px solid var(--bs-red);
            color: var(--bs-text-muted);
        }

        /* SweetAlert Customization */
        .swal2-popup {
            background: #0f172a !important;
            border: 1px solid var(--bs-red);
            border-radius: 0 !important;
            color: #fff !important;
        }
        .swal2-title { font-family: 'Orbitron', sans-serif; text-transform: uppercase; font-size: 1.2rem !important; }
        .swal2-content { font-size: 0.9rem !important; }
        .swal2-confirm { background-color: var(--bs-red) !important; border-radius: 0 !important; font-family: 'Orbitron', sans-serif; }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.1rem;
            }
            .navbar .btn-sm {
                font-size: 0.65rem !important;
                padding: 6px 12px !important;
            }
        }
    </style>
</head>
<body>
    <div class="hero-bg"></div>
    <div class="scanlines"></div>

    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand orbitron-font text-white fw-bold" href="#">
                <span style="color: var(--bs-red); text-shadow: 0 0 10px var(--bs-red);">BLOOD</span>STRIKE
            </a>
            <div class="ms-auto d-flex gap-2 gap-sm-3">
                <?php if (session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url(session()->get('role')) ?>" class="btn btn-outline-light orbitron-font px-2 px-sm-4 rounded-0 btn-sm py-2" style="border-width: 2px;">DASHBOARD →</a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="btn btn-outline-light orbitron-font px-2 px-sm-4 rounded-0 btn-sm py-2" style="border-width: 2px;">LOGIN<span class="d-none d-sm-inline"> KREATOR</span> →</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Header Hero -->
    <header class="hero-section">
        <div class="container">
            <div class="netease-logo-wrapper">
                <img src="<?= base_url('assets/img/netease_logo.jpg') ?>" class="netease-logo" alt="NetEase Games" loading="lazy">
            </div>
            <p class="orbitron-font text-danger mb-2 fw-bold" style="letter-spacing: 5px;">PORTAL RESMI KREATOR</p>
            <h1 class="hero-title brush-font">PUSAT LAPORAN KREATOR</h1>
            <div class="hero-description mx-auto">
                <p class="mb-4">
                    <strong>Bloodstrike</strong> merupakan game FPS taktis dikembangkan oleh <strong>NetEase Games</strong>. Kami mengundang para Kreator Konten agar bergabung bersama komunitas resmi MiminBS untuk pengembangan kanal yang lebih baik.
                </p>
                <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2 gap-md-4 small orbitron-font opacity-75">
                    <span class="text-nowrap"><i class="fas fa-check-circle text-danger me-2"></i> DATA TERVERIFIKASI</span>
                    <span class="text-nowrap"><i class="fas fa-clock text-danger me-2"></i> RESPON CEPAT</span>
                    <span class="text-nowrap"><i class="fas fa-users text-danger me-2"></i> KOMUNITAS RESMI</span>
                </div>
            </div>
            <?php if (session()->get('isLoggedIn')): ?>
                <a href="<?= base_url(session()->get('role')) ?>" class="btn-strike">KE DASHBOARD</a>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="btn-strike">MASUK SEKARANG</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Stats Section -->
    <div class="stats-container">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="stat-card">
                        <span class="stat-value">1,240+</span>
                        <span class="stat-label">Laporan Disetujui</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <span class="stat-value">500+</span>
                        <span class="stat-label">Kreator Aktif</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <span class="stat-value">24/7</span>
                        <span class="stat-label">Dukungan Admin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tiering Section -->
    <section class="py-4">
        <div class="container py-2">
            <div class="text-center">
                <h2 class="section-title orbitron-font text-uppercase">Sistem Pangkat Kreator</h2>
                <p class="text-secondary mb-4 small">Kenaikan Pangkat Berdasarkan Total Views Laporan</p>
            </div>
            <?php
            $formatK = function($num) {
                if ($num >= 1000) {
                    // Check if division yields integer or float, format appropriately
                    $val = $num / 1000;
                    return (floor($val) == $val ? (int)$val : number_format($val, 1, ',', '')) . 'RB';
                }
                return $num;
            };
            ?>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="tier-card tier-1">
                        <div class="tier-icon"><i class="fas fa-medal" style="color: #FFD700;"></i></div>
                        <h3 class="orbitron-font">TIER 1 (GOLD)</h3>
                        <hr class="border-secondary opacity-25">
                        <div class="small fw-bold text-white mb-1"><i class="fas fa-users text-danger me-1"></i> CCV PREDIKSI: <?= number_format($settings['t1_ccv']) ?>+</div>
                        <div class="small text-secondary fw-bold" style="font-size: 0.65rem;">AVG VIEWS: <?= $formatK($settings['t1_yt']) ?> - <?= $formatK($settings['t1_tt']) ?>+</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tier-card tier-2">
                        <div class="tier-icon"><i class="fas fa-medal" style="color: #C0C0C0;"></i></div>
                        <h3 class="orbitron-font">TIER 2 (SILVER)</h3>
                        <hr class="border-secondary opacity-25">
                        <div class="small fw-bold text-white mb-1"><i class="fas fa-users text-danger me-1"></i> CCV PREDIKSI: <?= number_format($settings['t2_ccv']) ?>+</div>
                        <div class="small text-secondary fw-bold" style="font-size: 0.65rem;">AVG VIEWS: <?= $formatK($settings['t2_yt']) ?> - <?= $formatK($settings['t2_tt']) ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tier-card tier-3">
                        <div class="tier-icon"><i class="fas fa-medal" style="color: #CD7F32;"></i></div>
                        <h3 class="orbitron-font">TIER 3 (BRONZE)</h3>
                        <hr class="border-secondary opacity-25">
                        <div class="small fw-bold text-white mb-1"><i class="fas fa-users text-danger me-1"></i> CCV PREDIKSI: <?= number_format($settings['t3_ccv']) ?>+</div>
                        <div class="small text-secondary fw-bold" style="font-size: 0.65rem;">AVG VIEWS: <?= $formatK($settings['t3_yt']) ?> - <?= $formatK($settings['t3_tt']) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-4" style="background: rgba(0,0,0,0.3);">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="info-card text-center">
                        <i class="fas fa-database"></i>
                        <h4 class="orbitron-font">DATA VALID</h4>
                        <p class="text-secondary small">Statistik video dan livestream Anda akan tercatat secara akurat di database pusat MiminBS.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card text-center">
                        <i class="fas fa-user-check"></i>
                        <h4 class="orbitron-font">PENILAIAN RESMI</h4>
                        <p class="text-secondary small">Setiap laporan diverifikasi langsung oleh Admin untuk memastikan pertumbuhan kanal berjalan sehat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card text-center">
                        <i class="fas fa-project-diagram"></i>
                        <h4 class="orbitron-font">EKOSISTEM TAKTIS</h4>
                        <p class="text-secondary small">Jadilah bagian dari komunitas elit para pemain FPS terbaik yang memiliki akses langsung ke pengelola.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-4" style="background: rgba(0,0,0,0.5);">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-5">
                    <h2 class="orbitron-font text-white mb-3">PUSAT <br><span class="text-danger">INFORMASI</span></h2>
                    <p class="text-secondary mb-4 small">Bantuan teknis dan jawaban atas pertanyaan umum seputar program kreator.</p>
                </div>
                <div class="col-lg-7">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Kenapa laporan saya ditolak?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Penolakan terjadi jika data tidak sesuai dengan bukti screenshot, atau link video tidak bisa diakses. Harap pastikan keaslian data sebelum mengirim.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Apakah ada syarat minimal minimal followers?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Tidak ada syarat minimal followers yang ketat. Siapapun bisa bergabung selama konsisten membuat konten Bloodstrike yang berkualitas.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Berapa lama proses verifikasi laporan?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Admin biasanya melakukan pengecekan dalam waktu 1-3 hari kerja. Anda bisa memantau statusnya di dashboard masing-masing.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Bagaimana jika saya terlambat mengirim laporan?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Setiap periode laporan memiliki batas waktu tertentu. Jika terlewat, Anda tidak bisa mengupload data untuk minggu tersebut secara mundur. Harap selalu disiplin setiap minggunya.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    Apakah akun game harus level tertentu untuk bergabung?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Level akun game tidak menjadi syarat utama. Fokus kami adalah pada performa konten dan interaksi positif Anda dengan komunitas Bloodstrike.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                    <div class="footer-brand orbitron-font text-white fw-bold">
                        <span style="color: var(--bs-red); text-shadow: 0 0 10px var(--bs-red);">BLOOD</span>STRIKE
                    </div>
                    <p class="small text-secondary mb-0" style="max-width: 450px;">Portal resmi monitoring dan pengembangan kreator konten Bloodstrike dari NetEase Games di Indonesia.</p>
                </div>
                
                <div class="col-lg-6 text-center text-lg-end">
                    <div class="d-flex justify-content-center justify-content-lg-end gap-3 mb-3">
                        <a href="#" class="text-white opacity-50 hover-red"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="text-white opacity-50 hover-red"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="text-white opacity-50 hover-red"><i class="fab fa-instagram"></i></a>
                    </div>
                    <div class="orbitron small mb-1" style="letter-spacing: 1px; color: #94a3b8; font-size: 0.65rem;">SISTEM MONITORING KREATOR BLOODSTRIKE</div>
                    <div class="orbitron small" style="letter-spacing: 1px; font-size: 0.75rem;">Copyright 2026 - Developed by <span class="text-danger fw-bold">Fendy A.K.A Kaiser</span></div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // SweetAlert2 Integration for Flash Messages (if any)
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (session()->getFlashdata('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'BERHASIL',
                    text: '<?= session()->getFlashdata('success') ?>',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '<?= session()->getFlashdata('error') ?>',
                    confirmButtonText: 'COBA LAGI'
                });
            <?php endif; ?>

            // Inisialisasi Bootstrap Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
</body>
</html>
