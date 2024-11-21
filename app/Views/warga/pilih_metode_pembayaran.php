<!-- Views/warga/pilih_metode_pembayaran.php -->
<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Metode Pembayaran</h3>
    <div class="card">
        <div class="card-body">
            <h4>Total Pembayaran: Rp. <?= number_format($totalAmount, 0, ',', '.') ?></h4>
            <p>Silakan pilih metode pembayaran:</p>

            <form action="<?= base_url('warga/proses_pembayaran') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="metode-otomatis" name="metode_pembayaran" class="custom-control-input" value="otomatis" required>
                        <label class="custom-control-label" for="metode-otomatis">Validasi Otomatis (Menggunakan Payment Gateway)</label>
                    </div>
                    <div class="custom-control custom-radio mt-2">
                        <input type="radio" id="metode-manual" name="metode_pembayaran" class="custom-control-input" value="manual">
                        <label class="custom-control-label" for="metode-manual">Validasi Manual (Transfer Bank/VA)</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Lanjutkan</button>
            </form>
        </div>
    </div>
    <a href="<?= base_url('warga/bayar_iuran') ?>" class="btn btn-secondary mt-3">Kembali ke Tagihan</a>
</div>

<?= $this->endSection() ?>
