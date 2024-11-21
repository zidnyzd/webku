<?php

namespace App\Models;

use CodeIgniter\Model;

class RekeningModel extends Model
{
    protected $table = 'rekening_bank';
    protected $primaryKey = 'id_rekening';
    protected $allowedFields = ['bank', 'nomor_rekening', 'atas_nama', 'created_at', 'updated_at'];
}
