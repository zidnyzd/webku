<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<?php if (!empty($success)): ?>
    <div class="alert alert-success">
        <?= esc($success) ?>
    </div>
<?php endif; ?>

<?php if (!empty($info)): ?>
    <div class="alert alert-info">
        <?= esc($info) ?>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <?= esc($error) ?>
    </div>
<?php endif; ?>


    
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
                                <th>ID Transaksi</th>
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
                                        <td><?= esc($pembayaran['id_transaksi']) ?></td>
                                        <td><?= esc($pembayaran['tanggal_pembayaran']) ?></td>
                                        <td>
                                            <ul style="list-style-type: none; padding: 0;">
                                                <?php
                                                // Proses nama_iuran dan bulan dari string hasil GROUP_CONCAT
                                                $iuranDetail = explode(", ", $pembayaran['nama_iuran']);
                                                $groupedIuran = [];

                                                foreach ($iuranDetail as $iuran) {
                                                    [$namaIuran, $bulan] = explode(":", $iuran);
                                                    $groupedIuran[$namaIuran][] = $bulan;
                                                }

                                                foreach ($groupedIuran as $namaIuran => $bulanArray): ?>
                                                    <li><strong><?= esc($namaIuran) ?> :</strong></li>
                                                    <ul style="margin: 5px 0; padding-left: 15px;">
                                                        <?php foreach ($bulanArray as $bulan): ?>
                                                            <li><?= esc($bulan) ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td>Rp. <?= number_format($pembayaran['total_nominal'], 0, ',', '.') ?></td>
                                        <td><?= esc($pembayaran['status']) ?></td>
                                        <td><?= esc($pembayaran['metode_pembayaran']) ?></td>
                                        <td>
                                            <?php if (!empty($pembayaran['nomor_referensi'])): ?>
                                                <?= esc($pembayaran['nomor_referensi']) ?>
                                            <?php elseif (!empty($pembayaran['snap_token']) && $pembayaran['status'] === 'Pending'): ?>
                                                <a href="https://app.sandbox.midtrans.com/snap/v2/vtweb/<?= esc($pembayaran['snap_token']) ?>" target="_blank">
                                                    Link Pembayaran
                                                </a>
                                            <?php else: ?>
                                                <?= esc($pembayaran['snap_token']) ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($pembayaran['bukti_file'])): ?>
                                                <a href="<?= base_url('uploads/bukti_pembayaran/' . esc($pembayaran['bukti_file'])) ?>" target="_blank">
                                                    <img src="<?= base_url('uploads/bukti_pembayaran/' . esc($pembayaran['bukti_file'])) ?>" alt="Bukti Pembayaran" style="width: 100px; height: auto;">
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Tidak ada bukti</span>
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
