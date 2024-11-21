<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WargaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nik' => '1111111111111111',  // NIK singkat untuk testing
                'password' => password_hash('warga', PASSWORD_DEFAULT),  // Password: 1234
                'no_kk' => '4444444444444444',  // Nomor KK singkat
                'nama_lengkap' => 'Warga A',
                'alamat' => 'Alamat Warga A',
                'blok_no' => 'A1/01',
                'dawis' => 'Dawis 1',
                'no_telpon' => '081234567890',
                'jenis_kelamin' => 'Laki-Laki',
                'tempat_lahir' => 'Kota A',
                'tanggal_lahir' => '1990-01-01',
                'status_pernikahan' => 'Menikah',
                'agama' => 'Islam',
                'status_anggota_keluarga' => 'Kepala Keluarga',
                'kewarganegaraan' => 'WNI',
                'pekerjaan' => 'Pegawai',
                'role' => 'warga',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nik' => '2222222222222222',  // NIK singkat untuk testing
                'password' => password_hash('bendahara', PASSWORD_DEFAULT),  // Password: 1234
                'no_kk' => '5555555555555555',  // Nomor KK singkat
                'nama_lengkap' => 'bendahara B',
                'alamat' => 'Alamat bendahara B',
                'blok_no' => 'B2/02',
                'dawis' => 'Dawis 2',
                'no_telpon' => '081234567891',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Kota B',
                'tanggal_lahir' => '1985-02-02',
                'status_pernikahan' => 'Menikah',
                'agama' => 'Kristen',
                'status_anggota_keluarga' => 'Istri',
                'kewarganegaraan' => 'WNI',
                'pekerjaan' => 'Guru',
                'role' => 'bendahara',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nik' => '3333333333333333',  // NIK singkat untuk testing
                'password' => password_hash('pengurus', PASSWORD_DEFAULT),  // Password: 1234
                'no_kk' => '6666666666666666',  // Nomor KK singkat
                'nama_lengkap' => 'pengurus C',
                'alamat' => 'Alamat pengurus C',
                'blok_no' => 'C3/03',
                'dawis' => 'Dawis 3',
                'no_telpon' => '081234567892',
                'jenis_kelamin' => 'Laki-Laki',
                'tempat_lahir' => 'Kota C',
                'tanggal_lahir' => '1980-03-03',
                'status_pernikahan' => 'Menikah',
                'agama' => 'Katolik',
                'status_anggota_keluarga' => 'Kepala Keluarga',
                'kewarganegaraan' => 'WNI',
                'pekerjaan' => 'Pegawai',
                'role' => 'pengurus',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nik' => '4444444444444444',
                'password' => password_hash('sekretaris', PASSWORD_DEFAULT),
                'no_kk' => '7777777777777777',
                'nama_lengkap' => 'Sekretaris D',
                'alamat' => 'Alamat Sekretaris D',
                'blok_no' => 'D4/04',
                'dawis' => 'Dawis 4',
                'no_telpon' => '081234567893',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Kota D',
                'tanggal_lahir' => '1988-04-04',
                'status_pernikahan' => 'Menikah',
                'agama' => 'Hindu',
                'status_anggota_keluarga' => 'Istri',
                'kewarganegaraan' => 'WNI',
                'pekerjaan' => 'Sekretaris',
                'role' => 'sekretaris',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nik' => '5555555555555555',
                'password' => password_hash('ketua', PASSWORD_DEFAULT),
                'no_kk' => '8888888888888888',
                'nama_lengkap' => 'Ketua E',
                'alamat' => 'Alamat Ketua E',
                'blok_no' => 'E5/05',
                'dawis' => 'Dawis 5',
                'no_telpon' => '081234567894',
                'jenis_kelamin' => 'Laki-Laki',
                'tempat_lahir' => 'Kota E',
                'tanggal_lahir' => '1975-05-05',
                'status_pernikahan' => 'Menikah',
                'agama' => 'Budha',
                'status_anggota_keluarga' => 'Kepala Keluarga',
                'kewarganegaraan' => 'WNI',
                'pekerjaan' => 'Ketua RT',
                'role' => 'ketua',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nik' => '6666666666666666',
                'password' => password_hash('wakil', PASSWORD_DEFAULT),
                'no_kk' => '9999999999999999',
                'nama_lengkap' => 'Wakil F',
                'alamat' => 'Alamat Wakil F',
                'blok_no' => 'F6/06',
                'dawis' => 'Dawis 6',
                'no_telpon' => '081234567895',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Kota F',
                'tanggal_lahir' => '1982-06-06',
                'status_pernikahan' => 'Menikah',
                'agama' => 'Konghucu',
                'status_anggota_keluarga' => 'Istri',
                'kewarganegaraan' => 'WNI',
                'pekerjaan' => 'Wakil Ketua',
                'role' => 'wakil',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data ke tabel warga
        $this->db->table('warga')->insertBatch($data);
    }
}
