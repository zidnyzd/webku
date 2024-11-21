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
                    <div class="card-header">
                        <h3 class="card-title">Update Profile</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('/warga/profile/update') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Nama Lengkap -->
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= esc($warga['nama_lengkap']) ?>" required>
                            </div>

                            <!-- NIK -->
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="<?= esc($warga['nik']) ?>" readonly>
                            </div>

                            <!-- Nomor KK -->
                            <div class="form-group">
                                <label for="no_kk">Nomor KK</label>
                                <input type="text" class="form-control" id="no_kk" name="no_kk" value="<?= esc($warga['no_kk']) ?>" required>
                            </div>

                            <!-- Alamat -->
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" required><?= esc($warga['alamat']) ?></textarea>
                            </div>

                            <!-- Blok/No -->
                            <div class="form-group">
                                <label for="blok_no">Blok/No</label>
                                <input type="text" class="form-control" id="blok_no" name="blok_no" value="<?= esc($warga['blok_no']) ?>">
                            </div>

                            <!-- Dawis -->
                            <div class="form-group">
                                <label for="dawis">Dawis</label>
                                <input type="text" class="form-control" id="dawis" name="dawis" value="<?= esc($warga['dawis']) ?>">
                            </div>

                            <!-- No Telpon -->
                            <div class="form-group">
                                <label for="no_telpon">No Telpon</label>
                                <input type="text" class="form-control" id="no_telpon" name="no_telpon" value="<?= esc($warga['no_telpon']) ?>" required>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="Laki-Laki" <?= $warga['jenis_kelamin'] == 'Laki-Laki' ? 'selected' : '' ?>>Laki-Laki</option>
                                    <option value="Perempuan" <?= $warga['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= esc($warga['tempat_lahir']) ?>" required>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= esc($warga['tanggal_lahir']) ?>" required>
                            </div>

                            <!-- Status Pernikahan -->
                            <div class="form-group">
                                <label for="status_pernikahan">Status Pernikahan</label>
                                <select class="form-control" id="status_pernikahan" name="status_pernikahan">
                                    <option value="Belum Menikah" <?= $warga['status_pernikahan'] == 'Belum Menikah' ? 'selected' : '' ?>>Belum Menikah</option>
                                    <option value="Menikah" <?= $warga['status_pernikahan'] == 'Menikah' ? 'selected' : '' ?>>Menikah</option>
                                    <option value="Cerai" <?= $warga['status_pernikahan'] == 'Cerai' ? 'selected' : '' ?>>Cerai</option>
                                </select>
                            </div>

                            <!-- Agama -->
                            <div class="form-group">
                                <label for="agama">Agama</label>
                                <select class="form-control" id="agama" name="agama">
                                    <option value="Islam" <?= $warga['agama'] == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                    <option value="Kristen" <?= $warga['agama'] == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                                    <option value="Katolik" <?= $warga['agama'] == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                                    <option value="Hindu" <?= $warga['agama'] == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                    <option value="Budha" <?= $warga['agama'] == 'Budha' ? 'selected' : '' ?>>Budha</option>
                                    <option value="Konghucu" <?= $warga['agama'] == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                                </select>
                            </div>

                            <!-- Status Anggota Keluarga -->
                            <div class="form-group">
                                <label for="status_anggota_keluarga">Status Anggota Keluarga</label>
                                <select class="form-control" id="status_anggota_keluarga" name="status_anggota_keluarga">
                                    <option value="Kepala Keluarga" <?= $warga['status_anggota_keluarga'] == 'Kepala Keluarga' ? 'selected' : '' ?>>Kepala Keluarga</option>
                                    <option value="Istri" <?= $warga['status_anggota_keluarga'] == 'Istri' ? 'selected' : '' ?>>Istri</option>
                                    <option value="Anak" <?= $warga['status_anggota_keluarga'] == 'Anak' ? 'selected' : '' ?>>Anak</option>
                                    <option value="Lainnya" <?= $warga['status_anggota_keluarga'] == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>

                            <!-- Kewarganegaraan -->
                            <div class="form-group">
                                <label for="kewarganegaraan">Kewarganegaraan</label>
                                <select class="form-control" id="kewarganegaraan" name="kewarganegaraan" required>
                                    <option value="WNI" <?= $warga['kewarganegaraan'] == 'WNI' ? 'selected' : '' ?>>WNI</option>
                                    <option value="WNA" <?= $warga['kewarganegaraan'] == 'WNA' ? 'selected' : '' ?>>WNA</option>
                                </select>
                            </div>

                            <!-- Pekerjaan -->
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?= esc($warga['pekerjaan']) ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
