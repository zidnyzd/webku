<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IuranWargaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_iuran' => 1, 'id_user' => 1, 'januari' => 50000, 'februari' => 50000, 'maret' => 50000, 'keterangan' => 'Lunas'],
            ['id_iuran' => 1, 'id_user' => 2, 'januari' => 50000, 'februari' => 0, 'maret' => 50000, 'keterangan' => 'Belum Lunas'],
            ['id_iuran' => 2, 'id_user' => 1, 'januari' => 30000, 'februari' => 30000, 'maret' => 30000, 'keterangan' => 'Lunas'],
            ['id_iuran' => 2, 'id_user' => 2, 'januari' => 30000, 'februari' => 0, 'maret' => 30000, 'keterangan' => 'Belum Lunas'],
        ];

        $this->db->table('iuran_warga')->insertBatch($data);
    }
}
