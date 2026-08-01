<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIndexesForPerformance extends Migration
{
    public function up()
    {
        // 1. Index untuk tabel redeem_codes (mempercepat pencarian is_used & used_by)
        $this->db->query("ALTER TABLE redeem_codes ADD INDEX idx_is_used (is_used)");
        $this->db->query("ALTER TABLE redeem_codes ADD INDEX idx_used_by (used_by)");

        // 2. Index untuk tabel users (mempercepat sorting & filter role, no_telp)
        $this->db->query("ALTER TABLE users ADD INDEX idx_role (role)");

        // 3. Index untuk tabel laporan_mingguan (mempercepat pencarian status_validasi, status_banding, kreator_id)
        $this->db->query("ALTER TABLE laporan_mingguan ADD INDEX idx_status_validasi (status_validasi)");
        $this->db->query("ALTER TABLE laporan_mingguan ADD INDEX idx_status_banding (status_banding)");
        $this->db->query("ALTER TABLE laporan_mingguan ADD INDEX idx_kreator_id (kreator_id)");
    }

    public function down()
    {
        @$this->db->query("ALTER TABLE redeem_codes DROP INDEX idx_is_used");
        @$this->db->query("ALTER TABLE redeem_codes DROP INDEX idx_used_by");
        @$this->db->query("ALTER TABLE users DROP INDEX idx_role");
        @$this->db->query("ALTER TABLE laporan_mingguan DROP INDEX idx_status_validasi");
        @$this->db->query("ALTER TABLE laporan_mingguan DROP INDEX idx_status_banding");
        @$this->db->query("ALTER TABLE laporan_mingguan DROP INDEX idx_kreator_id");
    }
}
