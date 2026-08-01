<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\KreatorModel;
use App\Models\RedeemCodeModel;

class ManajemenAkun extends BaseController
{
    protected UserModel $uModel;
    protected KreatorModel $kModel;
    protected RedeemCodeModel $rModel;
    protected \App\Models\LaporanMingguanModel $lModel;
    protected \CodeIgniter\Database\BaseConnection $db;

    public function __construct()
    {
        $this->uModel = new UserModel();
        $this->kModel = new KreatorModel();
        $this->rModel = new RedeemCodeModel();
        $this->lModel = new \App\Models\LaporanMingguanModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Ambil data redeem codes terpaginasi (server-side pagination)
        $redeemCodes = $this->rModel->select('redeem_codes.*, users.username as used_by_username')
            ->join('users', 'users.user_id = redeem_codes.used_by', 'left')
            ->orderBy('redeem_codes.created_at', 'DESC')
            ->paginate(10, 'redeem');

        // Ambil hanya kolom code untuk redeem code yang belum terpakai (tanpa SELECT *)
        $allUnusedCodes = $this->rModel->select('code')->where('is_used', 0)->orderBy('created_at', 'DESC')->findColumn('code') ?? [];

        $registerBaseUrl = base_url('register?code=');
        $unusedLinksList = !empty($allUnusedCodes) ? $registerBaseUrl . implode("\n" . $registerBaseUrl, $allUnusedCodes) : '';

        $data = [
            'judul'              => 'Manajemen Akun',
            'users'              => $this->uModel->orderBy('role', 'ASC')->orderBy('username', 'ASC')->paginate(10, 'user'),
            'pager'              => $this->uModel->pager, // Berisi pager untuk 'user' dan 'redeem'
            'redeem_codes'       => $redeemCodes,
            'unused_links_str'   => $unusedLinksList,
            'unused_codes_count' => count($allUnusedCodes),
            'register_url'       => base_url('register'),
        ];

        return view('templates/v_header', $data)
            . view('templates/v_sidebar')
            . view('templates/v_topbar')
            . view('admin/manajemen_akun', $data)
            . view('templates/v_footer');
    }

    public function save()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'no_telp'  => 'required|min_length[8]|max_length[18]|is_unique[users.no_telp]',
            'id_game'  => 'required|min_length[5]|is_natural|is_unique[users.id_game]',
            'password' => 'required|min_length[8]',
            'role'     => 'required|in_list[admin,user,super_admin]'
        ];

        $messages = [
            'username' => ['is_unique' => 'Username sudah digunakan oleh akun lain.'],
            'no_telp' => ['is_unique' => 'Nomor telepon sudah terdaftar.'],
            'id_game' => [
                'is_unique' => 'ID Game sudah digunakan oleh kreator lain.',
                'is_natural' => 'ID Game hanya boleh berupa angka saja (tanpa huruf, titik, spasi, atau karakter lain).'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'no_telp' => $this->request->getPost('no_telp'),
            'id_game' => $this->request->getPost('id_game'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role')
        ];

        $this->db->transBegin();
        try {
            if (!$this->uModel->insert($data)) {
                throw new \RuntimeException('Gagal membuat baris akun pengguna.');
            }

            // Sinkronisasi: otomatis buat entri di tabel kreator jika role user (walau admin juga boleh buat as record)
            if ($data['role'] == 'user') {
                $existingKreator = $this->kModel->where('id_game', $this->request->getPost('id_game'))->first();
                if (!$existingKreator) {
                    $this->kModel->insert([
                        'nama' => $this->request->getPost('username'),
                        'alamat' => 'Indonesia',
                        'id_game' => $this->request->getPost('id_game')
                    ]);
                } else {
                    $this->kModel->update($existingKreator['kreator_id'], [
                        'nama' => $this->request->getPost('username')
                    ]);
                }
            }
            $this->db->transCommit();
            session()->setFlashdata('success', 'Akun berhasil dibuat.');
        } catch (\Exception $e) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'Gagal membuat akun: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $user = $this->uModel->find($id);

        if (!$user) {
            session()->setFlashdata('error', 'Data akun tidak ditemukan.');
            return redirect()->back();
        }

        // Rules conditional, mengizinkan username/no_telp/id_game sama jika tidak diubah oleh user bersangkutan
        $is_unique_username = ($user['username'] == $this->request->getPost('username')) ? '' : '|is_unique[users.username]';
        $is_unique_no_telp = ($user['no_telp'] == $this->request->getPost('no_telp')) ? '' : '|is_unique[users.no_telp]';
        $is_unique_id_game = ($user['id_game'] == $this->request->getPost('id_game')) ? '' : '|is_unique[users.id_game]';

        $rules = [
            'username' => 'required|min_length[3]|max_length[20]' . $is_unique_username,
            'no_telp' => 'required|min_length[8]|max_length[18]' . $is_unique_no_telp,
            'id_game' => 'required|min_length[5]|is_natural' . $is_unique_id_game,
            'role'     => 'required|in_list[admin,user,super_admin]'
        ];

        $messages = [
            'username' => ['is_unique' => 'Username sudah digunakan oleh akun lain.'],
            'no_telp' => ['is_unique' => 'Nomor telepon sudah terdaftar.'],
            'id_game' => [
                'is_unique' => 'ID Game sudah digunakan oleh kreator lain.',
                'is_natural' => 'ID Game hanya boleh berupa angka saja (tanpa huruf, titik, spasi, atau karakter lain).'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'no_telp' => $this->request->getPost('no_telp'),
            'id_game' => $this->request->getPost('id_game'),
            'role' => $this->request->getPost('role')
        ];

        // Ganti password hanya jika field password diisi
        $new_password = $this->request->getPost('password');
        if (!empty($new_password)) {
            if (strlen($new_password) < 8) {
                session()->setFlashdata('error', 'Kata sandi minimal 8 karakter.');
                return redirect()->back()->withInput();
            }
            $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $this->db->transBegin();
        try {
            // Update users DULU (parent FK), lalu kreator (child)
            $this->uModel->update($id, $data);

            if ($data['role'] == 'user') {
                // Cari kreator pakai old_id_game (sebelum user di-update)
                // CATATAN: jika id_game berubah, ON UPDATE CASCADE sudah
                // mengupdate kreator.id_game secara otomatis saat user di-update
                $kreator = $this->kModel->where('id_game', $data['id_game'])->first();
                if ($kreator) {
                    $this->kModel->update($kreator['kreator_id'], [
                        'nama' => $data['username'],
                        'id_game' => $data['id_game']
                    ]);
                }
            }
            $this->db->transCommit();
            session()->setFlashdata('success', 'Akun berhasil diperbarui.');
        } catch (\Exception $e) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'Gagal memperbarui akun: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function delete($id)
    {
        $user = $this->uModel->find($id);

        if (!$user) {
            session()->setFlashdata('error', 'Data akun tidak ditemukan.');
            return redirect()->back();
        }

        // Mencegah admin menghapus dirinya sendiri saat sedang login
        if ($id == session()->get('id')) {
            session()->setFlashdata('error', 'Otorisasi Gagal: Anda tidak dapat menghapus akun Anda sendiri.');
            return redirect()->back();
        }

        $this->db->transBegin();
        try {
            // Bersihkan data kreator yang terhubung dengan user ini agar tidak jadi sampah di database
            $kreator = null;
            $laporans = [];
            if (!empty($user['id_game'])) {
                $kreator = $this->kModel->where('id_game', $user['id_game'])->first();
                if ($kreator) {
                    // Ambil daftar laporan mingguan kreator untuk dihapus file fisiknya setelah DB commit
                    $laporans = $this->lModel->where('kreator_id', $kreator['kreator_id'])->findAll();

                    // Hapus data laporan dari database
                    $this->lModel->where('kreator_id', $kreator['kreator_id'])->delete();

                    // Hapus data profil kreator
                    $this->kModel->delete($kreator['kreator_id']);
                }
            }

            // Hapus data user
            if (!$this->uModel->delete($id)) {
                throw new \RuntimeException('Gagal menghapus akun pengguna.');
            }

            $this->db->transCommit();

            // Hapus file fisik (Cloud Storage atau lokal) hanya jika transaksi database sukses commit
            if ($kreator && !empty($laporans)) {
                $storage = new \App\Libraries\CloudStorageService();
                $deleteFile = function (?string $foto) use ($storage) {
                    if (empty($foto))
                        return;
                    if (\App\Libraries\CloudStorageService::isCloudUrl($foto)) {
                        $storage->delete($foto);
                    } else {
                        $localPath = FCPATH . 'uploads/laporan/' . basename($foto);
                        if (file_exists($localPath)) {
                            @unlink($localPath);
                        }
                    }
                };

                foreach ($laporans as $lap) {
                    $deleteFile($lap['foto_views_konten']);
                    $deleteFile($lap['foto_views_livestream']);
                    $deleteFile($lap['foto_penonton_puncak_live'] ?? null);
                    $deleteFile($lap['foto_views_shorts'] ?? null);
                }
            }

            session()->setFlashdata('success', 'Akun berhasil dihapus beserta profil kreator dan seluruh berkas laporannya.');
        } catch (\Exception $e) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'Gagal menghapus akun: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    // Generate kode redeem baru untuk pendaftaran kreator (bisa batch).
    public function generate_code()
    {
        $jumlah = $this->request->getPost('jumlah') ?? $this->request->getGet('jumlah') ?? 1;
        $jumlah = max(1, min(100, (int) $jumlah));

        $codesGenerated = [];
        for ($i = 0; $i < $jumlah; $i++) {
            $code = $this->rModel->generateUniqueCode();
            $this->rModel->insert([
                'code' => $code,
                'is_used' => 0,
                'created_by' => session()->get('id'),
            ]);
            $codesGenerated[] = $code;
        }

        if ($jumlah === 1) {
            session()->setFlashdata('success', "Redeem Code berhasil di-generate: {$codesGenerated[0]}. Salin dan bagikan ke kreator.");
        } else {
            session()->setFlashdata('success', "Berhasil me-generate {$jumlah} Redeem Code baru. Silakan salin dari daftar di bawah.");
        }

        return redirect()->to(base_url('admin/users'));
    }

    // Hapus/revoke kode redeem yang belum terpakai.
    public function delete_code($id)
    {
        $code = $this->rModel->find($id);

        if (!$code) {
            session()->setFlashdata('error', 'Kode tidak ditemukan.');
            return redirect()->back();
        }

        $this->rModel->delete($id);
        session()->setFlashdata('success', 'Redeem Code berhasil dihapus.');
        return redirect()->back();
    }
}
