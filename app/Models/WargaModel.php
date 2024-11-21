<?php

namespace App\Models;

use CodeIgniter\Model;

class WargaModel extends Model
{
    protected $table = 'warga'; // Nama tabel di database
    protected $primaryKey = 'id_user'; // Primary key

    // Kolom-kolom yang diizinkan untuk diisi melalui form (mass assignment)
    protected $allowedFields = [
        'nik', 'password', 'no_kk', 'nama_lengkap', 'alamat', 'blok_no', 'dawis',
        'no_telpon', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'status_pernikahan',
        'agama', 'status_anggota_keluarga', 'kewarganegaraan', 'pekerjaan', 'role',
        'created_at', 'updated_at'
    ];

    // Aktifkan timestamps agar created_at dan updated_at otomatis terisi
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
