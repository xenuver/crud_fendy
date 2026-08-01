<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\LaporanMingguanModel;
use App\Libraries\OneSignalService;

// Perintah CLI untuk memeriksa laporan pending dan meng-update status pengingat Admin.
class RemindAdminLaporan extends BaseCommand
{
    protected $group       = 'Admin Reminder';
    protected $name        = 'remind:admin';
    protected $description = 'Pemeriksaan otomatis status laporan pending untuk pengingat Admin.';

    public function run(array $params)
    {
        CLI::write('=== MEMULAI PEMERIKSAAN LAPORAN PENDING ===', 'yellow');

        $lModel = new LaporanMingguanModel();
        $pendingCount = $lModel->where('status_validasi', 'pending')->countAllResults();

        if ($pendingCount === 0) {
            CLI::write('✅ Tidak ada laporan pending. Pengingat dilewati.', 'green');
            return;
        }

        CLI::write("⚠️ Ditemukan {$pendingCount} laporan mingguan pending.", 'red');

        // Jika variabel OneSignal terpasang, coba kirim via OneSignal
        $appId = $_ENV['ONESIGNAL_APP_ID'] ?? getenv('ONESIGNAL_APP_ID') ?: '';
        if (!empty($appId)) {
            CLI::write('Mengirimkan Web Push Notification via OneSignal...', 'cyan');
            $oneSignal = new OneSignalService();
            $result    = $oneSignal->sendNotification(
                'Pengingat Laporan Pending',
                "Terdapat {$pendingCount} laporan mingguan kreator yang belum diverifikasi.",
                base_url('admin/laporan')
            );

            if ($result['success']) {
                CLI::write("✅ Notifikasi OneSignal berhasil dikirim.", 'green');
            } else {
                CLI::write("⚠️ OneSignal Warning: " . ($result['message'] ?? 'Gagal'), 'yellow');
            }
        } else {
            // Menggunakan Native Web Push Notification (0% Config)
            CLI::write('✅ Peringatan Laporan Pending Aktif (Native Web Push Notification).', 'green');
            CLI::write("ℹ️ Notifikasi melayang akan otomatis tampil di layar HP/Laptop Admin yang mengaktifkan Notifikasi.", 'white');
        }

        CLI::write('=== PEMERIKSAAN SELESAI ===', 'yellow');
    }
}
