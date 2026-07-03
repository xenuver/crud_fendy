<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserIdToLaporan extends Migration
{
    public function up()
    {
        $fields = [
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'after'      => 'id', // Letakkan setelah kolom ID
                'null'       => true, // Allow null for old data
            ],
        ];
        $this->forge->addColumn('laporan_mingguan', $fields);
        
        // Add foreign key
        $this->db->query("ALTER TABLE laporan_mingguan ADD CONSTRAINT fk_user_laporan FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->forge->dropColumn('laporan_mingguan', 'user_id');
    }
}
