<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateRoleColumnInWargaTable extends Migration
{
    public function up()
    {
        $fields = [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['ketua', 'wakil', 'sekretaris', 'bendahara', 'pengurus', 'warga'],
                'null'       => false,
                'default'    => 'warga'
            ]
        ];

        $this->forge->modifyColumn('warga', $fields);
    }

    public function down()
    {
        $fields = [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['warga', 'pengurus', 'bendahara'], // role sebelumnya
            ]
        ];

        $this->forge->modifyColumn('warga', $fields);
    }

}
