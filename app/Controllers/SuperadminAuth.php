<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SuperadminModel;

class SuperadminAuth extends Controller
{
    public function index()
    {
        return view('superadmin/login');
    }

    public function login()
    {
        $session = session();
        $model = new SuperadminModel();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $superadmin = $model->getSuperadminByUsername($username);

        if ($superadmin) {
            if (password_verify($password, $superadmin['password'])) {
                $session->set([
                    'id_superadmin' => $superadmin['id_superadmin'],
                    'username' => $superadmin['username'],
                    'role' => 'Superadmin', // role khusus untuk superadmin
                    'logged_in' => true
                ]);
                return redirect()->to('/superadmin/dashboard');
            } else {
                $session->setFlashdata('error', 'Password salah.');
                return redirect()->to('/superadmin/login');
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->to('/superadmin/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/superadmin/login');
    }
}
