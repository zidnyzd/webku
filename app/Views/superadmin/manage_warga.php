<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- Tabel warga dengan DataTables -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="wargaTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID User</th>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>No KK</th>
                                <th>Role</th>
                                <!-- <th>Aksi</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($warga as $item): ?>
                                <tr>
                                    <td><?= esc($item['id_user']) ?></td>
                                    <td><?= esc($item['nama_lengkap']) ?></td>
                                    <td><?= esc($item['nik']) ?></td>
                                    <td><?= esc($item['no_kk']) ?></td>
                                    <td>
                                        <!-- Dropdown untuk Role -->
                                        <form action="<?= base_url('/superadmin/update-warga/' . $item['id_user']) ?>" method="post">
                                            <select name="role" class="form-control">
                                                <option value="ketua" <?= $item['role'] == 'ketua' ? 'selected' : '' ?>>Ketua RT</option>
                                                <option value="wakil" <?= $item['role'] == 'wakil' ? 'selected' : '' ?>>Wakil RT</option>
                                                <option value="sekretaris" <?= $item['role'] == 'sekretaris' ? 'selected' : '' ?>>Sekretaris</option>
                                                <option value="bendahara" <?= $item['role'] == 'bendahara' ? 'selected' : '' ?>>Bendahara</option>
                                                <option value="pengurus" <?= $item['role'] == 'pengurus' ? 'selected' : '' ?>>Pengurus</option>
                                                <option value="warga" <?= $item['role'] == 'warga' ? 'selected' : '' ?>>Warga</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm mt-2">Update Role</button>
                                        </form>
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

<script>
    $(document).ready(function() {
        // Inisialisasi DataTables dengan AdminLTE
        $('#wargaTable').DataTable({
            "responsive": true, // Agar responsif di mobile
            "autoWidth": false,  // Menonaktifkan lebar otomatis
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>
