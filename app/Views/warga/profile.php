<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Profil Saya</h3>
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%;">Nama Lengkap</th>
                                        <td><?= esc($warga['nama_lengkap']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <td><?= esc($warga['nik']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nomor KK</th>
                                        <td><?= esc($warga['no_kk']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td><?= esc($warga['alamat']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Blok/No</th>
                                        <td><?= esc($warga['blok_no']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Dawis</th>
                                        <td><?= esc($warga['dawis']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>No Telpon</th>
                                        <td><?= esc($warga['no_telpon']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td><?= esc($warga['jenis_kelamin']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td><?= esc($warga['tempat_lahir']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td><?= esc($warga['tanggal_lahir']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status Pernikahan</th>
                                        <td><?= esc($warga['status_pernikahan']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Agama</th>
                                        <td><?= esc($warga['agama']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status Anggota Keluarga</th>
                                        <td><?= esc($warga['status_anggota_keluarga']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kewarganegaraan</th>
                                        <td><?= esc($warga['kewarganegaraan']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan</th>
                                        <td><?= esc($warga['pekerjaan']) ?></td>
                                    </tr>
                                </tbody>
                                
                            </table>
                            <a href="<?= base_url('/warga/profile/edit') ?>" class="btn btn-primary">Edit Profil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
