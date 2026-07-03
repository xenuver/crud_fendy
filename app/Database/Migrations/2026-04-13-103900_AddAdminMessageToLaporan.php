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
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('laporan_mingguan', 'pesan_admin');
    }
}
