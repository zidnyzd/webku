<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bukti Pembayaran Saya</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Nama Iuran & Bulan</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Metode Pembayaran</th>
                                <th>Nomor Referensi</th>
                                <th>Bukti Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pembayaranList)): ?>
                                <?php foreach ($pembayaranList as $pembayaran): ?>
                                    <tr>
                                        <td><?= 'INV#' . esc($pembayaran['id_pembayaran']) ?></td>
                                        <td><?= esc($pembayaran['tanggal_pembayaran']) ?></td>
                                        <td>
                                            <?php 
                                                $iuranDetail = json_decode($pembayaran['nama_iuran'], true);
                                                foreach ($iuranDetail as $namaIuran => $bulanArray): 
                                            ?>
                                                <strong><?= esc($namaIuran) ?></strong><br>
                                                Bulan yang Dibayar:
                                                <ul style="padding-left: 20px; margin: 5px 0;">
                                                    <?php foreach ($bulanArray as $bulan): ?>
                                                        <li><?= esc($bulan) ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>Rp. <?= number_format($pembayaran['nominal'], 0, ',', '.') ?></td>
                                        <td><?= esc($pembayaran['status']) ?></td>
                                        <td><?= esc($pembayaran['metode_pembayaran']) ?></td>
                                        <td><?= esc($pembayaran['nomor_referensi']) ?: '-' ?></td>
                                        <td>
                                            <?php if (!empty($pembayaran['bukti_file'])): ?>
                                                <a href="<?= base_url('uploads/bukti_pembayaran/' . esc($pembayaran['bukti_file'])) ?>" target="_blank">
                                                    <img src="<?= base_url('uploads/bukti_pembayaran/' . esc($pembayaran['bukti_file'])) ?>" alt="Bukti Pembayaran" style="width: 100px; height: auto;">
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Belum ada bukti</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data pembayaran.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
