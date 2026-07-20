<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Libraries\CloudStorageService;

class StorageMigrate extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Storage';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'storage:migrate';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Migrates locally saved weekly report images to Supabase Cloud Storage without deleting local files.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'storage:migrate';

    /**
     * Actually run a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $db = \Config\Database::connect();
        $storage = new CloudStorageService();

        if (!$storage->isEnabled()) {
            CLI::error('Supabase Cloud Storage is not enabled. Please check your .env credentials.');
            return;
        }

        CLI::write('Scanning database for local weekly report screenshots...', 'yellow');

        // Ambil semua laporan
        $reports = $db->table('laporan_mingguan')->get()->getResultArray();
        $migratedReports = 0;
        $totalFilesMigrated = 0;
        $fileFields = ['foto_views_konten', 'foto_views_livestream', 'foto_penonton_puncak_live', 'foto_views_shorts'];

        foreach ($reports as $report) {
            $updatedData = [];

            foreach ($fileFields as $field) {
                $fileName = $report[$field] ?? '';

                // Jika nama file tidak kosong dan bukan merupakan URL awalan http/https
                if (!empty($fileName) && !str_starts_with($fileName, 'http://') && !str_starts_with($fileName, 'https://')) {
                    $localPath = FCPATH . 'uploads/laporan/' . $fileName;

                    if (file_exists($localPath)) {
                        CLI::write("Uploading {$fileName} to Supabase...", 'blue');

                        // Upload file ke folder 'laporan' di Supabase
                        $cloudUrl = $storage->uploadLocalFile($localPath, $fileName, 'laporan');

                        if ($cloudUrl) {
                            $updatedData[$field] = $cloudUrl;
                            $totalFilesMigrated++;
                            CLI::write("Success! URL: {$cloudUrl}", 'green');
                            
                            // Catatan: sesuai permintaan, file fisik di lokal VPS dibiarkan saja (tidak di-unlink)
                        } else {
                            CLI::error("Failed to upload {$fileName} to Supabase.");
                        }
                    } else {
                        CLI::error("Local file not found on disk: {$localPath}");
                    }
                }
            }

            if (!empty($updatedData)) {
                $db->table('laporan_mingguan')
                   ->where('laporan_id', $report['laporan_id'])
                   ->update($updatedData);
                $migratedReports++;
            }
        }

        CLI::write("Migration finished! Reports updated: {$migratedReports}, Files uploaded: {$totalFilesMigrated}", 'green');
    }
}
