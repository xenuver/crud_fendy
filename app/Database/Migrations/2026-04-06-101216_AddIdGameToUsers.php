<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdGameToUsers extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('id_game', 'users')) {
            $this->forge->addColumn('users', [
                'id_game' => [
                    'type' => 'VARCHAR',
                    'constraint' => '50',
                    'after' => 'no_telp',
                    'null' => true,
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'id_game');
    }
}
