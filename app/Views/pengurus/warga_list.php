<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">

        <!-- Daftar Warga -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Warga</h3>
                
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
                                
                            </tr>
                        </thead>
                        <tbody id="warga-list">
                            <?php foreach ($wargaList as $warga): ?>
                                <tr>
                                    <td><?= esc($warga['nama_lengkap']) ?></td>
                                    <td><?= esc($warga['nik']) ?></td>
                                    <td><?= esc($warga['no_kk']) ?></td>
                                    <td><?= esc($warga['alamat']) ?></td>
                                    <td><?= esc($warga['blok_no']) ?></td>
                                    <td><?= esc($warga['dawis']) ?></td>
                                    <td><?= esc($warga['no_telpon']) ?></td>
                                    
                                </tr>
                            <?php endforeach; ?>
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
        xhr.open('GET', `<?= base_url('wakil/warga') ?>?keyword=${keyword}`, true);
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
