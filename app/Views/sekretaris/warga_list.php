<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">

        <!-- Pesan Flashdata -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Daftar Warga -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Warga</h3>
                <div class="float-right">
                    <a href="<?= base_url('sekretaris/warga/create') ?>" class="btn btn-primary">Tambah Warga Baru</a>
                </div>
            </div>
            <div class="card-body">

                <!-- Input Search -->
                <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="Cari berdasarkan NIK, Nama, atau No KK...">
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>No KK</th>
                                <th>Alamat</th>
                                <th>Blok/No</th>
                                <th>Dawis</th>
                                <th>No Telpon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="warga-list">
                            <?php if (!empty($wargaList)): ?>
                                <?php foreach ($wargaList as $warga): ?>
                                    <tr>
                                        <td><?= esc($warga['nama_lengkap']) ?></td>
                                        <td><?= esc($warga['nik']) ?></td>
                                        <td><?= esc($warga['no_kk']) ?></td>
                                        <td><?= esc($warga['alamat']) ?></td>
                                        <td><?= esc($warga['blok_no']) ?></td>
                                        <td><?= esc($warga['dawis']) ?></td>
                                        <td><?= esc($warga['no_telpon']) ?></td>
                                        <td>
                                            <a href="<?= base_url('sekretaris/warga/edit/' . $warga['id_user']) ?>" class="btn btn-info">Edit</a>
                                            <form action="<?= base_url('sekretaris/warga/delete/' . $warga['id_user']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus warga ini?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data warga.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- JavaScript for Live Search -->
<script>
    document.getElementById('search').addEventListener('input', function() {
        const keyword = this.value;
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `<?= base_url('sekretaris/warga') ?>?keyword=${keyword}`, true);
        xhr.onload = function() {
            if (this.status === 200) {
                const response = this.responseText;
                const parser = new DOMParser();
                const doc = parser.parseFromString(response, 'text/html');
                const newRows = doc.querySelector('#warga-list').innerHTML;
                document.querySelector('#warga-list').innerHTML = newRows;
            }
        }
        xhr.send();
    });
</script>
<?= $this->endSection() ?>
