<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KreatorModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class PengaturanProfil extends BaseController
{
    protected KreatorModel $kModel;
    protected UserModel $uModel;
    protected \CodeIgniter\Database\BaseConnection $db;

    public function __construct()
    {
        $this->kModel = new KreatorModel();
        $this->uModel = new UserModel();
        $this->db = \Config\Database::connect();
    }

    // Menampilkan halaman profil dan pengaturan akun admin.
    public function index()
    {
        $id_game = session()->get('id_game');
        $kreator = $this->kModel->getOrCreateProfile($id_game, session()->get('username'));

        $data = [
            'judul' => 'Pengaturan Profil Admin',
            'kreator' => $kreator,
            'canUpdateUid' => true,
            'daysRemaining' => 0,
        ];

        return $this->renderView("user/pengaturan_profil", $data);
    }

    // Memproses pembaruan profil admin.
    public function update()
    {
        $session = session();
        $id_game = $session->get('id_game');

        $kreator = $this->kModel->where('id_game', $id_game)->first();

        if (!$kreator) {
            // Auto bypass pembuatan jika terlewat
            $this->kModel->insert(['id_game' => $id_game, 'nama' => 'MiminBS', 'alamat' => 'Indonesia']);
            $kreator = $this->kModel->where('id_game', $id_game)->first();
        }

        // === CEK PERUBAHAN UID GAME ===
        $newIdGame = $this->request->getPost('id_game');
        $uidChanged = false;

        if (!empty($newIdGame) && $newIdGame !== $kreator['id_game']) {
            // Validasi format: wajib angka saja dan panjang min 5
            if (!ctype_digit($newIdGame) || strlen($newIdGame) < 5) {
                return redirect()->back()->withInput()->with('error', 'UID Game harus berupa angka saja dengan panjang minimal 5 angka.');
            }

            // Validasi keunikan UID Game agar tidak menimpa akun lain
            $existing = $this->uModel->where('id_game', $newIdGame)->first();
            if ($existing) {
                return redirect()->back()->withInput()->with('error', 'UID Game ini sudah digunakan oleh akun lain.');
            }
            $uidChanged = true;
        }

        $rules = [
            'nama' => 'required|min_length[3]',
            'alamat' => 'required',
            'tiktok_link' => 'permit_empty|valid_url|regex_match[/tiktok\.com/i]',
            'youtube_link' => 'permit_empty|valid_url|regex_match[/youtube\.com|youtu\.be/i]',
        ];

        $validationMessages = [
            'tiktok_link' => [
                'regex_match' => 'Link TikTok harus berasal dari domain tiktok.com.'
            ],
            'youtube_link' => [
                'regex_match' => 'Link YouTube harus berasal dari domain youtube.com atau youtu.be.'
            ],
        ];

        if (!$this->validate($rules, $validationMessages)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'tiktok_link' => $this->request->getPost('tiktok_link'),
            'youtube_link' => $this->request->getPost('youtube_link'),
        ];

        if ($uidChanged) {
            $data['id_game'] = $newIdGame;
        }

        $this->db->transBegin();
        try {
            // Jika UID berubah, update tabel users DULU (parent FK)
            if ($uidChanged) {
                $user = $this->uModel->find($session->get('id'));
                if ($user) {
                    $this->uModel->update($user['user_id'], ['id_game' => $newIdGame]);
                }
                $session->set('id_game', $newIdGame);
            }

            // Update kreator (id_game di-cascade jika berubah, field lain diupdate di sini)
            $this->kModel->update($kreator['kreator_id'], $data);

            $this->db->transCommit();
            $msg = $uidChanged ? 'Profil dan UID Game admin berhasil diperbarui.' : 'Profil admin berhasil diperbarui.';
            return redirect()->back()->with('success', $msg);
        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil admin: ' . $e->getMessage());
        }
    }

    // Memproses pembaruan kata sandi admin.
    public function update_password()
    {
        $session = session();
        $user = $this->uModel->where('username', $session->get('username'))->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Akun admin tidak ditemukan.');
        }

        $rules = [
            'password_lama' => 'required',
            'password_baru' => 'required|min_length[8]',
            'konfirmasi_password' => 'required|matches[password_baru]',
        ];

        $messages = [
            'password_lama' => [
                'required' => 'Kata sandi saat ini wajib diisi.',
            ],
            'password_baru' => [
                'required' => 'Kata sandi baru wajib diisi.',
                'min_length' => 'Kata sandi baru minimal 8 karakter.',
            ],
            'konfirmasi_password' => [
                'required' => 'Konfirmasi kata sandi baru wajib diisi.',
                'matches' => 'Konfirmasi kata sandi baru tidak cocok dengan kata sandi baru.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $password_lama = $this->request->getPost('password_lama');
        $password_baru = $this->request->getPost('password_baru');

        if (!password_verify($password_lama, $user['password'])) {
            return redirect()->back()->with('error', 'Kata sandi saat ini tidak cocok.');
        }

        if ($this->uModel->update($user['user_id'], ['password' => password_hash($password_baru, PASSWORD_DEFAULT)])) {
            return redirect()->back()->with('success', 'Kata sandi admin berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengenkripsi kata sandi baru.');
        }
    }
}
