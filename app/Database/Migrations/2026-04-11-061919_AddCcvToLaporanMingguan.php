<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCcvToLaporanMingguan extends Migration
{
    public function up()
    {
        $fields = [
            'penonton_puncak_live' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => 0,
            ],
            'foto_penonton_puncak_live' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ];
        $this->forge->addColumn('laporan_mingguan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('laporan_mingguan', 'penonton_puncak_live');
        $this->forge->dropColumn('laporan_mingguan', 'foto_penonton_puncak_live');
    }
}
