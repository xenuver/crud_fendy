<?php

namespace App\Libraries;

use Config\Services;

// Service pengirim Email Notifikasi resmi untuk Admin menggunakan CodeIgniter Email Library.
class EmailNotificationService
{
    protected $email;

    public function __construct()
    {
        $this->email = Services::email();
    }

    // Mengirimkan Email Notifikasi Pengingat Laporan Pending ke Email Admin
    public function sendPendingReportReminder(string $adminEmail, int $pendingCount): bool
    {
        if (empty($adminEmail)) {
            return false;
        }

        $this->email->clear();
        $this->email->setTo($adminEmail);
        $this->email->setSubject("[Pengingat] {$pendingCount} Laporan Mingguan Kreator Belum Diverifikasi");

        $linkVerifikasi = base_url('admin/laporan');

        $body = "
        <div style=\"font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 20px;\">
            <div style=\"max-width: 600px; margin: 0 auto; background: #ffffff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);\">
                <h3 style=\"color: #0f172a; margin-top: 0;\">Pengingat Laporan Pending</h3>
                <p style=\"color: #334155; font-size: 14px; line-height: 1.6;\">
                    Halo Admin,<br><br>
                    Terdapat <strong>{$pendingCount} laporan mingguan kreator</strong> yang saat ini berstatus <em>pending</em> dan membutuhkan verifikasi Anda.
                </p>
                <div style=\"margin: 25px 0; text-align: center;\">
                    <a href=\"{$linkVerifikasi}\" style=\"background-color: #f59e0b; color: #000000; text-decoration: none; font-weight: bold; padding: 12px 24px; border-radius: 4px; display: inline-block; font-size: 14px;\">
                        VERIFIKASI SEKARANG &rarr;
                    </a>
                </div>
                <hr style=\"border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;\">
                <p style=\"color: #94a3b8; font-size: 12px; margin-bottom: 0;\">
                    Pesan ini dikirimkan secara otomatis oleh sistem Bloodstrike Creator Hub.
                </p>
            </div>
        </div>
        ";

        $this->email->setMessage($body);
        $this->email->setMailType('html');

        return $this->email->send();
    }
}
