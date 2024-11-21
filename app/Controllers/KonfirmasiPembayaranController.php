<?php

namespace App\Controllers;

use App\Models\PembayaranModel;
use App\Models\WargaModel;
use App\Models\IuranWargaModel;
use App\Models\IuranModel;

class KonfirmasiPembayaranController extends BaseController
{
    protected $pembayaranModel;
    protected $wargaModel;
    protected $iuranWargaModel;
    protected $iuranModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->wargaModel = new WargaModel();
        $this->iuranWargaModel = new IuranWargaModel();
        $this->iuranModel = new IuranModel();
    }

    // Menampilkan daftar pembayaran yang menunggu konfirmasi
    public function index()
    {
        $search = $this->request->getGet('search');
    
        $query = $this->pembayaranModel
            ->select('
                id_transaksi, 
                MAX(tanggal_pembayaran) AS tanggal_pembayaran, 
                GROUP_CONCAT(CONCAT(nama_iuran, ":", bulan) SEPARATOR ", ") AS nama_iuran, 
                SUM(nominal) AS total_nominal, 
                MAX(status) AS status, 
                MAX(metode_pembayaran) AS metode_pembayaran, 
                MAX(nomor_referensi) AS nomor_referensi, 
                MAX(bukti_file) AS bukti_file, 
                MAX(warga.nama_lengkap) AS nama_warga
            ')
            ->join('warga', 'warga.id_user = pembayaran.id_user')
            ->where('pembayaran.status', 'Menunggu Konfirmasi')
            ->groupBy('id_transaksi')
            ->orderBy('MAX(tanggal_pembayaran)', 'DESC');
    
        if ($search) {
            $query = $query->groupStart()
                ->like('id_transaksi', $search)
                ->orLike('warga.nama_lengkap', $search)
                ->groupEnd();
        }
    
        $pembayaranList = $query->findAll();
    
        return view('bendahara/konfirmasi_pembayaran', [
            'title' => 'Konfirmasi Pembayaran',
            'pembayaranList' => $pembayaranList,
            'search' => $search,
        ]);
    }

    // Konfirmasi pembayaran manual
    public function konfirmasi($id_transaksi)
    {
        $role = strtolower(session()->get('role'));
    
        // Ambil semua pembayaran berdasarkan id_transaksi
        $pembayaranList = $this->pembayaranModel
            ->where('id_transaksi', $id_transaksi)
            ->findAll();
    
        if (empty($pembayaranList)) {
            return redirect()->to("/$role/konfirmasi_pembayaran")->with('error', 'Data pembayaran tidak ditemukan.');
        }
    
        foreach ($pembayaranList as $pembayaran) {
            // Update status pembayaran menjadi "Dikonfirmasi"
            $this->pembayaranModel->update($pembayaran['id_pembayaran'], [
                'status' => 'Dikonfirmasi',
                'confirmed_by' => session()->get('id_user'),
                'confirmed_at' => date('Y-m-d H:i:s'),
            ]);
    
            // Update iuran_warga berdasarkan bulan dan id_iuran
            $this->iuranWargaModel->set(strtolower($pembayaran['bulan']), $pembayaran['nominal'])
                ->where('id_iuran', $pembayaran['id_iuran'])
                ->where('id_user', $pembayaran['id_user'])
                ->update();
    
            // Periksa apakah semua bulan telah dibayar
            $iuranWarga = $this->iuranWargaModel
                ->where('id_iuran', $pembayaran['id_iuran'])
                ->where('id_user', $pembayaran['id_user'])
                ->first();
    
            $allPaid = true;
            for ($i = 1; $i <= 12; $i++) {
                $bulan = strtolower(date('F', mktime(0, 0, 0, $i, 10)));
                if (isset($iuranWarga[$bulan]) && (float)$iuranWarga[$bulan] == 0) {
                    $allPaid = false;
                    break;
                }
            }
    
            // Update status iuran menjadi "Lunas" atau "Belum Lunas"
            $this->iuranWargaModel->update($iuranWarga['id_iuran_warga'], [
                'keterangan' => $allPaid ? 'Lunas' : 'Belum Lunas'
            ]);
        }
    
        return redirect()->to("/$role/konfirmasi_pembayaran")->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }
    
    // Batalkan konfirmasi pembayaran
    public function tolak($id_transaksi)
    {
        $role = strtolower(session()->get('role'));
    
        // Ambil semua pembayaran berdasarkan id_transaksi
        $pembayaranList = $this->pembayaranModel
            ->where('id_transaksi', $id_transaksi)
            ->findAll();
    
        if (empty($pembayaranList)) {
            return redirect()->to("/$role/konfirmasi_pembayaran")->with('error', 'Data pembayaran tidak ditemukan.');
        }
    
        foreach ($pembayaranList as $pembayaran) {
            // Update status pembayaran menjadi "Ditolak"
            $this->pembayaranModel->update($pembayaran['id_pembayaran'], [
                'status' => 'Ditolak',
                'confirmed_by' => session()->get('id_user'),
                'confirmed_at' => date('Y-m-d H:i:s'),
            ]);
    
            // Reset nominal pada tabel iuran_warga untuk bulan terkait
            $this->iuranWargaModel->set(strtolower($pembayaran['bulan']), 0)
                ->where('id_iuran', $pembayaran['id_iuran'])
                ->where('id_user', $pembayaran['id_user'])
                ->update();
    
            // Perbarui keterangan menjadi "Belum Lunas"
            $this->updateStatusIuranWarga($pembayaran['id_user'], $pembayaran['id_iuran']);
        }
    
        return redirect()->to("/$role/konfirmasi_pembayaran")->with('success', 'Pembayaran berhasil ditolak.');
    }
    
    // Menampilkan riwayat konfirmasi pembayaran
    public function riwayat()
    {
        $search = $this->request->getGet('search');
        $role = strtolower(session()->get('role'));
    
        $query = $this->pembayaranModel
            ->select('id_transaksi, 
                      MAX(tanggal_pembayaran) AS tanggal_pembayaran, 
                      GROUP_CONCAT(DISTINCT warga.nama_lengkap) AS nama_warga, 
                      GROUP_CONCAT(CONCAT(nama_iuran, ":", bulan) SEPARATOR ", ") AS nama_iuran, 
                      SUM(nominal) AS total_nominal, 
                      MAX(status) AS status, 
                      MAX(confirmed_at) AS confirmed_at, 
                      MAX(bukti_file) AS bukti_file, 
                      MAX(nomor_referensi) AS nomor_referensi')
            ->join('warga', 'warga.id_user = pembayaran.id_user')
            ->whereIn('status', ['Dikonfirmasi', 'Ditolak'])
            ->groupBy('id_transaksi')
            ->orderBy('confirmed_at', 'DESC');
    
        if ($search) {
            $query = $query->groupStart()
                ->like('id_transaksi', $search)
                ->orLike('warga.nama_lengkap', $search)
                ->orLike('nama_iuran', $search)
                ->groupEnd();
        }
    
        $pembayaranList = $query->findAll();
    
        $data = [
            'title' => 'Riwayat Konfirmasi Pembayaran',
            'pembayaranList' => $pembayaranList,
            'search' => $search,
        ];
    
        return view("$role/riwayat_konfirmasi", $data);
    }
    
    private function updateStatusIuranWarga($id_user, $id_iuran)
    {
        // Ambil data iuran warga
        $iuranWarga = $this->iuranWargaModel
            ->where('id_user', $id_user)
            ->where('id_iuran', $id_iuran)
            ->first();

        if ($iuranWarga) {
            $allPaid = true;
            $totalSudahDibayar = 0;

            // Periksa setiap bulan (Januari - Desember)
            for ($i = 1; $i <= 12; $i++) {
                $namaBulan = strtolower(date('F', mktime(0, 0, 0, $i, 10)));

                if (isset($iuranWarga[$namaBulan])) {
                    $nominal = (float)$iuranWarga[$namaBulan];
                    $totalSudahDibayar += $nominal;

                    if ($nominal == 0) {
                        $allPaid = false;
                    }
                }
            }

            // Perbarui total dan keterangan di tabel iuran_warga
            $this->iuranWargaModel->update($iuranWarga['id_iuran_warga'], [
                'total' => $totalSudahDibayar,
                'keterangan' => $allPaid ? 'Lunas' : 'Belum Lunas'
            ]);
        }
    }
}
