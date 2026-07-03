<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MeiRealDataSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $creatorsData = [
            // Tier 1 Creators (3 Youtube, 2 Tiktok)
            [
                'name'     => 'Jerry Tiktok',
                'ccv'      => 1800,
                'platform' => 'tiktok',
                'views'    => [176400, 302200, 409500, 372000],
                'id_game'  => '100010'
            ],
            [
                'name'     => 'Xval',
                'ccv'      => 1087,
                'platform' => 'tiktok',
                'views'    => [645000, 670000, 632000, 607000],
                'id_game'  => '100029'
            ],
            [
                'name'     => 'Elva',
                'ccv'      => 2600,
                'platform' => 'youtube',
                'views'    => [566900, 850600, 991700, 0],
                'id_game'  => '100007'
            ],
            [
                'name'     => 'Errmentok',
                'ccv'      => 1451,
                'platform' => 'youtube',
                'views'    => [555175, 1357500, 932900, 528100],
                'id_game'  => '100008'
            ],
            [
                'name'     => 'Nael',
                'ccv'      => 1000,
                'platform' => 'youtube',
                'views'    => [20723, 96470, 332040, 197641],
                'id_game'  => '100039'
            ],

            // Tier 2 Creators (2 Youtube, 3 Tiktok)
            [
                'name'     => 'Feels Gaming',
                'ccv'      => 898,
                'platform' => 'youtube',
                'views'    => [0, 428000, 476000, 493200],
                'id_game'  => '100006'
            ],
            [
                'name'     => 'Aurest',
                'ccv'      => 617,
                'platform' => 'youtube',
                'views'    => [0, 50000, 0, 0],
                'id_game'  => '100001'
            ],
            [
                'name'     => 'Hans7',
                'ccv'      => 427,
                'platform' => 'tiktok',
                'views'    => [140100, 136700, 107000, 156200],
                'id_game'  => '100012'
            ],
            [
                'name'     => 'Kaolla',
                'ccv'      => 364,
                'platform' => 'tiktok',
                'views'    => [144300, 281700, 177700, 215700],
                'id_game'  => '100018'
            ],
            [
                'name'     => 'Benjamin 889',
                'ccv'      => 327,
                'platform' => 'tiktok',
                'views'    => [291900, 294200, 0, 0],
                'id_game'  => '100003'
            ],

            // Tier 3 Creators (3 Youtube, 2 Tiktok)
            [
                'name'     => 'Lynch',
                'ccv'      => 266,
                'platform' => 'youtube',
                'views'    => [151100, 180200, 487200, 407300],
                'id_game'  => '100035'
            ],
            [
                'name'     => 'Paat',
                'ccv'      => 324,
                'platform' => 'youtube',
                'views'    => [37500, 65100, 71800, 36500],
                'id_game'  => '100013'
            ],
            [
                'name'     => 'Xeo Gaming',
                'ccv'      => 120,
                'platform' => 'youtube',
                'views'    => [190543, 126345, 118171, 162867],
                'id_game'  => '100028'
            ],
            [
                'name'     => 'Valtz',
                'ccv'      => 103,
                'platform' => 'tiktok',
                'views'    => [296700, 121000, 214080, 233500],
                'id_game'  => '100031'
            ],
            [
                'name'     => 'Fenzy',
                'ccv'      => 262,
                'platform' => 'tiktok',
                'views'    => [659900, 529007, 622500, 617600],
                'id_game'  => '100015'
            ],

            // No Tier Creators (2 Youtube, 3 Tiktok)
            [
                'name'     => 'Cukup Tampan',
                'ccv'      => 0,
                'platform' => 'youtube',
                'views'    => [0, 0, 0, 0],
                'id_game'  => '100004'
            ],
            [
                'name'     => 'Aisyah',
                'ccv'      => 0,
                'platform' => 'youtube',
                'views'    => [0, 0, 0, 0],
                'id_game'  => '100016'
            ],
            [
                'name'     => 'Tearyu',
                'ccv'      => 0,
                'platform' => 'tiktok',
                'views'    => [0, 0, 0, 0],
                'id_game'  => '100023'
            ],
            [
                'name'     => 'Vindragon',
                'ccv'      => 0,
                'platform' => 'tiktok',
                'views'    => [0, 0, 0, 0],
                'id_game'  => '100025'
            ],
            [
                'name'     => 'Sir Melon',
                'ccv'      => 0,
                'platform' => 'tiktok',
                'views'    => [0, 0, 0, 0],
                'id_game'  => '100037'
            ]
        ];

        // Hashing password standard ('password123')
        $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);

        // Tanggal input laporan untuk kinerja:
        // Week 1: Kinerja 04 May - 10 May 2026 -> Diinput Senin, 11 May 2026
        // Week 2: Kinerja 11 May - 17 May 2026 -> Diinput Senin, 18 May 2026
        // Week 3: Kinerja 18 May - 24 May 2026 -> Diinput Senin, 25 May 2026
        // Week 4: Kinerja 25 May - 31 May 2026 -> Diinput Senin, 01 June 2026
        $weeksDates = [
            '2026-05-11 10:00:00', // Minggu 1 (Kinerja 4-10 Mei)
            '2026-05-18 10:00:00', // Minggu 2 (Kinerja 11-17 Mei)
            '2026-05-25 10:00:00', // Minggu 3 (Kinerja 18-24 Mei)
            '2026-06-01 10:00:00'  // Minggu 4 (Kinerja 25-31 Mei)
        ];

        foreach ($creatorsData as $creator) {
            $username = strtolower(str_replace(' ', '_', $creator['name']));
            
            // 1. Cek / Buat Akun Pengguna
            $existingUser = $db->table('users')->where('username', $username)->get()->getRowArray();
            if ($existingUser) {
                $userId = $existingUser['id'];
                // Update game id & role jika berbeda
                $db->table('users')->where('id', $userId)->update([
                    'id_game' => $creator['id_game'],
                    'role'    => 'user'
                ]);
            } else {
                $phone = '081234560' . $creator['id_game'];
                $db->table('users')->insert([
                    'username'   => $username,
                    'no_telp'    => $phone,
                    'id_game'    => $creator['id_game'],
                    'password'   => $hashedPassword,
                    'role'       => 'user',
                    'created_at' => '2026-05-01 08:00:00',
                    'updated_at' => '2026-05-01 08:00:00'
                ]);
                $userId = $db->insertID();
            }

            // 2. Cek / Buat Profil Kreator
            $existingKreator = $db->table('kreator')->where('id_game', $creator['id_game'])->get()->getRowArray();
            if ($existingKreator) {
                $kreatorId = $existingKreator['kreator_id'];
                $db->table('kreator')->where('kreator_id', $kreatorId)->update([
                    'nama'         => $creator['name'],
                    'tiktok_link'  => $creator['platform'] === 'tiktok' ? "https://tiktok.com/@{$username}" : '',
                    'youtube_link' => $creator['platform'] === 'youtube' ? "https://youtube.com/@{$username}" : '',
                    'status'       => 'active'
                ]);
            } else {
                $db->table('kreator')->insert([
                    'nama'         => $creator['name'],
                    'alamat'       => 'Indonesia',
                    'id_game'      => $creator['id_game'],
                    'tiktok_link'  => $creator['platform'] === 'tiktok' ? "https://tiktok.com/@{$username}" : '',
                    'youtube_link' => $creator['platform'] === 'youtube' ? "https://youtube.com/@{$username}" : '',
                    'status'       => 'active',
                    'created_at'   => '2026-05-01 08:00:00',
                    'updated_at'   => '2026-05-01 08:00:00'
                ]);
                $kreatorId = $db->insertID();
            }

            // 3. Buat / Pastikan Redeem Code terdaftar & terpakai
            $existingCode = $db->table('redeem_codes')->where('used_by', $userId)->get()->getRowArray();
            if (!$existingCode) {
                $suffix = strtoupper(bin2hex(random_bytes(4)));
                $code = 'BS-' . $suffix;
                $db->table('redeem_codes')->insert([
                    'code'       => $code,
                    'is_used'    => 1,
                    'used_by'    => $userId,
                    'used_at'    => '2026-05-01 08:30:00',
                    'created_by' => 1,
                    'created_at' => '2026-05-01 08:00:00',
                    'updated_at' => '2026-05-01 08:30:00'
                ]);
            }

            // 4. Hapus data laporan bulan Mei 2026 milik kreator ini agar tidak double
            $db->table('laporan_mingguan')
               ->where('kreator_id', $kreatorId)
               ->where("created_at >= '2026-05-01 00:00:00'")
               ->where("created_at <= '2026-06-03 23:59:59'")
               ->delete();

            // 5. Masukkan data laporan mingguan Mei 2026
            foreach ($creator['views'] as $weekIndex => $totalViews) {
                if ($totalViews <= 0) {
                    continue; // Skip jika tidak ada performa
                }

                $weekDate = $weeksDates[$weekIndex];

                if ($creator['platform'] === 'tiktok') {
                    // TikTok: Video 80%, Live 20%
                    $videoViews = (int)($totalViews * 0.80);
                    $liveViews  = (int)($totalViews * 0.20);
                    $shortsViews = 0;
                    $shortsCount = 0;
                } else {
                    // YouTube: Video 40%, Shorts 40%, Live 20%
                    $videoViews  = (int)($totalViews * 0.40);
                    $shortsViews = (int)($totalViews * 0.40);
                    $liveViews   = (int)($totalViews * 0.20);
                    $shortsCount = 5;
                }

                $db->table('laporan_mingguan')->insert([
                    'user_id'                   => $userId,
                    'nama_lengkap'              => $creator['name'],
                    'kreator_id'                => $kreatorId,
                    'platform'                  => $creator['platform'],
                    'jumlah_video'              => 3,
                    'total_views_video'         => $videoViews,
                    'jumlah_shorts'             => $shortsCount,
                    'views_shorts'              => $shortsViews,
                    'jumlah_live'               => 2,
                    'total_views_live'          => $liveViews,
                    'penonton_puncak_live'      => $creator['ccv'],
                    'foto_views_konten'         => 'dummy_konten.webp',
                    'foto_views_shorts'         => $creator['platform'] === 'youtube' ? 'dummy_shorts.webp' : null,
                    'foto_views_livestream'     => 'dummy_live.webp',
                    'foto_penonton_puncak_live' => 'dummy_ccv.webp',
                    'status_validasi'           => 'valid',
                    'pesan_admin'               => 'Data historis bulan Mei 2026 berhasil diverifikasi otomatis.',
                    'is_read'                   => 1,
                    'created_at'                => $weekDate,
                    'updated_at'                => $weekDate
                ]);
            }
        }
    }
}
