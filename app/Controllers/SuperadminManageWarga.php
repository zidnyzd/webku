<?php

namespace App\Controllers;

use App\Models\WargaModel;
use CodeIgniter\Controller;

class SuperadminManageWarga extends Controller
{
    public function index()
    {
        $model = new WargaModel();
        $warga = $model->findAll();

        return view('superadmin/manage_warga', [
            'title' => 'Kelola Warga',
            'warga' => $warga
        ]);
    }

    // Method untuk menampilkan form edit role warga
    public function edit($id_user)
    {
        // Pastikan superadmin sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'Superadmin') {
            return redirect()->to('/superadmin/login');
        }

        $model = new WargaModel();
        $warga = $model->find($id_user);

        if (!$warga) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Warga dengan ID: ' . $id_user . ' tidak ditemukan');
        }

        return view('superadmin/edit_warga', [
            'title' => 'Edit Role Warga',
            'warga' => $warga
        ]);
    }

    // Method untuk mengupdate role warga
    public function update($id_user)
    {
        // Pastikan superadmin sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'Superadmin') {
            return redirect()->to('/superadmin/login');
        }

        $model = new WargaModel();
        $data = [
            'role' => $this->request->getPost('role')
        ];

        $model->update($id_user, $data);

        return redirect()->to('/superadmin/manage-warga')->with('success', 'Role warga berhasil diperbarui.');
    }
}
