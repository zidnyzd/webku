<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">

        <!-- Notifikasi -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Card Informasi Warga -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Catat Iuran Warga</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th>Nama Warga</th><td><?= esc($warga['nama_lengkap']) ?></td></tr>
                    <tr><th>NIK</th><td><?= esc($warga['nik']) ?></td></tr>
                    <tr><th>Alamat</th><td><?= esc($warga['alamat']) ?></td></tr>
                    <tr><th>Blok/No</th><td><?= esc($warga['blok_no']) ?></td></tr>
                </table>
            </div>
        </div>

        <!-- Form Pencatatan Iuran -->
        <div class="card mt-4">
            <div class="card-header"><h3 class="card-title">Form Pencatatan Iuran</h3></div>
            <div class="card-body">
                <form action="<?= base_url('bendahara/catat_iuran/save') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_user" value="<?= esc($warga['id_user']) ?>">

                    <!-- Pilih Iuran -->
                    <div class="form-group">
                        <label for="id_iuran">Pilih Iuran</label>
                        <select class="form-control" id="id_iuran" name="id_iuran" required>
                            <option value="">Pilih Iuran</option>
                            <?php foreach ($iuranList as $iuran): ?>
                                <option value="<?= esc($iuran['id_iuran']) ?>" 
                                        data-nominal="<?= $iuran['nominal_khusus'] ?? $iuran['iuran_bulanan'] ?>" 
                                        data-bulan='<?= json_encode($iuran['bulan_belum_dibayar']) ?>'>
                                    <?= esc($iuran['nama_iuran']) ?> (Rp. <?= number_format($iuran['nominal_khusus'] ?? $iuran['iuran_bulanan'], 0, ',', '.') ?> per bulan)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Pilih Bulan -->
                    <div class="form-group">
                        <label for="bulan">Pilih Bulan</label>
                        <select class="form-control" id="bulan" name="bulan" required>
                            <option value="">Pilih Bulan</option>
                        </select>
                    </div>

                    <!-- Jumlah Iuran dengan Format Rupiah -->
                    <div class="form-group">
                        <label for="jumlah">Jumlah Iuran</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="jumlah" id="jumlah" class="form-control nominal-input" placeholder="Masukkan Nominal" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Catat Iuran</button>
                </form>
            </div>
        </div>
    </div>

        <!-- Daftar Iuran Pribadi dengan Modal Edit -->
        <div class="card mt-4">
            <div class="card-header"><h3 class="card-title">Daftar Iuran Pribadi</h3></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Aksi</th><th>Nama Iuran</th><th>Tahun</th>
                                <?php foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan): ?>
                                    <th><?= $bulan ?></th>
                                <?php endforeach; ?>
                                <th>Total</th><th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($iuranPribadi as $iuran): ?>
                                <tr>
                                    <td><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal-<?= $iuran['id_iuran_warga'] ?>">Edit</button></td>
                                    <td><?= esc($iuran['nama_iuran']) ?></td>
                                    <td><?= esc($iuran['tahun']) ?></td>
                                    <?php foreach (['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'] as $bulan): ?>
                                        <td>Rp. <?= number_format($iuran[$bulan], 0, ',', '.') ?></td>
                                    <?php endforeach; ?>
                                    <td>Rp. <?= number_format($iuran['total'], 0, ',', '.') ?></td>
                                    <td><?= esc($iuran['keterangan']) ?></td>
                                </tr>

                                <!-- Modal for Editing Monthly Iuran Amounts -->
                                <div class="modal fade" id="editModal-<?= $iuran['id_iuran_warga'] ?>" tabindex="-1" aria-labelledby="editModalLabel-<?= $iuran['id_iuran_warga'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel-<?= $iuran['id_iuran_warga'] ?>">Edit Iuran Bulanan - <?= esc($iuran['nama_iuran']) ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?= base_url('bendahara/update_iuran/' . $iuran['id_iuran_warga']) ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="id_user" value="<?= esc($warga['id_user']) ?>">

                                                    <?php foreach (['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'] as $month): ?>
                                                        <div class="form-group">
                                                            <label for="<?= $month ?>"><?= ucfirst($month) ?></label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Rp</span>
                                                                <input type="text" name="<?= $month ?>" id="<?= $month ?>" class="form-control nominal-input" value="<?= number_format($iuran[$month], 0, ',', '.') ?>" required>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Fungsi untuk menambahkan titik sebagai pemisah ribuan
    function formatRupiah(value) {
        if (!value) return '';
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Fungsi untuk membersihkan angka dari format rupiah
    function clearRupiah(value) {
        return value.replace(/\./g, ''); // Hapus semua titik
    }

    // Event listener untuk mengubah bulan dan nominal sesuai iuran yang dipilih
    document.getElementById('id_iuran').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        let nominal = selectedOption.getAttribute('data-nominal'); // Ambil nominal dari atribut data
        const bulanBelumDibayar = JSON.parse(selectedOption.getAttribute('data-bulan')); // Ambil daftar bulan

        // Pastikan nominal valid, hilangkan dua nol terakhir
        if (nominal) {
            nominal = parseInt(clearRupiah(nominal), 10) / 100; // Pastikan nominal asli dibagi 100
        }

        // Update nominal otomatis di input
        const jumlahInput = document.getElementById('jumlah');
        jumlahInput.value = formatRupiah(nominal); // Tampilkan nominal dalam format rupiah

        // Update daftar bulan yang belum dibayar
        const bulanSelect = document.getElementById('bulan');
        bulanSelect.innerHTML = '<option value="">Pilih Bulan</option>'; // Reset options
        bulanBelumDibayar.forEach(bulan => {
            const option = document.createElement('option');
            option.value = bulan.toLowerCase(); // Format value agar sesuai dengan backend
            option.textContent = bulan.charAt(0).toUpperCase() + bulan.slice(1); // Kapitalisasi nama bulan
            bulanSelect.appendChild(option);
        });
    });

    // Terapkan pada semua input yang memerlukan format rupiah
    document.querySelectorAll('.nominal-input').forEach(function (input) {
        // Format angka saat mengetik
        input.addEventListener('input', function () {
            const rawValue = clearRupiah(this.value); // Hapus titik jika ada
            this.value = formatRupiah(rawValue); // Format kembali dengan titik
        });

        // Hilangkan format sebelum pengiriman form
        input.closest('form').addEventListener('submit', function () {
            input.value = clearRupiah(input.value); // Ubah ke format angka biasa sebelum submit
        });
    });
});



</script>


<?= $this->endSection() ?>
