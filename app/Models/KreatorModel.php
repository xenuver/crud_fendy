<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\LaporanMingguanModel;

// Model untuk mengelola data kreator
class KreatorModel extends Model
{
    // Nama tabel di database
    protected $table = 'kreator';
    // Primary key tabel
    protected $primaryKey = 'kreator_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;

    // Field yang diizinkan untuk diisi sesuai request
    protected $allowedFields = [
        'nama',
        'alamat',
        'id_game',
        'last_uid_update',
        'foto_profil',
        'tiktok_link',
        'youtube_link',
        'status'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true; // Set true jika tabel menggunakan field created_at dan updated_at
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Mengambil semua kreator beserta akumulasi metrik dan data tier.
    // Logika dipindahkan dari controller ke model untuk pemisahan tugas yang lebih baik.
    public function getKreatorsWithMetrics()
    {
        // 1. Ambil semua data kreator dasar (kecuali yang merupakan Admin)
        $kreators = $this->select('kreator.*')
            ->join('users', 'users.id_game = kreator.id_game', 'left')
            ->groupStart()
            ->where('users.role !=', 'admin')
            ->orWhere('users.role', null)
            ->groupEnd()
            ->findAll();
        $lModel = new LaporanMingguanModel();

        $startOfPrevMonth = date('Y-m-01 00:00:00', strtotime('first day of last month'));
        $endOfPrevMonth = date('Y-m-t 23:59:59', strtotime('first day of last month'));
        $startOfCurrMonth = date('Y-m-01 00:00:00');
        $endOfCurrMonth = date('Y-m-t 23:59:59');

        foreach ($kreators as &$k) {
            // 2. Ambil semua laporan valid bulan berjalan (untuk data statistik/views)
            $recentLaps = $lModel->where('kreator_id', $k['kreator_id'])
                ->where('status_validasi', 'valid')
                ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) >=', $startOfCurrMonth)
                ->where('DATE_SUB(created_at, INTERVAL WEEKDAY(created_at) + 1 DAY) <=', $endOfCurrMonth)
                ->orderBy('created_at', 'DESC')
                ->findAll();

            $rPeak = 0;
            $rYtV = 0;
            $rYtC = 0;
            $rYtSV = 0;
            $rYtSC = 0;
            $rYtLV = 0;
            $rTtV = 0;
            $rTtC = 0;
            $rTtLV = 0;
            if (!empty($recentLaps)) {
                foreach ($recentLaps as $laporan) {
                    $rPeak = max($rPeak, $laporan['penonton_puncak_live']);
                    if ($laporan['platform'] == 'youtube') {
                        $rYtV += $laporan['total_views_video'];
                        $rYtC += $laporan['jumlah_video'];
                        $rYtSV += $laporan['views_shorts'];
                        $rYtSC += $laporan['jumlah_shorts'];
                        $rYtLV += $laporan['total_views_live'];
                    } else {
                        $rTtV += $laporan['total_views_video'];
                        $rTtC += $laporan['jumlah_video'];
                        $rTtLV += $laporan['total_views_live'];
                    }
                }
            }

            $k['peak_ccv'] = $rPeak;
            $k['yt_views'] = $rYtV;
            $k['yt_vids'] = $rYtC;
            $k['yt_shorts_views'] = $rYtSV;
            $k['yt_shorts_vids'] = $rYtSC;
            $k['yt_live_views'] = $rYtLV;
            $k['tt_views'] = $rTtV;
            $k['tt_vids'] = $rTtC;
            $k['tt_live_views'] = $rTtLV;
            $k['total_views'] = $rYtV + $rYtSV + $rYtLV + $rTtV + $rTtLV;

            // 3. Hitung Pangkat Aktif (Bulan Lalu) & Proyeksi Pangkat (Bulan Ini)
            $activeTier = LaporanMingguanModel::calculateTierForPeriod($k['kreator_id'], $startOfPrevMonth, $endOfPrevMonth);
            $projectedTier = LaporanMingguanModel::calculateTierForPeriod($k['kreator_id'], $startOfCurrMonth, $endOfCurrMonth);

            // Set Pangkat Aktif sebagai pangkat utama di lists
            $k['tier_label'] = $activeTier['label'];
            $k['tier_icon'] = $activeTier['icon'];
            $k['tier_color'] = $activeTier['color'];
            $k['tier_glow'] = match ($activeTier['name']) {
                'Tier 1' => '0 0 15px rgba(255, 215, 0, 0.5)',
                'Tier 2' => '0 0 10px rgba(192, 192, 192, 0.4)',
                'Tier 3' => '0 0 8px rgba(205, 127, 50, 0.3)',
                default => 'none'
            };
            $k['tier_level'] = (int) filter_var($activeTier['name'], FILTER_SANITIZE_NUMBER_INT);

            // Set Proyeksi Pangkat
            $k['projected_tier_label'] = $projectedTier['label'];
            $k['projected_tier_icon'] = $projectedTier['icon'];
            $k['projected_tier_color'] = $projectedTier['color'];
            $k['projected_tier_level'] = (int) filter_var($projectedTier['name'], FILTER_SANITIZE_NUMBER_INT);
        }

        // Sort by tier first (1 is best), then by total views desc
        usort($kreators, function ($a, $b) {
            if ($a['tier_level'] === $b['tier_level']) {
                return $b['total_views'] <=> $a['total_views'];
            }
            return $a['tier_level'] <=> $b['tier_level'];
        });

        return $kreators;
    }

    public function processTiering(array $k): array
    {
        $metrics = [
            'peak_ccv' => $k['peak_ccv'] ?? 0,
            'yt_avg'   => (($k['yt_views'] ?? 0) + ($k['yt_shorts_views'] ?? 0) + ($k['yt_live_views'] ?? 0)) / 4,
            'tt_avg'   => (($k['tt_views'] ?? 0) + ($k['tt_live_views'] ?? 0)) / 4
        ];

        $tierData = LaporanMingguanModel::calculateTier($metrics);
        $k['tier_label'] = $tierData['label'];
        $k['tier_icon'] = $tierData['icon'];
        $k['tier_color'] = $tierData['color'];
        $k['tier_glow'] = match ($tierData['name']) {
            'Tier 1' => '0 0 15px rgba(255, 215, 0, 0.5)',
            'Tier 2' => '0 0 10px rgba(192, 192, 192, 0.4)',
            'Tier 3' => '0 0 8px rgba(205, 127, 50, 0.3)',
            default => 'none'
        };
        $k['tier_level'] = (int) filter_var($tierData['name'], FILTER_SANITIZE_NUMBER_INT);
        $k['total_views'] = ($k['yt_views'] ?? 0) + ($k['yt_shorts_views'] ?? 0) + ($k['yt_live_views'] ?? 0) + ($k['tt_views'] ?? 0) + ($k['tt_live_views'] ?? 0);

        return $k;
    }

    // Mengambil distribusi jumlah kreator berdasarkan tier mereka.
    public function getTierDistribution(array $kreators): array
    {
        $distribution = [
            'Tier 1' => 0,
            'Tier 2' => 0,
            'Tier 3' => 0,
            'Kreator Baru' => 0
        ];

        foreach ($kreators as $k) {
            $label = $k['tier_label'] ?? 'Kreator Baru';
            if (isset($distribution[$label])) {
                $distribution[$label]++;
            } else {
                $distribution['Kreator Baru']++;
            }
        }

        return $distribution;
    }

    // Menganalisis aktivitas kreator dan tren pertumbuhan views.
    public function analyzeActivity(array $k): array
    {
        $lModel = new LaporanMingguanModel();
        $laps = $lModel->where('kreator_id', $k['kreator_id'])
            ->where('status_validasi', 'valid')
            ->orderBy('created_at', 'DESC')
            ->limit(2)
            ->findAll();

        $k['active_status'] = 'danger';
        $k['status_text'] = 'INAKTIF';
        $k['trend_pct'] = 0;
        $k['trend_dir'] = 'neutral';

        if (count($laps) > 0) {
            $days = (time() - strtotime($laps[0]['created_at'])) / 86400;
            if ($days <= 10) {
                $k['active_status'] = 'success';
                $k['status_text'] = 'AKTIF';
            } else if ($days <= 21) {
                $k['active_status'] = 'warning';
                $k['status_text'] = 'SIAGA';
            }

            if (count($laps) == 2) {
                $c = $laps[0]['total_views_video'] + ($laps[0]['views_shorts'] ?? 0);
                $p = $laps[1]['total_views_video'] + ($laps[1]['views_shorts'] ?? 0);
                if ($p > 0) {
                    $k['trend_pct'] = (($c - $p) / $p) * 100;
                    $k['trend_dir'] = ($k['trend_pct'] > 1) ? 'up' : (($k['trend_pct'] < -1) ? 'down' : 'neutral');
                }
            }
        }

        return $k;
    }

    // Mendapatkan profil kreator atau membuatnya secara otomatis jika belum ada (misal untuk Admin).
    public function getOrCreateProfile(string $id_game, string $defaultName = 'Kreator'): array
    {
        $kreator = $this->where('id_game', $id_game)->first();

        if (!$kreator) {
            $this->insert([
                'id_game' => $id_game,
                'nama' => $defaultName ?: 'Kreator',
                'alamat' => 'Indonesia',
            ]);
            $kreator = $this->where('id_game', $id_game)->first();
        }

        return $kreator ?? ['id_game' => $id_game, 'nama' => $defaultName, 'foto_profil' => null];
    }

    // Memeriksa status cooldown perubahan UID (limit 30 hari).
    public function getUidCooldown(?array $kreator): array
    {
        if (!$kreator || empty($kreator['last_uid_update'])) {
            return ['can' => true, 'days' => 0];
        }

        $lastUpdate = new \DateTime($kreator['last_uid_update']);
        $now = new \DateTime();
        $diff = $now->diff($lastUpdate)->days;
        $canUpdateUid = $diff >= 30;
        $daysRemaining = $canUpdateUid ? 0 : (30 - $diff);

        return ['can' => $canUpdateUid, 'days' => $daysRemaining];
    }

    // Menghitung progres menuju tier berikutnya.
    public function calculateNextTier(array $currentMetrics): array
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

        $allTiers = [
            ['threshold_ccv' => $t3_ccv, 'threshold_yt' => $t3_yt, 'threshold_tt' => $t3_tt, 'name' => 'Tier 3', 'display_name' => 'Tier 3 (Bronze)'],
            ['threshold_ccv' => $t2_ccv, 'threshold_yt' => $t2_yt, 'threshold_tt' => $t2_tt, 'name' => 'Tier 2', 'display_name' => 'Tier 2 (Silver)'],
            ['threshold_ccv' => $t1_ccv, 'threshold_yt' => $t1_yt, 'threshold_tt' => $t1_tt, 'name' => 'Tier 1', 'display_name' => 'Tier 1 (Gold)'],
        ];

        $nextTier = null;
        foreach ($allTiers as $t) {
            $ccvMet = ($currentMetrics['peak_ccv'] ?? 0) >= $t['threshold_ccv'];
            $avgMet = (($currentMetrics['yt_avg'] ?? 0) >= $t['threshold_yt'] ||
                ($currentMetrics['tt_avg'] ?? 0) >= $t['threshold_tt']);

            if (!$ccvMet || !$avgMet) {
                $nextTier = $t;
                break;
            }
        }

        return ['next' => $nextTier, 'all' => $allTiers];
    }
}
