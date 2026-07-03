<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToKreator extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kreator', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'suspended'],
                'default'    => 'active',
                'after'      => 'id_game'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('kreator', 'status');
    }
}
