<?php
// App/Models/PembayaranModel.php
namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $allowedFields = [
        'id_transaksi', 'id_user', 'id_iuran', 'nama_iuran', 'tahun', 'bulan', 'nominal',
        'metode_pembayaran', 'snap_token', 'status', 'tanggal_pembayaran',
        'nomor_referensi', 'bukti_file', 'created_at', 'updated_at',
        'confirmed_by', 'confirmed_at'
    ];
}
