<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/selesai', 'Selesai::index');

# SUPERADMIN
$routes->group('superadmin', function($routes) {
    $routes->get('dashboard', 'SuperadminDashboard::index');
    $routes->get('login', 'SuperadminAuth::index');
    $routes->post('login', 'SuperadminAuth::login');
    $routes->get('logout', 'SuperadminAuth::logout');
    $routes->get('manage-warga', 'SuperadminManageWarga::index');
    $routes->get('edit-warga/(:num)', 'SuperadminManageWarga::edit/$1');
    $routes->post('update-warga/(:num)', 'SuperadminManageWarga::update/$1');
    $routes->get('search-warga', 'SuperadminManageWarga::searchWarga');
});

# KETUA RT (Akses Penuh)
$routes->group('ketua', function($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('profile', 'ProfileController::index');
    $routes->post('profile/update', 'ProfileController::update');
    $routes->get('profile/edit', 'ProfileController::edit');     
    $routes->post('profile/update', 'ProfileController::update');
    
    // Daftar dan Kelola Warga
    $routes->get('warga', 'KetuaController::wargaList');
    $routes->get('warga/create', 'KetuaController::create');
    $routes->post('warga/store', 'KetuaController::store');
    $routes->get('warga/edit/(:num)', 'KetuaController::edit/$1');
    $routes->post('warga/update/(:num)', 'KetuaController::update/$1');
    $routes->post('warga/delete/(:num)', 'KetuaController::deleteWarga');
    
    // Kelola Iuran
    $routes->get('iuran', 'IuranController::index');
    $routes->get('iuran/list', 'IuranController::iuranList');
    $routes->get('iuran/detail/(:num)', 'IuranController::iuranDetail/$1');
    $routes->get('iuran/create', 'IuranController::createIuranForm');
    $routes->post('iuran/store', 'IuranController::store');
    $routes->get('iuran/edit/(:num)', 'IuranController::edit/$1');
    $routes->post('iuran/update/(:num)', 'IuranController::update/$1');
    $routes->get('iuran/delete/(:num)', 'IuranController::delete/$1');
    $routes->post('catat_iuran/save', 'BendaharaController::saveIuran');
    $routes->post('update_iuran/(:num)', 'BendaharaController::updateIuran/$1');

    // Kelola Nominal Khusus
    $routes->get('manage_nominal_khusus', 'KetuaController::manageNominalKhusus');
    $routes->post('update_nominal_khusus/(:num)/(:num)', 'KetuaController::updateNominalKhusus/$1/$2');

    // Catat Iuran Warga
    $routes->get('catat_iuran/(:num)', 'KetuaController::catatIuran/$1');
    $routes->post('catat_iuran/save', 'KetuaController::saveIuran');
    
    // Konfirmasi Pembayaran
    $routes->get('konfirmasi_pembayaran', 'KonfirmasiPembayaranController::index');
    $routes->get('konfirmasi_pembayaran/konfirmasi/(:num)', 'KonfirmasiPembayaranController::konfirmasi/$1');
    $routes->get('konfirmasi_pembayaran/tolak/(:num)', 'KonfirmasiPembayaranController::tolak/$1');
    $routes->get('riwayat_konfirmasi', 'KonfirmasiPembayaranController::riwayat');

    // Pembayaran Iuran
    $routes->get('bayar_iuran', 'PembayaranController::bayarIuran');
    $routes->post('pilih_metode_pembayaran', 'PembayaranController::pilihMetodePembayaran');
    $routes->post('proses_pembayaran', 'PembayaranController::prosesPembayaran'); 
});

# WAKIL KETUA
$routes->group('wakil', function($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('profile', 'ProfileController::index');
    $routes->post('profile/update', 'ProfileController::update');
    $routes->get('profile/edit', 'ProfileController::edit');    
    $routes->post('profile/update', 'ProfileController::update');
    
    // VIEW ONLY Warga
    $routes->get('warga', 'WakilController::wargaList');
    // $routes->get('warga/create', 'KetuaController::create');
    // $routes->post('warga/store', 'KetuaController::store');
    $routes->get('warga/edit/(:num)', 'KetuaController::edit/$1');
    // $routes->post('warga/update/(:num)', 'KetuaController::update/$1');
    // $routes->post('warga/delete/(:num)', 'KetuaController::deleteWarga');
    
    // View ONLY Iuran
    $routes->get('iuran', 'IuranController::index');
    $routes->get('iuran/list', 'IuranController::iuranList');
    $routes->get('iuran/detail/(:num)', 'IuranController::iuranDetail/$1');
    // $routes->get('iuran/create', 'IuranController::createIuranForm');
    // $routes->post('iuran/store', 'IuranController::store');
    // $routes->get('iuran/edit/(:num)', 'IuranController::edit/$1');
    // $routes->post('iuran/update/(:num)', 'IuranController::update/$1');
    // $routes->get('iuran/delete/(:num)', 'IuranController::delete/$1');
    // $routes->post('catat_iuran/save', 'BendaharaController::saveIuran');
    // $routes->post('update_iuran/(:num)', 'BendaharaController::updateIuran/$1');

    // Kelola Nominal Khusus
    $routes->get('manage_nominal_khusus', 'WakilController::manageNominalKhusus');
    // $routes->post('update_nominal_khusus/(:num)/(:num)', 'KetuaController::updateNominalKhusus/$1/$2');

    // Catat Iuran Warga
    // $routes->get('catat_iuran/(:num)', 'KetuaController::catatIuran/$1');
    // $routes->post('catat_iuran/save', 'KetuaController::saveIuran');
    
    // Konfirmasi Pembayaran
    $routes->get('konfirmasi_pembayaran', 'KonfirmasiPembayaranController::index');
    // $routes->get('konfirmasi_pembayaran/konfirmasi/(:num)', 'KonfirmasiPembayaranController::konfirmasi/$1');
    // $routes->get('konfirmasi_pembayaran/tolak/(:num)', 'KonfirmasiPembayaranController::tolak/$1');
    $routes->get('riwayat_konfirmasi', 'KonfirmasiPembayaranController::riwayat');

    // Pembayaran Iuran
    $routes->get('bayar_iuran', 'PembayaranController::bayarIuran');
    $routes->post('pilih_metode_pembayaran', 'PembayaranController::pilihMetodePembayaran');
    $routes->post('proses_pembayaran', 'PembayaranController::prosesPembayaran'); 
});

# SEKRETARIS
$routes->group('sekretaris', function($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('profile', 'ProfileController::index');
    $routes->post('profile/update', 'ProfileController::update');
    $routes->get('profile/edit', 'ProfileController::edit');     
    $routes->post('profile/update', 'ProfileController::update');

    // Kelola Data Warga
    $routes->get('warga', 'SekretarisController::wargaList');
    $routes->get('warga/create', 'SekretarisController::create');
    $routes->post('warga/store', 'SekretarisController::store');
    $routes->get('warga/edit/(:num)', 'SekretarisController::edit/$1');
    $routes->post('warga/update/(:num)', 'SekretarisController::update/$1');
    $routes->post('warga/delete/(:num)', 'SekretarisController::deleteWarga/$1');

    // Melihat Iuran, pay and VIEW Only
    $routes->get('iuran', 'IuranController::index');
    $routes->get('iuran/list', 'IuranController::iuranList');
    $routes->get('iuran/detail/(:num)', 'IuranController::iuranDetail/$1');

    // Pembayaran Iuran
    $routes->get('bayar_iuran', 'PembayaranController::bayarIuran');
    $routes->post('pilih_metode_pembayaran', 'PembayaranController::pilihMetodePembayaran');
    $routes->post('proses_pembayaran', 'PembayaranController::prosesPembayaran'); 
    $routes->get('bukti_pembayaran', 'PembayaranController::listPembayaran');
});

# BENDAHARA (Akses untuk Kelola dan Catat Iuran)
$routes->group('bendahara', function($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('profile', 'ProfileController::index');
    $routes->post('profile/update', 'ProfileController::update');
    $routes->get('profile/edit', 'ProfileController::edit');     
    $routes->post('profile/update', 'ProfileController::update');
    
    // Kelola Iuran
    $routes->get('iuran', 'IuranController::index');
    $routes->get('iuran/(:num)', 'IuranController::detailIuranWarga/$1');
    $routes->get('iuran/list', 'IuranController::iuranList');
    $routes->get('iuran/detail/(:num)', 'IuranController::iuranDetail/$1');
    $routes->get('iuran/create', 'IuranController::createIuranForm');
    $routes->post('iuran/store', 'IuranController::store');
    $routes->get('iuran/edit/(:num)', 'IuranController::edit/$1');
    $routes->post('iuran/update/(:num)', 'IuranController::update/$1');
    $routes->get('iuran/delete/(:num)', 'IuranController::delete/$1');
    $routes->get('catat_iuran_warga', 'BendaharaController::wargaList');
    $routes->get('catat_iuran/(:num)', 'BendaharaController::catatIuran/$1');
    $routes->post('catat_iuran/save', 'BendaharaController::saveIuran');
    $routes->post('update_iuran/(:num)', 'BendaharaController::updateIuran/$1');

    // Kelola Rekening
    $routes->get('rekening', 'RekeningController::index');
    $routes->get('rekening/create', 'RekeningController::create');
    $routes->post('rekening/store', 'RekeningController::store');
    $routes->get('rekening/edit/(:num)', 'RekeningController::edit/$1');
    $routes->post('rekening/update/(:num)', 'RekeningController::update/$1');
    $routes->post('rekening/delete/(:num)', 'RekeningController::delete/$1');

    // Kelola Nominal Khusus
    $routes->get('manage_nominal_khusus', 'BendaharaController::manageNominalKhusus');
    $routes->post('update_nominal_khusus/(:num)/(:num)', 'BendaharaController::updateNominalKhusus/$1/$2');

    // Konfirmasi Pembayaran
    $routes->get('konfirmasi_pembayaran', 'KonfirmasiPembayaranController::index');
    $routes->get('konfirmasi_pembayaran/konfirmasi/(:any)', 'KonfirmasiPembayaranController::konfirmasi/$1');
    $routes->get('konfirmasi_pembayaran/tolak/(:any)', 'KonfirmasiPembayaranController::tolak/$1');
    $routes->get('riwayat_konfirmasi', 'KonfirmasiPembayaranController::riwayat');


    // Pembayaran Iuran
    $routes->get('bayar_iuran', 'PembayaranController::bayarIuran');
    $routes->post('pilih_metode_pembayaran', 'PembayaranController::pilihMetodePembayaran');
    $routes->post('proses_pembayaran', 'PembayaranController::prosesPembayaran'); 
});

# PENGURUS (Hak akses melihat warga saja, seperti Wakil)
$routes->group('pengurus', function($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('profile', 'ProfileController::index');
    $routes->post('profile/update', 'ProfileController::update');
    $routes->get('profile/edit', 'ProfileController::edit');    
    $routes->post('profile/update', 'ProfileController::update');
    
    // VIEW ONLY Warga
    $routes->get('warga', 'PengurusController::wargaList');
    // $routes->get('warga/create', 'KetuaController::create');
    // $routes->post('warga/store', 'KetuaController::store');
    $routes->get('warga/edit/(:num)', 'PengurusController::edit/$1');
    // $routes->post('warga/update/(:num)', 'KetuaController::update/$1');
    // $routes->post('warga/delete/(:num)', 'KetuaController::deleteWarga');
    
    // View ONLY Iuran
    $routes->get('iuran', 'IuranController::index');
    $routes->get('iuran/list', 'IuranController::iuranList');
    $routes->get('iuran/detail/(:num)', 'IuranController::iuranDetail/$1');
    // $routes->get('iuran/create', 'IuranController::createIuranForm');
    // $routes->post('iuran/store', 'IuranController::store');
    // $routes->get('iuran/edit/(:num)', 'IuranController::edit/$1');
    // $routes->post('iuran/update/(:num)', 'IuranController::update/$1');
    // $routes->get('iuran/delete/(:num)', 'IuranController::delete/$1');
    // $routes->post('catat_iuran/save', 'BendaharaController::saveIuran');
    // $routes->post('update_iuran/(:num)', 'BendaharaController::updateIuran/$1');

    // Kelola Nominal Khusus
    $routes->get('manage_nominal_khusus', 'PengurusController::manageNominalKhusus');
    // $routes->post('update_nominal_khusus/(:num)/(:num)', 'KetuaController::updateNominalKhusus/$1/$2');

    // Catat Iuran Warga
    // $routes->get('catat_iuran/(:num)', 'KetuaController::catatIuran/$1');
    // $routes->post('catat_iuran/save', 'KetuaController::saveIuran');
    
    // Konfirmasi Pembayaran
    $routes->get('konfirmasi_pembayaran', 'KonfirmasiPembayaranController::index');
    // $routes->get('konfirmasi_pembayaran/konfirmasi/(:num)', 'KonfirmasiPembayaranController::konfirmasi/$1');
    // $routes->get('konfirmasi_pembayaran/tolak/(:num)', 'KonfirmasiPembayaranController::tolak/$1');
    $routes->get('riwayat_konfirmasi', 'KonfirmasiPembayaranController::riwayat');

    // Pembayaran Iuran
    $routes->get('bayar_iuran', 'PembayaranController::bayarIuran');
    $routes->post('pilih_metode_pembayaran', 'PembayaranController::pilihMetodePembayaran');
    $routes->post('proses_pembayaran', 'PembayaranController::prosesPembayaran'); 
});


# WARGA
$routes->group('warga', function ($routes) {
    $routes->get('login', 'WargaAuth::index');
    $routes->post('login', 'WargaAuth::login');

    // Dashboard dan Profile Update
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('profile', 'ProfileController::index');
    $routes->post('profile/update', 'ProfileController::update');
    $routes->get('profile/edit', 'ProfileController::edit');     
    $routes->post('profile/update', 'ProfileController::update');

    // Cek Iuran
    $routes->get('iuran', 'IuranController::index');
    $routes->get('iuran/detail/(:num)', 'IuranController::iuranDetail/$1');
    $routes->get('list', 'IuranController::iuranList');
    
    // Rute Pembayaran Iuran
    $routes->get('bayar_iuran', 'PembayaranController::bayarIuran');
    $routes->get('pilih_metode_pembayaran', 'PembayaranController::pilihMetodePembayaran');
    $routes->post('pilih_metode_pembayaran', 'PembayaranController::pilihMetodePembayaran'); // Tambahkan ini
    $routes->post('proses_pembayaran', 'PembayaranController::prosesPembayaran'); 
    $routes->get('bukti_pembayaran', 'PembayaranController::listPembayaran');
    $routes->get('manual_transfer', 'ManualTransferController::index');
    $routes->post('manual_transfer/store', 'ManualTransferController::store');
    $routes->get('payment_gateway', 'PaymentGatewayController::index');
    $routes->post('callback', 'MidtransController::callback');

});
$routes->post('/callback', 'MidtransController::callback');

$routes->get('/logout', 'WargaAuth::logout');

