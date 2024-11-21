<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Rekening</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('bendahara/rekening/update/' . $rekening['id_rekening']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <label for="bank">Bank</label>
                                <input type="text" class="form-control" id="bank" name="bank" value="<?= esc($rekening['bank']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nomor_rekening">Nomor Rekening</label>
                                <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening" value="<?= esc($rekening['nomor_rekening']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="atas_nama">Atas Nama</label>
                                <input type="text" class="form-control" id="atas_nama" name="atas_nama" value="<?= esc($rekening['atas_nama']) ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
