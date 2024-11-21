<?php

namespace App\Models;

use CodeIgniter\Model;

class BuktiPembayaranModel extends Model
{
    protected $table = 'bukti_pembayaran';
    protected $primaryKey = 'id_bukti';
    protected $allowedFields = [
        'id_user', 'id_iuran', 'tanggal_pembayaran', 'nomor_referensi', 
        'bukti_file', 'status', 'metode_pembayaran', 'bulan', 
        'created_at', 'updated_at'
    ];

    public function getBuktiPembayaran($role, $id_user = null)
    {
        if ($role === 'warga' && $id_user) {
            return $this->where('id_user', $id_user)->findAll();
        } else {
            return $this->findAll();
        }
    }
}
