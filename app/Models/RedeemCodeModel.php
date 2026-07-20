<?php

namespace App\Models;

use CodeIgniter\Model;

class RedeemCodeModel extends Model
{
    protected $table            = 'redeem_codes';
    protected $primaryKey       = 'redeem_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['code', 'is_used', 'used_by', 'used_at', 'created_by'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Generate kode redeem unik baru dengan format BS-XXXXX.
    // Karakter yang digunakan sengaja menghindari 0, O, I, l agar tidak
    // membingungkan kreator saat mengetiknya.
    public function generateUniqueCode(): string
    {
        $chars = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';
        do {
            $suffix = '';
            for ($i = 0; $i < 6; $i++) {
                $suffix .= $chars[random_int(0, strlen($chars) - 1)];
            }
            $code = 'BS-' . $suffix;
        } while ($this->where('code', $code)->first());

        return $code;
    }

    // Validasi apakah kode redeem valid dan belum dipakai.
    public function isValid(string $code): bool
    {
        $record = $this->where('code', $code)->where('is_used', 0)->first();
        return $record !== null;
    }

    // Tandai kode sebagai sudah terpakai.
    public function markAsUsed(string $code, int $userId): bool
    {
        return $this->where('code', $code)->set([
            'is_used' => 1,
            'used_by' => $userId,
            'used_at' => date('Y-m-d H:i:s'),
        ])->update();
    }
}
