<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameRedeemKeys extends Migration
{
    public function up()
    {
        $fieldsRedeem = [
            'id' => [
                'name'           => 'redeem_id',
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ];
        $this->forge->modifyColumn('redeem_codes', $fieldsRedeem);
    }

    public function down()
    {
        $fieldsRedeem = [
            'redeem_id' => [
                'name'           => 'id',
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ];
        $this->forge->modifyColumn('redeem_codes', $fieldsRedeem);
    }
}
