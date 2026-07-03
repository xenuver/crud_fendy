<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdminMessageToLaporan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('laporan_mingguan', [
            'pesan_admin' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'status_validasi'
            ],
            'is_read' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'pesan_admin'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('laporan_mingguan', 'pesan_admin');
        $this->forge->dropColumn('laporan_mingguan', 'is_read');
    }
}
