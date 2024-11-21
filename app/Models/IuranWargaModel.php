<?php

namespace App\Models;

use CodeIgniter\Model;

class IuranWargaModel extends Model
{
    protected $table = 'iuran_warga';
    protected $primaryKey = 'id_iuran_warga';
    protected $allowedFields = [
        'id_iuran', 'id_user', 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 
        'juli', 'agustus', 'september', 'oktober', 'november', 'desember', 'total', 
        'keterangan', 'nominal_khusus' // Tambahkan 'nominal_khusus' di sini
    ];

    public function getIuranWarga($id_user)
    {
        return $this->where('id_user', $id_user)->findAll();
    }

    // Fungsi untuk mengambil iuran bulanan berdasarkan id_iuran
    public function getIuranBulanan($id_iuran)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('iuran');
        $builder->select('iuran_bulanan');
        $builder->where('id_iuran', $id_iuran);
        $query = $builder->get();
        
        $result = $query->getRow();

        if ($result) {
            return $result->iuran_bulanan;
        }

        return 0; // Jika tidak ditemukan, kembalikan 0 sebagai default
    }

    public function updateIuranBulan($id_iuran, $bulan, $id_user, $nominal)
    {
        $bulan = strtolower($bulan); // Konversi nama bulan ke huruf kecil
        log_message('debug', "Updating iuran: id_iuran = $id_iuran, bulan = $bulan, id_user = $id_user, nominal = $nominal");

        $this->db->table($this->table)
            ->set($bulan, $nominal)
            ->where('id_iuran', $id_iuran)
            ->where('id_user', $id_user)
            ->update();

        if ($this->db->affectedRows() > 0) {
            log_message('debug', "Iuran updated successfully: id_iuran = $id_iuran, bulan = $bulan, id_user = $id_user");
        } else {
            log_message('debug', "No rows affected for: id_iuran = $id_iuran, bulan = $bulan, id_user = $id_user");
        }
    }


    public function resetIuranBulan($id_iuran, $bulan, $id_user)
    {
        $this->db->table($this->table)
            ->set($bulan, 0)
            ->where('id_iuran', $id_iuran)
            ->where('id_user', $id_user)
            ->update();

        log_message('debug', "Reset iuran for id_iuran: $id_iuran, bulan: $bulan, id_user: $id_user");
    }




}
