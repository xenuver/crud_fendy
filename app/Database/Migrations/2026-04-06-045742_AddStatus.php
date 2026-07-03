<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatus extends Migration
{
    public function up()
    {
        $this->forge->addColumn('laporan_mingguan', [
            'status_validasi' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'pending',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('laporan_mingguan', 'status_validasi');
    }
}
