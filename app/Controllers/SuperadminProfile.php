<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SuperadminModel;

class SuperadminProfile extends Controller
{
    public function index()
    {
        // Pastikan superadmin sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/superadmin/login');
        }

        // Data superadmin dari session
        $data = [
            'title' => 'Profile Superadmin',
            'username' => session()->get('username')
        ];

        return view('superadmin/profile', $data);
    }

    public function update()
    {
        // Method untuk update data profile (bisa ditambahkan form update)
    }
}
