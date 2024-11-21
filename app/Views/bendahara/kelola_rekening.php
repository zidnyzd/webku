<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kelola Rekening Bank</h3>
                        <div class="float-right">
                            <a href="<?= base_url('bendahara/rekening/create') ?>" class="btn btn-primary">Tambah Rekening Baru</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($rekeningList)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Bank</th>
                                            <th>Nomor Rekening</th>
                                            <th>Atas Nama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rekeningList as $rekening): ?>
                                            <tr>
                                                <td><?= esc($rekening['bank']) ?></td>
                                                <td><?= esc($rekening['nomor_rekening']) ?></td>
                                                <td><?= esc($rekening['atas_nama']) ?></td>
                                                <td>
                                                    <a href="<?= base_url('bendahara/rekening/edit/' . $rekening['id_rekening']) ?>" class="btn btn-info">Edit</a>
                                                    <form action="<?= base_url('bendahara/rekening/delete/' . $rekening['id_rekening']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus rekening ini?');">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Belum ada rekening yang ditambahkan.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
