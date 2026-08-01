<?php

namespace App\Libraries;

// Library pengirim Web Push Notification melalui OneSignal REST API.
class OneSignalService
{
    protected string $appId;
    protected string $restKey;

    public function __construct()
    {
        $this->appId   = $_ENV['ONESIGNAL_APP_ID'] ?? getenv('ONESIGNAL_APP_ID') ?: '';
        $this->restKey = $_ENV['ONESIGNAL_REST_KEY'] ?? getenv('ONESIGNAL_REST_KEY') ?: '';
    }

    // Mengirimkan Web Push Notification ke segmen Admin atau seluruh penonton berizin.
    public function sendNotification(string $title, string $message, ?string $url = null): array
    {
        if (empty($this->appId) || empty($this->restKey)) {
            return [
                'success' => false,
                'message' => 'ONESIGNAL_APP_ID atau ONESIGNAL_REST_KEY belum dikonfigurasi di variabel environment (.env).'
            ];
        }

        $targetUrl = $url ?? base_url('admin/laporan');

        $content = [
            'en' => $message,
            'id' => $message,
        ];

        $headings = [
            'en' => $title,
            'id' => $title,
        ];

        $fields = [
            'app_id'            => $this->appId,
            'included_segments' => ['Subscribers'], // Mengirim ke device ber-izin
            'headings'          => $headings,
            'contents'          => $content,
            'url'               => $targetUrl,
            'chrome_web_icon'   => base_url('assets/img/bloodstrike_actual.jpg'),
        ];

        $fieldsJson = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $this->restKey
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsJson);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $err      = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return ['success' => false, 'message' => 'cURL Error: ' . $err];
        }

        $resData = json_decode($response, true);
        return [
            'success'  => isset($resData['id']),
            'response' => $resData
        ];
    }
}
