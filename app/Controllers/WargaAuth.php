<?php

namespace App\Controllers;

use App\Models\WargaModel;
use CodeIgniter\Controller;

class WargaAuth extends Controller
{
    public function index()
    {
        return view('warga/login');
    }

    public function login()
    {
        $session = session();
        $model = new WargaModel();

        $nik = $this->request->getVar('nik');
        $password = $this->request->getVar('password');

        $warga = $model->where('nik', $nik)->first();

        if ($warga) {
            if (password_verify($password, $warga['password'])) {
                // Menyimpan session dengan role dalam huruf kecil
                $session->set([
                    'id_user' => $warga['id_user'],
                    'nik' => $warga['nik'],
                    'nama_lengkap' => $warga['nama_lengkap'],
                    'role' => strtolower($warga['role']),
                    'logged_in' => true
                ]);

                // Debugging role yang disimpan
                log_message('debug', 'Role yang disimpan: ' . $warga['role']);

                // Redirect berdasarkan role
                switch (strtolower($warga['role'])) {
                    case 'ketua':
                        return redirect()->to('/ketua/dashboard');
                    case 'wakil':
                        return redirect()->to('/wakil/dashboard');
                    case 'sekretaris':
                        return redirect()->to('/sekretaris/dashboard');
                    case 'bendahara':
                        return redirect()->to('/bendahara/dashboard');
                    case 'pengurus':
                        return redirect()->to('/pengurus/dashboard');
                    case 'warga':
                        return redirect()->to('/warga/dashboard');
                    default:
                        $session->setFlashdata('error', 'Role tidak dikenal.');
                        return redirect()->to('/warga/login');
                }
            } else {
                $session->setFlashdata('error', 'Password salah.');
                return redirect()->to('/warga/login');
            }
        } else {
            $session->setFlashdata('error', 'NIK tidak ditemukan.');
            return redirect()->to('/warga/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/warga/login');
    }
}
