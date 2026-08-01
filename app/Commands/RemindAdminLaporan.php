<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\LaporanMingguanModel;
use App\Libraries\OneSignalService;

// Perintah CLI untuk memeriksa & mengirim notifikasi pengingat laporan pending ke Admin.
class RemindAdminLaporan extends BaseCommand
{
    protected $group       = 'Admin Reminder';
    protected $name        = 'remind:admin';
    protected $description = 'Pemeriksaan otomatis & pengiriman Web Push Notification laporan pending ke Admin.';

    public function run(array $params)
    {
        CLI::write('=== MEMULAI PEMERIKSAAN LAPORAN PENDING ===', 'yellow');

        $lModel = new LaporanMingguanModel();
        $pendingCount = $lModel->where('status_validasi', 'pending')->countAllResults();

        if ($pendingCount === 0) {
            CLI::write('✅ Tidak ada laporan pending. Pengiriman notifikasi dilewati.', 'green');
            return;
        }

        CLI::write("⚠️ Ditemukan {$pendingCount} laporan mingguan pending.", 'red');
        CLI::write('Mengirimkan Web Push Notification ke Admin...', 'cyan');

        $title   = 'Pengingat Laporan Pending';
        $message = "Terdapat {$pendingCount} laporan mingguan kreator yang belum diverifikasi.";
        $url     = base_url('admin/laporan');

        $oneSignal = new OneSignalService();
        $result    = $oneSignal->sendNotification($title, $message, $url);

        if ($result['success']) {
            CLI::write("✅ Notifikasi berhasil dikirim via OneSignal REST API. ID: " . ($result['response']['id'] ?? '-'), 'green');
        } else {
            CLI::error("❌ Gagal mengirim notifikasi: " . ($result['message'] ?? json_encode($result)));
        }

        CLI::write('=== PEMERIKSAAN SELESAI ===', 'yellow');
    }
}
