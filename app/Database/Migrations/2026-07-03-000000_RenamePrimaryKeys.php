<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenamePrimaryKeys extends Migration
{
    public function up()
    {
        // Menggunakan modifyColumn untuk me-rename primary key
        $fieldsUsers = [
            'id' => [
                'name'           => 'user_id',
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ];
        $this->forge->modifyColumn('users', $fieldsUsers);

        $fieldsKreator = [
            'id' => [
                'name'           => 'kreator_id',
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ];
        $this->forge->modifyColumn('kreator', $fieldsKreator);

        $fieldsLaporan = [
            'id' => [
                'name'           => 'laporan_id',
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ];
        $this->forge->modifyColumn('laporan_mingguan', $fieldsLaporan);

        $fieldsMedia = [
            'id' => [
                'name'           => 'media_id',
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ];
        $this->forge->modifyColumn('media_kreator', $fieldsMedia);
    }

    public function down()
    {
        $fieldsUsers = [
            'user_id' => [
                'name'           => 'id',
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ];
        $this->forge->modifyColumn('users', $fieldsUsers);

        $fieldsKreator = [
            'kreator_id' => [
                'name'           => 'id',
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ];
        $this->forge->modifyColumn('kreator', $fieldsKreator);

        $fieldsLaporan = [
            'laporan_id' => [
                'name'           => 'id',
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ];
        $this->forge->modifyColumn('laporan_mingguan', $fieldsLaporan);

        $fieldsMedia = [
            'media_id' => [
                'name'           => 'id',
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ];
        $this->forge->modifyColumn('media_kreator', $fieldsMedia);
    }
}
