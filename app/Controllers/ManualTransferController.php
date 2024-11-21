<?php

namespace App\Controllers;

use App\Models\PembayaranModel;
use App\Models\IuranModel;

class ManualTransferController extends BaseController
{
    protected $pembayaranModel;
    protected $iuranModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->iuranModel = new IuranModel();
    }

    public function index()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/warga/login');
        }

        $selectedPayments = session()->get('selectedPayments');
        $totalAmount = session()->get('totalAmount');

        // Tambahkan pengecekan untuk memastikan data sesi ada
        if (empty($selectedPayments) || !$totalAmount) {
            return redirect()->to('/warga/metode_pembayaran')->with('error', 'Data pembayaran tidak ditemukan.');
        }

        // Ambil daftar rekening dari database
        $rekeningModel = new \App\Models\RekeningModel();
        $rekeningList = $rekeningModel->findAll();

        $data = [
            'title' => 'Transfer Manual',
            'totalAmount' => $totalAmount
        ];

        return view('warga/manual_transfer', $data);
    }


    public function store()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/warga/login');
        }
    
        // Ambil metode pembayaran dan data iuran yang dipilih dari sesi
        $metodePembayaran = session()->get('metodePembayaran');
        $selectedPayments = session()->get('selectedPayments');
    
        if (empty($selectedPayments)) {
            return redirect()->to('/warga/bayar_iuran')->with('error', 'Data pembayaran tidak valid.');
        }
    
        // Validasi input dari form
        $validation = $this->validate([
            'nomor_referensi' => 'required',
            'bukti_transfer' => 'uploaded[bukti_transfer]|max_size[bukti_transfer,2048]|ext_in[bukti_transfer,jpg,jpeg,png,pdf]',
        ]);
    
        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        // Ambil file bukti transfer dan nomor referensi dari input
        $file = $this->request->getFile('bukti_transfer');
        $nomorReferensi = $this->request->getPost('nomor_referensi');
    
        // Generate nama file unik untuk disimpan
        $newFileName = $file->getRandomName();
    
        // Pindahkan file ke folder uploads/bukti_pembayaran
        if ($file->isValid() && !$file->hasMoved()) {
            try {
                $file->move(FCPATH . 'uploads/bukti_pembayaran', $newFileName);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah bukti transfer.');
            }
        } else {
            return redirect()->back()->with('error', 'File tidak valid atau sudah dipindahkan.');
        }
    
        // Buat ID Transaksi unik
        $idTransaksi = 'TRX-' . strtoupper(uniqid());
    
        // Proses dan simpan setiap pembayaran iuran
        foreach ($selectedPayments as $id_iuran => $bulanArray) {
            // Ambil data iuran untuk mendapatkan nominal
            $iuranData = $this->iuranModel->find($id_iuran);
            if (!$iuranData) {
                return redirect()->to('/warga/bayar_iuran')->with('error', 'Data iuran tidak ditemukan.');
            }
    
            // Gunakan nominal_khusus jika ada, jika tidak pakai iuran_bulanan
            $nominal = $iuranData['nominal_khusus'] ?? $iuranData['iuran_bulanan'];
    
            foreach ($bulanArray as $bulan) {
                // Simpan setiap bulan ke dalam tabel pembayaran
                $this->pembayaranModel->insert([
                    'id_user' => $id_user,
                    'id_transaksi' => $idTransaksi,
                    'id_iuran' => $id_iuran,
                    'nama_iuran' => $iuranData['nama_iuran'],
                    'tahun' => date('Y'),
                    'bulan' => ucfirst($bulan),
                    'nominal' => $nominal,
                    'metode_pembayaran' => $metodePembayaran,
                    'status' => 'Menunggu Konfirmasi',
                    'tanggal_pembayaran' => date('Y-m-d'),
                    'nomor_referensi' => $nomorReferensi,
                    'bukti_file' => $newFileName,
                ]);
            }
        }
    
        // Hapus data sesi setelah berhasil menyimpan
        session()->remove('selectedPayments');
        session()->remove('metodePembayaran');
    
        return redirect()->to('/warga/bukti_pembayaran')->with('success', 'Bukti pembayaran berhasil dikirim dan menunggu konfirmasi.');
    }
    



}
