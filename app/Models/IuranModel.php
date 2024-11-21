<?php

namespace App\Models;

use CodeIgniter\Model;

class IuranModel extends Model
{
    protected $table = 'iuran';
    protected $primaryKey = 'id_iuran';
    protected $allowedFields = ['nama_iuran', 'tahun', 'iuran_bulanan'];

    // Metode untuk mengambil iuran bulanan berdasarkan id_iuran
    public function getIuranBulanan($id_iuran)
    {
        $result = $this->select('iuran_bulanan')
                       ->where('id_iuran', $id_iuran)
                       ->first();

        return $result ? $result['iuran_bulanan'] : 0; // Kembalikan 0 jika tidak ditemukan
    }
}
