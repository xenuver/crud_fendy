<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LaporanMingguanModel;
use App\Models\KreatorModel;
use App\Libraries\CloudStorageService;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanMingguan extends BaseController
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

    /**
     * Menampilkan daftar seluruh laporan masuk untuk Admin.
     */
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

        $builder = $this->lModel;

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

        $data = [
            "judul" => $judul,
            "laporans" => $laporans,
            "pager" => $pager,
            "kreators" => $kreators,
            "kreatorLogin" => null,
            "tglMulai" => $tglMulai,
            "tglSelesai" => $tglSelesai,
            "isOpen" => $this->isSubmissionOpen(),
            "hasSubmittedYt" => false,
            "hasSubmittedTt" => false
        ];

        return $this->renderView("laporan/mingguan", $data);
    }

    /**
     * Memperbarui data laporan mingguan (Edit Laporan oleh Admin).
     */
    public function update(): ResponseInterface
    {
        $id = $this->request->getPost('id');
        $laporanOld = $this->lModel->find($id);

        if (!$laporanOld) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->back();
        }

        $fileKonten = $this->request->getFile('foto_views_konten');
        $fileLive = $this->request->getFile('foto_views_livestream');
        $fileCcv = $this->request->getFile('foto_penonton_puncak_live');

        $platform = $laporanOld['platform'];

        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'jumlah_video' => 'required|is_natural|less_than_equal_to[1000]',
            'total_views_video' => 'required|is_natural|less_than_equal_to[1000000000]',
            'jumlah_live' => 'required|is_natural|less_than_equal_to[1000]',
            'total_views_live' => 'required|is_natural|less_than_equal_to[1000000000]',
            'penonton_puncak_live' => 'required|is_natural|less_than_equal_to[500000]',
        ];

        if ($platform === 'youtube') {
            $rules['jumlah_shorts'] = 'required|is_natural|less_than_equal_to[1000]';
            $rules['views_shorts'] = 'required|is_natural|less_than_equal_to[1000000000]';
        }

        if ($fileKonten && $fileKonten->isValid() && !$fileKonten->hasMoved()) {
            $rules['foto_views_konten'] = 'max_size[foto_views_konten,2048]|is_image[foto_views_konten]';
        }

        if ($fileLive && $fileLive->isValid() && !$fileLive->hasMoved()) {
            $rules['foto_views_livestream'] = 'max_size[foto_views_livestream,2048]|is_image[foto_views_livestream]';
        }

        if ($fileCcv && $fileCcv->isValid() && !$fileCcv->hasMoved()) {
            $rules['foto_penonton_puncak_live'] = 'max_size[foto_penonton_puncak_live,2048]|is_image[foto_penonton_puncak_live]';
        }

        if ($platform === 'youtube') {
            $fileShorts = $this->request->getFile('foto_views_shorts');
            if ($fileShorts && $fileShorts->isValid() && !$fileShorts->hasMoved()) {
                $rules['foto_views_shorts'] = 'max_size[foto_views_shorts,2048]|is_image[foto_views_shorts]';
            }
        }

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $storage = new CloudStorageService();

        $prosesGambar = function ($file, $oldFoto) use ($storage) {
            if (!$file || !$file->isValid() || $file->hasMoved()) {
                return $oldFoto;
            }

            $newFoto = null;
            if ($storage->isEnabled()) {
                $newFoto = $storage->upload($file, 'laporan');
            }

            if ($newFoto === null) {
                if (!is_dir(FCPATH . 'uploads/laporan')) {
                    mkdir(FCPATH . 'uploads/laporan', 0777, true);
                }
                $tempName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/laporan', $tempName);
                $tempPath = FCPATH . 'uploads/laporan/' . $tempName;
                $webpName = pathinfo($tempName, PATHINFO_FILENAME) . '.webp';
                $webpPath = FCPATH . 'uploads/laporan/' . $webpName;
                try {
                    \Config\Services::image()
                        ->withFile($tempPath)
                        ->resize(1000, 1000, true, 'height')
                        ->save($webpPath, 60);
                    @unlink($tempPath);
                    $newFoto = $webpName;
                } catch (\Exception $e) {
                    rename($tempPath, $webpPath);
                    $newFoto = $webpName;
                }
            }

            if ($newFoto !== null && !empty($oldFoto)) {
                if (CloudStorageService::isCloudUrl($oldFoto)) {
                    $storage->delete($oldFoto);
                } else {
                    $localPath = FCPATH . 'uploads/laporan/' . basename($oldFoto);
                    if (file_exists($localPath)) {
                        @unlink($localPath);
                    }
                }
            }

            return $newFoto;
        };

        $namaFotoKonten = $prosesGambar($fileKonten, $laporanOld['foto_views_konten']);
        $namaFotoLive = $prosesGambar($fileLive, $laporanOld['foto_views_livestream']);
        $namaFotoCcv = $prosesGambar($fileCcv, $laporanOld['foto_penonton_puncak_live'] ?? null);

        $namaFotoShorts = $laporanOld['foto_views_shorts'] ?? null;
        if ($platform == 'youtube') {
            $fileShorts = $this->request->getFile('foto_views_shorts');
            $namaFotoShorts = $prosesGambar($fileShorts, $namaFotoShorts);
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'jumlah_video' => $this->request->getPost('jumlah_video') ?: 0,
            'total_views_video' => $this->request->getPost('total_views_video') ?: 0,
            'jumlah_live' => $this->request->getPost('jumlah_live') ?: 0,
            'total_views_live' => $this->request->getPost('total_views_live') ?: 0,
            'penonton_puncak_live' => $this->request->getPost('penonton_puncak_live') ?: 0,
            'foto_views_konten' => $namaFotoKonten,
            'foto_views_livestream' => $namaFotoLive,
            'foto_penonton_puncak_live' => $namaFotoCcv,
            'status_validasi' => 'pending'
        ];

        if ($platform == 'youtube') {
            $data['jumlah_shorts'] = $this->request->getPost('jumlah_shorts') ?: 0;
            $data['views_shorts'] = $this->request->getPost('views_shorts') ?: 0;
            $data['foto_views_shorts'] = $namaFotoShorts;
        } else {
            $data['jumlah_shorts'] = 0;
            $data['views_shorts'] = 0;
            $data['foto_views_shorts'] = null;
        }

        if ($this->lModel->update($id, $data)) {
            session()->setFlashdata('success', 'Laporan berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui laporan.');
        }

        return redirect()->back();
    }

    /**
     * Menghapus data laporan mingguan beserta file fisiknya.
     */
    public function delete(int $id): ResponseInterface
    {
        $laporan = $this->lModel->find($id);

        if (!$laporan) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->back();
        }

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

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            if (!$this->lModel->delete($id)) {
                throw new \RuntimeException('Gagal menghapus data laporan dari database.');
            }

            $db->transCommit();

            $deleteFile($laporan['foto_views_konten']);
            $deleteFile($laporan['foto_views_livestream']);
            $deleteFile($laporan['foto_penonton_puncak_live'] ?? null);
            $deleteFile($laporan['foto_views_shorts'] ?? null);

            session()->setFlashdata('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    /**
     * Memverifikasi (Validasi) status laporan mingguan (Valid/Tidak Valid) oleh Admin.
     */
    public function verify(int $id): ResponseInterface
    {
        $status = $this->request->getPost('status');
        $pesan = $this->request->getPost('pesan');

        if (in_array($status, ['valid', 'tidak_valid', 'pending'])) {
            $updateData = [
                'status_validasi' => $status,
                'pesan_admin' => $pesan,
                'is_read' => ($status !== 'pending' ? 0 : 1)
            ];

            if ($this->lModel->update($id, $updateData)) {
                $msg = $status === 'valid' ? 'Laporan divalidasi sebagai VALID.' : 'Laporan ditandai sebagai TIDAK VALID.';
                session()->setFlashdata('success', $msg . ' Feedback telah dikirim.');
            }
        }

        return redirect()->back();
    }

    /**
     * Mengekspor data manifes mingguan (raw data) ke format Excel.
     */
    public function exportWeekly()
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

        $builder = $this->db->table('laporan_mingguan');
        $builder->select('laporan_mingguan.*, kreator.nama as nama_kreator, kreator.id_game as uid');
        $builder->join('kreator', 'kreator.kreator_id = laporan_mingguan.kreator_id', 'left');

        if ($platform && in_array($platform, ['youtube', 'tiktok']))
            $builder->where('laporan_mingguan.platform', $platform);
        if ($status && in_array($status, ['pending', 'valid', 'tidak_valid']))
            $builder->where('laporan_mingguan.status_validasi', $status);
        if ($tglMulai)
            $builder->where('DATE(laporan_mingguan.created_at) >=', $tglMulai);
        if ($tglSelesai)
            $builder->where('DATE(laporan_mingguan.created_at) <=', $tglSelesai);

        $builder->orderBy('laporan_mingguan.created_at', 'DESC');
        $laporans = $builder->get()->getResultArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'DATA MANIFES MINGGUAN KREATOR - BLOODSTRIKE');
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $periodeStr = ($tglMulai && $tglSelesai) ? "($tglMulai s/d $tglSelesai)" : "Semua Periode";
        $sheet->setCellValue('A2', 'Rentang Data: ' . $periodeStr);
        $sheet->mergeCells('A2:J2');

        $headers = ['NO', 'TANGGAL', 'NAMA KREATOR', 'UID', 'PLATFORM', 'VIDEO REG VIEWS', 'YT SHORTS VIEWS', 'LIVE VIEWS', 'PEAK CCV', 'STATUS'];
        $column = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($column . '4', $h);
            $sheet->getStyle($column . '4')->getFont()->setBold(true);
            $sheet->getStyle($column . '4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFEA1917');
            $sheet->getStyle($column . '4')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $column++;
        }

        $row = 5;
        $no = 1;
        foreach ($laporans as $lap) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, date('d/m/Y H:i', strtotime($lap['created_at'])));
            $sheet->setCellValue('C' . $row, $lap['nama_lengkap']);
            $sheet->setCellValue('D' . $row, $lap['uid']);
            $sheet->setCellValue('E' . $row, strtoupper($lap['platform']));
            $sheet->setCellValue('F' . $row, $lap['total_views_video']);
            $sheet->setCellValue('G' . $row, ($lap['platform'] == 'youtube') ? $lap['views_shorts'] : 0);
            $sheet->setCellValue('H' . $row, $lap['total_views_live']);
            $sheet->setCellValue('I' . $row, $lap['penonton_puncak_live']);
            $sheet->setCellValue('J' . $row, strtoupper($lap['status_validasi']));
            $row++;
        }

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "Laporan_Mingguan_Kreator_" . date('Ymd_His') . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
