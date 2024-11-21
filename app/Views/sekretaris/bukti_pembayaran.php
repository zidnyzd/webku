<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">

        <!-- Form Upload Bukti Pembayaran -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Upload Bukti Pembayaran</h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('warga/bukti_pembayaran/store') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="id_iuran">Pilih Iuran</label>
                        <select class="form-control" id="id_iuran" name="id_iuran" required>
                            <option value="" disabled selected>Pilih Iuran</option>
                            <?php foreach ($iuranList as $iuran): ?>
                                <option value="<?= esc($iuran['id_iuran']) ?>"><?= esc($iuran['nama_iuran']) ?> - Tahun <?= esc($iuran['tahun']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                        <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor_referensi">Nomor Referensi (Opsional)</label>
                        <input type="text" class="form-control" id="nomor_referensi" name="nomor_referensi" placeholder="Masukkan Nomor Referensi">
                    </div>
                    <div class="form-group">
                        <label for="bukti_file">Upload Bukti Pembayaran</label>
                        <input type="file" class="form-control" id="bukti_file" name="bukti_file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Bukti</button>
                </form>
            </div>
        </div>

    </div>
</section>
<?= $this->endSection() ?>
