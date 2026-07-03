<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCcvToLaporanMingguan extends Migration
{
    public function up()
    {
        $fields = [
            'jumlah_penonton_puncak' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => 0,
            ],
            'foto_bukti_ccv' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ];
        $this->forge->addColumn('laporan_mingguan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('laporan_mingguan', 'jumlah_penonton_puncak');
        $this->forge->dropColumn('laporan_mingguan', 'foto_bukti_ccv');
    }
}
