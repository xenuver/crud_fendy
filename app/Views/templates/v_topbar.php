<!-- Pembungkus Konten -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Konten Utama -->
    <div id="content">

        <!-- Bilah Navigasi Atas -->
        <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow-sm"
            style="background: rgba(15, 23, 42, 0.8) !important; border-bottom: 2px solid rgba(234, 25, 23, 0.3); backdrop-filter: blur(10px); position: relative; z-index: 1050;">

            <!-- Tombol Toggle Sidebar (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"
                style="color: var(--bs-red);">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Pencarian Global -->
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
                onsubmit="return false;">
                <div class="input-group">
                    <input type="text" id="globalSearchInput" class="form-control bg-dark border-0 small text-white"
                        placeholder="Cari data..." aria-label="Search" aria-describedby="basic-addon2"
                        style="font-size: 0.75rem; min-width: 300px;">
                    <div class="input-group-append">
                        <button class="btn btn-danger" type="button"
                            style="background: var(--bs-red); border-radius: 0; clip-path: polygon(10% 0, 100% 0, 90% 100%, 0 100%);">
                            <i class="fas fa-search fa-sm px-2"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Judul Sistem (Hanya pada XS) -->
            <div class="d-sm-none orbitron text-white small" style="letter-spacing: 2px;">CREATOR HUB</div>

            <!-- Navigasi Menu Atas -->
            <ul class="navbar-nav ml-auto">
                <?php
                $bellCount = 0;
                $alertList = [];
                if (session()->get('role') == 'user') {
                    $db = \Config\Database::connect();
                    $bellCount = $db->table('laporan_mingguan')
                        ->join('kreator', 'kreator.kreator_id = laporan_mingguan.kreator_id')
                        ->where('kreator.id_game', session()->get('id_game'))
                        ->where('laporan_mingguan.is_read', 0)
                        ->countAllResults();

                    $builder = $db->table('laporan_mingguan');
                    $builder->select('laporan_mingguan.laporan_id, laporan_mingguan.status_validasi, laporan_mingguan.pesan_admin, laporan_mingguan.updated_at, laporan_mingguan.is_read');
                    $builder->join('kreator', 'kreator.kreator_id = laporan_mingguan.kreator_id');
                    $builder->where('kreator.id_game', session()->get('id_game'));
                    $builder->whereIn('laporan_mingguan.status_validasi', ['valid', 'tidak_valid']);
                    $builder->orderBy('laporan_mingguan.updated_at', 'DESC');
                    $builder->limit(5);
                    $alertList = $builder->get()->getResultArray();
                } elseif (session()->get('role') == 'admin') {
                    $db = \Config\Database::connect();
                    $bellCount = $db->table('laporan_mingguan')
                        ->where('status_validasi', 'pending')
                        ->countAllResults();

                    $builder = $db->table('laporan_mingguan');
                    $builder->select('laporan_mingguan.laporan_id, laporan_mingguan.nama_lengkap, laporan_mingguan.created_at, laporan_mingguan.status_validasi');
                    $builder->orderBy('laporan_mingguan.created_at', 'DESC');
                    $builder->limit(7);
                    $alertList = $builder->get()->getResultArray();
                }
                ?>

                <?php if (in_array(session()->get('role'), ['admin', 'super_admin'])): ?>
                    <script>
                        function pemicuNotifMelayang(title, body, url) {
                            if (!('Notification' in window)) {
                                alert('Browser HP Anda tidak mendukung Notifikasi.');
                                return;
                            }
                            if (Notification.permission !== 'granted') {
                                Notification.requestPermission().then(permission => {
                                    if (permission === 'granted') {
                                        pemicuNotifMelayang(title, body, url);
                                    } else {
                                        alert('Izin notifikasi ditolak di browser HP. Mohon izinkan notifikasi pada ikon gembok 🔒 di alamat URL browser.');
                                    }
                                });
                                return;
                            }

                            const options = {
                                body: body,
                                icon: '<?= base_url('assets/img/bloodstrike_actual.jpg') ?>',
                                badge: '<?= base_url('assets/img/bloodstrike_actual.jpg') ?>',
                                vibrate: [200, 100, 200],
                                data: { url: url || '<?= base_url('admin/laporan') ?>' }
                            };

                            if ('serviceWorker' in navigator) {
                                navigator.serviceWorker.ready.then(function(reg) {
                                    reg.showNotification(title, options);
                                }).catch(function() {
                                    new Notification(title, options);
                                });
                            } else {
                                new Notification(title, options);
                            }
                        }

                        <?php if ($bellCount > 0): ?>
                        document.addEventListener('DOMContentLoaded', function() {
                            setTimeout(function() {
                                pemicuNotifMelayang(
                                    'Pengingat Laporan Pending',
                                    'Terdapat <?= $bellCount ?> laporan mingguan kreator yang belum diverifikasi.',
                                    '<?= base_url('admin/laporan') ?>'
                                );
                            }, 1000);
                        });
                        <?php endif; ?>
                    </script>
                <?php endif; ?>

                <?php if (session()->get('role') == 'user'): ?>
                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw text-secondary"></i>
                            <!-- Counter - Alerts -->
                            <?php if ($bellCount > 0): ?>
                                <span class="badge badge-danger badge-counter"
                                    style="background: var(--bs-red); font-size: 0.6rem; margin-top: 5px;"><?= $bellCount ?>+</span>
                            <?php endif; ?>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow-lg animated--grow-in"
                            aria-labelledby="alertsDropdown"
                            style="background: #0f172a; border: 1px solid rgba(255,255,255,0.1);">
                            <h6 class="dropdown-header orbitron bg-danger text-white border-0" style="letter-spacing: 1px;">
                                PUSAT NOTIFIKASI
                            </h6>

                            <?php if (count($alertList) > 0): ?>
                                <?php foreach ($alertList as $alert): ?>
                                    <a class="dropdown-item d-flex align-items-center bg-dark border-bottom border-light <?= $alert['is_read'] == 0 ? 'bg-gradient-dark' : 'opacity-75' ?>"
                                        href="<?= base_url('user/laporan/read/' . $alert['laporan_id']) ?>"
                                        style="border-color: rgba(255,255,255,0.05) !important;">
                                        <div class="mr-3">
                                            <div
                                                class="icon-circle bg-<?= $alert['status_validasi'] == 'valid' ? 'success' : 'danger' ?>">
                                                <i
                                                    class="fas fa-<?= $alert['status_validasi'] == 'valid' ? 'check' : 'times' ?> text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">
                                                <?= date('d M Y, H:i', strtotime($alert['updated_at'])) ?></div>
                                            <span class="font-weight-bold text-white mb-1 d-block"
                                                style="font-size: 0.85rem;">Status Laporan:
                                                <?= strtoupper(str_replace('_', ' ', $alert['status_validasi'])) ?></span>
                                            <?php if (!empty($alert['pesan_admin'])): ?>
                                                <div class="small text-secondary fst-italic">"<?= esc($alert['pesan_admin']) ?>"</div>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                                <a class="dropdown-item text-center small text-gray-500 p-2 bg-dark orbitron text-danger"
                                    href="<?= base_url('user/laporan') ?>">Ke Halaman Laporan</a>
                            <?php else: ?>
                                <a class="dropdown-item text-center small text-gray-500 p-3 bg-dark" href="#">Tidak ada
                                    peringatan baru</a>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php elseif (session()->get('role') == 'admin'): ?>
                    <!-- Nav Item - Alerts (ADMIN) -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdownAdmin" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw text-secondary"></i>
                            <!-- Counter - Alerts (Removed counter mark for admin) -->
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow-lg animated--grow-in"
                            aria-labelledby="alertsDropdownAdmin"
                            style="background: #0f172a; border: 1px solid rgba(255,255,255,0.1);">
                            <h6 class="dropdown-header orbitron bg-warning text-dark border-0" style="letter-spacing: 1px;">
                                LAPORAN MASUK (PENDING)
                            </h6>

                            <?php if (count($alertList) > 0): ?>
                                <?php foreach ($alertList as $alert): ?>
                                    <a class="dropdown-item d-flex align-items-center bg-dark border-bottom border-light"
                                        href="<?= base_url('admin/laporan?status=pending') ?>"
                                        style="border-color: rgba(255,255,255,0.05) !important;">
                                        <div class="mr-3">
                                            <div
                                                class="icon-circle bg-<?= $alert['status_validasi'] == 'pending' ? 'warning' : ($alert['status_validasi'] == 'valid' ? 'success' : 'danger') ?>">
                                                <i
                                                    class="fas fa-<?= $alert['status_validasi'] == 'pending' ? 'file-alt' : ($alert['status_validasi'] == 'valid' ? 'check' : 'times') ?> text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">
                                                <?= date('d M Y, H:i', strtotime($alert['created_at'])) ?></div>
                                            <span class="font-weight-bold text-white mb-1 d-block" style="font-size: 0.85rem;">
                                                <?= $alert['status_validasi'] == 'pending' ? 'Menunggu Verifikasi:' : 'Diproses:' ?>
                                                <?= esc($alert['nama_lengkap']) ?>
                                            </span>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                                <a class="dropdown-item text-center small p-2 bg-dark orbitron text-warning fw-bold border-top border-secondary"
                                    href="javascript:void(0)"
                                    onclick="pemicuNotifMelayang('Pengingat Laporan Pending (TES)', 'Ini adalah tes notifikasi melayang di HP Admin. Notifikasi berjalan dengan sukses!', '<?= base_url('admin/laporan') ?>')">
                                    <i class="fas fa-bell mr-1"></i> TES NOTIFIKASI HP
                                </a>
                                <a class="dropdown-item text-center small text-gray-500 p-2 bg-dark orbitron text-info"
                                    href="<?= base_url('admin/laporan?status=pending') ?>">Ke Halaman Verifikasi</a>
                            <?php else: ?>
                                <a class="dropdown-item text-center small text-gray-500 p-3 bg-dark" href="#">Semua laporan
                                    telah diproses!</a>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endif; ?>

                <div class="topbar-divider d-none d-sm-block" style="border-right: 1px solid rgba(255, 255, 255, 0.1);">
                </div>

                <!-- Item Navigasi - Informasi Pengguna -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="mr-3 d-none d-lg-inline text-white orbitron"
                            style="font-size: 0.8rem; letter-spacing: 1px;">
                            <i class="fas fa-id-badge mr-2 text-danger"></i>
                            <?= strtoupper(session()->get('username')) ?>
                        </span>
                        <img class="img-profile rounded-circle"
                            style="border: 2px solid var(--bs-red); box-shadow: 0 0 10px var(--bs-accent-glow);"
                            src="<?= base_url('assets/img/profile/blood-strike.jpg') ?>" alt="Avatar">
                    </a>
                    <!-- Menu Dropdown Informasi Pengguna -->
                    <div class="dropdown-menu dropdown-menu-right shadow-lg animated--grow-in"
                        style="background: #1e293b; border: 1px solid rgba(234, 25, 23, 0.5); border-radius: 0; clip-path: polygon(0 0, 100% 0, 100% 90%, 90% 100%, 0% 100%);"
                        aria-labelledby="userDropdown">
                        <div class="dropdown-header orbitron text-danger small py-2 px-3">PROFIL SAYA</div>
                        <a class="dropdown-item text-white py-2"
                            href="<?= base_url(session()->get('role') . '/profile') ?>">
                            <i class="fas fa-shield-alt fa-sm fa-fw mr-3 text-gray-500"></i>
                            Keamanan Akun
                        </a>
                        <div class="dropdown-divider border-secondary opacity-25"></div>
                        <a class="dropdown-item text-white py-2" href="<?= base_url('logout') ?>">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-3 text-danger"></i>
                            Keluar Sistem (Logout)
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- Akhir Bilah Navigasi Atas -->

        <!-- Global Alert/Notification System (Handled by SweetAlert2 in Footer) -->
        <div class="container-fluid mt-2 mb-0">
        </div>