<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\KreatorModel;
use App\Libraries\EmailNotificationService;

// Perintah CLI untuk pengiriman Email Pengingat Submit Laporan Mingguan ke semua Kreator aktif.
// Jadwal: Setiap Jumat jam 17:00 WIB (10:00 UTC) → cron: 0 10 * * 5
class RemindKreatorLaporan extends BaseCommand
{
    protected $group       = 'Notification';
    protected $name        = 'remind:kreator';
    protected $description = 'Kirim email pengingat submit laporan mingguan ke semua kreator aktif yang memiliki email.';

    public function run(array $params)
    {
        CLI::write('=== MEMULAI PENGIRIMAN PENGINGAT LAPORAN KE KREATOR ===', 'yellow');

        $kreatorModel = new KreatorModel();
        $emailSvc     = new EmailNotificationService();

        // Ambil semua kreator aktif yang sudah punya email
        $kreators = $kreatorModel
            ->where('status', 'active')
            ->where('email IS NOT NULL', null, false)
            ->where('email !=', '')
            ->findAll();

        if (empty($kreators)) {
            CLI::write('⚠️  Tidak ada kreator aktif dengan email terdaftar.', 'yellow');
            CLI::write('=== SELESAI ===', 'yellow');
            return;
        }

        CLI::write('📋 Ditemukan ' . count($kreators) . ' kreator aktif dengan email.', 'green');

        $sukses = 0;
        $gagal  = 0;

        foreach ($kreators as $kreator) {
            $email = $kreator['email'] ?? '';
            $nama  = $kreator['nama']  ?? 'Kreator';

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                CLI::write("⚠️  Lewati {$nama}: Alamat email '{$email}' tidak valid.", 'yellow');
                $gagal++;
                continue;
            }

            CLI::write("📧 Mengirim pengingat ke: {$nama} ({$email})...", 'white');

            $terkirim = $emailSvc->sendReminderToKreator($email, $nama);

            if ($terkirim) {
                CLI::write("   ✅ Pengingat terkirim ke {$email}", 'green');
                $sukses++;
            } else {
                CLI::write("   ❌ Gagal kirim ke {$email}: " . $emailSvc->getLastError(), 'red');
                $gagal++;
            }
        }

        CLI::write('');
        CLI::write("=== SELESAI: {$sukses} Email Pengingat Terkirim, {$gagal} Gagal ===", $sukses > 0 ? 'green' : 'red');
    }
}
