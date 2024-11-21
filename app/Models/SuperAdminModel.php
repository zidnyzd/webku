<?php

namespace App\Models;

use CodeIgniter\Model;

class SuperadminModel extends Model
{
    protected $table = 'superadmin';
    protected $primaryKey = 'id_superadmin';
    protected $allowedFields = ['username', 'password'];

    public function getSuperadminByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
