<?php

namespace App\Controllers;

use App\Models\IuranWargaModel;
use App\Models\PembayaranModel;
use App\Models\IuranModel;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\WargaModel;

class PembayaranController extends BaseController
{
    protected $iuranWargaModel;
    protected $pembayaranModel;
    protected $iuranModel;
    protected $wargaModel;

    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = 'SB-Mid-server-kfuj6oM444zRYcz-enhAT29t'; // Ganti dengan server key Midtrans Anda
        Config::$isProduction = false; // Ubah ke true jika di produksi
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $this->iuranWargaModel = new IuranWargaModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->iuranModel = new IuranModel();
        $this->wargaModel = new WargaModel();
    }

    // Menampilkan halaman pembayaran iuran
    public function bayarIuran()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/warga/login');
        }

        // Ambil data iuran warga, termasuk nominal_khusus
        $iuranWarga = $this->iuranWargaModel
            ->select('iuran_warga.*, iuran.nama_iuran, iuran.tahun, iuran.iuran_bulanan, iuran_warga.nominal_khusus')
            ->join('iuran', 'iuran.id_iuran = iuran_warga.id_iuran')
            ->where('iuran_warga.id_user', $id_user)
            ->findAll();

        // Ambil pembayaran yang menunggu konfirmasi
        $pendingPayments = $this->pembayaranModel
            ->select('id_iuran, bulan')
            ->where('id_user', $id_user)
            ->where('status', 'Menunggu Konfirmasi')
            ->findAll();

        // Konversi daftar bulan yang menunggu konfirmasi ke array
        $pendingBulan = [];
        foreach ($pendingPayments as $payment) {
            $pendingBulan[$payment['id_iuran']][] = strtolower($payment['bulan']);
        }

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
                // Cek jika belum dibayar atau tidak sedang menunggu konfirmasi
                $isPending = in_array($key, $pendingBulan[$iuran['id_iuran']] ?? []);
                if ($iuran[$key] == 0 && !$isPending) {
                    $nominal = $iuran['nominal_khusus'] ?? $iuran['iuran_bulanan']; // Prioritaskan nominal_khusus
                    $bulanBelumDibayar[$iuran['id_iuran']][] = [
                        'nama_bulan' => $namaBulan,
                        'nominal' => $nominal
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

    public function pilihMetodePembayaran()
    {
        $id_user = session()->get('id_user');
        $role = session()->get('role');

        if (!$id_user) {
            return redirect()->to('/warga/login');
        }

        // Ambil data pembayaran yang dipilih
        $selectedPayments = $this->request->getPost('iuran');
        if (empty($selectedPayments)) {
            return redirect()->to('/warga/bayar_iuran')->with('error', 'Pilih iuran yang akan dibayar.');
        }

        $paymentDetails = [];
        $totalAmount = 0;

        foreach ($selectedPayments as $id_iuran => $bulanArray) {
            // Ambil data iuran dengan nominal khusus jika tersedia
            $iuranData = $this->iuranWargaModel
                ->select('iuran.nama_iuran, iuran_bulanan, nominal_khusus')
                ->join('iuran', 'iuran.id_iuran = iuran_warga.id_iuran')
                ->where('iuran_warga.id_user', $id_user)
                ->where('iuran_warga.id_iuran', $id_iuran)
                ->first();

            if (!$iuranData) {
                return redirect()->to('/warga/bayar_iuran')->with('error', 'Data iuran tidak ditemukan.');
            }

            // Gunakan nominal_khusus jika tersedia, atau fallback ke iuran_bulanan
            $nominal = $iuranData['nominal_khusus'] ?? $iuranData['iuran_bulanan'];

            foreach ($bulanArray as $bulan) {
                $paymentDetails[$iuranData['nama_iuran']][strtolower($bulan)] = ucfirst($bulan);
                $totalAmount += $nominal;
            }
        }

        // Simpan data ke sesi
        session()->set('selectedPayments', $selectedPayments);
        session()->set('totalAmount', $totalAmount);

        $data = [
            'title' => 'Metode Pembayaran',
            'totalAmount' => $totalAmount
        ];

        return view("$role/pilih_metode_pembayaran", $data);
    }

    public function prosesPembayaran()
    {
        $id_user = session()->get('id_user');
        $role = session()->get('role');
        
        if (!$id_user) {
            return redirect()->to('/warga/login');
        }

        // Ambil data warga dari WargaModel
        $warga = $this->wargaModel->find($id_user);

        if (!$warga) {
            return redirect()->to("/$role/bayar_iuran")->with('error', 'Data warga tidak ditemukan.');
        }
    
        $metodePembayaran = $this->request->getPost('metode_pembayaran');
        $selectedPayments = session()->get('selectedPayments');
        $totalAmount = session()->get('totalAmount');
        
        if (empty($selectedPayments) || !$totalAmount || !$metodePembayaran) {
            return redirect()->to("/$role/bayar_iuran")->with('error', 'Data pembayaran tidak lengkap.');
        }
    
        if ($metodePembayaran === 'otomatis') {
            // Buat ID Transaksi
            $idTransaksi = uniqid('TRX-');
    
            // Buat payload untuk Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $idTransaksi,
                    'gross_amount' => $totalAmount,
                ],
                'customer_details' => [
                    'first_name' => session()->get('nama_lengkap'),
                    'email' => session()->get('email'),
                    'phone' => session()->get('no_telpon'),
                    'alamat' => session()->get('alamat'),
                ],
                'callbacks' => [
                    'finish' => base_url('warga/bukti_pembayaran'), // URL pengalihan setelah selesai
                ],
            ];
    
            try {
                // Dapatkan Snap Token
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                // Debug: pastikan snap_token benar
                if (empty($snapToken)) {
                    log_message('error', 'Snap Token tidak terisi untuk transaksi: ' . $idTransaksi);
                    return redirect()->to("/$role/pilih_metode_pembayaran")->with('error', 'Gagal mendapatkan Snap Token.');
                }
    
                // Simpan data transaksi ke tabel pembayaran
                foreach ($selectedPayments as $id_iuran => $bulanArray) {
                    $iuranData = $this->iuranWargaModel
                        ->select('iuran.nama_iuran, iuran_bulanan, nominal_khusus, iuran.tahun')
                        ->join('iuran', 'iuran.id_iuran = iuran_warga.id_iuran')
                        ->where('iuran_warga.id_user', $id_user)
                        ->where('iuran_warga.id_iuran', $id_iuran)
                        ->first();
                    
                    $nominalPerBulan = $iuranData['nominal_khusus'] ?? $iuranData['iuran_bulanan'];
                    
                    foreach ($bulanArray as $bulan) {
                        $tahun = $iuranData['tahun'] ?? date('Y');
                        log_message('info', "Menyimpan Snap Token: {$snapToken} untuk transaksi {$idTransaksi}");
                        
                        $this->pembayaranModel->insert([
                            'id_user' => $id_user,
                            'id_transaksi' => $idTransaksi,
                            'id_iuran' => $id_iuran,
                            'nama_iuran' => $iuranData['nama_iuran'],
                            'bulan' => ucfirst($bulan),
                            'tahun' => $tahun,
                            'nominal' => $nominalPerBulan,
                            'status' => 'Pending',
                            'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                            'metode_pembayaran' => 'Otomatis',
                            'snap_token' => $snapToken, // Pastikan snap_token disimpan
                        ]);
                    }
                }
                return redirect()->to("https://app.sandbox.midtrans.com/snap/v2/vtweb/$snapToken");

                // return view('warga/midtrans_payment', ['snapToken' => $snapToken]);
            } catch (\Exception $e) {
                return redirect()->to("/$role/pilih_metode_pembayaran")->with('error', 'Gagal memproses pembayaran otomatis.');
            }
        } else {
            // Metode Manual
            session()->set('metodePembayaran', $metodePembayaran);
            return redirect()->to("/$role/manual_transfer");
        }
    }    

    public function listPembayaran()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/warga/login');
        }

        log_message('info', 'Flashdata di listPembayaran: ' . session()->getFlashdata('success'));
    
        // Ambil pembayaran dan kelompokkan berdasarkan ID Transaksi
        $pembayaranList = $this->pembayaranModel
            ->select('
                id_transaksi, 
                MAX(tanggal_pembayaran) AS tanggal_pembayaran, 
                GROUP_CONCAT(CONCAT(nama_iuran, ":", bulan) SEPARATOR ", ") AS nama_iuran, 
                SUM(nominal) AS total_nominal, 
                MAX(status) AS status, 
                MAX(metode_pembayaran) AS metode_pembayaran, 
                MAX(nomor_referensi) AS nomor_referensi, 
                MAX(bukti_file) AS bukti_file,
                MAX(snap_token) AS snap_token

            ')
            ->where('id_user', $id_user)
            ->groupBy('id_transaksi')
            ->orderBy('tanggal_pembayaran', 'DESC')
            ->findAll();
    
            return view('warga/bukti_pembayaran_list', [
                'title' => 'Riwayat Pembayaran',
                'pembayaranList' => $pembayaranList,
            ]);
            
    }
}
