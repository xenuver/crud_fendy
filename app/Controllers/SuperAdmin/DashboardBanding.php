<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\LaporanMingguanModel;
use App\Models\KreatorModel;
use CodeIgniter\HTTP\ResponseInterface;

// Controller eksklusif Super Admin untuk mengelola pengajuan banding kreator.
class DashboardBanding extends BaseController
{
    protected LaporanMingguanModel $lModel;
    protected KreatorModel $kModel;
    protected \CodeIgniter\Database\BaseConnection $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Guard: hanya super_admin yang bisa akses controller ini
        if (session()->get('role') !== 'super_admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function __construct()
    {
        $this->lModel = new LaporanMingguanModel();
        $this->kModel = new KreatorModel();
        $this->db = \Config\Database::connect();
    }

    // Menampilkan halaman daftar banding kreator.
    public function index(): string
    {
        $filter = $this->request->getGet('filter') ?? 'menunggu';

        $builder = $this->lModel->where('status_validasi', 'tidak_valid');

        if ($filter === 'menunggu') {
            $builder = $builder->where('status_banding', 'menunggu');
        } elseif ($filter === 'selesai') {
            $builder = $builder->groupStart()
                ->where('status_banding', 'diterima')
                ->orWhere('status_banding', 'ditolak_final')
                ->groupEnd();
        } else {
            // semua — tampilkan yang ada status_banding
            $builder = $builder->where('status_banding IS NOT NULL', null, false);
        }

        $bandingRaw = $builder->orderBy('updated_at', 'DESC')->paginate(15, 'banding');
        $pager = $this->lModel->pager;

        // Gabungkan data kreator ke setiap banding
        $banding = [];
        foreach ($bandingRaw as $lap) {
            $lap['kreator'] = $this->kModel->find($lap['kreator_id']);
            $banding[] = $lap;
        }

        // Hitung ringkasan badge
        $jumlahMenunggu = $this->lModel
            ->where('status_validasi', 'tidak_valid')
            ->where('status_banding', 'menunggu')
            ->countAllResults();

        $data = [
            'judul'         => 'Panel Banding Kreator',
            'banding'       => $banding,
            'pager'         => $pager,
            'filter'        => $filter,
            'jumlahMenunggu' => $jumlahMenunggu,
        ];

        return $this->renderView('superadmin/dashboard_banding', $data);
    }

    // Memutuskan pengajuan banding: terima atau tolak.
    public function putuskan(int $id): ResponseInterface
    {
        $laporan = $this->lModel->find($id);

        if (!$laporan) {
            return redirect()->back()->with('error', 'Data laporan tidak ditemukan.');
        }

        if ($laporan['status_banding'] !== 'menunggu') {
            return redirect()->back()->with('error', 'Banding ini sudah pernah diputuskan sebelumnya.');
        }

        $keputusan = $this->request->getPost('keputusan');
        $catatan   = trim($this->request->getPost('catatan_superadmin') ?? '');

        if (!in_array($keputusan, ['diterima', 'ditolak_final'])) {
            return redirect()->back()->with('error', 'Keputusan tidak valid.');
        }

        if (empty($catatan)) {
            return redirect()->back()->with('error', 'Catatan keputusan wajib diisi.');
        }

        $updateData = [
            'status_banding'      => $keputusan,
            'catatan_superadmin'  => $catatan,
        ];

        // Jika banding diterima, ubah status validasi laporan menjadi valid
        if ($keputusan === 'diterima') {
            $updateData['status_validasi'] = 'valid';
            $updateData['is_read']         = 0; // Notifikasi ulang ke kreator
        } else {
            // Ditolak final — beri tahu kreator dengan is_read = 0
            $updateData['is_read'] = 0;
        }

        if ($this->lModel->update($id, $updateData)) {
            cache()->delete('kreators_with_metrics_list');
            $msg = ($keputusan === 'diterima')
                ? '✅ Banding diterima. Laporan kreator telah diubah menjadi VALID.'
                : '❌ Banding ditolak final. Laporan tetap tidak valid.';
            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Gagal menyimpan keputusan banding.');
    }
}
