<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KreatorAndMedia extends Migration
{
    public function up()
    {
        // Table kreator
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama'        => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'alamat'      => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'id_game'     => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'foto_profil' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kreator');

        // Table media_kreator
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kreator_id'  => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'file_name'   => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'file_path'   => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'file_type'   => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'file_size'   => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'created_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('media_kreator');
    }

    public function down()
    {
        $this->forge->dropTable('media_kreator');
        $this->forge->dropTable('kreator');
    }
}
