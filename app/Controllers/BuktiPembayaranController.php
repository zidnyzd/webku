<?php

namespace App\Controllers;

use App\Models\BuktiPembayaranModel;
use App\Models\IuranModel;
use App\Models\IuranWargaModel;

class BuktiPembayaranController extends BaseController
{
    protected $buktiPembayaranModel;
    protected $iuranModel;
    protected $iuranWargaModel;

    public function __construct()
    {
        $this->buktiPembayaranModel = new BuktiPembayaranModel();
        $this->iuranModel = new IuranModel();
        $this->iuranWargaModel = new IuranWargaModel();
    }

    public function indexWarga()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/warga/login');
        }

        // Ambil semua bukti pembayaran milik pengguna yang sedang login
        $buktiPembayaran = $this->buktiPembayaranModel
            ->select('bukti_pembayaran.*, iuran.nama_iuran')
            ->join('iuran', 'iuran.id_iuran = bukti_pembayaran.id_iuran')
            ->where('bukti_pembayaran.id_user', $id_user)
            ->orderBy('bukti_pembayaran.tanggal_pembayaran', 'DESC')
            ->findAll();

        // Gabungkan data bulan yang dibayar
        $pembayaranGrouped = [];
        foreach ($buktiPembayaran as $bukti) {
            $key = $bukti['tanggal_pembayaran'] . '-' . $bukti['nama_iuran'];
            if (!isset($pembayaranGrouped[$key])) {
                $pembayaranGrouped[$key] = [
                    'tanggal_pembayaran' => $bukti['tanggal_pembayaran'],
                    'nama_iuran' => $bukti['nama_iuran'],
                    'status' => $bukti['status'],
                    'metode_pembayaran' => $bukti['metode_pembayaran'],
                    'nomor_referensi' => $bukti['nomor_referensi'],
                    'bulan' => $bukti['bulan']
                ];
            }
            // Tambahkan nama iuran dan bulan ke dalam array
            $pembayaranGrouped[$key]['iuran'][] = [
            'nama_iuran' => $bukti['nama_iuran'],
            'bulan' => $bukti['bulan']
        ];
        }

        $data = [
            'title' => 'Bukti Pembayaran Saya',
            'buktiPembayaran' => $pembayaranGrouped
        ];

        return view('warga/bukti_pembayaran_list', $data);
    }

    public function bayarIuran()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/warga/login');
        }

        $iuranWarga = $this->iuranWargaModel
            ->select('iuran_warga.*, iuran.nama_iuran, iuran.tahun, iuran.iuran_bulanan')
            ->join('iuran', 'iuran.id_iuran = iuran_warga.id_iuran')
            ->where('iuran_warga.id_user', $id_user)
            ->findAll();

        $bulanBelumDibayar = [];
        foreach ($iuranWarga as $iuran) {
            $bulanBelumDibayar[$iuran['id_iuran']] = [];
            $bulan = [
                'januari' => 'Januari', 'februari' => 'Februari', 'maret' => 'Maret',
                'april' => 'April', 'mei' => 'Mei', 'juni' => 'Juni',
                'juli' => 'Juli', 'agustus' => 'Agustus', 'september' => 'September',
                'oktober' => 'Oktober', 'november' => 'November', 'desember' => 'Desember'
            ];

            foreach ($bulan as $key => $namaBulan) {
                if ($iuran[$key] == 0) {
                    $bulanBelumDibayar[$iuran['id_iuran']][] = [
                        'nama_bulan' => $namaBulan,
                        'nominal' => $iuran['iuran_bulanan']
                    ];
                }
            }
        }

        $data = [
            'title' => 'Pembayaran Iuran',
            'iuranList' => $iuranWarga,
            'bulanBelumDibayar' => $bulanBelumDibayar
        ];

        return view('warga/bayar_iuran', $data);
    }

    public function checkout()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/warga/login');
        }

        $iuranData = $this->request->getPost('iuran');
        $buktiPembayaranData = [];
        foreach ($iuranData as $id_iuran => $bulanArray) {
            $namaBulan = [];
            foreach ($bulanArray as $bulan) {
                $namaBulan[] = ucfirst($bulan);
            }

            $buktiPembayaranData[] = [
                'id_user' => $id_user,
                'id_iuran' => $id_iuran,
                'bulan' => implode(', ', $namaBulan),
                'tanggal_pembayaran' => date('Y-m-d'),
                'status' => 'Menunggu Konfirmasi',
                'metode_pembayaran' => 'Manual'
            ];
        }

        foreach ($buktiPembayaranData as $data) {
            $this->buktiPembayaranModel->insert($data);
        }

        return redirect()->to('/warga/bukti_pembayaran')->with('success', 'Pembayaran berhasil diajukan.');
    }

    public function pilihMetodePembayaran()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/warga/login');
        }

        $selectedPayments = $this->request->getPost('iuran');
        if (empty($selectedPayments)) {
            return redirect()->to('/warga/bayar_iuran')->with('error', 'Pilih iuran yang akan dibayar.');
        }

        session()->set('selectedPayments', $selectedPayments);

        $totalAmount = 0;
        foreach ($selectedPayments as $id_iuran => $bulanArray) {
            foreach ($bulanArray as $bulan) {
                $totalAmount += $this->iuranWargaModel->getIuranBulanan($id_iuran);
            }
        }

        session()->set('totalAmount', $totalAmount);

        return view('warga/pilih_metode_pembayaran', [
            'title' => 'Metode Pembayaran',
            'totalAmount' => $totalAmount
        ]);
    }

    public function prosesPembayaran()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/warga/login');
        }

        $metodePembayaran = $this->request->getPost('metode_pembayaran');
        $selectedPayments = session()->get('selectedPayments');

        if (empty($selectedPayments)) {
            return redirect()->to('/warga/bayar_iuran')->with('error', 'Tidak ada iuran yang dipilih untuk dibayar.');
        }

        if ($metodePembayaran === 'otomatis') {
            return redirect()->to('/warga/payment_gateway');
        } elseif ($metodePembayaran === 'manual') {
            return redirect()->to('/warga/manual_transfer');
        } else {
            return redirect()->to('/warga/pilih_metode_pembayaran')->with('error', 'Metode pembayaran tidak valid.');
        }
    }

    public function simpanBuktiPembayaran($id_user, $nomorReferensi, $newFileName, $selectedPayments)
    {
        $iuranGrouped = [];
        foreach ($selectedPayments as $id_iuran => $bulanArray) {
            $namaIuran = $this->iuranModel->select('nama_iuran')->where('id_iuran', $id_iuran)->first()['nama_iuran'];
            if (!isset($iuranGrouped[$namaIuran])) {
                $iuranGrouped[$namaIuran] = [];
            }
            $iuranGrouped[$namaIuran] = array_merge($iuranGrouped[$namaIuran], $bulanArray);
        }

        foreach ($iuranGrouped as $namaIuran => $bulanArray) {
            $data = [
                'id_user' => $id_user,
                'id_iuran' => $id_iuran,
                'tanggal_pembayaran' => date('Y-m-d'),
                'nomor_referensi' => $nomorReferensi,
                'bukti_file' => $newFileName,
                'status' => 'Menunggu Konfirmasi',
                'metode_pembayaran' => 'Manual',
                'bulan' => implode(', ', array_unique($bulanArray))
            ];

            $this->buktiPembayaranModel->insert($data);
        }
    }
}
