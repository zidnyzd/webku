<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SuperadminDashboard extends Controller
{
    public function index()
    {
        // Pastikan superadmin sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'Superadmin') {
            return redirect()->to('/superadmin/login');
        }

        return view('superadmin/dashboard', [
            'title' => 'Dashboard Superadmin'
        ]);
    }
}
