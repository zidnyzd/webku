<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIuranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_iuran' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_iuran' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'tahun' => [
                'type'       => 'YEAR',
                'constraint' => 4,
            ],
            'iuran_bulanan' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
        ]);

        // Menambahkan primary key
        $this->forge->addKey('id_iuran', true);
        // Membuat tabel
        $this->forge->createTable('iuran');
    }

    public function down()
    {
        $this->forge->dropTable('iuran');
    }
}
