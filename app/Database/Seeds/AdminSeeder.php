<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin_baru',
            'password' => password_hash('admin_baru_123', PASSWORD_DEFAULT),
            'no_telp'  => '083333333333',
            'id_game'  => 'ADMIN-MASTER-01',
            'role'     => 'admin',
        ];

        // Memasukkan data ke tabel users
        $this->db->table('users')->insert($data);
    }
}
