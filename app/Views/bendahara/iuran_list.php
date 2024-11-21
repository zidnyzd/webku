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
                <a href="<?= base_url('/bendahara/iuran/create') ?>" class="btn btn-primary mb-3">Tambah Iuran Baru</a>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Iuran</th>
                                <th>Tahun</th>
                                <th>Jumlah Per Bulan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($iuranList as $iuran): ?>
                                <?php 
                                    // Gunakan nominal_khusus jika ada, jika tidak gunakan iuran_bulanan
                                    $jumlahPerBulan = isset($iuran['nominal_khusus']) && $iuran['nominal_khusus'] > 0 
                                                      ? $iuran['nominal_khusus'] 
                                                      : $iuran['iuran_bulanan'];
                                ?>
                                <tr>
                                    <td><?= esc($iuran['nama_iuran']) ?></td>
                                    <td><?= esc($iuran['tahun']) ?></td>
                                    <td><?= 'Rp ' . number_format($jumlahPerBulan, 0, ',', '.') ?></td>
                                    <td>
                                        <a href="<?= base_url('bendahara/iuran/detail/' . $iuran['id_iuran']) ?>" class="btn btn-info">Detail</a>
                                        <a href="<?= base_url('bendahara/iuran/edit/' . $iuran['id_iuran']) ?>" class="btn btn-warning">Edit</a>
                                        <a href="<?= base_url('bendahara/iuran/delete/' . $iuran['id_iuran']) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus iuran ini?');">Delete</a>
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
