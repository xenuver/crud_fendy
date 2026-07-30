<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KreatorModel;
use App\Models\RedeemCodeModel;
use CodeIgniter\HTTP\ResponseInterface;

// Controller untuk mengelola autentikasi pengguna.
class Auth extends BaseController
{
    protected UserModel $uModel;
    protected KreatorModel $kModel;
    protected RedeemCodeModel $rModel;
    protected \App\Models\SettingModel $sModel;
    protected \CodeIgniter\Database\BaseConnection $db;

    public function __construct()
    {
        $this->uModel = new UserModel();
        $this->kModel = new KreatorModel();
        $this->rModel = new RedeemCodeModel();
        $this->sModel = new \App\Models\SettingModel();
        $this->db = \Config\Database::connect();
    }
    // Menampilkan halaman depan (Landing Page).
    public function index(): string|ResponseInterface
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectDashboard();
        }

        $settings = [
            't1_ccv' => (int) $this->sModel->getSetting('tier1_ccv', 900),
            't1_yt' => (int) $this->sModel->getSetting('tier1_yt', 40000),
            't1_tt' => (int) $this->sModel->getSetting('tier1_tt', 80000),
            't2_ccv' => (int) $this->sModel->getSetting('tier2_ccv', 300),
            't2_yt' => (int) $this->sModel->getSetting('tier2_yt', 20000),
            't2_tt' => (int) $this->sModel->getSetting('tier2_tt', 50000),
            't3_ccv' => (int) $this->sModel->getSetting('tier3_ccv', 100),
            't3_yt' => (int) $this->sModel->getSetting('tier3_yt', 10000),
            't3_tt' => (int) $this->sModel->getSetting('tier3_tt', 30000),
        ];

        return view('landing', ['settings' => $settings]);
    }

    // Menampilkan halaman login.
    public function login_view(): string|ResponseInterface
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectDashboard();
        }
        return view('auth/login');
    }

    // Memproses verifikasi login pengguna.
    public function login(): ResponseInterface
    {
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress()), 5, MINUTE) === false) {
            session()->setFlashdata('error', 'Terlalu banyak percobaan login. Silakan tunggu 1 menit.');
            return redirect()->to('/login');
        }

        $session = session();
        $loginInput = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $user = $this->uModel->where('username', $loginInput)
            ->orWhere('no_telp', $loginInput)
            ->first();

        if ($user && password_verify($password, $user['password'])) {
            $idGameStr = (string) ($user['id_game'] ?? '');
            if ($user['role'] !== 'admin') {
                $this->kModel->getOrCreateProfile($idGameStr, $user['username']);
            }

            // Regenerasi session ID untuk mencegah Session Fixation Attack
            session()->regenerate(true);

            $session->set([
                'id' => $user['user_id'],
                'username' => $user['username'],
                'no_telp' => $user['no_telp'],
                'id_game' => $user['id_game'],
                'role' => $user['role'],
                'isLoggedIn' => true,
            ]);

            return $user['role'] == 'admin' ? redirect()->to('/admin') : redirect()->to('/user');
        }

        $session->setFlashdata('error', 'Username atau password salah.');
        return redirect()->to('/login');
    }

    // Menampilkan halaman akun ditangguhkan.
    public function suspended(): string
    {
        return view('auth/suspended');
    }

    // Memproses keluar log (Logout) pengguna.
    public function logout(): ResponseInterface
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }


    // Menampilkan halaman pendaftaran kreator (hanya bisa diakses via link khusus dari Admin).
    public function register_view(): string|ResponseInterface
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectDashboard();
        }

        $codeFromUrl = $this->request->getGet('code');

        if (!empty($codeFromUrl)) {
            // Kode datang dari URL → simpan/perbarui session
            $locked = strtoupper(trim($codeFromUrl));
            session()->set('locked_redeem_code', $locked);
        } else {
            // Tidak ada kode di URL → coba ambil dari session
            $locked = session()->get('locked_redeem_code');
            if (empty($locked)) {
                // Tidak ada kode sama sekali → tolak akses
                return redirect()->to('/login')->with('error', 'Halaman pendaftaran hanya dapat diakses melalui link khusus dari Admin.');
            }
        }

        return view('auth/register', ['requested_code' => $locked]);
    }

    // Memproses pendaftaran kreator menggunakan redeem code.
    public function register_save(): ResponseInterface
    {
        // Rate limiter: maks 5 percobaan per menit per IP
        $throttler = \Config\Services::throttler();
        if ($throttler->check('register_' . md5($this->request->getIPAddress()), 5, MINUTE) === false) {
            session()->setFlashdata('error', 'Terlalu banyak percobaan. Silakan tunggu 1 menit.');
            return redirect()->to('/register');
        }

        $rules = [
            'redeem_code' => 'required',
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'no_telp' => 'required|min_length[8]|max_length[18]|is_unique[users.no_telp]',
            'id_game' => 'required|min_length[5]|is_natural|is_unique[users.id_game]',
            'password' => 'required|min_length[8]',
        ];

        $messages = [
            'username' => ['is_unique' => 'Username sudah dipakai, coba yang lain.'],
            'no_telp' => ['is_unique' => 'Nomor telepon sudah terdaftar.'],
            'id_game' => [
                'is_unique' => 'ID Game sudah terdaftar oleh kreator lain.',
                'is_natural' => 'ID Game hanya boleh berupa angka (tanpa huruf, titik, spasi, atau karakter lain).'
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->to('/register')->withInput();
        }

        $this->db->transBegin();

        try {
            // Jika ada kode yang dikunci di session (dari link admin), pakai itu — abaikan input POST
            $lockedCode = session()->get('locked_redeem_code');
            if (!empty($lockedCode)) {
                $code = $lockedCode;
            } else {
                $code = strtoupper(trim($this->request->getPost('redeem_code')));
            }

            // Kunci baris redeem code menggunakan FOR UPDATE untuk mencegah duplikat concurrent
            $codeRow = $this->db->query("SELECT * FROM redeem_codes WHERE code = ? AND is_used = 0 FOR UPDATE", [$code])->getRowArray();

            if (!$codeRow) {
                throw new \RuntimeException('Redeem Code tidak valid atau sudah pernah digunakan.');
            }

            // Buat akun user baru
            $userData = [
                'username' => $this->request->getPost('username'),
                'no_telp' => $this->request->getPost('no_telp'),
                'id_game' => $this->request->getPost('id_game'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => 'user',
            ];

            $userId = $this->uModel->insert($userData, true);

            if (!$userId) {
                throw new \RuntimeException('Gagal membuat akun pengguna.');
            }

            // Buat profil kreator otomatis jika belum ada (atau update nama jika sudah pre-created oleh admin)
            $existingKreator = $this->kModel->where('id_game', $this->request->getPost('id_game'))->first();
            if (!$existingKreator) {
                $this->kModel->insert([
                    'nama' => $this->request->getPost('username'),
                    'alamat' => 'Indonesia',
                    'id_game' => $this->request->getPost('id_game'),
                ]);
            } else {
                $this->kModel->update($existingKreator['kreator_id'], [
                    'nama' => $this->request->getPost('username')
                ]);
            }

            // Tandai redeem code sebagai terpakai
            $this->rModel->markAsUsed($code, $userId);

            // Hapus kode dari session setelah berhasil dipakai
            session()->remove('locked_redeem_code');

            // Jika semua sukses, commit transaksi
            $this->db->transCommit();
        } catch (\Exception $e) {
            // Jika ada yang gagal, rollback semua perubahan database
            $this->db->transRollback();
            session()->setFlashdata('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
            return redirect()->to('/register')->withInput();
        }

        session()->setFlashdata('success', 'Akun berhasil dibuat! Silakan login dengan username dan password Anda.');
        return redirect()->to('/login');
    }
}
