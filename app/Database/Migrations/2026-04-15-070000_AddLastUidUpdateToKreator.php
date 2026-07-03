<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLastUidUpdateToKreator extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kreator', [
            'last_uid_update' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
                'after'   => 'id_game',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('kreator', 'last_uid_update');
    }
}
