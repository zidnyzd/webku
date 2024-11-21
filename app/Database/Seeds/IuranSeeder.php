<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IuranSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_iuran' => 'Iuran Bulanan', 'tahun' => 2024, 'iuran_bulanan' => 50000],
            ['nama_iuran' => 'Iuran Kebersihan', 'tahun' => 2024, 'iuran_bulanan' => 30000],
        ];

        $this->db->table('iuran')->insertBatch($data);
    }
}
