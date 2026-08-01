<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBandingToLaporanAndSuperAdminRole extends Migration
{
    public function up()
    {
        // 1. Tambah kolom banding ke tabel laporan_mingguan
        $this->forge->addColumn('laporan_mingguan', [
            'status_banding' => [
                'type'       => 'ENUM',
                'constraint' => ['menunggu', 'diterima', 'ditolak_final'],
                'null'       => true,
                'default'    => null,
                'after'      => 'pesan_admin',
            ],
            'alasan_banding' => [
                'type'    => 'TEXT',
                'null'    => true,
                'default' => null,
                'after'   => 'status_banding',
            ],
            'catatan_superadmin' => [
                'type'    => 'TEXT',
                'null'    => true,
                'default' => null,
                'after'   => 'alasan_banding',
            ],
        ]);

        // 2. Ubah ENUM role di tabel users agar mendukung role super_admin
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user', 'super_admin') NOT NULL DEFAULT 'user'");
    }

    public function down()
    {
        $this->forge->dropColumn('laporan_mingguan', ['status_banding', 'alasan_banding', 'catatan_superadmin']);
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user') NOT NULL DEFAULT 'user'");
    }
}
