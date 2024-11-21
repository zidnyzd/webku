<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIuranWargaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_iuran_warga' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'id_iuran' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'januari' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'februari' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'maret' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'april' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'mei' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'juni' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'juli' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'agustus' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'september' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'oktober' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'november' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'desember' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'as'         => 'januari + februari + maret + april + mei + juni + juli + agustus + september + oktober + november + desember',
                'stored'     => true
            ],
            'keterangan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => 'Belum Lunas',
            ],
        ]);

        $this->forge->addKey('id_iuran_warga', true);
        // Tambahkan foreign key ke tabel iuran dan warga
        $this->forge->addForeignKey('id_iuran', 'iuran', 'id_iuran', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'warga', 'id_user', 'CASCADE', 'CASCADE');
        // Membuat tabel
        $this->forge->createTable('iuran_warga');
    }

    public function down()
    {
        $this->forge->dropTable('iuran_warga');
    }
}
