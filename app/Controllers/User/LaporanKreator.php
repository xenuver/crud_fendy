<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\LaporanMingguanModel;
use App\Models\KreatorModel;
use App\Libraries\CloudStorageService;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanKreator extends BaseController
{
    protected LaporanMingguanModel $lModel;
    protected KreatorModel $kModel;
    protected \CodeIgniter\Database\BaseConnection $db;

    public function __construct()
    {
        $this->lModel = new LaporanMingguanModel();
        $this->kModel = new KreatorModel();
        $this->db = \Config\Database::connect();
    }

    // Menampilkan daftar laporan pribadi milik kreator yang sedang login.
    public function index(): string|ResponseInterface
    {
        $rangeTanggal = $this->request->getGet('range_tanggal');
        $tglMulai = null;
        $tglSelesai = null;

        if ($rangeTanggal) {
            $dates = explode(' to ', $rangeTanggal);
            $tglMulai = $dates[0] ?? null;
            $tglSelesai = $dates[1] ?? ($dates[0] ?? null);
        }

        $platform = $this->request->getGet('platform');
        $status = $this->request->getGet('status');

        // Filter: hanya data milik user yang bersangkutan
        $builder = $this->lModel->where('user_id', session()->get('id'));

        if ($platform && in_array($platform, ['youtube', 'tiktok'])) {
            $builder = $builder->where('platform', $platform);
        }

        if ($status && in_array($status, ['pending', 'valid', 'tidak_valid'])) {
            $builder = $builder->where('status_validasi', $status);
        }

        if ($tglMulai) {
            $builder = $builder->where('DATE(created_at) >=', $tglMulai);
        }
        if ($tglSelesai) {
            $builder = $builder->where('DATE(created_at) <=', $tglSelesai);
        }

        $laporans = $builder->orderBy('created_at', 'DESC')->paginate(20, 'laporan');
        $pager = $this->lModel->pager;
        $kreators = $this->kModel->getKreatorsWithMetrics();

        $judul = "Laporan Mingguan Kreator";
        if ($platform == 'youtube')
            $judul = "Laporan Khusus YouTube";
        if ($platform == 'tiktok')
            $judul = "Laporan Khusus TikTok";

        $kreatorLogin = $this->kModel->where('id_game', session()->get('id_game'))->first();

        // Cek apakah profil lengkap
        if (!$kreatorLogin || empty($kreatorLogin['alamat']) || $kreatorLogin['alamat'] === '-' || (empty($kreatorLogin['tiktok_link']) && empty($kreatorLogin['youtube_link']))) {
            return redirect()->to(base_url('user/profile'))->with('error', 'Silakan lengkapi data alamat dan tautan channel (YouTube/TikTok) Anda terlebih dahulu.');
        }

        $hasSubmittedYt = false;
        $hasSubmittedTt = false;
        if ($kreatorLogin) {
            $mondayThisWeek = date('Y-m-d', strtotime('monday this week'));
            $hasSubmittedYt = $this->lModel->where('kreator_id', $kreatorLogin['kreator_id'])
                ->where('platform', 'youtube')
                ->where('status_validasi !=', 'tidak_valid')
                ->where('DATE(created_at) >=', $mondayThisWeek)
                ->first() !== null;
            $hasSubmittedTt = $this->lModel->where('kreator_id', $kreatorLogin['kreator_id'])
                ->where('platform', 'tiktok')
                ->where('status_validasi !=', 'tidak_valid')
                ->where('DATE(created_at) >=', $mondayThisWeek)
                ->first() !== null;
        }

        $data = [
            "judul" => $judul,
            "laporans" => $laporans,
            "pager" => $pager,
            "kreators" => $kreators,
            "kreatorLogin" => $kreatorLogin,
            "tglMulai" => $tglMulai,
            "tglSelesai" => $tglSelesai,
            "isOpen" => $this->isSubmissionOpen(),
            "hasSubmittedYt" => $hasSubmittedYt,
            "hasSubmittedTt" => $hasSubmittedTt
        ];

        return $this->renderView("laporan/mingguan", $data);
    }

    // Menyimpan laporan mingguan baru yang dikirim oleh kreator.
    public function save(): ResponseInterface
    {
        $debugInfo = [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'upload_tmp_dir' => ini_get('upload_tmp_dir'),
            'content_length' => $_SERVER['CONTENT_LENGTH'] ?? 'unknown',
            'files' => $_FILES,
        ];
        log_message('debug', 'DEBUG UPLOAD: ' . json_encode($debugInfo));

        if (!$this->isSubmissionOpen()) {
            return redirect()->back()->withInput()->with('error', 'Akses Pengiriman Laporan Ditutup. Pengiriman hanya dapat dilakukan pada hari Senin s/d Rabu pukul 15:00 WIB.');
        }

        $laporanModel = new LaporanMingguanModel();

        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'jumlah_video' => 'required|is_natural|less_than_equal_to[1000]',
            'total_views_video' => 'required|is_natural|less_than_equal_to[1000000000]',
            'jumlah_live' => 'required|is_natural|less_than_equal_to[1000]',
            'total_views_live' => 'required|is_natural|less_than_equal_to[1000000000]',
            'penonton_puncak_live' => 'required|is_natural|less_than_equal_to[500000]',
            'platform' => 'required|in_list[youtube,tiktok]',
            'foto_views_konten' => 'uploaded[foto_views_konten]|max_size[foto_views_konten,2048]|is_image[foto_views_konten]',
            'foto_views_livestream' => 'uploaded[foto_views_livestream]|max_size[foto_views_livestream,2048]|is_image[foto_views_livestream]',
            'foto_penonton_puncak_live' => 'uploaded[foto_penonton_puncak_live]|max_size[foto_penonton_puncak_live,2048]|is_image[foto_penonton_puncak_live]'
        ];

        if ($this->request->getPost('platform') == 'youtube') {
            $rules['jumlah_shorts'] = 'required|is_natural|less_than_equal_to[1000]';
            $rules['views_shorts'] = 'required|is_natural|less_than_equal_to[1000000000]';
            $rules['foto_views_shorts'] = 'uploaded[foto_views_shorts]|max_size[foto_views_shorts,2048]|is_image[foto_views_shorts]';
        }

        $messages = [
            'nama_lengkap' => [
                'required' => 'Nama lengkap wajib diisi.',
                'min_length' => 'Nama lengkap minimal harus 3 karakter.'
            ],
            'jumlah_video' => [
                'required' => 'Jumlah video reguler wajib diisi.',
                'is_natural' => 'Jumlah video reguler harus berupa angka bulat positif.',
                'less_than_equal_to' => 'Jumlah video reguler tidak boleh melebihi 1.000 video per minggu.'
            ],
            'total_views_video' => [
                'required' => 'Total views video reguler wajib diisi.',
                'is_natural' => 'Total views video reguler harus berupa angka bulat positif.',
                'less_than_equal_to' => 'Total views video reguler tidak boleh melebihi 1.000.000.000.'
            ],
            'jumlah_live' => [
                'required' => 'Jumlah livestream wajib diisi.',
                'is_natural' => 'Jumlah livestream harus berupa angka bulat positif.',
                'less_than_equal_to' => 'Jumlah livestream tidak boleh melebihi 1.000 livestream per minggu.'
            ],
            'total_views_live' => [
                'required' => 'Total views livestream wajib diisi.',
                'is_natural' => 'Total views livestream harus berupa angka bulat positif.',
                'less_than_equal_to' => 'Total views livestream tidak boleh melebihi 1.000.000.000.'
            ],
            'penonton_puncak_live' => [
                'required' => 'Jumlah penonton puncak (CCV) wajib diisi.',
                'is_natural' => 'Jumlah penonton puncak (CCV) harus berupa angka bulat positif.',
                'less_than_equal_to' => 'Jumlah penonton puncak (CCV) tidak boleh melebihi 500.000.'
            ],
            'jumlah_shorts' => [
                'required' => 'Jumlah video shorts wajib diisi.',
                'is_natural' => 'Jumlah video shorts harus berupa angka bulat positif.',
                'less_than_equal_to' => 'Jumlah video shorts tidak boleh melebihi 1.000 shorts per minggu.'
            ],
            'views_shorts' => [
                'required' => 'Total views shorts wajib diisi.',
                'is_natural' => 'Total views shorts harus berupa angka bulat positif.',
                'less_than_equal_to' => 'Total views shorts tidak boleh melebihi 1.000.000.000.'
            ],
            'foto_views_konten' => [
                'uploaded' => 'Bukti foto views konten wajib diunggah.',
                'max_size' => 'Ukuran foto views konten maksimal 2MB.',
                'is_image' => 'File bukti views konten harus berupa gambar (format png, jpg, jpeg, webp).'
            ],
            'foto_views_livestream' => [
                'uploaded' => 'Bukti foto views livestream wajib diunggah.',
                'max_size' => 'Ukuran foto views livestream maksimal 2MB.',
                'is_image' => 'File bukti views livestream harus berupa gambar (format png, jpg, jpeg, webp).'
            ],
            'foto_penonton_puncak_live' => [
                'uploaded' => 'Bukti foto penonton puncak (CCV) wajib diunggah.',
                'max_size' => 'Ukuran foto penonton puncak (CCV) maksimal 2MB.',
                'is_image' => 'File bukti penonton puncak (CCV) harus berupa gambar (format png, jpg, jpeg, webp).'
            ],
            'foto_views_shorts' => [
                'uploaded' => 'Bukti foto views shorts wajib diunggah.',
                'max_size' => 'Ukuran foto views shorts maksimal 2MB.',
                'is_image' => 'File bukti views shorts harus berupa gambar (format png, jpg, jpeg, webp).'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            $errors = $this->validator->getErrors();
            $errorMessage = !empty($errors) ? implode(' ', $errors) : 'Seluruh data operasional dan bukti tangkapan layar wajib diisi dengan benar.';
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        $fileKonten = $this->request->getFile('foto_views_konten');
        $fileLive = $this->request->getFile('foto_views_livestream');
        $fileCcv = $this->request->getFile('foto_penonton_puncak_live');

        $db = \Config\Database::connect();
        $db->transBegin();

        $namaFotoKonten = null;
        $namaFotoLive = null;
        $namaFotoCcv = null;
        $namaFotoShorts = null;

        try {
            $kreator = $db->query("SELECT * FROM kreator WHERE id_game = ? FOR UPDATE", [session()->get('id_game')])->getRowArray();

            if (!$kreator || empty($kreator['alamat']) || $kreator['alamat'] === '-' || (empty($kreator['tiktok_link']) && empty($kreator['youtube_link']))) {
                throw new \RuntimeException('Silakan lengkapi data alamat dan tautan channel (YouTube/TikTok) Anda terlebih dahulu sebelum mengirimkan laporan.');
            }

            // Bersihkan laporan DITOLAK (tidak_valid) minggu ini dari database dan cloud storage
            $platform = $this->request->getPost('platform');
            $mondayThisWeek = date('Y-m-d', strtotime('monday this week'));
            $laporanDitolak = $laporanModel->where('kreator_id', $kreator['kreator_id'])
                ->where('platform', $platform)
                ->where('status_validasi', 'tidak_valid')
                ->where('DATE(created_at) >=', $mondayThisWeek)
                ->first();

            if ($laporanDitolak) {
                $storage = new CloudStorageService();
                $deleteFile = function (?string $foto) use ($storage) {
                    if (empty($foto))
                        return;
                    if (CloudStorageService::isCloudUrl($foto)) {
                        $storage->delete($foto);
                    } else {
                        $localPath = FCPATH . 'uploads/laporan/' . basename($foto);
                        if (file_exists($localPath)) {
                            @unlink($localPath);
                        }
                    }
                };
                $deleteFile($laporanDitolak['foto_views_konten']);
                $deleteFile($laporanDitolak['foto_views_livestream']);
                $deleteFile($laporanDitolak['foto_penonton_puncak_live'] ?? null);
                $deleteFile($laporanDitolak['foto_views_shorts'] ?? null);

                $laporanModel->update($laporanDitolak['laporan_id'], [
                    'foto_views_konten' => null,
                    'foto_views_livestream' => null,
                    'foto_penonton_puncak_live' => null,
                    'foto_views_shorts' => null,
                ]);
            }

            $storage = new CloudStorageService();
            $safeKreatorName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $kreator['nama']));
            $timestamp = date('Ymd_His') . '_' . random_int(1000, 9999);

            $prosesGambar = function ($file, string $prefix) use ($storage, $safeKreatorName, $timestamp) {
                if (!$file || !$file->isValid() || $file->hasMoved())
                    return null;

                $customFileName = "{$prefix}_{$safeKreatorName}_{$timestamp}";

                if ($storage->isEnabled()) {
                    $url = $storage->upload($file, 'laporan', $customFileName);
                    if ($url !== null)
                        return $url;
                }

                // Fallback lokal
                if (!is_dir(FCPATH . 'uploads/laporan')) {
                    mkdir(FCPATH . 'uploads/laporan', 0777, true);
                }
                $tempName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/laporan', $tempName);
                $tempPath = FCPATH . 'uploads/laporan/' . $tempName;
                $webpName = "{$customFileName}.webp";
                $webpPath = FCPATH . 'uploads/laporan/' . $webpName;

                try {
                    \Config\Services::image()
                        ->withFile($tempPath)
                        ->resize(1000, 1000, true, 'height')
                        ->save($webpPath, 60);
                    @unlink($tempPath);
                    return $webpName;
                } catch (\Exception $e) {
                    rename($tempPath, $webpPath);
                    return $webpName;
                }
            };

            $namaFotoKonten = $prosesGambar($fileKonten, 'konten');
            $namaFotoLive = $prosesGambar($fileLive, 'live');
            $namaFotoCcv = $prosesGambar($fileCcv, 'ccv');

            if ($platform == 'youtube') {
                $fileShorts = $this->request->getFile('foto_views_shorts');
                $namaFotoShorts = $prosesGambar($fileShorts, 'shorts');
            }

            if ($namaFotoKonten === null || $namaFotoLive === null || $namaFotoCcv === null || ($platform == 'youtube' && $namaFotoShorts === null)) {
                throw new \RuntimeException('Gagal mengupload berkas bukti tangkapan layar.');
            }

            $data = [
                'user_id' => session()->get('id'),
                'kreator_id' => $kreator['kreator_id'],
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'platform' => $platform,
                'jumlah_video' => $this->request->getPost('jumlah_video'),
                'total_views_video' => $this->request->getPost('total_views_video'),
                'jumlah_live' => $this->request->getPost('jumlah_live'),
                'total_views_live' => $this->request->getPost('total_views_live'),
                'penonton_puncak_live' => $this->request->getPost('penonton_puncak_live'),
                'foto_views_konten' => $namaFotoKonten,
                'foto_views_livestream' => $namaFotoLive,
                'foto_penonton_puncak_live' => $namaFotoCcv,
                'status_validasi' => 'pending',
                'is_read' => 1
            ];

            if ($platform == 'youtube') {
                $data['jumlah_shorts'] = $this->request->getPost('jumlah_shorts');
                $data['views_shorts'] = $this->request->getPost('views_shorts');
                $data['foto_views_shorts'] = $namaFotoShorts;
            }

            // Simpan laporan ke DB
            if ($laporanDitolak) {
                // Jika sudah ada laporan ditolak, timpa record tersebut
                $laporanModel->update($laporanDitolak['laporan_id'], $data);
            } else {
                // Jika baru pertama minggu ini, insert baru
                $laporanModel->insert($data);
            }

            $db->transCommit();
            return redirect()->back()->with('success', 'Laporan berhasil dikirim ke MiminBS dan menunggu verifikasi.');
        } catch (\Exception $e) {
            $db->transRollback();

            $storage = new CloudStorageService();
            $deleteFile = function (?string $foto) use ($storage) {
                if (empty($foto))
                    return;
                if (CloudStorageService::isCloudUrl($foto)) {
                    $storage->delete($foto);
                } else {
                    $localPath = FCPATH . 'uploads/laporan/' . basename($foto);
                    if (file_exists($localPath)) {
                        @unlink($localPath);
                    }
                }
            };

            $deleteFile($namaFotoKonten);
            $deleteFile($namaFotoLive);
            $deleteFile($namaFotoCcv);
            $deleteFile($namaFotoShorts);

            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    // Menandai notifikasi laporan sebagai sudah dibaca oleh user.
    public function markAsRead(int $id): ResponseInterface
    {
        $kreator = $this->kModel->where('id_game', session()->get('id_game'))->first();

        if ($kreator) {
            $laporan = $this->lModel->where('laporan_id', $id)->where('kreator_id', $kreator['kreator_id'])->first();
            if ($laporan) {
                $this->lModel->update($id, ['is_read' => 1]);
            }
        }

        return redirect()->to(base_url('user/laporan'));
    }
}
