<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">

        <!-- Detail Iuran -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Iuran</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Iuran</th>
                        <td><?= esc($iuran['nama_iuran']) ?></td>
                    </tr>
                    <tr>
                        <th>Tahun</th>
                        <td><?= esc($iuran['tahun']) ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Iuran Per Bulan (Default)</th>
                        <td>Rp<?= number_format($iuran['iuran_bulanan'], 0, ',', '.') ?></td>
                    </tr>
                    <?php if (!empty($nominal_khusus)): ?>
                    <tr>
                        <th>Jumlah Iuran Per Bulan Khusus Anda</th>
                        <td>Rp<?= number_format($nominal_khusus, 0, ',', '.') ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <!-- Daftar Warga yang Berpartisipasi -->
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Daftar Warga dan Status Pembayaran</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Warga</th>
                                <th>Blok/No</th>
                                <th>Dawis</th>
                                <th>Iuran</th>
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
                            <?php 
                            // Variabel untuk menghitung total per bulan
                            $totalPerBulan = [
                                'januari' => 0, 'februari' => 0, 'maret' => 0, 
                                'april' => 0, 'mei' => 0, 'juni' => 0, 
                                'juli' => 0, 'agustus' => 0, 'september' => 0, 
                                'oktober' => 0, 'november' => 0, 'desember' => 0
                            ];

                            $totalTahun = 0;

                            foreach ($iuranWarga as $warga): 
                                // Hitung total per warga
                                $totalPerWarga = 
                                    $warga['januari'] + $warga['februari'] + $warga['maret'] + 
                                    $warga['april'] + $warga['mei'] + $warga['juni'] + 
                                    $warga['juli'] + $warga['agustus'] + $warga['september'] + 
                                    $warga['oktober'] + $warga['november'] + $warga['desember'];

                                // Tambahkan setiap bulan ke total per bulan
                                foreach ($totalPerBulan as $bulan => $nilai) {
                                    $totalPerBulan[$bulan] += $warga[$bulan];
                                }

                                // Tambahkan total per warga ke total tahunan
                                $totalTahun += $totalPerWarga;
                            ?>
                                <tr>
                                    <td><?= esc($warga['nama_lengkap']) ?></td>
                                    <td><?= esc($warga['blok_no']) ?></td>
                                    <td><?= esc($warga['dawis']) ?></td>
                                    <td>Rp <?= number_format($warga['jumlah_per_bulan'], 0, ',', '.') ?></td> <!-- Jumlah per bulan -->
                                    <td>Rp<?= number_format($warga['januari'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($warga['februari'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($warga['maret'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($warga['april'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($warga['mei'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($warga['juni'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($warga['juli'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($warga['agustus'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($warga['september'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($warga['oktober'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($warga['november'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($warga['desember'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format($totalPerWarga, 0, ',', '.') ?></td> <!-- Total per warga -->
                                    <td><?= esc($warga['keterangan']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <!-- Baris Total per Bulan -->
                            <tr>
                                <th colspan="4">Total</th>
                                <th>Rp <?= number_format($totalPerBulan['januari'], 0, ',', '.') ?></th>
                                <th>Rp <?= number_format($totalPerBulan['februari'], 0, ',', '.') ?></th>
                                <th>Rp <?= number_format($totalPerBulan['maret'], 0, ',', '.') ?></th>
                                <th>Rp <?= number_format($totalPerBulan['april'], 0, ',', '.') ?></th>
                                <th>Rp <?= number_format($totalPerBulan['mei'], 0, ',', '.') ?></th>
                                <th>Rp <?= number_format($totalPerBulan['juni'], 0, ',', '.') ?></th>
                                <th>Rp <?= number_format($totalPerBulan['juli'], 0, ',', '.') ?></th>
                                <th>Rp <?= number_format($totalPerBulan['agustus'], 0, ',', '.') ?></th>
                                <th>Rp <?= number_format($totalPerBulan['september'], 0, ',', '.') ?></th>
                                <th>Rp <?= number_format($totalPerBulan['oktober'], 0, ',', '.') ?></th>
                                <th>Rp <?= number_format($totalPerBulan['november'], 0, ',', '.') ?></th>
                                <th>Rp <?= number_format($totalPerBulan['desember'], 0, ',', '.') ?></th>
                                <th>Rp <?= number_format($totalTahun, 0, ',', '.') ?></th> <!-- Total seluruh iuran -->
                                <th colspan="2"></th> <!-- Kosongkan kolom total dan keterangan di bagian bawah -->
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <a href="<?= base_url('bendahara/iuran/list') ?>" class="btn btn-secondary">Kembali ke Daftar Iuran</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
