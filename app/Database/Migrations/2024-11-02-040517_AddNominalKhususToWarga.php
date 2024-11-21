<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNominalKhususToWarga extends Migration
{
    public function up()
    {
        $this->forge->addColumn('warga', [
            'nominal_khusus' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => null,
                'comment'    => 'Nominal khusus iuran per bulan untuk warga tertentu',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('warga', 'nominal_khusus');
    }
}
