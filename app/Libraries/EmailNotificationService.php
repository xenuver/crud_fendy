<?php

namespace App\Libraries;

use Config\Services;

// Service pengirim Email Notifikasi resmi untuk Admin menggunakan CodeIgniter Email Library.
class EmailNotificationService
{
    protected $email;
    protected string $lastError = '';

    public function __construct()
    {
        $this->email = Services::email();
    }

    public function getLastError(): string
    {
        return $this->lastError;
    }

    // Mengirimkan Email Notifikasi Pengingat Laporan Pending ke Email Admin
    public function sendPendingReportReminder(string $adminEmail, int $pendingCount): bool
    {
        if (empty($adminEmail)) {
            $this->lastError = 'Alamat email penerima kosong.';
            return false;
        }

        $baseConfig = config('Email');

        $smtpHost = $_ENV['SMTP_HOST'] ?? getenv('SMTP_HOST') ?: $baseConfig->SMTPHost;
        $smtpUser = $_ENV['SMTP_USER'] ?? getenv('SMTP_USER') ?: $baseConfig->SMTPUser;
        $smtpPass = $_ENV['SMTP_PASS'] ?? getenv('SMTP_PASS') ?: $baseConfig->SMTPPass;
        $smtpPort = (int)($_ENV['SMTP_PORT'] ?? getenv('SMTP_PORT') ?: $baseConfig->SMTPPort ?: 465);

        // Jika menggunakan Resend, isi default SMTPUser jika belum diisi
        if (strpos($smtpHost, 'resend') !== false && empty($smtpUser)) {
            $smtpUser = 'resend';
        }

        if (!empty($smtpHost) && empty($smtpPass)) {
            $this->lastError = 'Variabel SMTP_PASS (API Key Resend / Password SMTP) belum dimasukkan atau masih kosong di Environment Variables Coolify.';
            return false;
        }

        if (!empty($smtpHost)) {
            $crypto = ($smtpPort === 465) ? 'ssl' : 'tls';

            $configArray = [
                'userAgent'       => 'CodeIgniter',
                'protocol'        => 'smtp',
                'mailPath'        => '/usr/sbin/sendmail',
                'SMTPHost'        => $smtpHost,
                'SMTPUser'        => $smtpUser,
                'SMTPPass'        => $smtpPass,
                'SMTPPort'        => $smtpPort,
                'SMTPTimeout'     => 10,
                'SMTPKeepAlive'   => false,
                'SMTPCrypto'      => $_ENV['SMTP_CRYPTO'] ?? getenv('SMTP_CRYPTO') ?: $crypto,
                'wordWrap'        => true,
                'wrapChars'       => 76,
                'mailType'        => 'html',
                'charset'         => 'UTF-8',
                'validate'        => false,
                'priority'        => 3,
                'CRLF'            => "\r\n",
                'newline'         => "\r\n",
                'BCCBatchMode'    => false,
                'BCCBatchSize'    => 200,
                'DSN'             => false,
                'SMTPAuth'        => true,
                'SMTPAuthMethod'  => 'login',
            ];

            $this->email = new \CodeIgniter\Email\Email($configArray);
        }

        $fromEmail = $_ENV['SMTP_FROM_EMAIL'] ?? getenv('SMTP_FROM_EMAIL') ?: ((strpos($smtpHost, 'resend') !== false) ? 'onboarding@resend.dev' : 'no-reply@kreatorbshub.my.id');
        $fromName  = $_ENV['SMTP_FROM_NAME'] ?? getenv('SMTP_FROM_NAME') ?: 'Bloodstrike Creator Hub';

        $this->email->clear();
        $this->email->setFrom($fromEmail, $fromName);
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

        $sent = $this->email->send(false);
        if (!$sent) {
            $this->lastError = strip_tags($this->email->printDebugger(['headers', 'subject']));
        }

        return $sent;
    }
}
