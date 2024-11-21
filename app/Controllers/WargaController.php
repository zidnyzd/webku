<?php

namespace App\Controllers;

use App\Models\WargaModel;

class WargaController extends BaseController
{
    protected $wargaModel;

    public function __construct()
    {
        $this->wargaModel = new WargaModel();
    }

    // Menampilkan semua data warga dengan pencarian otomatis
    public function index()
    {
        // Pastikan pengguna adalah bendahara
        if (session()->get('role') !== 'bendahara') {
            return redirect()->to('/login');
        }

        // Ambil kata kunci pencarian jika ada
        $keyword = $this->request->getGet('keyword');

        // Jika ada keyword, lakukan pencarian
        if ($keyword) {
            $wargaList = $this->wargaModel->like('nama_lengkap', $keyword)
                                           ->orLike('nik', $keyword)
                                           ->orLike('no_kk', $keyword)
                                           ->findAll();
        } else {
            // Jika tidak ada keyword, ambil semua data warga
            $wargaList = $this->wargaModel->findAll();
        }

        // Kirim data ke view
        return view('bendahara/warga_list', [
            'title' => 'Daftar Warga',
            'wargaList' => $wargaList
        ]);
    }

    // Menampilkan detail data warga berdasarkan id
    public function detail($id_user)
    {
        // Pastikan pengguna adalah bendahara
        if (session()->get('role') !== 'bendahara') {
            return redirect()->to('/login');
        }

        // Ambil data warga dari model berdasarkan id
        $warga = $this->wargaModel->find($id_user);

        if (!$warga) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Warga tidak ditemukan');
        }

        // Kirim data ke view
        return view('bendahara/warga_detail', [
            'title' => 'Detail Warga',
            'warga' => $warga
        ]);
    }

    public function uploadBukti()
    {
        // Pastikan user adalah warga yang sudah login
        if (session()->get('role') !== 'warga') {
            return redirect()->to('/login');
        }

        // Validasi input
        $validation = $this->validate([
            'id_iuran' => 'required|numeric',
            'tanggal_pembayaran' => 'required|valid_date',
            'bukti_file' => 'uploaded[bukti_file]|max_size[bukti_file,2048]|ext_in[bukti_file,jpg,jpeg,png,pdf]',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari input
        $id_user = session()->get('id_user');
        $id_iuran = $this->request->getPost('id_iuran');
        $tanggal_pembayaran = $this->request->getPost('tanggal_pembayaran');
        $nomor_referensi = $this->request->getPost('nomor_referensi');
        $buktiFile = $this->request->getFile('bukti_file');

        // Simpan file bukti pembayaran
        $newName = $buktiFile->getRandomName();
        $buktiFile->move(WRITEPATH . 'uploads/bukti_pembayaran', $newName);

        // Simpan data ke database
        $this->db->table('bukti_pembayaran')->insert([
            'id_user' => $id_user,
            'id_iuran' => $id_iuran,
            'tanggal_pembayaran' => $tanggal_pembayaran,
            'nomor_referensi' => $nomor_referensi,
            'bukti_file' => $newName,
            'status' => 'Menunggu Konfirmasi',
        ]);

        // Redirect dengan pesan sukses
        return redirect()->to('/warga/iuran')->with('success', 'Bukti pembayaran berhasil diupload, menunggu konfirmasi.');
    }

}
