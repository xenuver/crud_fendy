<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KreatorModel;
use CodeIgniter\HTTP\ResponseInterface;

// Controller untuk mengelola halaman publik dan manajemen kreator.
class DataKreator extends BaseController
{
    protected KreatorModel $kModel;
    protected \App\Models\UserModel $uModel;
    protected \App\Models\LaporanMingguanModel $lModel;
    protected \CodeIgniter\Database\BaseConnection $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Proteksi berlapis: Seluruh fitur di controller Home hanya untuk admin
        if (session()->get('role') !== 'admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function __construct()
    {
        $this->kModel = new KreatorModel();
        $this->uModel = new \App\Models\UserModel();
        $this->lModel = new \App\Models\LaporanMingguanModel();
        $this->db = \Config\Database::connect();
    }

    // Menampilkan Leaderboard Kreator di halaman utama.
    public function index(): string
    {
        // Ambil ID Game milik Admin & Super Admin untuk dikeluarkan dari daftar leaderboard
        $adminGameIds = $this->db->table('users')->select('id_game')->whereIn('role', ['admin', 'super_admin'])->get()->getResultArray();
        $adminIds = array_column($adminGameIds, 'id_game');

        // Ambil Seluruh Kreator dengan Metrik dari Model
        $kreators = $this->kModel->getKreatorsWithMetrics();

        // Filter: Keluarkan Admin & Super Admin dari list jika ada
        if (!empty($adminIds)) {
            $kreators = array_filter($kreators, function ($k) use ($adminIds) {
                return !in_array($k['id_game'], $adminIds);
            });
            $kreators = array_values($kreators);
        }

        $data = [
            "judul"    => "Data Kreator",
            "kreators" => $kreators
        ];

        return $this->renderView("admin/data_kreator", $data);
    }

    // Menyimpan data kreator baru.
    public function save(): ResponseInterface
    {
        $id_g = $this->request->getPost('id_game');
        $tk_l = (string)$this->request->getPost('tiktok_link');
        $yt_l = (string)$this->request->getPost('youtube_link');

        // Validasi keunikan ID Game agar tidak duplikat di tabel kreator dan format link media sosial
        $rules = [
            'id_game'      => 'required|min_length[5]|is_natural|is_unique[kreator.id_game]',
            'tiktok_link'  => 'permit_empty|valid_url',
            'youtube_link' => 'permit_empty|valid_url'
        ];
        $messages = [
            'id_game' => [
                'is_unique' => 'ID Game sudah terdaftar di data kreator.',
                'is_natural' => 'ID Game hanya boleh berupa angka saja (tanpa huruf, titik, spasi, atau karakter lain).'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $user = $this->db->table('users')->where('id_game', $id_g)->get()->getRow();
        $f_nama = ($user) ? $user->username : '';

        if (empty($f_nama)) {
            if (!empty($tk_l) && preg_match('/@([a-zA-Z0-9._]+)/', $tk_l, $matches)) {
                $f_nama = $matches[1];
            } elseif (!empty($yt_l) && preg_match('/@([a-zA-Z0-9._]+)/', $yt_l, $matches)) {
                $f_nama = $matches[1];
            } else {
                $f_nama = 'Kreator-' . substr($id_g, -3);
            }
        }

        $data = [
            'nama'         => $f_nama,
            'alamat'       => $this->request->getPost('alamat'),
            'id_game'      => $id_g,
            'tiktok_link'  => $tk_l,
            'youtube_link' => $yt_l,
        ];

        if ($this->kModel->insert($data)) {
            return redirect()->back()->with('success', 'Berhasil menambahkan kreator baru.');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan kreator baru.');
    }

    // Memperbarui data kreator.
    public function update(): ResponseInterface
    {
        $id = $this->request->getPost('id');
        $kreatorOld = $this->kModel->find($id);

        if (!$kreatorOld) {
            return redirect()->back();
        }

        // Validasi keunikan ID Game saat update (lewati jika tidak berubah) dan format link media sosial
        $is_unique_id_game = ($kreatorOld['id_game'] == $this->request->getPost('id_game')) ? '' : '|is_unique[kreator.id_game]';
        $rules = [
            'id_game'      => 'required|min_length[5]|is_natural' . $is_unique_id_game,
            'tiktok_link'  => 'permit_empty|valid_url',
            'youtube_link' => 'permit_empty|valid_url'
        ];
        $messages = [
            'id_game' => [
                'is_unique' => 'ID Game sudah digunakan oleh kreator lain.',
                'is_natural' => 'ID Game hanya boleh berupa angka saja (tanpa huruf, titik, spasi, atau karakter lain).'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'alamat'       => $this->request->getPost('alamat'),
            'id_game'      => $this->request->getPost('id_game'),
            'tiktok_link'  => $this->request->getPost('tiktok_link'),
            'youtube_link' => $this->request->getPost('youtube_link'),
        ];

        $this->db->transBegin();
        try {
            // Sinkronkan UID game baru ke tabel users DULU (parent FK)
            // agar kreator.id_game bisa di-update tanpa FK violation
            if ($kreatorOld['id_game'] !== $data['id_game']) {
                $user = $this->uModel->where('id_game', $kreatorOld['id_game'])->first();
                if ($user) {
                    $this->uModel->update($user['user_id'], ['id_game' => $data['id_game']]);
                    // ON UPDATE CASCADE otomatis update kreator.id_game
                }
            }

            // Update kreator (id_game sudah di-cascade, field lain tetap di-update)
            $this->kModel->update($id, $data);

            $this->db->transCommit();
            return redirect()->back()->with('success', 'Berhasil memperbarui data kreator.');
        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data kreator: ' . $e->getMessage());
        }
    }

    // Menghapus data kreator.
    public function delete(int $id): ResponseInterface
    {
        $kreator = $this->kModel->find($id);
        if (!$kreator) {
            session()->setFlashdata('error', 'Kreator tidak ditemukan.');
            return redirect()->back();
        }

        // Hapus file fisik/R2 laporan mingguan terikat
        $laporans = $this->lModel->where('kreator_id', $id)->findAll();
        
        $storage = new \App\Libraries\CloudStorageService();
        $deleteFile = function(?string $foto) use ($storage) {
            if (empty($foto)) return;
            if (\App\Libraries\CloudStorageService::isCloudUrl($foto)) {
                $storage->delete($foto);
            } else {
                $localPath = FCPATH . 'uploads/laporan/' . basename($foto);
                if (file_exists($localPath)) {
                    @unlink($localPath);
                }
            }
        };

        $this->db->transBegin();

        try {
            // Hapus data laporan dari database
            $this->lModel->where('kreator_id', $id)->delete();

            // Hapus data kreator
            $this->kModel->delete($id);

            // Hapus akun user terikat
            if (!empty($kreator['id_game'])) {
                $this->uModel->where('id_game', $kreator['id_game'])->delete();
            }

            $this->db->transCommit();

            // Hapus file fisik hanya jika transaksi DB berhasil
            foreach ($laporans as $lap) {
                $deleteFile($lap['foto_views_konten']);
                $deleteFile($lap['foto_views_livestream']);
                $deleteFile($lap['foto_penonton_puncak_live'] ?? null);
                $deleteFile($lap['foto_views_shorts'] ?? null);
            }

            session()->setFlashdata('success', 'Kreator beserta seluruh laporan, akun user, dan berkas fisiknya berhasil dihapus.');
        } catch (\Exception $e) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'Gagal menghapus kreator: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    // Mengubah status aktif/tangguh kreator.
    public function toggle_status(int $id): ResponseInterface
    {
        $kreator = $this->kModel->find($id);

        if ($kreator) {
            $newStatus = ($kreator['status'] == 'active') ? 'suspended' : 'active';
            $this->kModel->update($id, ['status' => $newStatus]);

            $msg = ($newStatus == 'suspended') ? 'Kreator telah ditangguhkan (SUSPENDED).' : 'Kreator telah diaktifkan kembali.';
            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back();
    }
}
