<!-- Views/warga/manual_transfer.php -->
<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<?php
    $rekeningModel = new \App\Models\RekeningModel();
    $rekeningList = $rekeningModel->findAll();
?>
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h4>Transfer Manual</h4>
            <p>Silakan lakukan transfer ke rekening berikut:</p>
            <ul>
                <?php foreach ($rekeningList as $rekening): ?>
                    <li>
                        Bank: <?= esc($rekening['bank']) ?><br>
                        Nomor Rekening: <?= esc($rekening['nomor_rekening']) ?><br>
                        Atas Nama: <?= esc($rekening['atas_nama']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <hr>
            <h5>Jumlah yang harus ditransfer: <strong>Rp. <?= number_format($totalAmount, 0, ',', '.') ?></strong></h5>
            <p>Pastikan untuk melakukan transfer sesuai dengan jumlah di atas agar proses verifikasi berjalan lancar.</p>
            <hr>
            <form action="<?= base_url('warga/manual_transfer/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="nomor_referensi">Nomor Referensi Transfer</label>
                    <input type="text" class="form-control" id="nomor_referensi" name="nomor_referensi" required>
                </div>
                <div class="form-group">
                    <label for="bukti_transfer">Upload Bukti Transfer</label>
                    <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer" required>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Bukti Transfer</button>
            </form>
        </div>
    </div>
    <a href="<?= base_url('warga/metode_pembayaran') ?>" class="btn btn-secondary mt-3">Kembali ke Metode Pembayaran</a>
</div>
<?= $this->endSection() ?>
