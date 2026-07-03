<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'setting_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'sys_key' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'sys_value' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('setting_id', true);
        $this->forge->addUniqueKey('sys_key');
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
