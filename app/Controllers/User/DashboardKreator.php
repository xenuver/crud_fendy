<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\KreatorModel;
use App\Models\LaporanMingguanModel;

class DashboardKreator extends BaseController
{
    protected KreatorModel $kModel;
    protected LaporanMingguanModel $lModel;

    public function __construct()
    {
        $this->kModel = new KreatorModel();
        $this->lModel = new LaporanMingguanModel();
    }

    // Menampilkan Dashboard Utama untuk Kreator.
    public function index()
    {
        $id_game = session()->get('id_game');
        $kreator = $this->kModel->where('id_game', $id_game)->first();

        // Nilai default yang mencakup SEMUA yang dibutuhkan
        $defaultStats = [
            'peak_ccv' => 0,
            'yt_views' => 0,
            'yt_vids' => 0,
            'tt_views' => 0,
            'tt_vids' => 0,
            'yt_shorts_views' => 0,
            'yt_shorts_vids' => 0,
            'month_views' => 0,
            'month_vids' => 0,
            'month_ccv' => 0,
            'recent_metrics' => ['peak_ccv' => 0, 'yt_avg' => 0, 'tt_avg' => 0],
            'chart' => ['labels' => [], 'yt' => [], 'tt' => [], 'ccv' => []]
        ];

        $stats = $kreator ? $this->lModel->getPersonalStats($kreator['kreator_id']) : $defaultStats;

        $isProfileIncomplete = false;
        if ($kreator) {
            $isProfileIncomplete = (
                empty($kreator['alamat']) ||
                $kreator['alamat'] === '-' ||
                (empty($kreator['tiktok_link']) && empty($kreator['youtube_link']))
            );
        } else {
            $isProfileIncomplete = true;
        }

        $hasSubmittedYt = false;
        $hasSubmittedTt = false;
        if ($kreator) {
            $hasSubmittedYt = $this->lModel->where('kreator_id', $kreator['kreator_id'])
                ->where('platform', 'youtube')
                ->where('created_at >=', date('Y-m-d 00:00:00', strtotime('monday this week')))
                ->where('created_at <=', date('Y-m-d 23:59:59', strtotime('sunday this week')))
                ->countAllResults() > 0;
            $hasSubmittedTt = $this->lModel->where('kreator_id', $kreator['kreator_id'])
                ->where('platform', 'tiktok')
                ->where('created_at >=', date('Y-m-d 00:00:00', strtotime('monday this week')))
                ->where('created_at <=', date('Y-m-d 23:59:59', strtotime('sunday this week')))
                ->countAllResults() > 0;
        }

        $activeTier = $stats['prev_month_tier'] ?? [
            'name' => 'Tier 4',
            'label' => 'Kreator Baru',
            'icon' => 'fas fa-user-shield',
            'color' => '#94a3b8'
        ];

        $projectedTier = $stats['curr_month_tier'] ?? [
            'name' => 'Tier 4',
            'label' => 'Kreator Baru',
            'icon' => 'fas fa-user-shield',
            'color' => '#94a3b8'
        ];

        if ($kreator) {
            $kreator['tier_label'] = $activeTier['label'];
            $kreator['tier_icon'] = $activeTier['icon'];
            $kreator['tier_color'] = $activeTier['color'];
        }

        $tierProgress = $this->kModel->calculateNextTier($stats['recent_metrics']);

        $tiersWithStyle = array_reverse($tierProgress['all']);
        $tierColors = ['#FFD700', '#C0C0C0', '#CD7F32'];
        $tierIcons = ['fa-crown', 'fa-medal', 'fa-medal'];

        foreach ($tiersWithStyle as $idx => &$t) {
            $t['color_style'] = $tierColors[$idx] ?? '#94a3b8';
            $t['icon_style'] = $tierIcons[$idx] ?? 'fa-medal';
        }

        $data = [
            'judul' => 'Dasbor Kreator',
            'kreator' => $kreator,
            'totalViews' => $stats['month_views'],
            'totalCcv' => $stats['month_ccv'],
            'totalVideo' => $stats['month_vids'],
            'currentMetrics' => $stats['recent_metrics'],
            'nextTier' => $tierProgress['next'],
            'allTiers' => $tiersWithStyle,
            'tier' => $activeTier,
            'projectedTier' => $projectedTier,
            'chartLabels' => json_encode($stats['chart']['labels']),
            'chartYtViews' => json_encode($stats['chart']['yt']),
            'chartTtViews' => json_encode($stats['chart']['tt']),
            'chartCcv' => json_encode($stats['chart']['ccv']),
            'isOpen' => $this->isSubmissionOpen(),
            'hasSubmittedYt' => $hasSubmittedYt,
            'hasSubmittedTt' => $hasSubmittedTt,
            'isProfileIncomplete' => $isProfileIncomplete,
        ];

        return $this->renderView("user/dashboard_utama", $data);
    }
}
