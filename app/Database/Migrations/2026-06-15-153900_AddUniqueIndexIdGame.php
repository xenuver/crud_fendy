<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUniqueIndexIdGame extends Migration
{
    public function up()
    {
        // Bersihkan data duplikat di kreator sebelum pasang constraint (jika ada)
        $this->db->query("
            DELETE k1 FROM kreator k1
            INNER JOIN kreator k2 
            WHERE k1.id > k2.id AND k1.id_game = k2.id_game
        ");

        // Pasang UNIQUE constraint di tabel kreator
        // Cek dulu apakah index sudah ada agar tidak error saat re-run
        $check = $this->db->query("SHOW INDEX FROM `kreator` WHERE Key_name = 'uq_kreator_id_game'")->getResult();
        if (empty($check)) {
            $this->db->query("ALTER TABLE `kreator` ADD UNIQUE INDEX `uq_kreator_id_game` (`id_game`)");
        }

        // Pasang UNIQUE constraint di tabel users
        $check2 = $this->db->query("SHOW INDEX FROM `users` WHERE Key_name = 'uq_users_id_game'")->getResult();
        if (empty($check2)) {
            $this->db->query("ALTER TABLE `users` ADD UNIQUE INDEX `uq_users_id_game` (`id_game`)");
        }
    }

    public function down()
    {
        // Hapus UNIQUE index saat rollback
        $check = $this->db->query("SHOW INDEX FROM `kreator` WHERE Key_name = 'uq_kreator_id_game'")->getResult();
        if (!empty($check)) {
            $this->db->query("ALTER TABLE `kreator` DROP INDEX `uq_kreator_id_game`");
        }

        $check2 = $this->db->query("SHOW INDEX FROM `users` WHERE Key_name = 'uq_users_id_game'")->getResult();
        if (!empty($check2)) {
            $this->db->query("ALTER TABLE `users` DROP INDEX `uq_users_id_game`");
        }
    }
}
