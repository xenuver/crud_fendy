<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LaporanMingguan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'kreator_id'  => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'jumlah_video' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'total_views_video' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'jumlah_live' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'total_views_live' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'foto_views_konten' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'foto_views_livestream' => [
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
        ]);
        
        $this->forge->addKey('id', true);
        
        // Foreign Key constraint if needed (opsional tergantung storage engine)
        // $this->forge->addForeignKey('kreator_id', 'kreator', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('laporan_mingguan');
    }

    public function down()
    {
        $this->forge->dropTable('laporan_mingguan');
    }
}
