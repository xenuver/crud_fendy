<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CleanDuplicateNoTelpIndex extends Migration
{
    public function up()
    {
        // Hapus index lama 'email' yang tersisa dari proses rename kolom email → no_telp
        // (index 'no_telp' yang baru sudah ada, jadi yang lama perlu dihapus)
        $check = $this->db->query("SHOW INDEX FROM `users` WHERE Key_name = 'email'")->getResult();
        if (!empty($check)) {
            $this->db->query("ALTER TABLE `users` DROP INDEX `email`");
        }
    }

    public function down()
    {
        // Tidak perlu rollback — index duplikat tidak perlu dikembalikan
    }
}
