<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanMingguanModel extends Model
{
    protected $table = 'laporan_mingguan';
    protected $primaryKey = 'laporan_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;

    protected $allowedFields = [
        'user_id',               // ID Pengguna yang mengisi laporan
        'nama_lengkap',          // Nama lengkap pengisi laporan
        'kreator_id',            // FK ke tabel kreator (Nama Channel)
        'platform',              // Platform utama laporan (tiktok/youtube)
        'jumlah_video',          // Jumlah video yang dibuat
        'total_views_video',     // Total views video
        'jumlah_shorts',         // NEW: Jumlah YT Shorts yang dibuat
        'views_shorts',          // NEW: Total views YT Shorts
        'jumlah_live',           // Jumlah live stream yang dibuat
        'total_views_live',      // Total views livestream
        'penonton_puncak_live',  // Jumlah penonton puncak (CCV)
        'foto_views_konten',     // Foto screenshot views konten
        'foto_views_shorts',     // NEW: Foto screenshot views YT Shorts
        'foto_views_livestream', // Foto screenshot views livestream
        'foto_penonton_puncak_live', // Foto screenshot bukti CCV
        'status_validasi',       // Status dari admin
        'pesan_admin',           // Feedback dari admin
        'is_read'                // NEW: Status notifikasi sudah dibaca/belum
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Menghitung Tier berdasarkan metrik akumulasi.
    // Syarat: CCV Target terpenuhi DAN salah satu target AVG Views (YT/TT) terpenuhi.
    public static function calculateTier($metrics): array
    {
        $sModel = new \App\Models\SettingModel();

        $t1_ccv = (int) $sModel->getSetting('tier1_ccv', 900);
        $t1_yt = (int) $sModel->getSetting('tier1_yt', 40000);
        $t1_tt = (int) $sModel->getSetting('tier1_tt', 80000);

        $t2_ccv = (int) $sModel->getSetting('tier2_ccv', 300);
        $t2_yt = (int) $sModel->getSetting('tier2_yt', 20000);
        $t2_tt = (int) $sModel->getSetting('tier2_tt', 50000);

        $t3_ccv = (int) $sModel->getSetting('tier3_ccv', 100);
        $t3_yt = (int) $sModel->getSetting('tier3_yt', 10000);
        $t3_tt = (int) $sModel->getSetting('tier3_tt', 30000);

        $ccv = (int) ($metrics['peak_ccv'] ?? 0);
        $yt = (int) ($metrics['yt_avg'] ?? 0); // Rata-rata gabungan views YouTube
        $tt = (int) ($metrics['tt_avg'] ?? 0); // Rata-rata gabungan views TikTok

        // Tier 1
        if ($ccv >= $t1_ccv && ($yt >= $t1_yt || $tt >= $t1_tt)) {
            return [
                'name' => 'Tier 1',
                'label' => 'Tier 1',
                'icon' => 'fas fa-check-circle',
                'color' => '#FFD700' // Gold
            ];
        }

        // Tier 2
        if ($ccv >= $t2_ccv && ($yt >= $t2_yt || $tt >= $t2_tt)) {
            return [
                'name' => 'Tier 2',
                'label' => 'Tier 2',
                'icon' => 'fas fa-check-circle',
                'color' => '#C0C0C0' // Silver
            ];
        }

        // Tier 3
        if ($ccv >= $t3_ccv && ($yt >= $t3_yt || $tt >= $t3_tt)) {
            return [
                'name' => 'Tier 3',
                'label' => 'Tier 3',
                'icon' => 'fas fa-check-circle',
                'color' => '#CD7F32' // Bronze
            ];
        }

        // DEFAULT (BELUM MASUK PANGKAT)
        return [
            'name' => 'Tier 4',
            'label' => 'Kreator Baru',
            'icon' => 'fas fa-user-shield',
            'color' => '#94a3b8'
        ];
    }

    // Mendapatkan statistik global untuk TikTok dan YouTube (perbandingan bulanan).
    public function getGlobalStats()
    {
        $bulanIni = date('m');
        $tahunIni = date('Y');

        $startBulanIni = sprintf('%04d-%02d-01 00:00:00', $tahunIni, $bulanIni);
        $endBulanIni = date('Y-m-t 23:59:59', strtotime($startBulanIni));

        $startBulanLalu = date('Y-m-01 00:00:00', strtotime('-1 month'));
        $endBulanLalu = date('Y-m-t 23:59:59', strtotime($startBulanLalu));

        // TIKTOK STATS
        $ttMonth = $this->selectSum('total_views_video')->selectSum('total_views_live')
            ->where('platform', 'tiktok')->where('status_validasi', 'valid')
            ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) >=', $startBulanIni)->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) <=', $endBulanIni)
            ->first();
        $ttLast = $this->selectSum('total_views_video')->selectSum('total_views_live')
            ->where('platform', 'tiktok')->where('status_validasi', 'valid')
            ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) >=', $startBulanLalu)->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) <=', $endBulanLalu)
            ->first();
        $ttTotal = ($ttMonth['total_views_video'] ?? 0) + ($ttMonth['total_views_live'] ?? 0);
        $ttPrev = ($ttLast['total_views_video'] ?? 0) + ($ttLast['total_views_live'] ?? 0);
        $ttTrend = $ttPrev > 0 ? (($ttTotal - $ttPrev) / $ttPrev) * 100 : 0;

        // YOUTUBE STATS
        $ytMonth = $this->selectSum('total_views_video')->selectSum('views_shorts')->selectSum('total_views_live')
            ->where('platform', 'youtube')->where('status_validasi', 'valid')
            ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) >=', $startBulanIni)->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) <=', $endBulanIni)
            ->first();
        $ytLast = $this->selectSum('total_views_video')->selectSum('views_shorts')->selectSum('total_views_live')
            ->where('platform', 'youtube')->where('status_validasi', 'valid')
            ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) >=', $startBulanLalu)->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) <=', $endBulanLalu)
            ->first();
        $ytTotal = ($ytMonth['total_views_video'] ?? 0) + ($ytMonth['views_shorts'] ?? 0) + ($ytMonth['total_views_live'] ?? 0);
        $ytPrev = ($ytLast['total_views_video'] ?? 0) + ($ytLast['views_shorts'] ?? 0) + ($ytLast['total_views_live'] ?? 0);
        $ytTrend = $ytPrev > 0 ? (($ytTotal - $ytPrev) / $ytPrev) * 100 : 0;

        return [
            'tt' => ['total' => $ttTotal, 'trend' => $ttTrend],
            'yt' => ['total' => $ytTotal, 'trend' => $ytTrend]
        ];
    }

    // Mendapatkan data grafik (chart) untuk beberapa bulan terakhir.
    public function getChartData(int $months = 6)
    {
        $chart_labels = [];
        $chart_tt = [];
        $chart_yt = [];
        $chart_ccv = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $month = date('m', strtotime("-$i month"));
            $year = date('Y', strtotime("-$i month"));
            $label = date('M Y', strtotime("-$i month"));
            $chart_labels[] = $label;

            $start = sprintf('%04d-%02d-01 00:00:00', $year, $month);
            $end = date('Y-m-t 23:59:59', strtotime($start));

            // TikTok Monthly
            $tt_data = $this->selectSum('total_views_video')->selectSum('total_views_live')
                ->where('platform', 'tiktok')->where('status_validasi', 'valid')
                ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) >=', $start)->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) <=', $end)
                ->first();
            $chart_tt[] = ($tt_data['total_views_video'] ?? 0) + ($tt_data['total_views_live'] ?? 0);

            // YouTube Monthly
            $yt_data = $this->selectSum('total_views_video')->selectSum('views_shorts')->selectSum('total_views_live')
                ->where('platform', 'youtube')->where('status_validasi', 'valid')
                ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) >=', $start)->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) <=', $end)
                ->first();
            $chart_yt[] = ($yt_data['total_views_video'] ?? 0) + ($yt_data['views_shorts'] ?? 0) + ($yt_data['total_views_live'] ?? 0);

            // CCV Monthly (Max CCV)
            $ccv_data = $this->selectMax('penonton_puncak_live')
                ->where('status_validasi', 'valid')
                ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) >=', $start)->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) <=', $end)
                ->first();
            $chart_ccv[] = (int) ($ccv_data['penonton_puncak_live'] ?? 0);
        }

        return [
            'labels' => $chart_labels,
            'tt' => $chart_tt,
            'yt' => $chart_yt,
            'ccv' => $chart_ccv
        ];
    }

    // Mendapatkan statistik personal untuk kreator tertentu.
    public function getPersonalStats(int $kreatorId)
    {
        $metricsData = $this->where('kreator_id', $kreatorId)
            ->where('status_validasi', 'valid')
            ->orderBy('created_at', 'ASC')
            ->findAll();

        $stats = [
            'peak_ccv' => 0,
            'yt_views' => 0,
            'yt_vids' => 0,
            'yt_shorts_views' => 0,
            'yt_shorts_vids' => 0,
            'tt_views' => 0,
            'tt_vids' => 0,
            // Stats Khusus Bulan Ini
            'month_views' => 0,
            'month_vids' => 0,
            'month_ccv' => 0,
            'chart' => [
                'labels' => [],
                'yt' => [],
                'tt' => [],
                'ccv' => []
            ],
            // Metrik Terbaru (Last 4 reports) untuk Tiering Dinamis
            'recent_metrics' => [
                'peak_ccv' => 0,
                'yt_avg' => 0,
                'yt_shorts_avg' => 0,
                'tt_avg' => 0
            ]
        ];

        $currentMonth = date('m');
        $currentYear = date('Y');
        $aggregated = [];

        foreach ($metricsData as $m) {
            $mDate = strtotime($m['created_at']);
            $dayOfWeek = (int) date('N', $mDate);
            $perfSunday = strtotime('-' . $dayOfWeek . ' days', $mDate);
            $isThisMonth = (date('m', $perfSunday) == $currentMonth && date('Y', $perfSunday) == $currentYear);

            // All Time Stats (for fallback)
            if ($m['penonton_puncak_live'] > $stats['peak_ccv']) {
                $stats['peak_ccv'] = $m['penonton_puncak_live'];
            }

            if ($m['platform'] == 'youtube') {
                $stats['yt_views'] += $m['total_views_video'];
                $stats['yt_vids'] += $m['jumlah_video'];
                $stats['yt_shorts_views'] += $m['views_shorts'];
                $stats['yt_shorts_vids'] += $m['jumlah_shorts'];

                if ($isThisMonth) {
                    $stats['month_views'] += ($m['total_views_video'] + $m['views_shorts']);
                    $stats['month_vids'] += ($m['jumlah_video'] + $m['jumlah_shorts']);
                }
            } else {
                $stats['tt_views'] += $m['total_views_video'];
                $stats['tt_vids'] += $m['jumlah_video'];

                if ($isThisMonth) {
                    $stats['month_views'] += $m['total_views_video'];
                    $stats['month_vids'] += $m['jumlah_video'];
                }
            }

            if ($isThisMonth && $m['penonton_puncak_live'] > $stats['month_ccv']) {
                $stats['month_ccv'] = $m['penonton_puncak_live'];
            }

            // Chart Data
            $dateLabel = date('d M', $perfSunday);
            if (!isset($aggregated[$dateLabel])) {
                $aggregated[$dateLabel] = ['yt' => 0, 'tt' => 0, 'ccv' => 0];
            }
            if ($m['platform'] == 'youtube') {
                $aggregated[$dateLabel]['yt'] += ($m['total_views_video'] + $m['views_shorts']);
            } else {
                $aggregated[$dateLabel]['tt'] += $m['total_views_video'];
            }
            $aggregated[$dateLabel]['ccv'] = max($aggregated[$dateLabel]['ccv'], $m['penonton_puncak_live']);
        }

        foreach ($aggregated as $label => $vals) {
            $stats['chart']['labels'][] = $label;
            $stats['chart']['yt'][] = $vals['yt'];
            $stats['chart']['tt'][] = $vals['tt'];
            $stats['chart']['ccv'][] = $vals['ccv'];
        }

        // --- TIERING DINAMIS (Berdasarkan Laporan Bulan Lalu & Bulan Ini) ---
        $startOfPrevMonth = date('Y-m-01 00:00:00', strtotime('first day of last month'));
        $endOfPrevMonth = date('Y-m-t 23:59:59', strtotime('first day of last month'));
        $startOfCurrMonth = date('Y-m-01 00:00:00');
        $endOfCurrMonth = date('Y-m-t 23:59:59');

        $stats['prev_month_tier'] = self::calculateTierForPeriod($kreatorId, $startOfPrevMonth, $endOfPrevMonth);
        $stats['curr_month_tier'] = self::calculateTierForPeriod($kreatorId, $startOfCurrMonth, $endOfCurrMonth);

        // Petakan recent_metrics ke metrik bulan berjalan untuk kalkulasi progres target tier
        $currReports = $this->where('kreator_id', $kreatorId)
            ->where('status_validasi', 'valid')
            ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) >=', $startOfCurrMonth)
            ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) <=', $endOfCurrMonth)
            ->orderBy('created_at', 'DESC')
            ->limit(4)
            ->findAll();

        if (!empty($currReports)) {
            $rPeak = 0;
            $rYtV = 0; // Total views gabungan YouTube (video + shorts + live)
            $rTtV = 0; // Total views gabungan TikTok (video + live)
            foreach ($currReports as $laporan) {
                $rPeak = max($rPeak, $laporan['penonton_puncak_live']);
                if ($laporan['platform'] == 'youtube') {
                    $rYtV += $laporan['total_views_video'] + ($laporan['views_shorts'] ?? 0) + ($laporan['total_views_live'] ?? 0);
                } else {
                    $rTtV += $laporan['total_views_video'] + ($laporan['total_views_live'] ?? 0);
                }
            }
            $stats['recent_metrics'] = [
                'peak_ccv' => $rPeak,
                'yt_avg'   => $rYtV / 4,
                'tt_avg'   => $rTtV / 4
            ];
        }

        return $stats;
    }

    // Menghitung Tier untuk Kreator berdasarkan laporan valid dalam periode tanggal tertentu.
    public static function calculateTierForPeriod(int $kreatorId, string $startDate, string $endDate): array
    {
        $lModel = new self();
        $reports = $lModel->where('kreator_id', $kreatorId)
            ->where('status_validasi', 'valid')
            ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) >=', $startDate)
            ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) <=', $endDate)
            ->orderBy('created_at', 'DESC')
            ->limit(4)
            ->findAll();

        if (empty($reports)) {
            return [
                'name' => 'Tier 4',
                'label' => 'Kreator Baru',
                'icon' => 'fas fa-user-shield',
                'color' => '#94a3b8'
            ];
        }

        $rPeak = 0;   // Penonton puncak live (CCV) tertinggi
        $rYtV = 0;    // Total views gabungan YouTube (video + shorts + live)
        $rTtV = 0;    // Total views gabungan TikTok (video + live)

        // --- TAHAP 1: PENJUMLAHAN AKUMULASI (Di dalam Loop) ---
        // Ulangi untuk membaca lembar laporan mingguan ($laporan) satu per satu
        foreach ($reports as $laporan) {
            // Cari penonton puncak live (CCV) paling tinggi di antara seluruh laporan
            $rPeak = max($rPeak, $laporan['penonton_puncak_live']);

            // Kelompokkan dan jumlahkan angka views berdasarkan platformnya
            if ($laporan['platform'] == 'youtube') {
                $rYtV += $laporan['total_views_video'] + ($laporan['views_shorts'] ?? 0) + ($laporan['total_views_live'] ?? 0);
            } else {
                $rTtV += $laporan['total_views_video'] + ($laporan['total_views_live'] ?? 0);
            }
        }

        // TAHAP 2: PEMBAGIAN RATA-RATA
        // Rumus: Total Views dibagi 4 (Minggu)
        $metrics = [
            'peak_ccv' => $rPeak,
            'yt_avg'   => $rYtV / 4,
            'tt_avg'   => $rTtV / 4
        ];

        return self::calculateTier($metrics);
    }
}
