<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LaporanMingguanModel;
use App\Models\KreatorModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanBulanan extends BaseController
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

    // Menampilkan rekap laporan bulanan untuk kepentingan audit dan leaderboard.
    public function index(): string|ResponseInterface
    {
        $bulanInput = $this->request->getGet('bulan') ?: date('m');
        $tahunInput = $this->request->getGet('tahun') ?: date('Y');

        $bulan = sprintf('%02d', max(1, min(12, (int) $bulanInput)));
        $tahun = sprintf('%04d', max(1970, min(2099, (int) $tahunInput)));

        $startDate = sprintf('%04d-%02d-01 00:00:00', $tahun, $bulan);
        $endDate = date('Y-m-t 23:59:59', strtotime($startDate));

        $builder = $this->db->table('kreator');
        $builder->select('kreator.kreator_id, kreator.nama, kreator.id_game');
        $builder->join('users', 'users.id_game = kreator.id_game', 'left');
        $builder->groupStart()
                ->where('users.role !=', 'admin')
                ->orWhere('users.role', null)
        ->groupEnd();
        $builder->select('MAX(laporan_mingguan.penonton_puncak_live) as max_ccv');
        $builder->select('SUM(CASE WHEN platform = "youtube" THEN laporan_mingguan.total_views_video ELSE 0 END) as yt_views');
        $builder->select('SUM(CASE WHEN platform = "youtube" THEN laporan_mingguan.jumlah_video ELSE 0 END) as yt_vids');
        $builder->select('SUM(CASE WHEN platform = "youtube" THEN laporan_mingguan.views_shorts ELSE 0 END) as yt_shorts_views');
        $builder->select('SUM(CASE WHEN platform = "youtube" THEN laporan_mingguan.jumlah_shorts ELSE 0 END) as yt_shorts_count');
        $builder->select('SUM(CASE WHEN platform = "youtube" THEN laporan_mingguan.total_views_live ELSE 0 END) as yt_live_views');
        $builder->select('SUM(CASE WHEN platform = "tiktok" THEN laporan_mingguan.total_views_video ELSE 0 END) as tt_views');
        $builder->select('SUM(CASE WHEN platform = "tiktok" THEN laporan_mingguan.jumlah_video ELSE 0 END) as tt_vids');
        $builder->select('SUM(CASE WHEN platform = "tiktok" THEN laporan_mingguan.total_views_live ELSE 0 END) as tt_live_views');

        $builder->join('laporan_mingguan', 'laporan_mingguan.kreator_id = kreator.kreator_id', 'left');
        $builder->where('laporan_mingguan.status_validasi', 'valid');
        $builder->where('DATE_SUB(laporan_mingguan.created_at, INTERVAL WEEKDAY(laporan_mingguan.created_at) + 1 DAY) >=', $startDate);
        $builder->where('DATE_SUB(laporan_mingguan.created_at, INTERVAL WEEKDAY(laporan_mingguan.created_at) + 1 DAY) <=', $endDate);
        $builder->groupBy('kreator.kreator_id');
        $results = $builder->get()->getResultArray();

        foreach ($results as &$r) {
            $tierResult = $this->kModel->processTiering([
                'peak_ccv' => $r['max_ccv'],
                'yt_views' => $r['yt_views'],
                'yt_vids' => $r['yt_vids'],
                'yt_shorts_views' => $r['yt_shorts_views'],
                'yt_shorts_vids' => $r['yt_shorts_count'],
                'yt_live_views' => $r['yt_live_views'],
                'tt_views' => $r['tt_views'],
                'tt_vids' => $r['tt_vids'],
                'tt_live_views' => $r['tt_live_views'],
                'nama' => $r['nama'],
                'id_game' => $r['id_game']
            ]);
            $r = array_merge($r, $tierResult);
            $r['tier'] = $r['tier_label'];
        }

        usort($results, function ($a, $b) {
            if ($a['tier_level'] === $b['tier_level']) {
                return $b['total_views'] <=> $a['total_views'];
            }
            return $a['tier_level'] <=> $b['tier_level'];
        });

        $data = [
            'judul' => 'Arsip Laporan Bulanan',
            'results' => $results,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'months' => [
                '12' => 'DESEMBER', '11' => 'NOVEMBER', '10' => 'OKTOBER', '09' => 'SEPTEMBER',
                '08' => 'AGUSTUS', '07' => 'JULI', '06' => 'JUNI', '05' => 'MEI',
                '04' => 'APRIL', '03' => 'MARET', '02' => 'FEBRUARI', '01' => 'JANUARI'
            ]
        ];

        return $this->renderView("laporan/bulanan", $data);
    }

    // Mengekspor data rekap bulanan ke format file Excel (.xlsx).
    public function export(): ResponseInterface
    {
        $bulanInput = $this->request->getGet('bulan') ?: date('m');
        $tahunInput = $this->request->getGet('tahun') ?: date('Y');

        $bulan = sprintf('%02d', max(1, min(12, (int) $bulanInput)));
        $tahun = sprintf('%04d', max(1970, min(2099, (int) $tahunInput)));

        $startDate = sprintf('%04d-%02d-01 00:00:00', $tahun, $bulan);
        $endDate = date('Y-m-t 23:59:59', strtotime($startDate));

        $builder = $this->db->table('kreator');
        $builder->select('kreator.nama, kreator.id_game');
        $builder->join('users', 'users.id_game = kreator.id_game', 'left');
        $builder->groupStart()
                ->where('users.role !=', 'admin')
                ->orWhere('users.role', null)
        ->groupEnd();
        $builder->select('MAX(laporan_mingguan.penonton_puncak_live) as max_ccv');
        $builder->select('SUM(CASE WHEN platform = "youtube" THEN laporan_mingguan.total_views_video ELSE 0 END) as yt_views');
        $builder->select('SUM(CASE WHEN platform = "youtube" THEN laporan_mingguan.jumlah_video ELSE 0 END) as yt_vids');
        $builder->select('SUM(CASE WHEN platform = "youtube" THEN laporan_mingguan.views_shorts ELSE 0 END) as yt_shorts_views');
        $builder->select('SUM(CASE WHEN platform = "youtube" THEN laporan_mingguan.jumlah_shorts ELSE 0 END) as yt_shorts_count');
        $builder->select('SUM(CASE WHEN platform = "youtube" THEN laporan_mingguan.total_views_live ELSE 0 END) as yt_live_views');
        $builder->select('SUM(CASE WHEN platform = "tiktok" THEN laporan_mingguan.total_views_video ELSE 0 END) as tt_views');
        $builder->select('SUM(CASE WHEN platform = "tiktok" THEN laporan_mingguan.jumlah_video ELSE 0 END) as tt_vids');
        $builder->select('SUM(CASE WHEN platform = "tiktok" THEN laporan_mingguan.total_views_live ELSE 0 END) as tt_live_views');

        $builder->join('laporan_mingguan', 'laporan_mingguan.kreator_id = kreator.kreator_id', 'left');
        $builder->where('laporan_mingguan.status_validasi', 'valid');
        $builder->where('DATE_SUB(laporan_mingguan.created_at, INTERVAL WEEKDAY(laporan_mingguan.created_at) + 1 DAY) >=', $startDate);
        $builder->where('DATE_SUB(laporan_mingguan.created_at, INTERVAL WEEKDAY(laporan_mingguan.created_at) + 1 DAY) <=', $endDate);
        $builder->groupBy('kreator.kreator_id');

        $results = $builder->get()->getResultArray();

        foreach ($results as &$r) {
            $r['total_views'] = $r['yt_views'] + $r['yt_shorts_views'] + $r['yt_live_views'] + $r['tt_views'] + $r['tt_live_views'];
            $metrics = [
                'peak_ccv' => $r['max_ccv'],
                'yt_avg'   => ($r['yt_views'] + $r['yt_shorts_views'] + $r['yt_live_views']) / 4,
                'tt_avg'   => ($r['tt_views'] + $r['tt_live_views']) / 4
            ];
            $tierData = LaporanMingguanModel::calculateTier($metrics);
            $r['tier_level'] = (int) filter_var($tierData['name'], FILTER_SANITIZE_NUMBER_INT);
            $r['tier_label'] = $tierData['label'];
        }

        usort($results, function ($a, $b) {
            if ($a['tier_level'] === $b['tier_level']) {
                return $b['total_views'] <=> $a['total_views'];
            }
            return $a['tier_level'] <=> $b['tier_level'];
        });

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Title Styling
        $sheet->setCellValue('A1', 'LAPORAN BULANAN KREATOR - BLOODSTRIKE');
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFC00000'));
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $monthName = date('F', mktime(0, 0, 0, $bulan, 10));
        // Translate month name to Indonesian
        $monthsId = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April',
            'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus',
            'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];
        $bulanIndo = $monthsId[$monthName] ?? $monthName;

        $sheet->setCellValue('A2', 'Periode: ' . $bulanIndo . ' ' . $tahun);
        $sheet->mergeCells('A2:J2');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(11);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // 2. Header Row Styling
        $headers = [
            'PERINGKAT', 
            'NAMA KREATOR', 
            'UID / GAME ID', 
            'VIEWS VIDEO YT', 
            'VIEWS SHORTS YT', 
            'VIEWS LIVE YT', 
            'VIEWS VIDEO TIKTOK', 
            'VIEWS LIVE TIKTOK', 
            'MAX CCV (PUNCAK)', 
            'PANGKAT / TIER AKHIR'
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
        $rank = 1;
        foreach ($results as $r) {
            $sheet->setCellValue('A' . $row, $rank++);
            $sheet->setCellValue('B' . $row, $r['nama']);
            $sheet->setCellValueExplicit('C' . $row, $r['id_game'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $row, $r['yt_views']);
            $sheet->setCellValue('E' . $row, $r['yt_shorts_views']);
            $sheet->setCellValue('F' . $row, $r['yt_live_views']);
            $sheet->setCellValue('G' . $row, $r['tt_views']);
            $sheet->setCellValue('H' . $row, $r['tt_live_views']);
            $sheet->setCellValue('I' . $row, $r['max_ccv'] ?: 0);
            $sheet->setCellValue('J' . $row, $r['tier_label']);

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
            $sheet->getStyle("A5:A$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C5:C$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("J5:J$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B5:B$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            // Format numbers with thousands separator and align right
            $sheet->getStyle("D5:I$lastRow")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("D5:I$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

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
        $filename = "Laporan_Bulanan_{$bulan}_{$tahun}.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}

