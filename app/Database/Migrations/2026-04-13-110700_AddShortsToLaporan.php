<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddShortsToLaporan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('laporan_mingguan', [
            'jumlah_shorts' => [
                'type' => 'INT',
                'default' => 0,
                'after' => 'total_views_video'
            ],
            'views_shorts' => [
                'type' => 'BIGINT',
                'default' => 0,
                'after' => 'jumlah_shorts'
            ],
            'foto_views_shorts' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'foto_views_konten'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('laporan_mingguan', ['jumlah_shorts', 'views_shorts', 'foto_views_shorts']);
    }
}
