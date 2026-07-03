<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Check if override setting exists
        $check = $db->table('settings')->where('sys_key', 'form_submission_override')->get()->getRow();
        
        if (!$check) {
            $db->table('settings')->insert([
                'sys_key'    => 'form_submission_override',
                'sys_value'  => '0',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
