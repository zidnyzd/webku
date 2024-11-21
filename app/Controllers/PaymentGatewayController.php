<?php

namespace App\Controllers;

use App\Config\MidtransConfig;
use App\Models\WargaModel;
use App\Models\IuranModel;
use App\Models\IuranWargaModel;

class PaymentController extends BaseController
{
    protected $wargaModel;
    protected $iuranModel;
    protected $iuranWargaModel;

    public function __construct()
    {
        $this->wargaModel = new WargaModel();
        $this->iuranModel = new IuranModel();
        $this->iuranWargaModel = new IuranWargaModel();
    }

    public function createPayment()
    {
        // Atur konfigurasi Midtrans
        MidtransConfig::configure();

        // Ambil `id_user` dari session
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/warga/login');
        }

        // Ambil data pengguna berdasarkan `id_user`
        $user = $this->wargaModel->find($id_user);

        // Ambil iuran yang akan dibayar
        $selectedPayments = session()->get('selectedPayments'); // Data iuran yang dipilih dari session
        $totalAmount = 0;
        $iuranDetails = []; // Untuk detail transaksi Midtrans

        foreach ($selectedPayments as $id_iuran => $bulanArray) {
            $iuran = $this->iuranModel->find($id_iuran);

            if (!$iuran) {
                continue; // Lewati jika iuran tidak ditemukan
            }

            foreach ($bulanArray as $bulan) {
                $nominal = $this->iuranWargaModel
                    ->where('id_user', $id_user)
                    ->where('id_iuran', $id_iuran)
                    ->first()['nominal_khusus'] ?? $iuran['iuran_bulanan'];

                $iuranDetails[] = [
                    'name' => $iuran['nama_iuran'] . " - " . ucfirst($bulan),
                    'quantity' => 1,
                    'price' => $nominal,
                ];

                $totalAmount += $nominal;
            }
        }

        // Jika tidak ada iuran yang dipilih, kembalikan error
        if (empty($iuranDetails)) {
            return redirect()->to('/warga/bayar_iuran')->with('error', 'Tidak ada iuran yang dipilih.');
        }

        // Data untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => uniqid('ORDER-'),
                'gross_amount' => $totalAmount,
            ],
            'customer_details' => [
                'first_name' => $user['nama_lengkap'],
                'email' => $user['email'] ?? 'example@example.com',
                'phone' => $user['no_telpon'] ?? '081234567890',
            ],
            'item_details' => $iuranDetails,
        ];

        try {
            // Dapatkan Snap Token dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan data transaksi ke database
            $this->saveOrderToDatabase($params, $snapToken, $id_user);

            // Kirim Snap Token ke view
            return view('payment_form', ['token' => $snapToken]);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setBody('Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    private function saveOrderToDatabase($params, $snapToken, $id_user)
    {
        $data = [
            'id_user' => $id_user,
            'order_id' => $params['transaction_details']['order_id'],
            'gross_amount' => $params['transaction_details']['gross_amount'],
            'snap_token' => $snapToken,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Simpan ke tabel `transactions`
        $this->db->table('transactions')->insert($data);
    }
}
