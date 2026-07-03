<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSocialLinksToKreator extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kreator', [
            'tiktok_link'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'foto_profil'
            ],
            'youtube_link' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'tiktok_link'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('kreator', ['tiktok_link', 'youtube_link']);
    }
}
