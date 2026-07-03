<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;
use CodeIgniter\HTTP\ResponseInterface;

class PengaturanMetrik extends BaseController
{
    protected SettingModel $sModel;

    public function __construct()
    {
        $this->sModel = new SettingModel();
    }

    /**
     * Menampilkan Halaman Pengaturan Metrik Penilaian.
     */
    public function index()
    {
        $settings = [
            'tier1_ccv' => (int)$this->sModel->getSetting('tier1_ccv', 900),
            'tier1_yt'  => (int)$this->sModel->getSetting('tier1_yt', 40000),
            'tier1_tt'  => (int)$this->sModel->getSetting('tier1_tt', 80000),
            'tier2_ccv' => (int)$this->sModel->getSetting('tier2_ccv', 300),
            'tier2_yt'  => (int)$this->sModel->getSetting('tier2_yt', 20000),
            'tier2_tt'  => (int)$this->sModel->getSetting('tier2_tt', 50000),
            'tier3_ccv' => (int)$this->sModel->getSetting('tier3_ccv', 100),
            'tier3_yt'  => (int)$this->sModel->getSetting('tier3_yt', 10000),
            'tier3_tt'  => (int)$this->sModel->getSetting('tier3_tt', 30000),
            'form_submission_override' => (int)$this->sModel->getSubmissionOverride()
        ];

        $data = [
            'judul'    => 'Pengaturan Metrik Penilaian',
            'settings' => $settings
        ];

        return $this->renderView('admin/pengaturan_metrik', $data);
    }

    /**
     * Memproses pembaruan pengaturan metrik penilaian.
     */
    public function update(): ResponseInterface
    {
        $rules = [
            'tier1_ccv' => 'required|integer|greater_than_equal_to[0]',
            'tier1_yt'  => 'required|integer|greater_than_equal_to[0]',
            'tier1_tt'  => 'required|integer|greater_than_equal_to[0]',
            'tier2_ccv' => 'required|integer|greater_than_equal_to[0]',
            'tier2_yt'  => 'required|integer|greater_than_equal_to[0]',
            'tier2_tt'  => 'required|integer|greater_than_equal_to[0]',
            'tier3_ccv' => 'required|integer|greater_than_equal_to[0]',
            'tier3_yt'  => 'required|integer|greater_than_equal_to[0]',
            'tier3_tt'  => 'required|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $tier1_ccv = (int)$this->request->getPost('tier1_ccv');
        $tier2_ccv = (int)$this->request->getPost('tier2_ccv');
        $tier3_ccv = (int)$this->request->getPost('tier3_ccv');

        $tier1_yt = (int)$this->request->getPost('tier1_yt');
        $tier2_yt = (int)$this->request->getPost('tier2_yt');
        $tier3_yt = (int)$this->request->getPost('tier3_yt');

        $tier1_tt = (int)$this->request->getPost('tier1_tt');
        $tier2_tt = (int)$this->request->getPost('tier2_tt');
        $tier3_tt = (int)$this->request->getPost('tier3_tt');

        if ($tier1_ccv <= $tier2_ccv || $tier2_ccv <= $tier3_ccv) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: Tier 1 CCV harus lebih besar dari Tier 2 CCV, dan Tier 2 CCV harus lebih besar dari Tier 3 CCV.');
        }
        if ($tier1_yt <= $tier2_yt || $tier2_yt <= $tier3_yt) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: Tier 1 YT Views harus lebih besar dari Tier 2 YT Views, dan Tier 2 YT Views harus lebih besar dari Tier 3 YT Views.');
        }
        if ($tier1_tt <= $tier2_tt || $tier2_tt <= $tier3_tt) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: Tier 1 TT Views harus lebih besar dari Tier 2 TT Views, dan Tier 2 TT Views harus lebih besar dari Tier 3 TT Views.');
        }

        $fields = [
            'tier1_ccv', 'tier1_yt', 'tier1_tt',
            'tier2_ccv', 'tier2_yt', 'tier2_tt',
            'tier3_ccv', 'tier3_yt', 'tier3_tt'
        ];

        $success = true;
        foreach ($fields as $field) {
            $value = $this->request->getPost($field);
            if (!$this->sModel->updateSetting($field, $value)) {
                $success = false;
            }
        }

        if ($success) {
            return redirect()->to(base_url('admin/settings'))->with('success', 'Metrik penilaian berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui beberapa pengaturan.');
        }
    }
}
