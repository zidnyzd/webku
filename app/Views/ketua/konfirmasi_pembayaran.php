<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <!-- Header Konfirmasi Pembayaran -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Konfirmasi Pembayaran</h3>
            </div>
            <div class="card-body">
                <!-- Kolom Pencarian Otomatis -->
                <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="Cari berdasarkan ID Pembayaran, Nama Warga, atau Nama Iuran">
                </div>

                <!-- Tabel Konfirmasi Pembayaran -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="konfirmasiTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Iuran</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Bukti</th>
                                <th>Aksi</th>
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
                                            <a href="<?= base_url('bendahara/konfirmasi_pembayaran/konfirmasi/' . $pembayaran['id_pembayaran']) ?>" class="btn btn-success">Konfirmasi</a>
                                            <a href="<?= base_url('bendahara/konfirmasi_pembayaran/tolak/' . $pembayaran['id_pembayaran']) ?>" class="btn btn-danger">Tolak</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada pembayaran yang menunggu konfirmasi.</td>
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
        let rows = document.querySelectorAll('#konfirmasiTable tbody tr');
        
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