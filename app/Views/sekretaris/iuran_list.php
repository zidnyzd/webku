<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">

        <!-- Tabel untuk menampilkan daftar iuran -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tabel Daftar Iuran</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Iuran</th>
                                <th>Tahun</th>
                                <th>Iuran Per Bulan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($iuranList as $iuran): ?>    
                                <tr>
                                    <td><?= esc($iuran['nama_iuran']) ?></td>
                                    <td><?= esc($iuran['tahun']) ?></td>
                                    <td><?= 'Rp ' . number_format($iuran['iuran_bulanan'], 0, ',', '.') ?></td>
                                    <td>
                                        <a href="<?= base_url('ketua/iuran/detail/' . $iuran['id_iuran']) ?>" class="btn btn-info">Detail</a>
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
