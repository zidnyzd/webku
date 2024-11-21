<?= $this->extend('layouts/admin_template') ?> 

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <!-- Header Riwayat Konfirmasi Pembayaran -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Konfirmasi Pembayaran</h3>
            </div>
            <div class="card-body">
                <!-- Kolom Pencarian Otomatis -->
                <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="Cari berdasarkan ID Transaksi atau Nama Warga" value="<?= esc($search ?? '') ?>">
                </div>

                <!-- Tabel Riwayat Konfirmasi -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="riwayatTable">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Tanggal</th>
                                <th>Nama Warga</th>
                                <th>Iuran & Bulan</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Bukti Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pembayaranList)): ?>
                                <?php foreach ($pembayaranList as $pembayaran): ?>
                                    <tr>
                                        <td><?= esc($pembayaran['id_transaksi']) ?></td>
                                        <td><?= esc($pembayaran['tanggal_pembayaran']) ?></td>
                                        <td><?= esc($pembayaran['nama_warga']) ?></td>
                                        <td>
                                            <ul style="list-style-type: none; padding: 0;">
                                                <?php
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
                                        <td>
                                            <?php if (!empty($pembayaran['bukti_file'])): ?>
                                                <a href="<?= base_url('uploads/bukti_pembayaran/' . esc($pembayaran['bukti_file'])) ?>" target="_blank">
                                                    <img src="<?= base_url('uploads/bukti_pembayaran/' . esc($pembayaran['bukti_file'])) ?>" alt="Bukti Pembayaran" style="width: 100px; height: auto;">
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Belum ada bukti</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($pembayaran['status'] === 'Dikonfirmasi'): ?>
                                                <a href="<?= base_url('bendahara/konfirmasi_pembayaran/tolak/' . $pembayaran['id_transaksi']) ?>" class="btn btn-warning">Batalkan Konfirmasi</a>
                                            <?php elseif ($pembayaran['status'] === 'Ditolak'): ?>
                                                <a href="<?= base_url('bendahara/konfirmasi_pembayaran/konfirmasi/' . $pembayaran['id_transaksi']) ?>" class="btn btn-success">Konfirmasi Ulang</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada riwayat konfirmasi pembayaran.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript untuk Pencarian Otomatis -->
<script>
    document.getElementById('search').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#riwayatTable tbody tr');
        
        rows.forEach(row => {
            let idTransaksi = row.cells[0].innerText.toLowerCase();
            let namaWarga = row.cells[2].innerText.toLowerCase();

            if (idTransaksi.includes(filter) || namaWarga.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<?= $this->endSection() ?>
