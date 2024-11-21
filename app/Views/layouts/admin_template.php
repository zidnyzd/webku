<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title) ?> | Admin Panel</title>

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('AdminLTE-3.2.0/dist/css/adminlte.min.css') ?>">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
</head>
<body class="hold-transition sidebar-mini layout-fixed" id="bodyElement">
<div class="wrapper">
  <!-- Navbar -->
  <?= $this->include('partials/navbar') ?>

  <!-- Main Sidebar Container -->
  <?= $this->include('partials/sidebar') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?= esc($title) ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <?php
                $role = session()->get('role');
                if ($role == 'warga') {
                  $dashboardUrl = base_url('/warga/dashboard');
                } elseif ($role == 'bendahara') {
                  $dashboardUrl = base_url('/bendahara/dashboard');
                } elseif ($role == 'pengurus') {
                  $dashboardUrl = base_url('/pengurus/dashboard');
                } elseif ($role == 'sekretaris') {
                  $dashboardUrl = base_url('/sekretaris/dashboard');
                } elseif ($role == 'ketua') {
                  $dashboardUrl = base_url('/ketua/dashboard');
                } elseif ($role == 'wakil') {
                  $dashboardUrl = base_url('/wakil/dashboard');
                }
              ?>
              <li class="breadcrumb-item"><a href="<?= $dashboardUrl ?>">Home</a></li>
              <li class="breadcrumb-item active"><?= esc($title) ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <?= $this->renderSection('content') ?>
    </section>
    <!-- /.content -->
  </div>

  <!-- Footer -->
  <?= $this->include('partials/footer') ?>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap JS -->
<script src="<?= base_url('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- DataTables JS -->
<script src="<?= base_url('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>

<!-- AdminLTE JS -->
<script src="<?= base_url('AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>

<!-- Inisialisasi DataTables -->
<script>
    $(document).ready(function() {
        $('#wargaTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });

    // Toggle dark mode
    $('#darkModeToggle').on('click', function(e) {
        e.preventDefault();
        $('body').toggleClass('dark-mode');
        
        // Simpan preferensi mode dalam localStorage
        if ($('body').hasClass('dark-mode')) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.setItem('darkMode', 'disabled');
        }
    });

    // Memuat preferensi mode dari localStorage
    if (localStorage.getItem('darkMode') === 'enabled') {
        $('body').addClass('dark-mode');
    }
</script>

<!-- Inisialisasi DataTables -->
<script>
    $(document).ready(function() {
        $('#iuranTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "search": "Cari:",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>

</body>
</html>
