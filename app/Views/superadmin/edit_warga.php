<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Role Warga</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ubah Role Warga</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('/superadmin/update-warga/' . $warga['id_user']) ?>" method="post">
                                <?= csrf_field() ?>

                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= esc($warga['nama_lengkap']) ?>" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="ketua" <?= $warga['role'] == 'ketua' ? 'selected' : '' ?>>Ketua RT</option>
                                        <option value="wakil" <?= $warga['role'] == 'wakil' ? 'selected' : '' ?>>Wakil RT</option>
                                        <option value="sekretaris" <?= $warga['role'] == 'sekretaris' ? 'selected' : '' ?>>Sekretaris</option>
                                        <option value="bendahara" <?= $warga['role'] == 'bendahara' ? 'selected' : '' ?>>Bendahara</option>
                                        <option value="pengurus" <?= $warga['role'] == 'pengurus' ? 'selected' : '' ?>>Pengurus</option>
                                        <option value="warga" <?= $warga['role'] == 'warga' ? 'selected' : '' ?>>Warga</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Role</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>
