<?php

namespace App\Libraries;

use Config\Services;

// Service pengirim Email Notifikasi resmi untuk Admin & Kreator menggunakan Resend API / SMTP.
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

    // =========================================================================
    // ADMIN NOTIFICATIONS
    // =========================================================================

    // Mengirimkan Email Notifikasi Pengingat Laporan Pending ke Email Admin
    public function sendPendingReportReminder(string $adminEmail, int $pendingCount): bool
    {
        if (empty($adminEmail)) {
            $this->lastError = 'Alamat email penerima kosong.';
            return false;
        }

        $cfg = $this->_resolveSmtpConfig();
        if (!$cfg) return false;

        $appBaseUrl     = rtrim(getenv('APP_BASEURL') ?: 'https://kreatorbshub.my.id', '/');
        $linkVerifikasi = $appBaseUrl . '/admin/laporan';

        $subject = "[Pengingat] {$pendingCount} Laporan Mingguan Kreator Belum Diverifikasi";
        $body    = "
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

        return $this->_sendEmail($cfg, $adminEmail, $subject, $body);
    }

    // =========================================================================
    // KREATOR NOTIFICATIONS
    // =========================================================================

    // Mengirimkan Email Notifikasi Status Laporan ke Kreator (valid/invalid)
    public function sendLaporanStatusToKreator(string $kreatorEmail, string $namaKreator, string $status, string $pesanAdmin = ''): bool
    {
        if (empty($kreatorEmail) || !filter_var($kreatorEmail, FILTER_VALIDATE_EMAIL)) {
            $this->lastError = "Alamat email kreator '{$kreatorEmail}' tidak valid.";
            return false;
        }

        $cfg = $this->_resolveSmtpConfig();
        if (!$cfg) return false;

        $appBaseUrl  = rtrim(getenv('APP_BASEURL') ?: 'https://kreatorbshub.my.id', '/');
        $linkLaporan = $appBaseUrl . '/kreator/laporan';

        $isValid      = ($status === 'valid');
        $statusLabel  = $isValid ? '✅ DITERIMA' : '❌ DITOLAK';
        $statusColor  = $isValid ? '#16a34a' : '#dc2626';
        $badgeBg      = $isValid ? '#dcfce7' : '#fee2e2';
        $subject      = "[Bloodstrike Hub] Laporan Mingguanmu {$statusLabel}";
        $pesanSection = !empty($pesanAdmin)
            ? "<div style=\"background:#f8fafc;border-left:4px solid {$statusColor};padding:12px 16px;margin:16px 0;border-radius:0 6px 6px 0;\">
                <strong style=\"color:#334155;font-size:13px;\">Pesan dari Admin:</strong><br>
                <p style=\"color:#475569;font-size:13px;margin:6px 0 0;\">{$pesanAdmin}</p>
               </div>"
            : '';

        $body = "
        <div style=\"font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 20px;\">
            <div style=\"max-width: 600px; margin: 0 auto; background: #ffffff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);\">
                <h3 style=\"color: #0f172a; margin-top: 0; text-align:center;\">Update Status Laporan Mingguanmu</h3>
                <p style=\"color: #334155; font-size: 14px; line-height: 1.6;\">
                    Halo <strong>{$namaKreator}</strong>,<br><br>
                    Laporan mingguan yang kamu kirimkan telah ditinjau oleh Admin.
                </p>
                <div style=\"text-align:center;margin:20px 0;\">
                    <span style=\"display:inline-block;background:{$badgeBg};color:{$statusColor};font-weight:bold;font-size:16px;padding:10px 28px;border-radius:999px;border:1.5px solid {$statusColor};\">
                        {$statusLabel}
                    </span>
                </div>
                {$pesanSection}
                <div style=\"margin: 25px 0; text-align: center;\">
                    <a href=\"{$linkLaporan}\" style=\"background-color: #0f172a; color: #ffffff; text-decoration: none; font-weight: bold; padding: 12px 24px; border-radius: 4px; display: inline-block; font-size: 14px;\">
                        LIHAT LAPORAN SAYA &rarr;
                    </a>
                </div>
                <hr style=\"border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;\">
                <p style=\"color: #94a3b8; font-size: 12px; margin-bottom: 0; text-align:center;\">
                    Pesan ini dikirimkan secara otomatis oleh sistem Bloodstrike Creator Hub.
                </p>
            </div>
        </div>
        ";

        return $this->_sendEmail($cfg, $kreatorEmail, $subject, $body);
    }

    // Mengirimkan Email Pengingat Submit Laporan Mingguan ke satu Kreator
    public function sendReminderToKreator(string $kreatorEmail, string $namaKreator): bool
    {
        if (empty($kreatorEmail) || !filter_var($kreatorEmail, FILTER_VALIDATE_EMAIL)) {
            $this->lastError = "Alamat email kreator '{$kreatorEmail}' tidak valid.";
            return false;
        }

        $cfg = $this->_resolveSmtpConfig();
        if (!$cfg) return false;

        $appBaseUrl  = rtrim(getenv('APP_BASEURL') ?: 'https://kreatorbshub.my.id', '/');
        $linkLaporan = $appBaseUrl . '/kreator/laporan/tambah';
        $deadline    = 'Rabu, pukul 23:59 WIB';

        $subject = '[Bloodstrike Hub] ⏰ Jangan Lupa Submit Laporan Mingguanmu!';
        $body    = "
        <div style=\"font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 20px;\">
            <div style=\"max-width: 600px; margin: 0 auto; background: #ffffff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);\">
                <h3 style=\"color: #0f172a; margin-top: 0;\">⏰ Pengingat Submit Laporan Mingguan</h3>
                <p style=\"color: #334155; font-size: 14px; line-height: 1.6;\">
                    Halo <strong>{$namaKreator}</strong>,<br><br>
                    Sudah hari <strong>Jumat</strong> nih! Jangan lupa untuk mengisi dan submit <strong>laporan mingguan</strong>-mu sebelum deadline:<br>
                    <strong style=\"color:#f59e0b;font-size:15px;\">{$deadline}</strong>
                </p>
                <div style=\"background:#fefce8;border:1.5px solid #fde68a;border-radius:8px;padding:14px 18px;margin:16px 0;\">
                    <p style=\"color:#92400e;font-size:13px;margin:0;\">
                        💡 <strong>Tips:</strong> Siapkan screenshot views konten, jumlah video, dan data livestream-mu sebelum mengisi laporan ya!
                    </p>
                </div>
                <div style=\"margin: 25px 0; text-align: center;\">
                    <a href=\"{$linkLaporan}\" style=\"background-color: #f59e0b; color: #000000; text-decoration: none; font-weight: bold; padding: 12px 24px; border-radius: 4px; display: inline-block; font-size: 14px;\">
                        SUBMIT LAPORAN SEKARANG &rarr;
                    </a>
                </div>
                <hr style=\"border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;\">
                <p style=\"color: #94a3b8; font-size: 12px; margin-bottom: 0;\">
                    Pesan ini dikirimkan secara otomatis oleh sistem Bloodstrike Creator Hub.<br>
                    Kamu menerima email ini karena terdaftar sebagai kreator aktif.
                </p>
            </div>
        </div>
        ";

        return $this->_sendEmail($cfg, $kreatorEmail, $subject, $body);
    }

    // =========================================================================
    // INTERNAL HELPERS
    // =========================================================================

    // Membaca dan memvalidasi konfigurasi SMTP/Resend dari environment
    protected function _resolveSmtpConfig(): ?array
    {
        $baseConfig = config('Email');
        $smtpHost   = $_ENV['SMTP_HOST'] ?? getenv('SMTP_HOST') ?: $_SERVER['SMTP_HOST'] ?? $baseConfig->SMTPHost;
        $smtpUser   = $_ENV['SMTP_USER'] ?? getenv('SMTP_USER') ?: $_SERVER['SMTP_USER'] ?? $baseConfig->SMTPUser;
        $smtpPass   = $_ENV['SMTP_PASS'] ?? getenv('SMTP_PASS') ?: $_SERVER['SMTP_PASS'] ?? $_ENV['RESEND_API_KEY'] ?? getenv('RESEND_API_KEY') ?: $baseConfig->SMTPPass;
        $smtpPort   = (int)($_ENV['SMTP_PORT'] ?? getenv('SMTP_PORT') ?: $_SERVER['SMTP_PORT'] ?? $baseConfig->SMTPPort ?: 465);

        // Baca dari .env file
        if (empty($smtpPass) && file_exists(ROOTPATH . '.env')) {
            $envContent = file_get_contents(ROOTPATH . '.env');
            if (preg_match('/(?:SMTP_PASS|RESEND_API_KEY)\s*=\s*["\']?([^"\'\\r\\n]+)/i', $envContent, $matches)) {
                $smtpPass = trim($matches[1]);
            }
        }

        // Baca dari WRITEPATH .resend_key
        if (empty($smtpPass) && file_exists(WRITEPATH . '.resend_key')) {
            $smtpPass = trim(file_get_contents(WRITEPATH . '.resend_key'));
        }

        if (empty($smtpPass)) {
            $this->lastError = "Variabel SMTP_PASS / Resend API Key belum terbaca di server.";
            return null;
        }

        $fromEmail = $_ENV['SMTP_FROM_EMAIL'] ?? getenv('SMTP_FROM_EMAIL') ?: ((strpos((string)$smtpHost, 'resend') !== false) ? 'onboarding@resend.dev' : 'no-reply@kreatorbshub.my.id');
        $fromName  = $_ENV['SMTP_FROM_NAME']  ?? getenv('SMTP_FROM_NAME')  ?: 'Bloodstrike Creator Hub';

        return compact('smtpHost', 'smtpUser', 'smtpPass', 'smtpPort', 'fromEmail', 'fromName');
    }

    // Kirim email via Resend API atau SMTP fallback
    protected function _sendEmail(array $cfg, string $toEmail, string $subject, string $htmlBody): bool
    {
        if (strpos($cfg['smtpPass'], 're_') === 0 || strpos((string)$cfg['smtpHost'], 'resend') !== false) {
            return $this->sendViaResendApi($cfg['smtpPass'], $cfg['fromEmail'], $cfg['fromName'], $toEmail, $subject, $htmlBody);
        }

        $crypto      = ($cfg['smtpPort'] === 465) ? 'ssl' : 'tls';
        $configArray = [
            'userAgent'      => 'CodeIgniter',
            'protocol'       => 'smtp',
            'SMTPHost'       => $cfg['smtpHost'],
            'SMTPUser'       => $cfg['smtpUser'],
            'SMTPPass'       => $cfg['smtpPass'],
            'SMTPPort'       => $cfg['smtpPort'],
            'SMTPTimeout'    => 10,
            'SMTPKeepAlive'  => false,
            'SMTPCrypto'     => $_ENV['SMTP_CRYPTO'] ?? getenv('SMTP_CRYPTO') ?: $crypto,
            'wordWrap'       => true,
            'wrapChars'      => 76,
            'mailType'       => 'html',
            'charset'        => 'UTF-8',
            'validate'       => false,
            'priority'       => 3,
            'CRLF'           => "\r\n",
            'newline'        => "\r\n",
            'BCCBatchMode'   => false,
            'BCCBatchSize'   => 200,
            'DSN'            => false,
            'SMTPAuth'       => true,
            'SMTPAuthMethod' => 'login',
        ];

        $emailObj = new \CodeIgniter\Email\Email($configArray);
        $emailObj->clear();
        $emailObj->setFrom($cfg['fromEmail'], $cfg['fromName']);
        $emailObj->setTo($toEmail);
        $emailObj->setSubject($subject);
        $emailObj->setMessage($htmlBody);
        $emailObj->setMailType('html');

        $sent = $emailObj->send(false);
        if (!$sent) {
            $this->lastError = strip_tags($emailObj->printDebugger(['headers', 'subject']));
        }
        return $sent;
    }

    // Mengirim Email langsung menggunakan Resend REST HTTP API (HTTPS Port 443)
    protected function sendViaResendApi(string $apiKey, string $fromEmail, string $fromName, string $toEmail, string $subject, string $htmlBody): bool
    {
        $url = 'https://api.resend.com/emails';

        // Jika domain kreatorbshub.my.id terdeteksi di SMTP_HOST / config, gunakan email domain terverifikasi
        // Jika masih menggunakan default localhost/IP, fallback ke onboarding@resend.dev untuk testing
        if (strpos($fromEmail, 'kreatorbshub.my.id') === false && strpos($fromEmail, 'resend.dev') === false) {
            $fromEmail = 'noreply@kreatorbshub.my.id';
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
