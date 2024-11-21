<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">

        <!-- Tabel responsive Bootstrap -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tabel Iuran Pribadi</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Iuran</th>
                                <th>Tahun</th>
                                <th>Januari</th>
                                <th>Februari</th>
                                <th>Maret</th>
                                <th>April</th>
                                <th>Mei</th>
                                <th>Juni</th>
                                <th>Juli</th>
                                <th>Agustus</th>
                                <th>September</th>
                                <th>Oktober</th>
                                <th>November</th>
                                <th>Desember</th>
                                <th>Total</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Looping data iuran warga -->
                            <?php foreach ($iuranWarga as $iuran): ?>
                                <tr>
                                    <td><?= esc($iuran['nama_iuran']) ?></td>
                                    <td><?= esc($iuran['tahun']) ?></td>
                                    <td>Rp <?= number_format((float) $iuran['januari'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $iuran['februari'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $iuran['maret'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $iuran['april'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $iuran['mei'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $iuran['juni'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $iuran['juli'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $iuran['agustus'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $iuran['september'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $iuran['oktober'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $iuran['november'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $iuran['desember'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $iuran['total'], 0, ',', '.') ?></td>
                                    <td><?= esc($iuran['keterangan']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Total Iuran Sampai Bulan Ini -->
                <div class="mt-4">
                    <h4>Total Iuran yang Harus Dibayar Sampai Bulan Ini:</h4>
                    <p class="font-weight-bold">Rp <?= number_format($totalIuran, 0, ',', '.') ?></p>
                </div>

                <!-- Tampilkan detail per iuran -->
                <!-- Tampilkan detail per iuran -->
                <div class="mt-4">
                    <h4>Rincian Total Per Iuran:</h4>
                    <ul>
                        <?php foreach ($iuranDetails as $detail): ?>
                            <li><?= esc($detail['nama_iuran']) ?>: Rp <?= number_format($detail['total_belum_dibayar'], 0, ',', '.') ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
