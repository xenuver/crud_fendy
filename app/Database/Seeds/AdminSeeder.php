<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // ⚠️  KEAMANAN: Password diambil dari variabel environment.
        // Sebelum menjalankan seeder ini, pastikan ADMIN_SEED_PASSWORD
        // sudah di-set di file .env kamu.
        // Contoh di .env: ADMIN_SEED_PASSWORD = password_rahasia_kamu
        $rawPassword = env('ADMIN_SEED_PASSWORD', 'GANTI_SEBELUM_DEPLOY');

        $data = [
            'username' => 'admin_baru',
            'password' => password_hash($rawPassword, PASSWORD_DEFAULT),
            'no_telp'  => '083333333333',
            'id_game'  => 'ADMIN-MASTER-01',
            'role'     => 'admin',
        ];

        // Memasukkan data ke tabel users
        $this->db->table('users')->insert($data);
    }
}
