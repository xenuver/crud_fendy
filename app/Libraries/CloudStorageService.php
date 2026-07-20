<?php

namespace App\Libraries;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use CodeIgniter\HTTP\Files\UploadedFile;

// CloudStorageService — Jembatan antara CodeIgniter dan Supabase Storage / S3-Compatible Cloud Storage.
//
// Cara kerja singkat:
// - Supabase Storage kompatibel dengan Amazon S3 API.
// - Kita menggunakan AWS SDK for PHP dengan mengarahkan endpoint ke Supabase.
// - File diunggah ke bucket Supabase, lalu URL publik dikembalikan untuk disimpan di database.
//
// Cara pakai:
//   $storage = new \App\Libraries\CloudStorageService();
//   $url = $storage->upload($uploadedFile, 'profil');
//   // $url = "https://[project-id].supabase.co/storage/v1/object/public/[bucket]/profil/abc123.jpg"
class CloudStorageService
{
    private S3Client $client;
    private string $bucket;
    private string $publicUrl;
    private bool $enabled;
    private bool $useAcl;

    public function __construct()
    {
        // Ambil kredensial dari .env dengan fallback ke R2 prefix lama agar tidak merusak hosting
        $accountId = env('CLOUD_ACCOUNT_ID', env('R2_ACCOUNT_ID', ''));
        $accessKeyId = env('CLOUD_ACCESS_KEY_ID', env('R2_ACCESS_KEY_ID', ''));
        $secretAccessKey = env('CLOUD_SECRET_ACCESS_KEY', env('R2_SECRET_ACCESS_KEY', ''));
        $customEndpoint = env('CLOUD_CUSTOM_ENDPOINT', env('R2_CUSTOM_ENDPOINT', ''));
        $region = env('CLOUD_REGION', env('R2_REGION', 'auto'));
        $verifySsl = env('CLOUD_VERIFY_SSL', env('R2_VERIFY_SSL', true));

        $this->bucket = env('CLOUD_BUCKET_NAME', env('R2_BUCKET_NAME', ''));
        $this->publicUrl = rtrim(env('CLOUD_PUBLIC_URL', env('R2_PUBLIC_URL', '')), '/');

        // Jika .env belum diisi, storage dianggap tidak aktif (fallback ke lokal)
        $this->enabled = !empty($accessKeyId) && !empty($secretAccessKey) && (!empty($accountId) || !empty($customEndpoint));

        $useAclVal = env('CLOUD_USE_ACL', env('R2_USE_ACL', null));
        if ($useAclVal === null) {
            $this->useAcl = !str_contains($customEndpoint, 'supabase.co');
        } else {
            $this->useAcl = filter_var($useAclVal, FILTER_VALIDATE_BOOLEAN);
        }

        if ($this->enabled) {
            // Inisialisasi S3Client dengan endpoint Supabase.
            //
            // Kenapa 'version' => 'latest'? → Pakai versi API S3 terbaru secara otomatis.
            // Kenapa 'region' => 'auto'?    → Supabase/S3 menggunakan region spesifik (misal ap-northeast-2).
            // 'endpoint'                    → Endpoint kustom Supabase
            // 'use_path_style_endpoint'     → Diperlukan agar SDK tidak membuat subdomain bucket sendiri.
            $endpoint = !empty($customEndpoint) ? $customEndpoint : "https://{$accountId}.r2.cloudflarestorage.com";

            $clientConfig = [
                'version' => 'latest',
                'region' => $region,
                'endpoint' => $endpoint,
                'credentials' => [
                    'key' => $accessKeyId,
                    'secret' => $secretAccessKey,
                ],
                'use_path_style_endpoint' => true,
            ];

            // Tambahkan bypass verifikasi SSL jika dikonfigurasi false (misal di Windows lokal cURL error 77)
            if ($verifySsl === false || $verifySsl === 'false') {
                $clientConfig['http'] = [
                    'verify' => false,
                ];
            }

            $this->client = new S3Client($clientConfig);
        }
    }

    // Upload file ke Cloud Storage (Supabase).
    //
    // @param UploadedFile $file      File yang diterima dari form upload
    // @param string       $folder    Subfolder di dalam bucket (misal: 'profil', 'laporan')
    // @param string|null  $customName Nama file kustom tanpa ekstensi
    // @return string|null            URL publik file di cloud, atau null jika gagal/storage tidak aktif
    public function upload(UploadedFile $file, string $folder = 'uploads', ?string $customName = null): ?string
    {
        // Jika storage belum dikonfigurasi, kembalikan null (controller akan fallback ke lokal)
        if (!$this->enabled) {
            return null;
        }

        // Generate nama file unik agar tidak ada konflik
        $extension = $file->getExtension();
        if ($customName) {
            $fileName = $folder . '/' . $customName . '.' . $extension;
        } else {
            $fileName = $folder . '/' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
        }

        try {
            // putObject → perintah S3 untuk mengupload satu file.
            //
            // 'Bucket' → nama bucket Supabase kamu
            // 'Key'    → path file di dalam bucket (mirip nama file + folder)
            // 'Body'   → isi file dalam bentuk stream (lebih efisien dari string)
            // 'ACL'    → 'public-read' agar file bisa diakses publik via URL
            // 'ContentType' → MIME type file agar browser tahu cara membukanya
            $params = [
                'Bucket' => $this->bucket,
                'Key' => $fileName,
                'Body' => fopen($file->getTempName(), 'rb'),
                'ContentType' => $file->getMimeType(),
            ];

            if ($this->useAcl) {
                $params['ACL'] = 'public-read';
            }

            $this->client->putObject($params);

            // Kembalikan URL publik lengkap
            return $this->publicUrl . '/' . $fileName;
        } catch (AwsException $e) {
            log_message('error', '[CloudStorageService] Upload gagal: ' . $e->getMessage());
            return null;
        }
    }

    // Upload file dari path lokal server ke Cloud Storage (Supabase).
    // Digunakan untuk migrasi berkas yang tersimpan secara lokal.
    //
    // @param string $localFilePath  Absolute path ke file lokal (misal FCPATH . 'uploads/laporan/nama.webp')
    // @param string $fileName       Nama file tujuan di bucket
    // @param string $folder         Subfolder di dalam bucket
    // @return string|null           URL publik file di cloud, atau null jika gagal
    public function uploadLocalFile(string $localFilePath, string $fileName, string $folder = 'uploads'): ?string
    {
        if (!$this->enabled || !file_exists($localFilePath)) {
            return null;
        }

        try {
            $params = [
                'Bucket' => $this->bucket,
                'Key' => $folder . '/' . $fileName,
                'Body' => fopen($localFilePath, 'rb'),
                'ContentType' => mime_content_type($localFilePath) ?: 'image/webp',
            ];

            if ($this->useAcl) {
                $params['ACL'] = 'public-read';
            }

            $this->client->putObject($params);

            return $this->publicUrl . '/' . $folder . '/' . $fileName;
        } catch (AwsException $e) {
            log_message('error', '[CloudStorageService] uploadLocalFile gagal: ' . $e->getMessage());
            return null;
        }
    }


    // Hapus file dari Cloud Storage berdasarkan URL publiknya.
    //
    // @param string $publicUrl  URL publik file yang ingin dihapus
    // @return bool
    public function delete(string $publicUrl): bool
    {
        if (!$this->enabled || empty($publicUrl)) {
            return false;
        }

        // Ekstrak 'Key' (path file) dari URL publik
        $key = ltrim(str_replace($this->publicUrl, '', $publicUrl), '/');

        if (empty($key)) {
            return false;
        }

        try {
            $this->client->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $key,
            ]);
            return true;
        } catch (AwsException $e) {
            log_message('error', '[CloudStorageService] Delete gagal: ' . $e->getMessage());
            return false;
        }
    }

    // Cek apakah Cloud Storage sudah dikonfigurasi dengan benar.
    //
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    // Helper: cek apakah string adalah URL Cloud Storage (bukan nama file lokal).
    //
    public static function isCloudUrl(string $value): bool
    {
        return str_starts_with($value, 'http://') || str_starts_with($value, 'https://');
    }
}
