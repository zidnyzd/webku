<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Pastikan pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/warga/login');
        }

        // Ambil role dari session
        $role = session()->get('role');

        // Tentukan view yang akan ditampilkan berdasarkan role
        switch ($role) {
            case 'ketua':
                return view('ketua/dashboard', [
                    'title' => 'Dashboard Ketua RT'
                ]);
            case 'wakil':
                return view('wakil/dashboard', [
                    'title' => 'Dashboard Wakil Ketua RT'
                ]);
            case 'sekretaris':
                return view('sekretaris/dashboard', [
                    'title' => 'Dashboard Sekretaris'
                ]);
            case 'bendahara':
                return view('bendahara/dashboard', [
                    'title' => 'Dashboard Bendahara'
                ]);
            case 'pengurus':
                return view('pengurus/dashboard', [
                    'title' => 'Dashboard Pengurus RT'
                ]);
            case 'warga':
                return view('warga/dashboard', [
                    'title' => 'Dashboard Warga',
                    'username' => session()->get('username')
                ]);
            default:
                // Jika role tidak dikenali, redirect ke halaman login
                return redirect()->to('/warga/login');
        }
    }
}
