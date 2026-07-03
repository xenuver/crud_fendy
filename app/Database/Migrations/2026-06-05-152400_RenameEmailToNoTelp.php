<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameEmailToNoTelp extends Migration
{
    public function up()
    {
        if ($this->db->fieldExists('email', 'users')) {
            $this->forge->modifyColumn('users', [
                'email' => [
                    'name'       => 'no_telp',
                    'type'       => 'VARCHAR',
                    'constraint' => '20',
                    'unique'     => true,
                    'null'       => true,
                ]
            ]);
        } elseif (!$this->db->fieldExists('no_telp', 'users')) {
            $this->forge->addColumn('users', [
                'no_telp' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '20',
                    'unique'     => true,
                    'null'       => true,
                    'after'      => 'username',
                ]
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('no_telp', 'users')) {
            $this->forge->modifyColumn('users', [
                'no_telp' => [
                    'name'       => 'email',
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'unique'     => true,
                    'null'       => true,
                ]
            ]);
        }
    }
}
