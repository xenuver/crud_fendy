<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Migration: Menambahkan kolom email ke tabel kreator untuk notifikasi email
class AddEmailToKreator extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kreator', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
                'after'      => 'nama',
                'comment'    => 'Alamat email kreator untuk notifikasi otomatis',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('kreator', 'email');
    }
}
