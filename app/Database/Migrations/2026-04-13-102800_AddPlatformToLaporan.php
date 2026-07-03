<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPlatformToLaporan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('laporan_mingguan', [
            'platform' => [
                'type'       => 'ENUM',
                'constraint' => ['youtube', 'tiktok'],
                'default'    => 'tiktok',
                'after'      => 'kreator_id'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('laporan_mingguan', 'platform');
    }
}
