<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KreatorModel;
use App\Models\LaporanMingguanModel;
use App\Models\SettingModel;

class DashboardUtama extends BaseController
{
    protected KreatorModel $kModel;
    protected LaporanMingguanModel $lModel;
    protected SettingModel $sModel;

    public function __construct()
    {
        $this->kModel = new KreatorModel();
        $this->lModel = new LaporanMingguanModel();
        $this->sModel = new SettingModel();
    }

    /**
     * Halaman index Dashboard Admin.
     * Menyiapkan data statistik global, distribusi tier, dan metrik kreator.
     */
    public function index()
    {
        $kreators    = $this->kModel->getKreatorsWithMetrics();
        $globalStats = $this->lModel->getGlobalStats();
        $chartData   = $this->lModel->getChartData();
        $tierDist    = $this->kModel->getTierDistribution($kreators);
        
        $submissionOv = $this->sModel->getSubmissionOverride();
        $mode_akses_form = $submissionOv ?? 0;
        $data_kontrol_akses = [
            'value'       => $mode_akses_form,
            'card_border' => match($mode_akses_form) { 1 => 'var(--bs-success)', 2 => 'var(--bs-danger)', default => 'rgba(255,255,255,0.05)' },
            'icon_class'  => match($mode_akses_form) { 1 => 'fa-unlock-alt text-success', 2 => 'fa-ban text-danger', default => 'fa-sync-alt text-info' },
            'status_label'=> match($mode_akses_form) { 1 => 'AKSES DIBUKA', 2 => 'AKSES DITUTUP', default => 'JADWAL OTOMATIS' },
            'status_color'=> match($mode_akses_form) { 1 => '#28a745', 2 => '#dc3545', default => '#17a2b8' }
        ];

        $data = [
            'judul'         => 'Pusat Komando Admin',
            'kreators'      => $kreators,
            'top_5'         => array_slice($kreators, 0, 5),
            'total_kreators'  => count($kreators),
            'total_pending' => $this->lModel->where('status_validasi', 'pending')->countAllResults(),
            'stats_tt'      => $globalStats['tt'],
            'stats_yt'      => $globalStats['yt'],
            'chart'         => $chartData,
            'tier_dist'     => $tierDist,
            'kontrol_akses'   => $data_kontrol_akses,
            'mode_akses_form' => $mode_akses_form
        ];

        return $this->renderView('admin/dashboard_utama', $data);
    }

    /**
     * Mengubah mode pengiriman laporan (Auto/Buka Paksa/Tutup Paksa).
     */
    public function toggle_submission()
    {
        $requestedMode = $this->request->getPost('mode');
        
        if ($requestedMode !== null) {
            $newValue = (int) $requestedMode;
        } else {
            $oldValue = $this->sModel->getSubmissionOverride();
            $newValue = ($oldValue + 1) % 3;
        }
        
        if ($this->sModel->updateSetting('form_submission_override', (string) $newValue)) {
            $statusMsg = match($newValue) {
                1 => 'DIBUKA SECARA PAKSA (Abaikan Jadwal)',
                2 => 'DITUTUP SECARA PAKSA (Meskipun Hari Senin-Rabu)',
                default => 'KEMBALI KE JADWAL OTOMATIS (Senin-Rabu)'
            };
            
            return redirect()->back()->with('success', 'Mode Pengiriman Laporan diubah ke: ' . $statusMsg);
        }
        
        return redirect()->back()->with('error', 'Gagal memperbarui konfigurasi.');
    }
}
