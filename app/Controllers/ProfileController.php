<?php

namespace App\Controllers;

use App\Models\WargaModel;
use CodeIgniter\Controller;

class ProfileController extends Controller
{
    protected $wargaModel;

    public function __construct()
    {
        $this->wargaModel = new WargaModel();
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/warga/login');
        }

        $role = session()->get('role');
        $warga = $this->wargaModel->find(session()->get('id_user'));

        return view("{$role}/profile", [
            'title' => 'Profile ' . ucfirst($role),
            'warga' => $warga
        ]);
    }

    public function edit()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/warga/login');
        }

        $role = session()->get('role');
        $warga = $this->wargaModel->find(session()->get('id_user'));

        return view("{$role}/edit_profile", [
            'title' => 'Edit Profile ' . ucfirst($role),
            'warga' => $warga
        ]);
    }

    public function update()
    {
        $id_user = session()->get('id_user');
        $role = session()->get('role');
        $existingWarga = $this->wargaModel->find($id_user);

        $rules = [
            'nama_lengkap' => 'required',
            'no_kk' => 'required|min_length[16]|max_length[16]',
            'alamat' => 'required',
            'blok_no' => 'permit_empty',
            'dawis' => 'permit_empty',
            'no_telpon' => 'permit_empty|max_length[15]',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|valid_date',
            'status_pernikahan' => 'required',
            'agama' => 'required',
            'status_anggota_keluarga' => 'required',
            'kewarganegaraan' => 'required|in_list[WNI,WNA]',
            'pekerjaan' => 'required',
        ];

        if ($this->request->getPost('nik') !== $existingWarga['nik']) {
            $rules['nik'] = 'required|min_length[16]|max_length[16]|is_unique[warga.nik]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'nik' => $this->request->getPost('nik'),
            'no_kk' => $this->request->getPost('no_kk'),
            'alamat' => $this->request->getPost('alamat'),
            'blok_no' => $this->request->getPost('blok_no'),
            'dawis' => $this->request->getPost('dawis'),
            'no_telpon' => $this->request->getPost('no_telpon'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'agama' => $this->request->getPost('agama'),
            'status_anggota_keluarga' => $this->request->getPost('status_anggota_keluarga'),
            'kewarganegaraan' => $this->request->getPost('kewarganegaraan'),
            'pekerjaan' => $this->request->getPost('pekerjaan')
        ];

        $this->wargaModel->update($id_user, $data);

        return redirect()->to('/' . strtolower($role) . '/profile')->with('success', 'Profile berhasil diperbarui.');
    }
}
