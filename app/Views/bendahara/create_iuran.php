<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Buat Iuran Baru</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('/bendahara/iuran/store') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <label for="nama_iuran">Nama Iuran</label>
                                <input type="text" class="form-control" id="nama_iuran" name="nama_iuran" required>
                            </div>
                            <div class="form-group">
                                <label for="iuran_bulanan">Nominal Iuran Bulanan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control nominal-input" id="iuran_bulanan" name="iuran_bulanan" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="number" class="form-control" id="tahun" name="tahun" value="<?= date('Y') ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Iuran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nominalInput = document.getElementById('iuran_bulanan');

        nominalInput.addEventListener('input', function() {
            let rawValue = this.value.replace(/\D/g, '');  // Hapus karakter selain angka
            if (rawValue) {
                this.value = parseInt(rawValue, 10).toLocaleString('id-ID');  // Format ke rupiah
            }
        });

        // Membersihkan format ketika dikirim ke server agar tidak ada titik
        document.querySelector('form').addEventListener('submit', function(e) {
            nominalInput.value = nominalInput.value.replace(/\./g, '');
        });
    });
</script>


<?= $this->endSection() ?>
