<?php

namespace App\Controllers;

use App\Models\RekeningModel;

class RekeningController extends BaseController
{
    protected $rekeningModel;

    public function __construct()
    {
        $this->rekeningModel = new RekeningModel();
    }

    // Menampilkan daftar rekening
    public function index()
    {
        $role = session()->get('role');
        if ($role !== 'bendahara') {
            return redirect()->to('/warga/login');
        }

        $data = [
            'title' => 'Kelola Rekening Bank',
            'rekeningList' => $this->rekeningModel->findAll()
        ];

        return view('bendahara/kelola_rekening', $data);
    }

    // Menambahkan rekening baru
    public function create()
    {
        $data = [
            'title' => 'Tambah Rekening Baru'
        ];

        return view('bendahara/tambah_rekening', $data);
    }

    // Proses menambahkan rekening
    public function store()
    {
        $validation = $this->validate([
            'bank' => 'required',
            'nomor_rekening' => 'required',
            'atas_nama' => 'required'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->rekeningModel->save([
            'bank' => $this->request->getPost('bank'),
            'nomor_rekening' => $this->request->getPost('nomor_rekening'),
            'atas_nama' => $this->request->getPost('atas_nama')
        ]);

        return redirect()->to('/bendahara/rekening')->with('success', 'Rekening berhasil ditambahkan.');
    }

    // Menghapus rekening
    public function delete($id_rekening)
    {
        $this->rekeningModel->delete($id_rekening);

        return redirect()->to('/bendahara/rekening')->with('success', 'Rekening berhasil dihapus.');
    }

    // Menampilkan form edit rekening
    public function edit($id_rekening)
    {
        $rekening = $this->rekeningModel->find($id_rekening);

        if (!$rekening) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Rekening tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Rekening',
            'rekening' => $rekening
        ];

        return view('bendahara/edit_rekening', $data);
    }

    // Proses update rekening
    public function update($id_rekening)
    {
        $validation = $this->validate([
            'bank' => 'required',
            'nomor_rekening' => 'required',
            'atas_nama' => 'required'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->rekeningModel->update($id_rekening, [
            'bank' => $this->request->getPost('bank'),
            'nomor_rekening' => $this->request->getPost('nomor_rekening'),
            'atas_nama' => $this->request->getPost('atas_nama')
        ]);

        return redirect()->to('/bendahara/rekening')->with('success', 'Rekening berhasil diperbarui.');
    }

}
