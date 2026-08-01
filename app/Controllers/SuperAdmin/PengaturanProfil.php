<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

// Controller untuk mengelola profil, kata sandi, dan Resend API Key Super Admin.
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

        $resendKey = '';
        if (file_exists(WRITEPATH . '.resend_key')) {
            $resendKey = trim(file_get_contents(WRITEPATH . '.resend_key'));
        }

        $data = [
            'judul'     => 'Pengaturan Profil Super Admin',
            'user'      => $user,
            'resendKey' => $resendKey,
        ];

        return $this->renderView('superadmin/pengaturan_profil', $data);
    }

    // Memproses pembaruan data profil (username, email & nomor telepon) Super Admin.
    public function update(): ResponseInterface
    {
        $user = $this->uModel->find(session()->get('id'));

        if (!$user) {
            return redirect()->back()->with('error', 'Akun tidak ditemukan.');
        }

        $is_unique_username = ($user['username'] == $this->request->getPost('username')) ? '' : '|is_unique[users.username]';
        $is_unique_email    = (($user['email'] ?? '') == $this->request->getPost('email')) ? '' : '|is_unique[users.email]';
        $is_unique_no_telp  = ($user['no_telp'] == $this->request->getPost('no_telp')) ? '' : '|is_unique[users.no_telp]';

        $rules = [
            'username' => 'required|min_length[3]|max_length[20]' . $is_unique_username,
            'email'    => 'permit_empty|valid_email' . $is_unique_email,
            'no_telp'  => 'required|min_length[8]|max_length[18]' . $is_unique_no_telp,
        ];

        $messages = [
            'username' => ['is_unique' => 'Username sudah digunakan oleh akun lain.'],
            'email'    => ['is_unique' => 'Email sudah digunakan oleh akun lain.', 'valid_email' => 'Format email tidak valid.'],
            'no_telp'   => ['is_unique' => 'Nomor telepon sudah terdaftar.'],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->with('error', implode('<br>', $this->validator->getErrors()))->withInput();
        }

        $updateData = [
            'username' => $this->request->getPost('username'),
            'email'    => trim($this->request->getPost('email') ?? ''),
            'no_telp'  => $this->request->getPost('no_telp'),
        ];

        if ($this->uModel->update($user['user_id'], $updateData)) {
            session()->set('username', $updateData['username']);
            return redirect()->back()->with('success', 'Profil Super Admin berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui profil.');
    }

    // Menyimpan Resend API Key langsung dari UI Web (100% Bebas Ribet Coolify).
    public function updateResendKey(): ResponseInterface
    {
        $key = trim($this->request->getPost('resend_key') ?? '');

        if (!empty($key)) {
            file_put_contents(WRITEPATH . '.resend_key', $key);
            return redirect()->back()->with('success', 'Resend API Key berhasil disimpan! Email Notification sekarang 100% Aktif.');
        } else {
            if (file_exists(WRITEPATH . '.resend_key')) {
                unlink(WRITEPATH . '.resend_key');
            }
            return redirect()->back()->with('success', 'Resend API Key dihapus.');
        }
    }

    // Memproses ganti password Super Admin.
    public function updatePassword(): ResponseInterface
    {
        $user = $this->uModel->find(session()->get('id'));

        if (!$user) {
            return redirect()->back()->with('error', 'Akun tidak ditemukan.');
        }

        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');
        $konfirmasi   = $this->request->getPost('konfirmasi_password');

        if (!password_verify($passwordLama, $user['password'])) {
            return redirect()->back()->with('error', 'Kata sandi saat ini tidak cocok.');
        }

        if (strlen($passwordBaru) < 8) {
            return redirect()->back()->with('error', 'Kata sandi baru minimal 8 karakter.');
        }

        if ($passwordBaru !== $konfirmasi) {
            return redirect()->back()->with('error', 'Konfirmasi kata sandi baru tidak cocok.');
        }

        $newHash = password_hash($passwordBaru, PASSWORD_DEFAULT);

        if ($this->uModel->update($user['user_id'], ['password' => $newHash])) {
            return redirect()->back()->with('success', 'Kata sandi Super Admin berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui kata sandi.');
    }
}
