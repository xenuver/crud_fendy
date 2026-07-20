<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ⚠️  KEAMANAN: Password diambil dari variabel environment.
        // Sebelum menjalankan seeder ini, pastikan variabel berikut
        // sudah di-set di file .env kamu:
        //   ADMIN_SEED_PASSWORD  = password_admin_kamu
        //   USER_SEED_PASSWORD   = password_user_kamu
        $adminPassword = env('ADMIN_SEED_PASSWORD', 'GANTI_SEBELUM_DEPLOY');
        $userPassword  = env('USER_SEED_PASSWORD', 'GANTI_SEBELUM_DEPLOY');

        $data = [
            [
                'username' => 'admin_hq',
                'password' => password_hash($adminPassword, PASSWORD_DEFAULT),
                'no_telp'  => '081111111111',
                'id_game'  => 'HQ-COMMANDER-01',
                'role'     => 'admin',
            ],
            [
                'username' => 'agent_strike',
                'password' => password_hash($userPassword, PASSWORD_DEFAULT),
                'no_telp'  => '082222222222',
                'id_game'  => 'BS-AGENT-777',
                'role'     => 'user',
            ],
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
