<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KreatorModel;

class DaftarPangkat extends BaseController
{
    protected KreatorModel $kModel;

    public function __construct()
    {
        $this->kModel = new KreatorModel();
    }

    /**
     * Menampilkan Halaman Penjenjangan (Tiering) Kreator.
     */
    public function index()
    {
        $tierFilter = $this->request->getGet('tier');
        $kreators   = $this->kModel->getKreatorsWithMetrics();

        foreach ($kreators as $key => &$k) {
            $k = $this->kModel->analyzeActivity($k);
            
            // Terapkan filter jika dipilih
            if ($tierFilter && $k['tier_label'] !== $tierFilter) {
                unset($kreators[$key]);
            }
        }

        $data = [
            'judul'      => 'Pusat Penjenjangan Kreator',
            'kreators'   => $kreators,
            'tierFilter' => $tierFilter
        ];

        return $this->renderView('admin/daftar_pangkat', $data);
    }
}
