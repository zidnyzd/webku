<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>
    <section class="content">
        <div class="container-fluid">
            <p>Selamat datang, <?= esc($username) ?>!</p>
            <!-- Isi dashboard warga di sini -->
        </div>
    </section>
<?= $this->endSection() ?>
