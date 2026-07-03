<?php

if (!function_exists('is_submission_open')) {
    /**
     * Helper untuk mengecek apakah periode input laporan sedang dibuka
     * Window: Senin 00:00 - Rabu 15:00
     */
    function is_submission_open()
    {
        $db = \Config\Database::connect();
        $override = $db->table('settings')->where('sys_key', 'form_submission_override')->get()->getRow();
        
        $val = $override ? (string)$override->sys_value : '0';

        // 1. PRIORITAS UTAMA: FORCE CLOSE (Status 2)
        if ($val === '2') {
            return false;
        }

        // 2. FORCE OPEN (Status 1)
        if ($val === '1') {
            return true;
        }

        // 3. JADWAL OTOMATIS (Status 0 atau null)
        $day = (int) date('N'); 
        $hour = (int) date('H');
        
        if ($day === 1 || $day === 2) {
            return true;
        }
        
        if ($day === 3 && $hour < 15) {
            return true;
        }

        return false;
    }
}
