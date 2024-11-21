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
                    <input type="text" id="search" class="form-control" placeholder="Cari berdasarkan ID Pembayaran, Nama Warga, atau Nama Iuran" value="<?= esc($search ?? '') ?>">
                </div>

                <!-- Tabel Riwayat Konfirmasi -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="riwayatTable">
                        <thead>
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>Nama Warga</th>
                                <th>Nama Iuran & Bulan</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Waktu Konfirmasi</th>
                                <th>Bukti Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pembayaranList)): ?>
                                <?php foreach ($pembayaranList as $pembayaran): ?>
                                    <tr>
                                        <td><?= 'INV#' . esc($pembayaran['id_pembayaran']) ?></td>
                                        <td><?= esc($pembayaran['nama_warga']) ?></td>
                                        <td>
                                            <?php 
                                                $iuranDetail = json_decode($pembayaran['nama_iuran'], true);
                                                foreach ($iuranDetail as $namaIuran => $bulanArray) {
                                                    echo "<strong>" . esc($namaIuran) . "</strong><br>";
                                                    echo "Bulan yang Dibayar: " . implode(', ', $bulanArray) . "<br>";
                                                }
                                            ?>
                                        </td>
                                        <td>Rp. <?= number_format($pembayaran['nominal'], 0, ',', '.') ?></td>
                                        <td><?= esc($pembayaran['status']) ?></td>
                                        <td><?= esc($pembayaran['confirmed_at']) ?: '-' ?></td>
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
            let idPembayaran = row.cells[0].innerText.toLowerCase();
            let namaWarga = row.cells[1].innerText.toLowerCase();
            let namaIuran = row.cells[2].innerText.toLowerCase();

            if (idPembayaran.includes(filter) || namaWarga.includes(filter) || namaIuran.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<?= $this->endSection() ?>
