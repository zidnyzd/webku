<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Nominal Khusus untuk <?= esc($warga['nama_lengkap']) ?></h3>
            </div>
            <div class="card-body">

                <!-- Table of Iuran with Normal and Custom Nominal -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Iuran</th>
                                <th>Nominal Default (Rp)</th>
                                <th>Nominal Khusus (Rp)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($iuranList as $iuran): ?>
                                <tr>
                                    <td><?= esc($iuran['nama_iuran']) ?></td>
                                    <td>Rp <?= number_format($iuran['nominal_default'], 0, ',', '.') ?></td>
                                    <td>
                                        <!-- Form untuk mengubah nominal khusus -->
                                        <form id="form-<?= $warga['id_user'] ?>-<?= $iuran['id_iuran'] ?>" 
                                            action="<?= base_url('bendahara/update_nominal_khusus/' . $warga['id_user'] . '/' . $iuran['id_iuran']) ?>" 
                                            method="post">
                                            <?= csrf_field() ?>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" name="nominal_khusus" class="form-control" 
                                                    value="<?= isset($iuran['nominal_khusus']) ? number_format($iuran['nominal_khusus'], 0, '', '') : '' ?>" 
                                                    placeholder="Masukkan Nominal Khusus">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm mt-2">Update</button>
                                        </form>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
