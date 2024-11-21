<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWargaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'unsigned' => true,  // Harus sesuai dengan tipe dari id_user di tabel warga
                'auto_increment' => true,
            ],
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'no_kk' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'blok_no' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'dawis' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'no_telpon' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'jenis_kelamin' => [
                'type'       => 'ENUM',
                'constraint' => ['Laki-Laki', 'Perempuan'],
            ],
            'tempat_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'status_pernikahan' => [
                'type'       => 'ENUM',
                'constraint' => ['Belum Menikah', 'Menikah', 'Cerai'],
            ],
            'agama' => [
                'type'       => 'ENUM',
                'constraint' => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'],
            ],
            'status_anggota_keluarga' => [
                'type'       => 'ENUM',
                'constraint' => ['Kepala Keluarga', 'Istri', 'Anak', 'Lainnya'],
            ],
            'kewarganegaraan' => [
                'type'       => 'ENUM',
                'constraint' => ['WNI', 'WNA'],
            ],
            'pekerjaan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['ketua', 'wakil', 'sekretaris', 'bendahara', 'pengurus', 'warga'],
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id_user', true);
        $this->forge->createTable('warga');
    }

    public function down()
    {
        $this->forge->dropTable('warga');
    }
}
