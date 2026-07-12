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

    /**
     * Menampilkan rekap laporan bulanan untuk kepentingan audit dan leaderboard.
     */
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

    /**
     * Mengekspor data rekap bulanan ke format file Excel (.xlsx).
     */
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
                'yt_avg' => $r['yt_vids'] > 0 ? ($r['yt_views'] / $r['yt_vids']) : 0,
                'yt_shorts_avg' => $r['yt_shorts_count'] > 0 ? ($r['yt_shorts_views'] / $r['yt_shorts_count']) : 0,
                'tt_avg' => $r['tt_vids'] > 0 ? ($r['tt_views'] / $r['tt_vids']) : 0
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

        $sheet->setCellValue('A1', 'LAPORAN BULANAN KREATOR - BLOODSTRIKE');
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $sheet->setCellValue('A2', 'Periode: ' . date('F', mktime(0, 0, 0, $bulan, 10)) . ' ' . $tahun);
        $sheet->mergeCells('A2:J2');

        $headers = ['RANK', 'NAMA KREATOR', 'GAME ID (UID)', 'YT REG VIEWS', 'YT SHORTS VIEWS', 'YT LIVE VIEWS', 'TT CONTEN VIEWS', 'TT LIVE VIEWS', 'MAX CCV', 'PANGKAT AKHIR'];
        $column = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($column . '4', $h);
            $sheet->getStyle($column . '4')->getFont()->setBold(true);
            $sheet->getStyle($column . '4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFEA1917');
            $sheet->getStyle($column . '4')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $column++;
        }

        $row = 5;
        $rank = 1;
        foreach ($results as $r) {
            $sheet->setCellValue('A' . $row, $rank++);
            $sheet->setCellValue('B' . $row, $r['nama']);
            $sheet->setCellValue('C' . $row, $r['id_game']);
            $sheet->setCellValue('D' . $row, $r['yt_views']);
            $sheet->setCellValue('E' . $row, $r['yt_shorts_views']);
            $sheet->setCellValue('F' . $row, $r['yt_live_views']);
            $sheet->setCellValue('G' . $row, $r['tt_views']);
            $sheet->setCellValue('H' . $row, $r['tt_live_views']);
            $sheet->setCellValue('I' . $row, $r['max_ccv'] ?: 0);
            $sheet->setCellValue('J' . $row, $r['tier_label']);
            $row++;
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
