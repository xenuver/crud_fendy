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

    // Menampilkan daftar seluruh laporan masuk untuk Admin.
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

        $laporansRaw = $builder->orderBy('created_at', 'DESC')->paginate(20, 'laporan');
        $pager = $this->lModel->pager;
        $kreators = $this->kModel->getKreatorsWithMetrics();

        // Menghubungkan laporan dengan profil kreator dan menghitung tanggal periode mingguan untuk dikirim ke View.
        $kreatorIndex = [];
        foreach ($kreators as $kr) {
            $kreatorIndex[$kr['kreator_id']] = $kr;
        }

        $laporans = [];
        foreach ($laporansRaw as $lap) {
            $lap['krData'] = $kreatorIndex[$lap['kreator_id']] ?? null;
            $lap['periode_kinerja'] = $this->hitungPeriodeKinerja($lap['created_at']);
            $laporans[] = $lap;
        }

        $judul = "Laporan Mingguan Kreator";
        if ($platform == 'youtube')
            $judul = "Laporan Khusus YouTube";
        if ($platform == 'tiktok')
            $judul = "Laporan Khusus TikTok";

        $data = [
            "judul" => $judul,
            "laporans" => $laporans,
            "pager" => $pager,
            "tglMulai" => $tglMulai,
            "tglSelesai" => $tglSelesai,
        ];

        return $this->renderView("admin/laporan_mingguan", $data);
    }

    // Menghitung rentang tanggal periode kinerja dari tanggal pengiriman laporan.
    // Kreator mengirimkan laporan di awal minggu untuk melaporkan kinerja minggu sebelumnya.
    private function hitungPeriodeKinerja(string $createdAt): string
    {
        $lapTime = strtotime($createdAt);
        $mondayOfSub = strtotime('monday this week', $lapTime);
        $startPerf = date('d M', strtotime('-7 days', $mondayOfSub));
        $endPerf = date('d M Y', strtotime('-1 day', $mondayOfSub));
        return "{$startPerf} - {$endPerf}";
    }


    // Menghapus data laporan mingguan beserta file fisiknya.
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

        $this->db->transBegin();

        try {
            if (!$this->lModel->delete($id)) {
                throw new \RuntimeException('Gagal menghapus data laporan dari database.');
            }

            $this->db->transCommit();

            $deleteFile($laporan['foto_views_konten']);
            $deleteFile($laporan['foto_views_livestream']);
            $deleteFile($laporan['foto_penonton_puncak_live'] ?? null);
            $deleteFile($laporan['foto_views_shorts'] ?? null);

            session()->setFlashdata('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    // Memverifikasi (Validasi) status laporan mingguan (Valid/Tidak Valid) oleh Admin.
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

    //Mengekspor data laporan mingguan ke format Excel.

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

        // 1. Title Styling
        $sheet->setCellValue('A1', 'LAPORAN MINGGUAN KREATOR - BLOODSTRIKE');
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFC00000'));
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $periodeStr = ($tglMulai && $tglSelesai) ? "($tglMulai s/d $tglSelesai)" : "Semua Periode";
        $sheet->setCellValue('A2', 'Rentang Data: ' . $periodeStr);
        $sheet->mergeCells('A2:J2');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(11);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // 2. Header Row Styling
        $headers = [
            'NO',
            'TANGGAL SUBMIT',
            'NAMA KREATOR',
            'UID / GAME ID',
            'PLATFORM',
            'VIEWS VIDEO REGULER',
            'VIEWS SHORTS (YT)',
            'VIEWS LIVE STREAMING',
            'PUNCAK PENONTON (CCV)',
            'STATUS VALIDASI'
        ];

        $column = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($column . '4', $h);
            $column++;
        }

        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFC00000'], // Dark Red
            ],
        ];
        $sheet->getStyle('A4:J4')->applyFromArray($headerStyle);
        $sheet->getRowDimension('4')->setRowHeight(30);

        // 3. Populate Data Rows
        $row = 5;
        $no = 1;
        foreach ($laporans as $lap) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, date('d-m-Y H:i', strtotime($lap['created_at'])));
            $sheet->setCellValue('C' . $row, $lap['nama_lengkap']);
            $sheet->setCellValueExplicit('D' . $row, $lap['uid'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('E' . $row, strtoupper($lap['platform']));
            $sheet->setCellValue('F' . $row, $lap['total_views_video']);
            $sheet->setCellValue('G' . $row, ($lap['platform'] == 'youtube') ? $lap['views_shorts'] : 0);
            $sheet->setCellValue('H' . $row, $lap['total_views_live']);
            $sheet->setCellValue('I' . $row, $lap['penonton_puncak_live']);
            $sheet->setCellValue('J' . $row, strtoupper($lap['status_validasi']));

            // Zebra striping
            $rowColor = ($row % 2 == 0) ? 'FFF9F9F9' : 'FFFFFFFF';
            $rowStyle = [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => $rowColor],
                ],
            ];
            $sheet->getStyle("A$row:J$row")->applyFromArray($rowStyle);
            $sheet->getRowDimension($row)->setRowHeight(20);
            $row++;
        }

        // 4. Alignments & Formatting
        $lastRow = $row - 1;
        if ($lastRow >= 5) {
            $sheet->getStyle("A5:B$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D5:E$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("J5:J$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C5:C$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            // Format numbers with thousands separator and align right
            $sheet->getStyle("F5:I$lastRow")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("F5:I$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

            // Apply grid borders
            $borderStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFDDDDDD'],
                    ],
                ],
            ];
            $sheet->getStyle("A4:J$lastRow")->applyFromArray($borderStyle);
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
