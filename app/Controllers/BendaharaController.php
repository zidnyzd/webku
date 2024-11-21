<?php

namespace App\Controllers;

use App\Models\WargaModel;
use App\Models\IuranWargaModel;
use App\Models\IuranModel;

class BendaharaController extends BaseController
{
    protected $wargaModel;
    protected $iuranWargaModel;
    protected $iuranModel;

    public function __construct()
    {
        $this->wargaModel = new WargaModel();
        $this->iuranWargaModel = new IuranWargaModel();
        $this->iuranModel = new IuranModel();
    }

    // Daftar warga dengan search untuk mencari nama dan mencatat
    public function wargaList()
    {
        // Pastikan user adalah pengurus
        if (session()->get('role') !== 'bendahara') {
            return redirect()->to('/warga/login');
        }
        
        $keyword = $this->request->getGet('keyword');
        if ($keyword) {
            $wargaList = $this->wargaModel->like('nama_lengkap', $keyword)
                                           ->orLike('nik', $keyword)
                                           ->orLike('no_kk', $keyword)
                                           ->findAll();
        } else {
            $wargaList = $this->wargaModel->findAll();
        }

        return view('bendahara/catat_iuran_warga', ['wargaList' => $wargaList, 'title' => 'Daftar Warga']);
    }

    public function manageNominalKhusus()
    {
        $keyword = $this->request->getGet('keyword');
        $wargaList = $this->wargaModel;

        if ($keyword) {
            $wargaList = $wargaList->like('nik', $keyword)
                                ->orLike('nama_lengkap', $keyword)
                                ->orLike('no_kk', $keyword);
        }

        $wargaList = $wargaList->findAll();

        foreach ($wargaList as &$warga) {
            $warga['iuran_list'] = $this->iuranWargaModel
                ->select('iuran.nama_iuran, iuran.iuran_bulanan as nominal_default, iuran_warga.nominal_khusus, iuran.id_iuran')
                ->join('iuran', 'iuran_warga.id_iuran = iuran.id_iuran')
                ->where('iuran_warga.id_user', $warga['id_user'])
                ->findAll();
        }

        return view('bendahara/manage_nominal_khusus', [
            'title' => 'Kelola Nominal Khusus Warga',
            'wargaList' => $wargaList
        ]);
    }


    public function editNominalKhusus($id_user)
    {
        // Ambil data warga berdasarkan ID
        $warga = $this->wargaModel->find($id_user);
        if (!$warga) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Warga tidak ditemukan');
        }

        // Ambil daftar iuran dan nominal khusus untuk pengguna
        $iuranList = $this->iuranWargaModel
            ->select('iuran.nama_iuran, iuran.iuran_bulanan as nominal_default, iuran_warga.nominal_khusus, iuran.id_iuran')
            ->join('iuran', 'iuran_warga.id_iuran = iuran.id_iuran')
            ->where('iuran_warga.id_user', $id_user)
            ->findAll();

        // Kirim data ke view
        return view('bendahara/edit_nominal_khusus', [
            'title' => 'Edit Nominal Khusus - ' . esc($warga['nama_lengkap']),
            'warga' => $warga,
            'iuranList' => $iuranList
        ]);
    }

    public function updateNominalKhusus($id_user, $id_iuran)
    {
        $nominalKhususRaw = $this->request->getPost('nominal_khusus_raw');
        
        // Set nominal khusus to null only if empty, otherwise, set the numeric value
        $nominalKhusus = !empty($nominalKhususRaw) ? (int)str_replace('.', '', $nominalKhususRaw) : null;
    
        $this->iuranWargaModel->where('id_user', $id_user)
                              ->where('id_iuran', $id_iuran)
                              ->set(['nominal_khusus' => $nominalKhusus])
                              ->update();
    
        return redirect()->to('/bendahara/manage_nominal_khusus')->with('success', 'Nominal Khusus berhasil diperbarui.');
    }


    public function catatIuran($id_user)
    {
        // Ambil data warga
        $warga = $this->wargaModel->find($id_user);
        if (!$warga) {
            return redirect()->to('/bendahara/warga')->with('error', 'Warga tidak ditemukan.');
        }
    
        // Ambil daftar iuran yang tersedia dan nominal khusus untuk warga ini
        $iuranList = $this->iuranWargaModel
        ->select('iuran.id_iuran, iuran.nama_iuran, iuran.iuran_bulanan, iuran_warga.nominal_khusus, 
            iuran_warga.januari, iuran_warga.februari, iuran_warga.maret, iuran_warga.april, 
            iuran_warga.mei, iuran_warga.juni, iuran_warga.juli, iuran_warga.agustus, 
            iuran_warga.september, iuran_warga.oktober, iuran_warga.november, iuran_warga.desember')
        ->join('iuran', 'iuran.id_iuran = iuran_warga.id_iuran')
        ->where('iuran_warga.id_user', $id_user)
        ->findAll();


        // Filter bulan yang belum dibayar
        foreach ($iuranList as &$iuran) {
            $bulanBelumDibayar = [];
            foreach (['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'] as $bulan) {
                if ($iuran[$bulan] == 0) { // Jika bulan belum dibayar
                    $bulanBelumDibayar[] = $bulan;
                }
            }
            $iuran['bulan_belum_dibayar'] = $bulanBelumDibayar;
        }
        
        // Ambil daftar iuran pribadi milik warga yang dipilih
        $iuranPribadi = $this->iuranWargaModel
            ->select('iuran_warga.*, iuran.nama_iuran, iuran.tahun')
            ->join('iuran', 'iuran.id_iuran = iuran_warga.id_iuran')
            ->where('iuran_warga.id_user', $id_user)
            ->findAll();
    
        // Kirim data warga, iuran, dan iuran pribadi ke view
        return view('bendahara/catat_iuran', [
            'title' => 'Catat Iuran Warga',
            'warga' => $warga,
            'iuranList' => $iuranList,
            'iuranPribadi' => $iuranPribadi
        ]);
    }
    
    // Fungsi untuk menyimpan iuran
    public function saveIuran()
    {
        // Ambil input
        $id_user = $this->request->getPost('id_user');
        $id_iuran = $this->request->getPost('id_iuran');
        $bulan = $this->request->getPost('bulan');
        $jumlah = str_replace('.', '', $this->request->getPost('jumlah'));  // Hapus titik pada nilai jumlah

        // Ambil data iuran warga dengan join ke tabel iuran untuk mendapatkan 'iuran_bulanan' dan 'nominal_khusus'
        $iuranWarga = $this->iuranWargaModel
            ->select('iuran_warga.*, iuran.iuran_bulanan')
            ->join('iuran', 'iuran_warga.id_iuran = iuran.id_iuran')
            ->where('iuran_warga.id_user', $id_user)
            ->where('iuran_warga.id_iuran', $id_iuran)
            ->first();

        if (!$iuranWarga) {
            return redirect()->back()->with('error', 'Data iuran warga tidak ditemukan.');
        }

        // Cek apakah nominal_khusus diisi, jika ya, gunakan nominal_khusus; jika tidak, gunakan iuran_bulanan
        $nominal = $iuranWarga['nominal_khusus'] ?? $iuranWarga['iuran_bulanan'];

        // Update iuran berdasarkan bulan yang dipilih
        $dataUpdate = [
            $bulan => $jumlah,  // Mengupdate kolom bulan yang sesuai dengan jumlah yang dibayar
        ];

        // Hitung ulang total setelah update
        $total = array_sum(array_slice($iuranWarga, 3, 12)) + $jumlah;

        $dataUpdate['total'] = $total;

        // Tentukan keterangan (Lunas atau Belum Lunas) berdasarkan nominal yang seharusnya
        if ($total >= 12 * $nominal) {
            $dataUpdate['keterangan'] = 'Lunas';
        } else {
            $dataUpdate['keterangan'] = 'Belum Lunas';
        }

        // Update data iuran warga
        $this->iuranWargaModel->update($iuranWarga['id_iuran_warga'], $dataUpdate);

        return redirect()->to('/bendahara/catat_iuran/' . $id_user)->with('success', 'Iuran berhasil dicatat.');
    }

    public function updateIuran($id_iuran_warga)
    {
        // Ambil data input dari form untuk tiap bulan
        $data = $this->request->getPost([
            'januari', 'februari', 'maret', 'april', 'mei', 'juni', 
            'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
        ]);

        // Hilangkan titik pemisah ribuan di setiap bulan
        foreach ($data as &$amount) {
            $amount = str_replace('.', '', $amount);
        }

        // Ambil data iuran warga
        $iuranWarga = $this->iuranWargaModel
            ->select('iuran_warga.*, iuran.iuran_bulanan')
            ->join('iuran', 'iuran.id_iuran = iuran_warga.id_iuran')
            ->where('iuran_warga.id_iuran_warga', $id_iuran_warga)
            ->first();

        if (!$iuranWarga) {
            return redirect()->back()->with('error', 'Data iuran warga tidak ditemukan.');
        }

        // Hitung ulang total iuran per tahun
        $data['total'] = array_sum($data);

        // Tentukan status lunas atau belum
        $nominal = $iuranWarga['nominal_khusus'] ?? $iuranWarga['iuran_bulanan'];
        $data['keterangan'] = $data['total'] >= 12 * $nominal ? 'Lunas' : 'Belum Lunas';

        // Update iuran_warga
        $this->iuranWargaModel->update($id_iuran_warga, $data);

        return redirect()->to('/bendahara/catat_iuran/' . $this->request->getPost('id_user'))->with('success', 'Iuran berhasil diperbarui.');
    }
}