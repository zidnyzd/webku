<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNominalKhususToIuranWarga extends Migration
{
    public function up()
    {
        $this->forge->addColumn('iuran_warga', [
            'nominal_khusus' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'default'    => null,
                'comment'    => 'Nominal iuran khusus untuk warga per iuran',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('iuran_warga', 'nominal_khusus');
    }
}
