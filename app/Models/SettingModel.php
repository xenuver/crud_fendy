<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola pengaturan sistem (tabel settings).
class SettingModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'setting_id';
    protected $allowedFields    = ['sys_key', 'sys_value', 'updated_at'];
    protected $useTimestamps    = true;
    protected $updatedField     = 'updated_at';

    // Cache internal untuk menyimpan pengaturan yang telah diambil dari database
    // guna menghindari query berulang dalam satu siklus request.
    private static $cache = null;

    // Mendapatkan nilai pengaturan berdasarkan key.
    //
    // @param string $key Kunci pengaturan
    // @param mixed $default Nilai default jika tidak ditemukan
    // @return mixed
    public function getSetting(string $key, $default = null)
    {
        // Jika cache belum terisi, muat semua setting sekaligus dalam satu query
        if (self::$cache === null) {
            self::$cache = [];
            $settings = $this->findAll();
            foreach ($settings as $setting) {
                self::$cache[$setting['sys_key']] = $setting['sys_value'];
            }
        }

        return array_key_key_exists_custom($key, self::$cache) ? self::$cache[$key] : $default;
    }

    // Mendapatkan status override pengiriman laporan.
    // 0 = Auto, 1 = Force Open, 2 = Force Close
    public function getSubmissionOverride()
    {
        return (int) $this->getSetting('form_submission_override', 0);
    }

    // Memperbarui nilai pengaturan.
    public function updateSetting(string $key, $value)
    {
        $updated = $this->where('sys_key', $key)->set(['sys_value' => $value])->update();
        if ($updated) {
            // Sinkronkan cache jika sudah ter-inisialisasi
            if (self::$cache !== null) {
                self::$cache[$key] = $value;
            }
        }
        return $updated;
    }
}

// Fungsi helper sederhana untuk pengecekan key di cache
if (!function_exists('array_key_key_exists_custom')) {
    function array_key_key_exists_custom($key, $array) {
        return array_key_exists($key, $array);
    }
}

