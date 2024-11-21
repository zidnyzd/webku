<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">

        <!-- Form Tambah Warga -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Warga Baru</h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('sekretaris/warga/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required placeholder="Masukkan Nama Lengkap" >
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" minlength="16" maxlength="16" required placeholder="Masukkan NIK">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan Password">
                    </div>
                    <div class="form-group">
                        <label for="no_kk">Nomor KK</label>
                        <input type="text" class="form-control" id="no_kk" name="no_kk" minlength="16" maxlength="16" required placeholder="Masukkan No KK">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required placeholder="Masukkan Alamat"> </textarea>
                    </div>
                    <div class="form-group">
                        <label for="blok_no">Blok/No</label>
                        <input type="text" class="form-control" id="blok_no" name="blok_no" placeholder="Masukkan NIK">
                    </div>
                    <div class="form-group">
                        <label for="dawis">Dawis</label>
                        <input type="text" class="form-control" id="dawis" name="dawis" placeholder="Masukkan Dawis">
                    </div>
                    <div class="form-group">
                        <label for="no_telpon">Nomor Telepon</label>
                        <input type="text" class="form-control" id="no_telpon" name="no_telpon" placeholder="Masukkan Nomor Telepon">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required placeholder="Masukkan Tempat Kota Lahir">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                    <div class="form-group">
                        <label for="status_pernikahan">Status Pernikahan</label>
                        <select class="form-control" id="status_pernikahan" name="status_pernikahan" required>
                            <option value="Belum Menikah">Belum Menikah</option>
                            <option value="Menikah">Menikah</option>
                            <option value="Cerai">Cerai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <select class="form-control" id="agama" name="agama" required>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_anggota_keluarga">Status Anggota Keluarga</label>
                        <select class="form-control" id="status_anggota_keluarga" name="status_anggota_keluarga" required>
                            <option value="Kepala Keluarga">Kepala Keluarga</option>
                            <option value="Istri">Istri</option>
                            <option value="Anak">Anak</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kewarganegaraan">Kewarganegaraan</label>
                        <select class="form-control" id="kewarganegaraan" name="kewarganegaraan" required>
                            <option value="WNI">WNI</option>
                            <option value="WNA">WNA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" required placeholder="Masukkan Pekerjaan">
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary">Tambah Warga</button>
                </form>
            </div>
        </div>

    </div>
</section>
<?= $this->endSection() ?>
