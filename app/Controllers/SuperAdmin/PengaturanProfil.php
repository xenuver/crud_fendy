<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

// Controller untuk mengelola profil & kata sandi Super Admin.
class PengaturanProfil extends BaseController
{
    protected UserModel $uModel;
    protected \CodeIgniter\Database\BaseConnection $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        if (session()->get('role') !== 'super_admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function __construct()
    {
        $this->uModel = new UserModel();
        $this->db = \Config\Database::connect();
    }

    // Menampilkan halaman pengaturan akun/profil Super Admin.
    public function index(): string
    {
        $user = $this->uModel->find(session()->get('id'));

        $data = [
            'judul' => 'Pengaturan Profil Super Admin',
            'user'  => $user,
        ];

        return $this->renderView('superadmin/pengaturan_profil', $data);
    }

    // Memproses pembaruan data profil (username & nomor telepon) Super Admin.
    public function update(): ResponseInterface
    {
        $user = $this->uModel->find(session()->get('id'));

        if (!$user) {
            return redirect()->back()->with('error', 'Akun tidak ditemukan.');
        }

        $is_unique_username = ($user['username'] == $this->request->getPost('username')) ? '' : '|is_unique[users.username]';
        $is_unique_no_telp  = ($user['no_telp'] == $this->request->getPost('no_telp')) ? '' : '|is_unique[users.no_telp]';

        $rules = [
            'username' => 'required|min_length[3]|max_length[20]' . $is_unique_username,
            'no_telp'  => 'required|min_length[8]|max_length[18]' . $is_unique_no_telp,
        ];

        $messages = [
            'username' => ['is_unique' => 'Username sudah digunakan oleh akun lain.'],
            'no_telp'  => ['is_unique' => 'Nomor telepon sudah terdaftar.'],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'no_telp'  => $this->request->getPost('no_telp'),
        ];

        if ($this->uModel->update($user['user_id'], $data)) {
            session()->set('username', $data['username']);
            session()->set('no_telp', $data['no_telp']);
            return redirect()->back()->with('success', 'Profil Super Admin berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui profil Super Admin.');
    }

    // Memproses perubahan kata sandi (password) Super Admin.
    public function update_password(): ResponseInterface
    {
        $user = $this->uModel->find(session()->get('id'));

        if (!$user) {
            return redirect()->back()->with('error', 'Akun tidak ditemukan.');
        }

        $rules = [
            'password_lama'       => 'required',
            'password_baru'       => 'required|min_length[8]',
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

        if ($this->uModel->update($user['user_id'], ['password' => password_hash($password_baru, PASSWORD_DEFAULT)])) {
            return redirect()->back()->with('success', 'Kata sandi Super Admin berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui kata sandi.');
    }
}
