<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin_hq',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'no_telp'  => '081111111111',
                'id_game'  => 'HQ-COMMANDER-01',
                'role'     => 'admin',
            ],
            [
                'username' => 'agent_strike',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'no_telp'  => '082222222222',
                'id_game'  => 'BS-AGENT-777',
                'role'     => 'user',
            ],
        ];

        // Membersihkan tabel sebelum seeder dijalankan (opsional, untuk mencegah duplikat)
        // $this->db->table('users')->emptyTable();

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
