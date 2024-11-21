<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Tombol untuk mengaktifkan dark mode -->
    <li class="nav-item">
      <a class="nav-link" href="#" id="darkModeToggle">
        <i class="fas fa-moon"></i>
      </a>
    </li>
    <!-- Dropdown Profile berdasarkan Role -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i>
        <!-- Tampilkan Nama Lengkap dari session -->
        <span class="d-none d-md-inline"><?= esc(session()->get('nama_lengkap')) ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!-- Superadmin Navbar -->
        <?php if (session()->get('role') == 'Superadmin'): ?>
          <a href="<?= base_url('/superadmin/profile') ?>" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile Superadmin
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('/manage-users') ?>" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> Kelola Pengguna
          </a>
        <?php endif; ?>

        <!-- Pengurus RT Navbar -->
        <?php if (session()->get('role') == 'pengurus'): ?>
          <a href="<?= base_url('/pengurus/profile') ?>" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile Pengurus RT
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('/manage-finances') ?>" class="dropdown-item">
            <i class="fas fa-money-bill mr-2"></i> Kelola Keuangan
          </a>
        <?php endif; ?>

        <!-- Bendahara Navbar -->
        <?php if (session()->get('role') == 'bendahara'): ?>
          <a href="<?= base_url('/bendahara/profile') ?>" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile Bendahara
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('/manage-finances') ?>" class="dropdown-item">
            <i class="fas fa-money-bill mr-2"></i> Kelola Keuangan
          </a>
        <?php endif; ?>

        <!-- Warga Navbar -->
        <?php if (session()->get('role') == 'warga'): ?>
          <a href="<?= base_url('/warga/profile') ?>" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile Warga
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('/warga/keuangan') ?>" class="dropdown-item">
            <i class="fas fa-money-bill mr-2"></i> Status Keuangan
          </a>
        <?php endif; ?>

        <!-- Logout untuk Semua Role -->
        <div class="dropdown-divider"></div>
        <a href="<?= base_url('/logout') ?>" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>
