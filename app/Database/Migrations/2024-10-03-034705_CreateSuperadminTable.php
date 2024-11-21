<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuperadminTable extends Migration
{
    public function up()
    {
        // Membuat tabel superadmin
        $this->forge->addField([
            'id_superadmin' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id_superadmin', true);
        $this->forge->createTable('superadmin');
    }

    public function down()
    {
        // Menghapus tabel superadmin
        $this->forge->dropTable('superadmin');
    }
}
