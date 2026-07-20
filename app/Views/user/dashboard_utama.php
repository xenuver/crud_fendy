<div class="container-fluid py-4">

    <!-- WELCOME BANNERS -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-2">
                <div class="bg-danger text-white px-3 py-1 orbitron small shadow-sm" style="clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
                    DASBOR KREATOR
                </div>
                <div class="ml-3 text-secondary small orbitron" style="opacity: 0.8; letter-spacing: 1px;">
                    Ringkasan Performa dan Target Pribadi
                </div>
            </div>
            
            <div class="hud-card border-0 shadow-lg" style="background: linear-gradient(135deg, rgba(15,23,42,0.9) 0%, rgba(20,0,0,0.9) 100%);">
                <div class="p-4 d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h2 class="orbitron fw-bold text-white mb-1">SELAMAT DATANG, <span class="text-danger"><?= esc(strtoupper(session()->get('username'))) ?></span></h2>
                        <div class="text-muted small">UID: <?= esc(session()->get('id_game')) ?> | Tingkat Saat Ini: <span class="text-white"><?= $tier['label'] ?></span></div>
                    </div>
                    <?php if(!$kreator): ?>
                        <div class="alert alert-warning m-0 px-3 py-2 small orbitron"><i class="fas fa-exclamation-triangle"></i> Profil Anda belum lengkap. Silakan hubungi admin.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ALERT PROFIL BELUM LENGKAP -->
    <?php if ($isProfileIncomplete): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger border-0 orbitron shadow-sm m-0" 
                     style="background: rgba(239, 68, 68, 0.15); color: #f87171; border-left: 4px solid #ef4444 !important; border-radius: 4px;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-edit mr-3" style="font-size: 1.25rem;"></i>
                            <div>
                                <strong style="font-size: 0.75rem;">PROFIL BELUM LENGKAP:</strong> 
                                <span class="small" style="font-size: 0.7rem;">Anda wajib melengkapi alamat dan menautkan minimal satu channel (YouTube/TikTok) sebelum dapat mengirimkan laporan mingguan.</span>
                            </div>
                        </div>
                        <a href="<?= base_url('user/profile') ?>" class="btn btn-sm btn-danger orbitron px-3 py-1 mt-2 mt-md-0" style="font-size: 0.55rem; background-color: #ef4444; border: none; border-radius: 2px;">LENGKAPI PROFIL SEKARANG</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- STATUS LAPORAN MINGGUAN MINGGU INI -->
    <?php if ($kreator && !$isProfileIncomplete): ?>
        <div class="row mb-4">
            <div class="col-12">
                <?php if ($hasSubmittedYt && $hasSubmittedTt): ?>
                    <div class="alert alert-success border-0 orbitron shadow-sm m-0" 
                         style="background: rgba(40, 167, 69, 0.15); color: #4ade80; border-left: 4px solid #22c55e !important; border-radius: 4px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-double mr-3" style="font-size: 1.25rem;"></i>
                            <div>
                                <strong style="font-size: 0.75rem;">SEMUA LAPORAN TERKIRIM:</strong> 
                                <span class="small" style="font-size: 0.7rem;">Anda telah mengirimkan laporan mingguan YouTube & TikTok untuk minggu ini. Terima kasih!</span>
                            </div>
                        </div>
                    </div>
                <?php elseif ($hasSubmittedYt): ?>
                    <div class="alert alert-info border-0 orbitron shadow-sm m-0" 
                         style="background: rgba(14, 165, 233, 0.15); color: #38bdf8; border-left: 4px solid #0ea5e9 !important; border-radius: 4px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle mr-3" style="font-size: 1.25rem;"></i>
                            <div class="w-100 d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <strong style="font-size: 0.75rem;">LAPORAN YOUTUBE TERKIRIM:</strong> 
                                    <span class="small" style="font-size: 0.7rem;">Anda telah mengirimkan laporan YouTube. Jangan lupa mengirimkan laporan TikTok jika Anda aktif di platform tersebut.</span>
                                </div>
                                <?php if ($isOpen): ?>
                                    <a href="<?= base_url('user/laporan') ?>" class="btn btn-sm btn-outline-info orbitron px-3 py-1 mt-2 mt-md-0" style="font-size: 0.55rem; border-radius: 2px;">KIRIM TIKTOK</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php elseif ($hasSubmittedTt): ?>
                    <div class="alert alert-info border-0 orbitron shadow-sm m-0" 
                         style="background: rgba(14, 165, 233, 0.15); color: #38bdf8; border-left: 4px solid #0ea5e9 !important; border-radius: 4px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle mr-3" style="font-size: 1.25rem;"></i>
                            <div class="w-100 d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <strong style="font-size: 0.75rem;">LAPORAN TIKTOK TERKIRIM:</strong> 
                                    <span class="small" style="font-size: 0.7rem;">Anda telah mengirimkan laporan TikTok. Jangan lupa mengirimkan laporan YouTube jika Anda aktif di platform tersebut.</span>
                                </div>
                                <?php if ($isOpen): ?>
                                    <a href="<?= base_url('user/laporan') ?>" class="btn btn-sm btn-outline-info orbitron px-3 py-1 mt-2 mt-md-0" style="font-size: 0.55rem; border-radius: 2px;">KIRIM YOUTUBE</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php elseif ($isOpen): ?>
                    <div class="alert alert-warning border-0 orbitron shadow-sm m-0" 
                         style="background: rgba(234, 179, 8, 0.15); color: #facc15; border-left: 4px solid #eab308 !important; border-radius: 4px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle mr-3" style="font-size: 1.25rem;"></i>
                            <div class="w-100 d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <strong style="font-size: 0.75rem;">LAPORAN BELUM DIKIRIM:</strong> 
                                    <span class="small" style="font-size: 0.7rem;">Anda belum mengirimkan laporan mingguan untuk minggu ini. Silakan kirimkan laporan Anda sebelum batas waktu berakhir.</span>
                                </div>
                                <a href="<?= base_url('user/laporan') ?>" class="btn btn-sm btn-outline-warning orbitron px-3 py-1 mt-2 mt-md-0" style="font-size: 0.55rem; border-radius: 2px;">KIRIM SEKARANG</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- STATS CARDS -->
    <div class="row mb-4">
        <!-- Total Tayangan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 py-2 border-0 shadow" 
                 style="background: rgba(15, 23, 42, 0.6); 
                        border-left: 4px solid var(--bs-red) !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="small fw-bold text-danger text-uppercase mb-1 orbitron" 
                                 data-toggle="tooltip" 
                                 title="Akumulasi seluruh tayangan video/live Anda dalam bulan berjalan.">
                                Total Tayangan (Bulan Ini) 
                                <i class="fas fa-info-circle ml-1 opacity-50"></i>
                            </div>
                            <div class="h3 mb-0 font-weight-bold text-white orbitron">
                                <?= number_format($totalViews) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-secondary" style="opacity: 0.4;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekor Penonton Puncak (CCV) -->
        <div class="col-xl-3 col-md-6 mb-4 reveal-fade delay-2">
            <div class="card h-100 py-2 border-0 shadow" 
                 style="background: rgba(15, 23, 42, 0.6); 
                        border-left: 4px solid #f6c23e !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="small fw-bold text-warning text-uppercase mb-1 orbitron" 
                                 data-toggle="tooltip" 
                                 title="Puncak jumlah penonton (Concurrent Viewers) tertinggi yang tercatat saat Anda Livestreaming.">
                                Rekor Penonton Puncak (CCV) 
                                <i class="fas fa-info-circle ml-1 opacity-50"></i>
                            </div>
                            <div class="h3 mb-0 font-weight-bold text-white orbitron">
                                <?= number_format($totalCcv) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-secondary" style="opacity: 0.4;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Video Diunggah -->
        <div class="col-xl-3 col-md-6 mb-4 reveal-fade delay-3">
            <div class="card h-100 py-2 border-0 shadow" 
                 style="background: rgba(15, 23, 42, 0.6); 
                        border-left: 4px solid #36b9cc !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="small fw-bold text-info text-uppercase mb-1 orbitron" 
                                 data-toggle="tooltip" 
                                 title="Jumlah total video bertema Bloodstrike yang telah Anda unggah dan laporkan.">
                                Total Video Diunggah 
                                <i class="fas fa-info-circle ml-1 opacity-50"></i>
                            </div>
                            <div class="h3 mb-0 font-weight-bold text-white orbitron">
                                <?= number_format($totalVideo) ?> 
                                <span class="small font-weight-normal text-muted">Video</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-video fa-2x text-secondary" style="opacity: 0.4;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tier Kreator -->
        <div class="col-xl-3 col-md-6 mb-4 reveal-fade delay-4">
            <div class="card h-100 py-2 border-0 shadow" 
                 style="background: rgba(15, 23, 42, 0.6); 
                        border-left: 4px solid var(--bs-red) !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="small fw-bold text-danger text-uppercase mb-2 orbitron" 
                                 data-toggle="tooltip" 
                                 title="Pangkat Anda saat ini berdasarkan total views. Tier lebih tinggi mendapatkan reward lebih besar.">
                                Tier Kreator 
                                <i class="fas fa-info-circle ml-1 opacity-50"></i>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="<?= $tier['icon'] ?> fa-2x mr-3" 
                                   style="color: <?= $tier['color'] ?>; 
                                          text-shadow: 0 0 10px <?= $tier['color'] ?>80;"></i>
                                <span class="h4 mb-0 text-white orbitron fw-bold">
                                    <?= $tier['label'] ?>
                                </span>
                            </div>
                            <div class="border-top border-secondary pt-2 mt-2 mb-3" style="border-top-color: rgba(255,255,255,0.08) !important;">
                                <div class="small text-secondary orbitron mb-1" style="font-size: 0.55rem; letter-spacing: 0.5px;">PROYEKSI BULAN DEPAN:</div>
                                <div class="d-flex align-items-center">
                                    <i class="<?= $projectedTier['icon'] ?> mr-2" style="color: <?= $projectedTier['color'] ?>; font-size: 0.85rem;"></i>
                                    <span class="orbitron text-white small fw-bold" style="color: <?= $projectedTier['color'] ?> !important; font-size: 0.7rem;"><?= $projectedTier['label'] ?></span>
                                </div>
                            </div>
                            <?php if ($isProfileIncomplete): ?>
                                <button class="btn btn-dark btn-sm w-100 orbitron p-2" 
                                        style="font-size: 0.65rem; opacity: 0.6; cursor: not-allowed;" 
                                        disabled 
                                        title="Lengkapi data profil Anda terlebih dahulu.">
                                    <i class="fas fa-lock mr-1"></i> INPUT LAPORAN (KUNCI)
                                </button>
                            <?php elseif ($isOpen): ?>
                                <a href="<?= base_url('user/laporan') ?>" 
                                   class="btn btn-outline-danger btn-sm w-100 orbitron p-2" 
                                   style="font-size: 0.65rem;">
                                    <i class="fas fa-plus mr-1"></i> INPUT LAPORAN MINGGUAN
                                </a>
                            <?php else: ?>
                                <button class="btn btn-dark btn-sm w-100 orbitron p-2" 
                                        style="font-size: 0.65rem; opacity: 0.6; cursor: not-allowed;" 
                                        disabled 
                                        title="Pengiriman laporan ditutup sementara.">
                                    <i class="fas fa-lock mr-1"></i> BELUM BISA DIAKSES
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CHART ANALYTICS -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="hud-card border-0 shadow-lg" style="background: rgba(15, 23, 42, 0.4);">
                <div class="hud-header bg-dark text-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                    <div class="orbitron" style="font-size: 0.9rem; letter-spacing: 1px;"><i class="fas fa-chart-line mr-2"></i> ANALISIS PERFORMA KONTEN</div>
                    <div class="small text-secondary orbitron" style="font-size: 0.6rem;">Data 7 Laporan Terakhir</div>
                </div>
                <div class="hud-body p-4">
                    <div style="height: 300px;">
                        <canvas id="kreatorChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TIERING ROADMAP GUIDE -->
    <div class="row mb-5">
        <div class="col-12 mb-3">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-danger text-white px-3 py-1 orbitron small shadow-sm" style="clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
                    KETENTUAN PROMOSI PANGKAT
                </div>
                <div class="ml-3 text-secondary small orbitron" style="opacity: 0.8; letter-spacing: 1px;">
                    Persyaratan Ambang Batas Metrik Evaluasi
                </div>
            </div>
            
            <div class="alert alert-dark border-0 text-white shadow-sm" style="background: rgba(255, 255, 255, 0.05); border-left: 3px solid rgba(255,255,255,0.2) !important;">
                <i class="fas fa-info-circle text-muted mr-2"></i>
                <span class="small orbitron" style="line-height: 1.5; color: #cbd5e1;">
                    <strong>SYARAT KENAIKAN PANGKAT:</strong> Untuk mencapai Pangkat tertentu, Anda <strong>WAJIB</strong> memenuhi <strong>TARGET MINIMAL CCV</strong> <u>DAN</u> <strong>SALAH SATU</strong> dari Target Views (<strong>YouTube</strong> atau <strong>TikTok</strong>).
                </span>
            </div>
        </div>

        <?php foreach ($allTiers as $t): 
            $isCurrent = ($tier['name'] == $t['name']);
        ?>
            <div class="col-lg-4 mb-4">
                <div class="hud-card h-100 <?= $isCurrent ? 'border-danger' : '' ?>" style="background: <?= $isCurrent ? 'rgba(234, 25, 23, 0.05)' : 'rgba(15, 23, 42, 0.4)' ?>; border: 1px solid <?= $isCurrent ? 'var(--bs-red)' : 'rgba(255,255,255,0.05)' ?>;">
                    <div class="p-4 text-center">
                        <?php if($isCurrent): ?>
                            <div class="badge bg-danger orbitron mb-3 py-2 px-3" style="font-size: 0.6rem; letter-spacing: 2px;">PANGKAT SAAT INI</div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <i class="fas <?= $t['icon_style'] ?> fa-3x" style="color: <?= $t['color_style'] ?>; text-shadow: 0 0 15px <?= $t['color_style'] ?>80;"></i>
                        </div>
                        <h4 class="orbitron fw-bold text-white mb-4"><?= strtoupper($t['display_name'] ?? $t['name']) ?></h4>
                        
                        <div class="row text-start g-2">
                            <div class="col-12 mb-2">
                                <div class="p-2 rounded bg-dark border-start border-warning" style="border-width: 3px !important; border-color: rgba(255,255,255,0.15) !important;">
                                    <div class="small text-secondary orbitron" style="font-size: 0.6rem;">TARGET MINIMAL CCV</div>
                                    <div class="orbitron text-white fw-bold"><?= number_format($t['threshold_ccv']) ?> <span class="small text-muted">VIEWERS</span></div>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-1 mt-1 text-center">
                                <span class="orbitron text-muted" style="font-size: 0.55rem; letter-spacing: 1px;">- DAN SALAH SATU DARI -</span>
                            </div>
                            
                            <div class="col-12 mb-2">
                                <div class="p-2 rounded bg-dark border-start border-danger" style="border-width: 3px !important; border-color: rgba(255,255,255,0.15) !important;">
                                    <div class="small text-secondary orbitron" style="font-size: 0.6rem;">VIEWS (YOUTUBE)</div>
                                    <div class="orbitron text-white fw-bold"><?= number_format($t['threshold_yt']) ?> <span class="small text-muted">VIEWS</span></div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="p-2 rounded bg-dark border-start border-info" style="border-width: 3px !important; border-color: rgba(255,255,255,0.15) !important;">
                                    <div class="small text-secondary orbitron" style="font-size: 0.6rem;">VIEWS (TIKTOK)</div>
                                    <div class="orbitron text-white fw-bold"><?= number_format($t['threshold_tt']) ?> <span class="small text-muted">VIEWS</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- TIER PROGRESS -->
    <div class="row">
        <div class="col-lg-12">
            <div class="hud-card" style="border-left: 4px solid #fff;">
                <div class="hud-header d-flex justify-content-between align-items-center" style="color: #fff;">
                    <div><i class="fas fa-chart-line mr-2"></i> STATISTIK BULAN INI</div>
                </div>
                <div class="hud-body text-center p-5">
                    <div class="display-3 mb-2" style="color: <?= $projectedTier['color'] ?>; text-shadow: 0 0 20px <?= $projectedTier['color'] ?>80;"><i class="<?= $projectedTier['icon'] ?>"></i></div>
                    <h3 class="orbitron text-white text-uppercase font-weight-bold mb-2"><?= $projectedTier['label'] ?></h3>
                    <div class="small text-secondary orbitron mb-4" style="letter-spacing: 1px;">(PROYEKSI PANGKAT BULAN DEPAN)</div>
                    
                    <?php if(isset($nextTier) && $nextTier): ?>
                        <div class="row text-left orbitron small text-white-50 mb-4">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>TARGET PEAK CCV</span>
                                    <span><?= number_format($currentMetrics['peak_ccv']) ?> / <?= number_format($nextTier['threshold_ccv']) ?></span>
                                </div>
                                <div class="progress bg-dark" style="height: 6px;">
                                    <?php $ccvPerc = min(100, ($currentMetrics['peak_ccv'] / $nextTier['threshold_ccv']) * 100); ?>
                                    <div class="progress-bar <?= $ccvPerc >= 100 ? 'bg-success' : 'bg-danger' ?>" style="width: <?= $ccvPerc ?>%"></div>
                                </div>
                            </div>

                            <?php if(($kreator['platform'] ?? '') == 'youtube'): ?>
                                <!-- YouTube -->
                                <div class="col-md-8 mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>TARGET AVG VIEWS (YOUTUBE)</span>
                                        <span><?= number_format($currentMetrics['yt_avg']) ?> / <?= number_format($nextTier['threshold_yt']) ?></span>
                                    </div>
                                    <div class="progress bg-dark" style="height: 6px;">
                                        <?php $bestAvg = min(100, ($currentMetrics['yt_avg'] / $nextTier['threshold_yt']) * 100); ?>
                                        <div class="progress-bar <?= $bestAvg >= 100 ? 'bg-success' : 'bg-info' ?>" style="width: <?= $bestAvg ?>%"></div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- TikTok/Other -->
                                <div class="col-md-8 mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>TARGET AVG VIEWS (TIKTOK)</span>
                                        <span><?= number_format($currentMetrics['tt_avg']) ?> / <?= number_format($nextTier['threshold_tt']) ?></span>
                                    </div>
                                    <div class="progress bg-dark" style="height: 6px;">
                                        <?php $bestAvg = min(100, ($currentMetrics['tt_avg'] / $nextTier['threshold_tt']) * 100); ?>
                                        <div class="progress-bar <?= $bestAvg >= 100 ? 'bg-success' : 'bg-info' ?>" style="width: <?= $bestAvg ?>%"></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="alert alert-dark border-secondary text-center py-3 mb-0">
                            <div class="orbitron small text-white mb-2">TARGET BERIKUTNYA: <span class="text-danger"><?= strtoupper($nextTier['name']) ?></span></div>
                            <div class="small text-secondary">
                                <?php if($ccvPerc < 100 && $bestAvg < 100): ?>
                                    Tingkatkan Peak CCV dan Rata-rata Views Konten Anda!
                                <?php elseif($ccvPerc < 100): ?>
                                    Target Views Terpenuhi! Fokus tingkatkan <span class="text-white">Peak CCV</span> Anda.
                                <?php elseif($bestAvg < 100): ?>
                                    Peak CCV Terpenuhi! Fokus tingkatkan <span class="text-white">Rata-rata Views</span> Konten Anda.
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success bg-transparent border-success text-success orbitron mt-4 p-3">
                            <i class="fas fa-crown fa-2x mb-2"></i><br>
                            TINGKAT MAKSIMUM TERCAPAI (TIER 1). PERFORMA ANDA LUAR BIASA!
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('kreatorChart').getContext('2d');
        
        // Data dari Controller PHP
        const labels = <?= $chartLabels ?>;
        const ytData = <?= $chartYtViews ?>;
        const ttData = <?= $chartTtViews ?>;
        const ccvData = <?= $chartCcv ?>;

        const dataHasValue = labels.length > 0;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Total Views YouTube',
                        data: ytData,
                        borderColor: '#ea1917',
                        backgroundColor: 'rgba(234, 25, 23, 0.1)',
                        borderWidth: 2,
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#1e293b',
                        tension: 0,
                        yAxisID: 'y'
                    },
                    {
                        type: 'line',
                        label: 'Total Views TikTok',
                        data: ttData,
                        borderColor: '#0dcaf0',
                        backgroundColor: 'rgba(13, 202, 240, 0.1)',
                        borderWidth: 2,
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#1e293b',
                        tension: 0,
                        yAxisID: 'y'
                    },
                    {
                        type: 'line',
                        label: 'Peak CCV (Live)',
                        data: ccvData,
                        borderColor: '#ffc107',
                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#1e293b',
                        tension: 0,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        labels: { color: '#cbd5e1', font: { family: 'Inter' } }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { family: 'Orbitron', size: 13 },
                        bodyFont: { family: 'Inter', size: 12 },
                        padding: 12,
                        borderColor: '#ea1917',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#94a3b8' }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#94a3b8' }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: { color: '#ffc107' }
                    }
                }
            }
        });
    });
</script>
