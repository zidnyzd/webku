<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">RT Finance</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Sidebar untuk Superadmin -->
                <?php if (session()->get('role') == 'Superadmin'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/superadmin/dashboard') ?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard Superadmin</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/superadmin/manage-warga') ?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Kelola Warga</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Sidebar untuk Ketua RT -->
                <?php if (session()->get('role') == 'ketua'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/ketua/dashboard') ?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/ketua/warga') ?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Kelola Data Warga</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/ketua/manage_nominal_khusus') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>Atur Nominal Khusus</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/ketua/konfirmasi_pembayaran') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Cek Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/ketua/riwayat_konfirmasi') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Riwayat Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/ketua/iuran/create') ?>" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-plus"></i>
                            <p>Buat Iuran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/ketua/iuran/') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Iuran Pribadi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/ketua/iuran/list') ?>" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>List Iuran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/ketua/profile') ?>" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Sidebar untuk Wakil Ketua -->
                <?php if (session()->get('role') == 'wakil'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/wakil/dashboard') ?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/wakil/warga') ?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Lihat Data Warga</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/wakil/manage_nominal_khusus') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>Lihat Nominal Khusus</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/wakil/konfirmasi_pembayaran') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Lihat Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/wakil/riwayat_konfirmasi') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Riwayat Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/wakil/iuran/') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Iuran Pribadi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/wakil/iuran/list') ?>" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>List Iuran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/wakil/profile') ?>" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Sidebar untuk Bendahara -->
                <?php if (session()->get('role') == 'bendahara'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/bendahara/dashboard') ?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/bendahara/catat_iuran_warga') ?>" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-users"></i>
                            <p>Catat Iuran Warga</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/bendahara/rekening') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>Atur Rekening</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/bendahara/manage_nominal_khusus') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>Atur Nominal Khusus</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/bendahara/konfirmasi_pembayaran') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Cek Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/bendahara/riwayat_konfirmasi') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Riwayat Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/bendahara/iuran/create') ?>" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-plus"></i>
                            <p>Buat Iuran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/bendahara/iuran/') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Iuran Pribadi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/bendahara/iuran/list') ?>" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>List Iuran</p>
                        </a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/bendahara/profile') ?>" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Sidebar untuk Sekretaris -->
                <?php if (session()->get('role') == 'sekretaris'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/sekretaris/dashboard') ?>" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard Sekretaris</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/sekretaris/warga') ?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Kelola Data Warga</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/sekretaris/iuran') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Iuran Pribadi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/sekretaris/iuran/list') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Daftar Iuran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/sekretaris/bayar_iuran') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Bayar Iuran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/sekretaris/bukti_pembayaran') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Riwayat Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/sekretaris/profile') ?>" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Sidebar untuk Pengurus -->
                <?php if (session()->get('role') == 'pengurus'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/pengurus/dashboard') ?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/pengurus/warga') ?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Lihat Data Warga</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/pengurus/manage_nominal_khusus') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>Lihat Nominal Khusus</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/pengurus/konfirmasi_pembayaran') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Lihat Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/pengurus/riwayat_konfirmasi') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Riwayat Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/pengurus/iuran/') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Iuran Pribadi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/pengurus/iuran/list') ?>" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>List Iuran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/pengurus/profile') ?>" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Sidebar untuk Warga -->
                <?php if (session()->get('role') == 'warga'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/warga/dashboard') ?>" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard Warga</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/warga/profile') ?>" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/warga/iuran') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Iuran Pribadi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/warga/list') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Daftar Iuran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/warga/bayar_iuran') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Bayar Iuran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/warga/bukti_pembayaran') ?>" class="nav-link">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Riwayat Pembayaran</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Menu Logout untuk Semua -->
                <li class="nav-item">
                    <a href="<?= base_url('/logout') ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
