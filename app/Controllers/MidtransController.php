<?php

namespace App\Controllers;

use App\Models\PembayaranModel;
use App\Models\IuranWargaModel;

class MidtransController extends BaseController
{
    protected $pembayaranModel;
    protected $iuranWargaModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->iuranWargaModel = new IuranWargaModel();
    }

    public function callback()
    {
        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = 'SB-Mid-server-kfuj6oM444zRYcz-enhAT29t';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;

        // Ambil data notifikasi dari Midtrans
        $json = file_get_contents('php://input');
        $notification = json_decode($json);

        // Validasi Signature Key
        $signatureKey = hash('sha512', $notification->order_id . $notification->status_code . $notification->gross_amount . \Midtrans\Config::$serverKey);
        if ($signatureKey !== $notification->signature_key) {
            return $this->response->setStatusCode(403)->setBody('Invalid Signature Key');
        }

        // Ambil detail transaksi
        $transactionStatus = $notification->transaction_status; // Status transaksi dari Midtrans
        $orderId = $notification->order_id;

        if ($transactionStatus === 'settlement') {
            // Transaksi berhasil
            $this->pembayaranModel->where('id_transaksi', $orderId)
                ->set(['status' => 'Dikonfirmasi'])
                ->update();

            // Ambil pembayaran terkait id_transaksi
            $pembayaranList = $this->pembayaranModel->where('id_transaksi', $orderId)->findAll();

            foreach ($pembayaranList as $pembayaran) {
                // Pastikan nama bulan sesuai kolom di tabel `iuran_warga`
                $namaBulan = strtolower($pembayaran['bulan']);

                // Update kolom bulan di tabel `iuran_warga`
                $this->iuranWargaModel->set($namaBulan, $pembayaran['nominal'])
                    ->where('id_iuran', $pembayaran['id_iuran'])
                    ->where('id_user', $pembayaran['id_user'])
                    ->update();
            }

            // Periksa status lunas dan total pembayaran
            $this->updateIuranStatus($pembayaranList[0]['id_iuran'], $pembayaranList[0]['id_user']);
        } elseif ($transactionStatus === 'pending') {
            // Menunggu pembayaran
            $this->pembayaranModel->where('id_transaksi', $orderId)
                ->set(['status' => 'Menunggu Konfirmasi'])
                ->update();
        } elseif ($transactionStatus === 'cancel' || $transactionStatus === 'expire') {
            // Transaksi dibatalkan atau kadaluarsa
            $this->pembayaranModel->where('id_transaksi', $orderId)
                ->set(['status' => 'Ditolak'])
                ->update();
        }

        // Log notifikasi untuk debugging
        log_message('info', 'Midtrans Callback: ' . json_encode($notification));

        return $this->response->setStatusCode(200)->setBody('OK');
    }

    private function updateIuranStatus($id_iuran, $id_user)
    {
        // Ambil data iuran_warga
        $iuranWarga = $this->iuranWargaModel
            ->select('iuran_warga.*, iuran.nama_iuran, iuran.iuran_bulanan')
            ->join('iuran', 'iuran.id_iuran = iuran_warga.id_iuran')
            ->where('iuran_warga.id_iuran', $id_iuran)
            ->where('iuran_warga.id_user', $id_user)
            ->first();

        if (!$iuranWarga) {
            log_message('error', 'Iuran warga tidak ditemukan untuk id_iuran: ' . $id_iuran . ', id_user: ' . $id_user);
            return;
        }

        $currentMonth = intval(date('m'));
        $totalSudahDibayar = 0;
        $totalHarusDibayar = 0;
        $allPaid = true;

        // Iterasi setiap bulan hingga bulan berjalan
        for ($i = 1; $i <= 12; $i++) {
            $namaBulan = strtolower(date('F', mktime(0, 0, 0, $i, 10)));

            switch ($namaBulan) {
                case 'january': $namaBulan = 'januari'; break;
                case 'february': $namaBulan = 'februari'; break;
                case 'march': $namaBulan = 'maret'; break;
                case 'april': $namaBulan = 'april'; break;
                case 'may': $namaBulan = 'mei'; break;
                case 'june': $namaBulan = 'juni'; break;
                case 'july': $namaBulan = 'juli'; break;
                case 'august': $namaBulan = 'agustus'; break;
                case 'september': $namaBulan = 'september'; break;
                case 'october': $namaBulan = 'oktober'; break;
                case 'november': $namaBulan = 'november'; break;
                case 'december': $namaBulan = 'desember'; break;
            }

            // Hitung total pembayaran berdasarkan bulan
            if (isset($iuranWarga[$namaBulan]) && (float)$iuranWarga[$namaBulan] > 0) {
                $totalSudahDibayar += (float)$iuranWarga[$namaBulan];
            }

            // Cek jika bulan berjalan belum dibayar
            if (isset($iuranWarga[$namaBulan]) && (float)$iuranWarga[$namaBulan] == 0 && $i <= $currentMonth) {
                $nilaiIuran = $iuranWarga['nominal_khusus'] ?? $iuranWarga['iuran_bulanan'];
                $totalHarusDibayar += $nilaiIuran;
                $allPaid = false;
            }
        }

        // Perbarui total pembayaran dan status
        $this->iuranWargaModel->update($iuranWarga['id_iuran_warga'], [
            'total' => $totalSudahDibayar,
            'keterangan' => $allPaid ? 'Lunas' : 'Belum Lunas'
        ]);

        log_message('info', 'Updated total and status for iuran_warga: ' . $iuranWarga['id_iuran_warga']);
    }


}
