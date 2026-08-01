<?php

use CodeIgniter\Router\RouteCollection;

//@var RouteCollection $routes

// Public Pages (Landing, Login, Register)
$routes->get('/', 'Auth::index'); // Landing Page
$routes->get('login', 'Auth::login_view'); // Form Login
$routes->get('register', 'Auth::register_view'); // Form Register (Private URL - no public link)
$routes->post('auth/login', 'Auth::login'); // Process Login
$routes->post('auth/register', 'Auth::register_save'); // Process Register
$routes->get('logout', 'Auth::logout');
$routes->get('suspended', 'Auth::suspended');
// Route /keamanan-akun dihapus — fitur ganti password sudah dipindah ke halaman profil masing-masing role.


// Group Admin
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('/', 'Admin\DashboardUtama::index');
    $routes->get('tiering', 'Admin\DaftarPangkat::index');
    $routes->post('laporan/toggle', 'Admin\DashboardUtama::toggle_submission');
    $routes->get('settings', 'Admin\PengaturanMetrik::index');
    $routes->post('settings/update', 'Admin\PengaturanMetrik::update');

    // Manage Kreator
    $routes->get('kreator', 'Admin\DataKreator::index');
    $routes->post('kreator/save', 'Admin\DataKreator::save');
    $routes->post('kreator/update', 'Admin\DataKreator::update');
    $routes->post('kreator/delete/(:num)', 'Admin\DataKreator::delete/$1');
    $routes->post('kreator/toggle_status/(:num)', 'Admin\DataKreator::toggle_status/$1');

    // Manage Laporan
    $routes->get('laporan', 'Admin\LaporanMingguan::index');
    $routes->get('laporan/bulanan', 'Admin\LaporanBulanan::index');
    $routes->get('laporan/export', 'Admin\LaporanBulanan::export');
    $routes->get('laporan/exportWeekly', 'Admin\LaporanMingguan::exportWeekly');

    $routes->post('laporan/delete/(:num)', 'Admin\LaporanMingguan::delete/$1');
    $routes->post('laporan/verify/(:num)', 'Admin\LaporanMingguan::verify/$1');

    // Manage Users (Akun)
    $routes->get('users', 'Admin\ManajemenAkun::index');
    $routes->post('users/save', 'Admin\ManajemenAkun::save');
    $routes->post('users/update', 'Admin\ManajemenAkun::update');
    $routes->post('users/delete/(:num)', 'Admin\ManajemenAkun::delete/$1');
    $routes->post('users/generate-code', 'Admin\ManajemenAkun::generate_code');
    $routes->post('users/delete-code/(:num)', 'Admin\ManajemenAkun::delete_code/$1');

    // Admin Profile
    $routes->get('profile', 'Admin\PengaturanProfil::index');
    $routes->post('profile/update', 'Admin\PengaturanProfil::update');
    $routes->post('password/update', 'Admin\PengaturanProfil::update_password');
});

// Group User
$routes->group('user', ['filter' => 'auth:user'], function ($routes) {
    $routes->get('/', 'User\DashboardKreator::index');
    $routes->get('laporan', 'User\LaporanKreator::index');
    $routes->post('laporan/save', 'User\LaporanKreator::save');
    $routes->get('laporan/read/(:num)', 'User\LaporanKreator::markAsRead/$1');
    $routes->post('laporan/banding/(:num)', 'User\LaporanKreator::ajukanBanding/$1');
    $routes->get('profile', 'User\ProfilKreator::profile');
    $routes->post('profile/update', 'User\ProfilKreator::update_profile');
    $routes->post('password/update', 'User\ProfilKreator::update_password');
});

// Group Super Admin — Halaman Eksklusif Banding Kreator & Profil
$routes->group('superadmin', ['filter' => 'auth:super_admin'], function ($routes) {
    $routes->get('/', 'SuperAdmin\DashboardBanding::index');
    $routes->post('banding/putuskan/(:num)', 'SuperAdmin\DashboardBanding::putuskan/$1');

    // Super Admin Profile & Password & Resend Key
    $routes->get('profile', 'SuperAdmin\PengaturanProfil::index');
    $routes->post('profile/update', 'SuperAdmin\PengaturanProfil::update');
    $routes->post('profile/resend-key', 'SuperAdmin\PengaturanProfil::updateResendKey');
    $routes->post('password/update', 'SuperAdmin\PengaturanProfil::updatePassword');
});
