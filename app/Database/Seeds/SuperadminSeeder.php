<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin', PASSWORD_DEFAULT),  // Password adalah 'admin'
            ]
        ];

        // Insert data ke tabel superadmin
        $this->db->table('superadmin')->insertBatch($data);
    }
}
