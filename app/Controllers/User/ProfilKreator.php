<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\KreatorModel;
use App\Models\UserModel;

class ProfilKreator extends BaseController
{
    protected KreatorModel $kModel;

    public function __construct()
    {
        $this->kModel = new KreatorModel();
    }

    // Menampilkan halaman profil dan pengaturan akun kreator.
    public function profile()
    {
        $id_game = session()->get('id_game');
        $kreator = $this->kModel->where('id_game', $id_game)->first();
        $cooldown = $this->kModel->getUidCooldown($kreator);

        $data = [
            'judul' => 'Pengaturan Profil',
            'kreator' => $kreator,
            'canUpdateUid' => $cooldown['can'],
            'daysRemaining' => $cooldown['days'],
        ];

        return $this->renderView("user/pengaturan_profil", $data);
    }

    // Memproses pembaruan profil kreator.
    // Termasuk validasi cooldown perubahan UID Game.
    public function update_profile()
    {
        $session = session();
        $id_game = $session->get('id_game');

        $kreator = $this->kModel->where('id_game', $id_game)->first();

        if (!$kreator) {
            return redirect()->back()->with('error', 'Data profil tidak ditemukan.');
        }

        // === CEK PERUBAHAN UID GAME ===
        $newIdGame = $this->request->getPost('id_game');
        $uidChanged = false;

        if (!empty($newIdGame) && $newIdGame !== $kreator['id_game']) {
            // Validasi format: wajib angka saja dan panjang min 5
            if (!ctype_digit($newIdGame) || strlen($newIdGame) < 5) {
                return redirect()->back()->withInput()->with('error', 'UID Game harus berupa angka saja (tanpa huruf, titik, spasi, atau karakter lain) dengan panjang minimal 5 karakter.');
            }

            // Validasi cooldown
            $cooldown = $this->kModel->getUidCooldown($kreator);
            if (!$cooldown['can']) {
                return redirect()->back()->withInput()->with('error', 'UID Game hanya bisa diubah 1x per 30 hari. Tersisa ' . $cooldown['days'] . ' hari lagi.');
            }
            // Validasi keunikan UID Game agar tidak menimpa akun kreator lain
            $userModel = new UserModel();
            $existing = $userModel->where('id_game', $newIdGame)->first();
            if ($existing) {
                return redirect()->back()->withInput()->with('error', 'UID Game ini sudah digunakan oleh kreator lain.');
            }
            $uidChanged = true;
        }

        $rules = [
            'nama' => 'required|min_length[3]',
            'alamat' => 'required',
            'tiktok_link' => 'permit_empty|valid_url',
            'youtube_link' => 'permit_empty|valid_url',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'tiktok_link' => $this->request->getPost('tiktok_link'),
            'youtube_link' => $this->request->getPost('youtube_link'),
        ];

        // Jika UID diubah, tambahkan ke data update
        if ($uidChanged) {
            $data['id_game'] = $newIdGame;
            $data['last_uid_update'] = date('Y-m-d H:i:s');
        }

        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            // Jika UID berubah, update tabel users DULU (parent FK)
            // agar kreator.id_game bisa di-update tanpa FK violation
            if ($uidChanged) {
                $userModel = new UserModel();
                $user = $userModel->find($session->get('id'));
                if ($user) {
                    $userModel->update($user['user_id'], ['id_game' => $newIdGame]);
                }
                $session->set('id_game', $newIdGame);
            }

            // Update kreator (id_game sudah di-cascade, field lain di-update di sini)
            $this->kModel->update($kreator['kreator_id'], $data);

            $db->transCommit();
            $msg = $uidChanged ? 'Profil dan UID Game berhasil diperbarui.' : 'Profil berhasil diperbarui.';
            return redirect()->back()->with('success', $msg);
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    public function update_password()
    {
        $session = session();
        $userModel = new UserModel();
        $user = $userModel->where('username', $session->get('username'))->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Akun tidak ditemukan.');
        }

        $rules = [
            'password_lama' => 'required',
            'password_baru' => 'required|min_length[8]',
            'konfirmasi_password' => 'required|matches[password_baru]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $password_lama = $this->request->getPost('password_lama');
        $password_baru = $this->request->getPost('password_baru');

        if (!password_verify($password_lama, $user['password'])) {
            return redirect()->back()->with('error', 'Kata sandi saat ini tidak cocok.');
        }

        // Simpan hash password baru
        if ($userModel->update($user['user_id'], ['password' => password_hash($password_baru, PASSWORD_DEFAULT)])) {
            return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengenkripsi kata sandi baru.');
        }
    }
}
