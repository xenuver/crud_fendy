<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixLaporanColumnTypes extends Migration
{
    public function up()
    {
        // 1. Upgrade semua kolom views dari INT ke BIGINT
        // INT max ~2.1 miliar, BIGINT max ~9.2 kuadriliun — aman untuk kreator besar
        $this->db->query("
            ALTER TABLE `laporan_mingguan`
            MODIFY COLUMN `total_views_video`    BIGINT NOT NULL DEFAULT 0,
            MODIFY COLUMN `total_views_live`     BIGINT NOT NULL DEFAULT 0,
            MODIFY COLUMN `jumlah_penonton_puncak` BIGINT NULL DEFAULT 0,
            MODIFY COLUMN `jumlah_shorts`        INT NULL DEFAULT 0,
            MODIFY COLUMN `views_shorts`         BIGINT NULL DEFAULT 0
        ");

        // 2. Ubah status_validasi dari VARCHAR(50) ke ENUM untuk konsistensi dan keamanan tipe data
        // Pastikan tidak ada nilai lain sebelum mengubah ke ENUM
        $this->db->query("
            UPDATE `laporan_mingguan` 
            SET status_validasi = 'pending' 
            WHERE status_validasi NOT IN ('pending', 'valid', 'tidak_valid') 
               OR status_validasi IS NULL
        ");

        $this->db->query("
            ALTER TABLE `laporan_mingguan`
            MODIFY COLUMN `status_validasi` ENUM('pending', 'valid', 'tidak_valid') NOT NULL DEFAULT 'pending'
        ");
    }

    public function down()
    {
        // Rollback ke tipe semula
        $this->db->query("
            ALTER TABLE `laporan_mingguan`
            MODIFY COLUMN `total_views_video`    INT NOT NULL DEFAULT 0,
            MODIFY COLUMN `total_views_live`     INT NOT NULL DEFAULT 0,
            MODIFY COLUMN `jumlah_penonton_puncak` INT NULL DEFAULT 0,
            MODIFY COLUMN `status_validasi`      VARCHAR(50) NULL DEFAULT 'pending'
        ");
    }
}
