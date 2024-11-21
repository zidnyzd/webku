<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Tampilkan error jika ada -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Form Edit Iuran -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Iuran</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('bendahara/iuran/update/' . $iuran['id_iuran']) ?>" method="post">
                            <?= csrf_field() ?>
                            
                            <div class="form-group">
                                <label for="nama_iuran">Nama Iuran</label>
                                <input type="text" class="form-control" id="nama_iuran" name="nama_iuran" value="<?= esc($iuran['nama_iuran']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="iuran_bulanan">Jumlah Iuran Per Bulan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" id="iuran_bulanan" name="iuran_bulanan" value="<?= number_format($iuran['iuran_bulanan'], 0, ',', '.') ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="number" class="form-control" id="tahun" name="tahun" value="<?= esc($iuran['tahun']) ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Iuran</button>
                            <a href="<?= base_url('bendahara/iuran/list') ?>" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const iuranInput = document.getElementById('iuran_bulanan');
        
        iuranInput.addEventListener('input', function() {
            // Hapus format rupiah sebelumnya
            let value = this.value.replace(/\D/g, '');

            // Format ulang sebagai rupiah
            if (value) {
                value = parseInt(value, 10).toLocaleString('id-ID');
            }
            this.value = value;
        });

        // Hapus format saat form di-submit agar hanya angka yang dikirim
        document.querySelector('form').addEventListener('submit', function() {
            iuranInput.value = iuranInput.value.replace(/\./g, '');
        });
    });
</script>
<?= $this->endSection() ?>
