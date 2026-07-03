<div class="container-fluid py-4">

    <!-- HEADER STATUS DASHBOARD -->
    <div class="d-flex align-items-center mb-4">
        <div class="bg-danger text-white px-3 py-1 orbitron small shadow-sm" style="clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
            Admin Dashboard
        </div>
        <div class="ml-2 text-secondary small orbitron" style="opacity: 0.8; letter-spacing: 1px;">
            Statistik Perkembangan Kreator Bloodstrike
        </div>
    </div>

    <!-- STATISTIK RINGKAS PRESTASI & OPERASIONAL -->
    <div class="row mb-4">
        <!-- TIKTOK STATS -->
        <div class="col-md-3">
            <div class="hud-card h-100 shadow-lg" style="border-left: 4px solid #000; background: linear-gradient(135deg, rgba(0,0,0,0.85) 0%, rgba(20,20,20,0.9) 100%); padding: 22px;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="text-white-50 small fw-bold"><i class="fab fa-tiktok mr-2"></i> TIKTOK</div>
                    <?php if ($stats_tt['trend'] != 0): ?>
                        <div class="orbitron fw-bold <?= $stats_tt['trend'] > 0 ? 'text-success' : 'text-danger' ?>" style="font-size: 0.6rem;">
                            <i class="fas fa-caret-<?= $stats_tt['trend'] > 0 ? 'up' : 'down' ?> mr-1"></i><?= number_format(abs($stats_tt['trend']), 1) ?>%
                        </div>
                    <?php endif; ?>
                </div>
                <div class="orbitron h3 text-white mb-1" style="letter-spacing: 1px;"><?= number_format($stats_tt['total']) ?></div>
                <div class="text-secondary small fw-bold" style="font-size: 0.6rem; letter-spacing: 2px;">TAYANGAN BULAN INI</div>
            </div>
        </div>

        <!-- YOUTUBE STATS -->
        <div class="col-md-3">
            <div class="hud-card h-100 shadow-lg" style="border-left: 4px solid var(--bs-red); background: linear-gradient(135deg, rgba(45,18,18,0.85) 0%, rgba(15,23,42,0.9) 100%); padding: 22px;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="text-white-50 small fw-bold"><i class="fab fa-youtube mr-2"></i> YOUTUBE</div>
                    <?php if ($stats_yt['trend'] != 0): ?>
                        <div class="orbitron fw-bold <?= $stats_yt['trend'] > 0 ? 'text-success' : 'text-danger' ?>" style="font-size: 0.6rem;">
                            <i class="fas fa-caret-<?= $stats_yt['trend'] > 0 ? 'up' : 'down' ?> mr-1"></i><?= number_format(abs($stats_yt['trend']), 1) ?>%
                        </div>
                    <?php endif; ?>
                </div>
                <div class="orbitron h3 text-white mb-1" style="letter-spacing: 1px;"><?= number_format($stats_yt['total']) ?></div>
                <div class="text-secondary small fw-bold" style="font-size: 0.6rem; letter-spacing: 2px;">TAYANGAN BULAN INI</div>
            </div>
        </div>

        <!-- ANTRIAN VERIFIKASI -->
        <div class="col-md-3">
            <div class="hud-card h-100 shadow-lg" style="border-left: 4px solid #ffba08; background: linear-gradient(135deg, rgba(43,36,0,0.85) 0%, rgba(15,23,42,0.9) 100%); padding: 22px;">
                <div class="text-white-50 small fw-bold mb-3"><i class="fas fa-tasks mr-2"></i> VERIFIKASI</div>
                <div class="orbitron h3 mb-1 <?= $total_pending > 0 ? 'text-warning' : 'text-success' ?>" style="letter-spacing: 1px;"><?= $total_pending ?></div>
                <div class="text-secondary small fw-bold" style="font-size: 0.6rem; letter-spacing: 2px;">ANTRIAN VERIFIKASI</div>
            </div>
        </div>

        <!-- TOTAL KREATOR -->
        <div class="col-md-3">
            <div class="hud-card h-100 shadow-lg" style="border-left: 4px solid #ffffff; background: linear-gradient(135deg, rgba(30,30,30,0.85) 0%, rgba(15,23,42,0.9) 100%); padding: 22px;">
                <div class="text-white-50 small fw-bold mb-3"><i class="fas fa-user-shield mr-2"></i> TOTAL USER</div>
                <div class="orbitron h3 text-white mb-1" style="letter-spacing: 1px;"><?= $total_kreators ?></div>
                <div class="text-secondary small fw-bold" style="font-size: 0.6rem; letter-spacing: 2px;">KREATOR TERDAFTAR</div>
            </div>
        </div>
    </div>


    <!-- KONTROL AKSES PENGIRIMAN -->
    <div class="row mb-4">
        <div class="col-12">
            <?php
                $seg_active_styles = [
                    0 => 'background: rgba(23, 162, 184, 0.15); color: #17a2b8; border-color: rgba(23,162,184,0.4);',
                    1 => 'background: rgba(40, 167, 69, 0.15); color: #28a745; border-color: rgba(40,167,69,0.4);',
                    2 => 'background: rgba(220, 53, 69, 0.15); color: #dc3545; border-color: rgba(220,53,69,0.4);',
                ];
                $seg_inactive = 'background: transparent; color: rgba(255,255,255,0.3); border-color: rgba(255,255,255,0.07);';
                $seg_info_text = [
                    0 => 'Form dibuka otomatis setiap Senin — Rabu.',
                    1 => 'Form dibuka paksa setiap hari tanpa batasan jadwal.',
                    2 => 'Form ditutup paksa, kreator tidak bisa mengirim laporan.',
                ];
            ?>
            <div style="background: rgba(15,23,42,0.4); border: 1px solid rgba(255,255,255,0.06); padding: 20px 24px;">
                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 16px;">
                    <!-- Label Kiri -->
                    <div>
                        <div class="orbitron text-white fw-bold" style="font-size: 0.75rem; letter-spacing: 1.5px; margin-bottom: 4px;">AKSES PENGIRIMAN LAPORAN</div>
                        <div class="text-muted" style="font-size: 0.68rem;"><?= $seg_info_text[$mode_akses_form] ?></div>
                    </div>

                    <!-- Segmented Control (POST + CSRF aman) -->
                    <div class="d-flex" style="border: 1px solid rgba(255,255,255,0.08); border-radius: 2px; overflow: hidden; gap: 0;">
                        <?php foreach ([0 => 'Otomatis', 1 => 'Buka Akses', 2 => 'Tutup Akses'] as $val => $label): ?>
                            <?php if ($mode_akses_form == $val): ?>
                                <!-- Tombol aktif — tidak bisa diklik -->
                                <span style="display: inline-flex; align-items: center; justify-content: center;
                                    padding: 8px 20px; font-size: 0.68rem; letter-spacing: 1px; font-family: 'Orbitron', sans-serif;
                                    text-decoration: none; border: 1px solid transparent; cursor: default; pointer-events: none;
                                    <?= $seg_active_styles[$val] ?>"><?= strtoupper($label) ?></span>
                            <?php else: ?>
                                <!-- Tombol tidak aktif — submit via POST+CSRF -->
                                <form method="POST" action="<?= base_url('admin/laporan/toggle') ?>" style="margin:0; padding:0;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="mode" value="<?= $val ?>">
                                    <button type="submit" style="display: inline-flex; align-items: center; justify-content: center;
                                        padding: 8px 20px; font-size: 0.68rem; letter-spacing: 1px; font-family: 'Orbitron', sans-serif;
                                        text-decoration: none; border: 1px solid transparent; background: none; cursor: pointer; transition: all 0.2s ease; white-space: nowrap;
                                        <?= $seg_inactive ?>"><?= strtoupper($label) ?></button>
                                </form>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- TOP 5 LEADERBOARD -->
        <div class="col-lg-7">
            <div class="hud-card mb-4 border-0 shadow-lg">
                <div class="hud-header d-flex justify-content-between align-items-center bg-dark text-white border-bottom-0 py-3">
                    <div class="orbitron" style="font-size: 0.9rem; letter-spacing: 1px;"><i class="fas fa-trophy mr-2"></i> TOP TIER KREATOR</div>
                    <div class="small orbitron text-secondary" style="font-size: 0.6rem;">Berdasarkan Akumulasi Tayangan</div>
                </div>
                <div class="hud-body p-0" style="background: rgba(15, 23, 42, 0.4);">
                    <div class="table-responsive">
                        <table class="table table-tactical mb-0">
                            <thead>
                                <tr style="background: rgba(255,255,255,0.02);">
                                    <th class="ps-4 py-3">POSISI</th>
                                    <th class="py-3">NAMA KREATOR</th>
                                    <th class="py-3">TIER</th>
                                    <th class="pe-4 py-3 text-end">TOTAL TAYANGAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $rank = 1; foreach ($top_5 as $k): ?>
                                    <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.03);">
                                        <td class="ps-4 align-middle text-muted"><?= $rank++ ?></td>
                                        <td class="align-middle d-flex align-items-center py-3">
                                            <img src="<?= base_url('assets/img/profile/blood-strike.jpg') ?>" 
                                                 class="rounded-circle border border-secondary shadow-sm mr-3" width="35" height="35" style="object-fit: cover;">
                                            <div class="fw-bold text-white"><?= esc($k['nama']) ?></div>
                                        </td>
                                        <td class="align-middle px-4">
                                            <div class="d-flex align-items-center">
                                                <i class="<?= $k['tier_icon'] ?> mr-2" style="color: <?= $k['tier_color'] ?>; text-shadow: <?= $k['tier_glow'] ?>;" title="<?= $k['tier_label'] ?>"></i>
                                                <span class="orbitron text-white fw-bold" style="font-size: 0.65rem;"><?= $k['tier_label'] ?></span>
                                            </div>
                                        </td>
                                        <td class="pe-4 align-middle text-end text-danger orbitron small fw-bold">
                                            <?= number_format($k['total_views']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TIER DISTRIBUTION / SUMMARY -->
        <div class="col-lg-5">
            <div class="hud-card mb-4 border-0">
                <div class="hud-header bg-dark text-white border-bottom-0 py-3">
                    <div class="orbitron" style="font-size: 0.9rem; letter-spacing: 1px;"><i class="fas fa-chart-pie mr-"></i> Tiering kreator</div>
                </div>
                <div class="hud-body shadow-sm">
                    <?php 
                        $total = array_sum($tier_dist); 
                        $colors = ['Tier 1' => '#FFD700', 'Tier 2' => '#C0C0C0', 'Tier 3' => '#CD7F32', 'Kreator Baru' => '#94a3b8'];
                        foreach ($tier_dist as $label => $count): 
                            $pct = $total > 0 ? ($count / $total) * 100 : 0;
                    ?>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="orbitron small" style="color: <?= $colors[$label] ?>;"><i class="fas fa-check-circle mr-1"></i> <?= $label ?></span>
                                <span class="text-white small fw-bold"><?= $count ?> Kreator</span>
                            </div>
                            <div class="progress bg-dark" style="height: 6px;">
                                <div class="progress-bar" style="background: <?= $colors[$label] ?>; width: <?= $pct ?>%;"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- GRAFIK ANALISIS KPI KREATOR (TREN BULANAN) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="hud-card shadow-lg p-0" style="border-left: 4px solid var(--bs-red); overflow: hidden;">
                <div class="hud-header bg-dark text-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                    <div class="orbitron" style="font-size: 0.9rem; letter-spacing: 1.5px;">
                        <i class="fas fa-chart-line mr-2"></i> ANALISIS TREN TAYANGAN
                    </div>
                    <div class="small orbitron text-secondary" style="font-size: 0.6rem;">6 BULAN TERAKHIR</div>
                </div>
                <div class="hud-body" style="background: rgba(15, 23, 42, 0.4); padding: 25px;">
                    <div style="height: 300px;">
                        <canvas id="kpiTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('kpiTrendChart').getContext('2d');
            
            // Konfigurasi Gradien TikTok (Hitam-Abu)
            const ttGradient = ctx.createLinearGradient(0, 0, 0, 400);
            ttGradient.addColorStop(0, 'rgba(0, 0, 0, 0.4)');
            ttGradient.addColorStop(1, 'rgba(0, 0, 0, 0)');

            // Konfigurasi Gradien YouTube (Merah)
            const ytGradient = ctx.createLinearGradient(0, 0, 0, 400);
            ytGradient.addColorStop(0, 'rgba(234, 25, 23, 0.3)');
            ytGradient.addColorStop(1, 'rgba(234, 25, 23, 0)');

            const kpiChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($chart['labels']) ?>,
                    datasets: [
                        {
                            label: 'TIKTOK VIEWS',
                            data: <?= json_encode($chart['tt']) ?>,
                            borderColor: '#0dcaf0',
                            backgroundColor: 'rgba(13, 202, 240, 0.1)',
                            borderWidth: 2,
                            pointStyle: 'circle',
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#1e293b',
                            tension: 0,
                            fill: true,
                            yAxisID: 'y'
                        },
                        {
                            label: 'YOUTUBE VIEWS',
                            data: <?= json_encode($chart['yt']) ?>,
                            borderColor: '#ea1917',
                            backgroundColor: 'rgba(234, 25, 23, 0.1)',
                            borderWidth: 2,
                            pointStyle: 'circle',
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#1e293b',
                            tension: 0,
                            fill: true,
                            yAxisID: 'y'
                        },
                        {
                            label: 'PEAK CCV (MAX)',
                            data: <?= json_encode($chart['ccv']) ?>,
                            borderColor: '#ffc107',
                            backgroundColor: 'rgba(255, 193, 7, 0.05)',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            pointStyle: 'circle',
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#1e293b',
                            tension: 0,
                            fill: false,
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
                            position: 'top',
                            labels: {
                                color: '#94a3b8',
                                font: { family: "'Orbitron', sans-serif", size: 10 }
                            }
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
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: {
                                color: '#94a3b8',
                                font: { family: "'Orbitron', sans-serif", size: 9 },
                                callback: function(value) { return value.toLocaleString(); }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: {
                                color: '#ffc107',
                                font: { family: "'Orbitron', sans-serif", size: 9 }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#94a3b8',
                                font: { family: "'Orbitron', sans-serif", size: 9 }
                            }
                        }
                    }
                }
            });
        });
    </script>
</div>
