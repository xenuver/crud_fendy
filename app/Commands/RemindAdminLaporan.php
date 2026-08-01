<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\LaporanMingguanModel;
use App\Models\UserModel;
use App\Libraries\EmailNotificationService;

// Perintah CLI untuk pengiriman Email Notifikasi Pengingat Laporan Pending ke Admin.
class RemindAdminLaporan extends BaseCommand
{
    protected $group       = 'Admin Reminder';
    protected $name        = 'remind:admin';
    protected $description = 'Pemeriksaan otomatis & pengiriman Email Notifikasi laporan pending ke Admin.';

    public function run(array $params)
    {
        CLI::write('=== MEMULAI PEMERIKSAAN LAPORAN PENDING ===', 'yellow');

        $lModel = new LaporanMingguanModel();
        $pendingCount = $lModel->where('status_validasi', 'pending')->countAllResults();

        if ($pendingCount === 0) {
            CLI::write('✅ Tidak ada laporan pending. Pengiriman email pengingat dilewati.', 'green');
            return;
        }

        CLI::write("⚠️ Ditemukan {$pendingCount} laporan mingguan pending.", 'red');
        CLI::write('Mencari alamat email Admin...', 'cyan');

        $uModel = new UserModel();
        $admins = $uModel->whereIn('role', ['admin', 'super_admin'])->findAll();

        if (empty($admins)) {
            CLI::error('❌ Tidak ditemukan akun Admin/Super Admin di database.');
            return;
        }

        $emailService = new EmailNotificationService();
        $successCount = 0;

        foreach ($admins as $adm) {
            // Jika akun admin memiliki kolom email atau menggunakan username/email
            $email = $adm['email'] ?? $adm['username'] ?? '';
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                CLI::write("Mengirimkan email pengingat ke: {$email}...", 'white');
                $sent = $emailService->sendPendingReportReminder($email, $pendingCount);
                if ($sent) {
                    $successCount++;
                    CLI::write("  ✅ Email sukses terkirim ke {$email}", 'green');
                } else {
                    CLI::write("  ⚠️ Gagal mengirim email ke {$email}", 'yellow');
                }
            }
        }

        CLI::write("=== PEMERIKSAAN SELESAI: {$successCount} Email Pengingat Berhasil Terkirim ===", 'yellow');
    }
}
