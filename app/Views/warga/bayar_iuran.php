<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Tagihan Iuran Wajib</h3>
    <form id="form-pembayaran" action="<?= base_url('warga/pilih_metode_pembayaran') ?>" method="post">
        <?= csrf_field() ?>
        
        <!-- Input hidden untuk menyimpan total nominal pembayaran -->
        <input type="hidden" name="total_nominal" id="total_nominal" value="0">

        <div class="list-group">
            <?php if (!empty($iuranList)): ?>
                <?php foreach ($iuranList as $iuran): ?>
                    <div class="list-group-item">
                        <h5><?= esc($iuran['nama_iuran']) ?> (Tahun <?= esc($iuran['tahun']) ?>)</h5>
                        <?php if (!empty($bulanBelumDibayar[$iuran['id_iuran']])): ?>
                            <?php foreach ($bulanBelumDibayar[$iuran['id_iuran']] as $bulanData): ?>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input iuran-checkbox" 
                                        data-nominal="<?= esc($bulanData['nominal_khusus'] ?? $bulanData['nominal']) ?>" 
                                        name="iuran[<?= esc($iuran['id_iuran']) ?>][<?= strtolower(esc($bulanData['nama_bulan'])) ?>]" 
                                        value="<?= esc($bulanData['nama_bulan']) ?>" 
                                        id="bulan-<?= esc($iuran['id_iuran']) ?>-<?= esc($bulanData['nama_bulan']) ?>">
                                    <label class="custom-control-label" 
                                        for="bulan-<?= esc($iuran['id_iuran']) ?>-<?= esc($bulanData['nama_bulan']) ?>">
                                        <?= esc($bulanData['nama_bulan']) ?> - Rp. <?= number_format($bulanData['nominal_khusus'] ?? $bulanData['nominal'], 0, ',', '.') ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Semua bulan sudah dibayar untuk iuran ini.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Tidak ada iuran yang belum dibayar.</p>
            <?php endif; ?>

        </div>




        <div class="mt-4">
            <h4>Total Tagihan: <span id="total-tagihan">Rp. 0</span></h4>
            <button type="submit" class="btn btn-success mt-3">Lanjutkan Pembayaran</button>
        </div>
    </form>
</div>

<script>
// Script to calculate the total amount
document.querySelectorAll('.iuran-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        let total = 0;
        document.querySelectorAll('.iuran-checkbox:checked').forEach(checked => {
            total += parseFloat(checked.getAttribute('data-nominal'));
        });
        document.getElementById('total-tagihan').innerText = 'Rp. ' + new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('total_nominal').value = total; // Set total to hidden input
    });
});
</script>

<?= $this->endSection() ?>
