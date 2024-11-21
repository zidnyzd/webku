<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <!-- Card for Nominal Khusus Management -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kelola Nominal Tiap Warga</h3>
            </div>
            <div class="card-body">
                <!-- Input Search -->
                <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="Cari berdasarkan NIK, Nama, atau No KK...">
                </div>

                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Nama Iuran</th>
                                <th>Nominal Default (Rp)</th>
                                <th>Nominal Khusus (Rp)</th>

                            </tr>
                        </thead>
                        <tbody id="warga-list">
                            <?php foreach ($wargaList as $warga): ?>
                                <tr>
                                    <td><?= esc($warga['nama_lengkap']) ?></td>
                                    <td>
                                        <select class="form-control iuran-dropdown mb-2" data-id="<?= $warga['id_user'] ?>" style="min-width: 100px;">
                                            <?php foreach ($warga['iuran_list'] as $iuran): ?>
                                                <option value="<?= esc($iuran['id_iuran']) ?>"
                                                        data-default="<?= esc($iuran['nominal_default']) ?>"
                                                        data-khusus="<?= esc($iuran['nominal_khusus'] ?? '') ?>">
                                                    <?= esc($iuran['nama_iuran']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td id="default-nominal-<?= $warga['id_user'] ?>" style="min-width: 80px;">Rp 0</td>
                                    <td>
                                    <form id="form-<?= $warga['id_user'] ?>" action="<?= base_url('/bendahara/update_nominal_khusus/' . $warga['id_user']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="nominal_khusus_raw" id="nominal-khusus-raw-<?= $warga['id_user'] ?>" value="">
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" id="nominal-khusus-<?= $warga['id_user'] ?>" class="form-control nominal-input" placeholder="Masukkan Nominal Khusus" readonly>
                                        </div>
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

<!-- JavaScript for Live Search and Dropdown Interaction -->
<script>
 document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.iuran-dropdown').forEach(function(dropdown) {
        updateNominalValues(dropdown);

        dropdown.addEventListener('change', function() {
            updateNominalValues(this);
        });
    });
    
    function updateNominalValues(dropdown) {
        const selectedOption = dropdown.options[dropdown.selectedIndex];
        const idUser = dropdown.getAttribute('data-id');
        const idIuran = selectedOption.value;
        const defaultNominal = selectedOption.getAttribute('data-default');
        const khususNominal = selectedOption.getAttribute('data-khusus');

        // Update nominal default
        document.getElementById('default-nominal-' + idUser).innerText = 'Rp ' + parseInt(defaultNominal).toLocaleString('id-ID');

        // Update nominal khusus, atau kosongkan jika tidak ada nilai khusus
        const nominalInput = document.getElementById('nominal-khusus-' + idUser);
        const rawInput = document.getElementById('nominal-khusus-raw-' + idUser); // Hidden input for raw value

        if (nominalInput) {
            nominalInput.value = khususNominal ? parseInt(khususNominal).toLocaleString('id-ID') : '';
            rawInput.value = khususNominal ? khususNominal.replace(/\./g, '') : ''; // Set raw value
        }

        // Update action URL of the form to include id_iuran
        const form = document.getElementById('form-' + idUser);
        form.action = `<?= base_url('/bendahara/update_nominal_khusus') ?>/${idUser}/${idIuran}`;
    }

    // Format input nominal khusus
    document.querySelectorAll('.nominal-input').forEach(function(input) {
        input.addEventListener('input', function() {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^\d]/g, '');
            if (this.value) {
                // Format as currency
                this.value = parseInt(this.value, 10).toLocaleString('id-ID');
            }

            // Update hidden input for unformatted value
            const idUser = this.id.split('-')[2]; // Extract idUser from the input ID
            const rawInput = document.getElementById('nominal-khusus-raw-' + idUser);
            if (rawInput) {
                rawInput.value = this.value.replace(/\./g, ''); // Remove thousands separator
            }
        });
    });
});


    document.getElementById('search').addEventListener('input', function() {
        const keyword = this.value.trim();
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `<?= base_url('bendahara/manage_nominal_khusus') ?>?keyword=${encodeURIComponent(keyword)}`, true);
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

<style>
    /* Additional CSS for responsive layout */
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
        }

        .table td, .table th {
            white-space: nowrap;
        }

        /* Adjust font size and padding for mobile view */
        .iuran-dropdown, .nominal-input, .btn-sm {
            font-size: 0.9rem;
        }
    }
</style>

<?= $this->endSection() ?>
