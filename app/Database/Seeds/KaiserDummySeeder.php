<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KaiserDummySeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'user_id'                   => 2,
            'nama_lengkap'              => 'Kaiser',
            'kreator_id'                => 2,
            'platform'                  => 'youtube',
            'jumlah_video'              => 1,
            'total_views_video'         => 500000, // 500k avg
            'jumlah_shorts'             => 5,
            'views_shorts'              => 2500000, // 500k shorts avg
            'jumlah_live'               => 3,
            'total_views_live'          => 150000,
            'penonton_puncak_live'      => 1250, // Tier S qualifying CCV
            'foto_penonton_puncak_live' => 'kaiser_ccv.jpg',
            'foto_views_konten'         => 'kaiser_yt_vids.jpg',
            'foto_views_shorts'         => 'kaiser_shorts.jpg',
            'foto_views_livestream'     => 'kaiser_live.jpg',
            'status_validasi'           => 'valid',
            'created_at'                => date('Y-m-d H:i:s'),
            'updated_at'                => date('Y-m-d H:i:s')
        ];

        $db->table('laporan_mingguan')->insert($data);
        echo "Successfully added YouTube dummy data for Kaiser!\n";
    }
}
