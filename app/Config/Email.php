<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'no-reply@kreatorbshub.my.id';
    public string $fromName   = 'Bloodstrike Creator Hub';
    public string $recipients = '';

    public function __construct()
    {
        parent::__construct();

        $smtpHost         = $_ENV['SMTP_HOST'] ?? getenv('SMTP_HOST') ?: '';
        $defaultFrom      = (strpos($smtpHost, 'resend') !== false) ? 'onboarding@resend.dev' : 'no-reply@kreatorbshub.my.id';

        $port             = (int)($_ENV['SMTP_PORT'] ?? getenv('SMTP_PORT') ?: (strpos($smtpHost, 'resend') !== false ? 465 : 587));
        $defaultCrypto    = ($port === 465) ? 'ssl' : 'tls';

        $this->fromEmail  = $_ENV['SMTP_FROM_EMAIL'] ?? getenv('SMTP_FROM_EMAIL') ?: $defaultFrom;
        $this->fromName   = $_ENV['SMTP_FROM_NAME'] ?? getenv('SMTP_FROM_NAME') ?: 'Bloodstrike Creator Hub';
        $this->protocol   = $_ENV['SMTP_PROTOCOL'] ?? getenv('SMTP_PROTOCOL') ?: 'mail';
        $this->SMTPHost   = $smtpHost;
        $this->SMTPUser   = $_ENV['SMTP_USER'] ?? getenv('SMTP_USER') ?: '';
        $this->SMTPPass   = $_ENV['SMTP_PASS'] ?? getenv('SMTP_PASS') ?: '';
        $this->SMTPPort   = $port;
        $this->SMTPCrypto = $_ENV['SMTP_CRYPTO'] ?? getenv('SMTP_CRYPTO') ?: $defaultCrypto;
        $this->SMTPAuth   = true;
    }

    /**
     * The "user agent"
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * The mail sending protocol: mail, sendmail, smtp
     */
    public string $protocol = 'mail';

    /**
     * The server path to Sendmail.
     */
    public string $mailPath = '/usr/sbin/sendmail';

    /**
     * SMTP Server Hostname
     */
    public string $SMTPHost = '';

    /**
     * Which SMTP authentication method to use: login, plain
     */
    public string $SMTPAuthMethod = 'login';

    /**
     * SMTP Username
     */
    public string $SMTPUser = '';

    /**
     * SMTP Password
     */
    public string $SMTPPass = '';

    /**
     * SMTP Port
     */
    public int $SMTPPort = 25;

    /**
     * SMTP Timeout (in seconds)
     */
    public int $SMTPTimeout = 5;

    /**
     * Enable persistent SMTP connections
     */
    public bool $SMTPKeepAlive = false;

    /**
     * SMTP Encryption.
     *
     * @var string '', 'tls' or 'ssl'. 'tls' will issue a STARTTLS command
     *             to the server. 'ssl' means implicit SSL. Connection on port
     *             465 should set this to ''.
     */
    public string $SMTPCrypto = 'tls';

    /**
     * Enable word-wrap
     */
    public bool $wordWrap = true;

    /**
     * Character count to wrap at
     */
    public int $wrapChars = 76;

    /**
     * Type of mail, either 'text' or 'html'
     */
    public string $mailType = 'text';

    /**
     * Character set (utf-8, iso-8859-1, etc.)
     */
    public string $charset = 'UTF-8';

    /**
     * Whether to validate the email address
     */
    public bool $validate = false;

    /**
     * Email Priority. 1 = highest. 5 = lowest. 3 = normal
     */
    public int $priority = 3;

    /**
     * Newline character. (Use “\r\n” to comply with RFC 822)
     */
    public string $CRLF = "\r\n";

    /**
     * Newline character. (Use “\r\n” to comply with RFC 822)
     */
    public string $newline = "\r\n";

    /**
     * Enable BCC Batch Mode.
     */
    public bool $BCCBatchMode = false;

    /**
     * Number of emails in each BCC batch
     */
    public int $BCCBatchSize = 200;

    /**
     * Enable notify message from server
     */
    public bool $DSN = false;
}
