<?php

namespace App\Libraries;

use Config\Services;

// Service pengirim Email Notifikasi resmi untuk Admin menggunakan Resend API / SMTP.
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

        // 1. Coba baca dari Environment Variables
        $smtpHost = $_ENV['SMTP_HOST'] ?? getenv('SMTP_HOST') ?: $_SERVER['SMTP_HOST'] ?? $baseConfig->SMTPHost;
        $smtpUser = $_ENV['SMTP_USER'] ?? getenv('SMTP_USER') ?: $_SERVER['SMTP_USER'] ?? $baseConfig->SMTPUser;
        $smtpPass = $_ENV['SMTP_PASS'] ?? getenv('SMTP_PASS') ?: $_SERVER['SMTP_PASS'] ?? $_ENV['RESEND_API_KEY'] ?? getenv('RESEND_API_KEY') ?: $baseConfig->SMTPPass;
        $smtpPort = (int)($_ENV['SMTP_PORT'] ?? getenv('SMTP_PORT') ?: $_SERVER['SMTP_PORT'] ?? $baseConfig->SMTPPort ?: 465);

        // 2. Baca dari file .env di root project jika belum terbaca
        if (empty($smtpPass) && file_exists(ROOTPATH . '.env')) {
            $envContent = file_get_contents(ROOTPATH . '.env');
            if (preg_match('/(?:SMTP_PASS|RESEND_API_KEY)\s*=\s*["\']?([^"\'\r\n]+)/i', $envContent, $matches)) {
                $smtpPass = trim($matches[1]);
            }
        }

        // 3. Baca dari WRITEPATH .resend_key jika ada
        if (empty($smtpPass) && file_exists(WRITEPATH . '.resend_key')) {
            $smtpPass = trim(file_get_contents(WRITEPATH . '.resend_key'));
        }

        if (empty($smtpPass)) {
            $this->lastError = "Variabel SMTP_PASS / Resend API Key belum terbaca di server. Silakan klik tombol 'Redeploy' (oranye di kanan atas Coolify) agar variabel baru diterapkan ke kontainer aplikasi.";
            return false;
        }

        $fromEmail = $_ENV['SMTP_FROM_EMAIL'] ?? getenv('SMTP_FROM_EMAIL') ?: ((strpos($smtpHost, 'resend') !== false) ? 'onboarding@resend.dev' : 'no-reply@kreatorbshub.my.id');
        $fromName  = $_ENV['SMTP_FROM_NAME'] ?? getenv('SMTP_FROM_NAME') ?: 'Bloodstrike Creator Hub';

        $subject = "[Pengingat] {$pendingCount} Laporan Mingguan Kreator Belum Diverifikasi";
        // Gunakan APP_BASEURL dari environment, fallback ke domain produksi
        $appBaseUrl = rtrim(getenv('APP_BASEURL') ?: 'https://kreatorbshub.my.id', '/');
        $linkVerifikasi = $appBaseUrl . '/admin/laporan';

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

        // MENGGUNAKAN RESEND HTTP REST API (Super Fast & Reliable) jika API Key diawali `re_`
        if (strpos($smtpPass, 're_') === 0 || strpos($smtpHost, 'resend') !== false) {
            return $this->sendViaResendApi($smtpPass, $fromEmail, $fromName, $adminEmail, $subject, $body);
        }

        // FALLBACK SMTP BIASA
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
        $this->email->clear();
        $this->email->setFrom($fromEmail, $fromName);
        $this->email->setTo($adminEmail);
        $this->email->setSubject($subject);
        $this->email->setMessage($body);
        $this->email->setMailType('html');

        $sent = $this->email->send(false);
        if (!$sent) {
            $this->lastError = strip_tags($this->email->printDebugger(['headers', 'subject']));
        }

        return $sent;
    }

    // Mengirim Email langsung menggunakan Resend REST HTTP API (HTTPS Port 443)
    protected function sendViaResendApi(string $apiKey, string $fromEmail, string $fromName, string $toEmail, string $subject, string $htmlBody): bool
    {
        $url = 'https://api.resend.com/emails';

        // Resend default sender jika belum verifikasi domain khusus
        if (strpos($fromEmail, 'resend.dev') === false && strpos($fromEmail, '@') !== false) {
            $fromEmail = 'onboarding@resend.dev';
        }

        $payload = [
            'from'    => "{$fromName} <{$fromEmail}>",
            'to'      => [$toEmail],
            'subject' => $subject,
            'html'    => $htmlBody,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err      = curl_error($ch);
        curl_close($ch);

        if ($err) {
            $this->lastError = 'cURL Error: ' . $err;
            return false;
        }

        $resData = json_decode($response, true);

        if ($httpCode >= 200 && $httpCode < 300 && isset($resData['id'])) {
            return true;
        }

        $this->lastError = "Resend API Error ({$httpCode}): " . ($resData['message'] ?? $response);
        return false;
    }
}
