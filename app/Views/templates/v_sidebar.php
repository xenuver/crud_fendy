        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar" style="background: rgba(15, 23, 42, 0.9) !important; border-right: 2px solid var(--bs-red); box-shadow: 10px 0 30px rgba(0,0,0,0.4);">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(session()->get('role')) ?>">
                <div class="sidebar-brand-text mx-3 orbitron" style="color: var(--bs-red); text-shadow: 0 0 10px var(--bs-accent-glow); font-size: 1.1rem; letter-spacing: 2px;">
                    <i class="fas fa-crosshairs mr-1"></i> Hub Kreator
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">

            <!-- Heading -->
            <div class="sidebar-heading mt-4 text-white-50 small fw-bold">
                MENU SISTEM (<?= strtoupper(session()->get('role')) ?>)
            </div>

            <?php if (session()->get('role') == 'admin'): ?>
                <!-- Nav Item - Dashboard Utama -->
                <li class="nav-item <?= uri_string() == 'admin' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin') ?>">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard Utama</span>
                    </a>
                </li>

                <!-- Nav Item - Laporan (Admin) -->
                <li class="nav-item <?= (strpos(uri_string(), 'admin/laporan') === 0 && strpos(uri_string(), 'admin/laporan/bulanan') === false) ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/laporan') ?>">
                        <i class="fas fa-fw fa-file-medical-alt"></i>
                        <span>Laporan Mingguan</span>
                    </a>
                </li>

                <!-- Nav Item - Laporan Bulanan (Admin) -->
                <li class="nav-item <?= strpos(uri_string(), 'admin/laporan/bulanan') === 0 ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/laporan/bulanan') ?>">
                        <i class="fas fa-fw fa-archive"></i>
                        <span>Laporan Bulanan</span>
                    </a>
                </li>

                <!-- Nav Item - Penjenjangan (Admin) -->
                <li class="nav-item <?= strpos(uri_string(), 'admin/tiering') === 0 ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/tiering') ?>">
                        <i class="fas fa-fw fa-medal"></i>
                        <span>Daftar Pangkat</span>
                    </a>
                </li>

                <!-- Nav Item - Pengaturan Metrik (Admin) -->
                <li class="nav-item <?= strpos(uri_string(), 'admin/settings') === 0 ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/settings') ?>">
                        <i class="fas fa-fw fa-sliders-h"></i>
                        <span>Pengaturan Metrik</span>
                    </a>
                </li>
                
                <!-- Nav Item - Data Kreator -->
                <li class="nav-item <?= strpos(uri_string(), 'admin/kreator') === 0 ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/kreator') ?>">
                        <i class="fas fa-fw fa-user-shield"></i>
                        <span>Data Kreator</span>
                    </a>
                </li>

                <!-- Nav Item - Manajemen Akun -->
                <li class="nav-item <?= strpos(uri_string(), 'admin/users') === 0 ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/users') ?>">
                        <i class="fas fa-fw fa-users-cog"></i>
                        <span>Manajemen Akun</span>
                    </a>
                </li>
            <?php else: ?>
                <!-- Nav Item - Dashboard Utama (User) -->
                <li class="nav-item <?= uri_string() == 'user' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('user') ?>">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard Utama</span>
                    </a>
                </li>
                <!-- Nav Item - Laporan (User) -->
                <li class="nav-item <?= strpos(uri_string(), 'user/laporan') === 0 ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('user/laporan') ?>">
                        <i class="fas fa-file-signature"></i>
                        <span>Laporan Mingguan</span>
                    </a>
                </li>
                <!-- Nav Item - Profil (User) -->
                <li class="nav-item <?= strpos(uri_string(), 'user/profile') === 0 ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('user/profile') ?>">
                        <i class="fas fa-user-circle"></i>
                        <span>Pengaturan Profil</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Divider -->
            <hr class="sidebar-divider" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">

            <?php if (session()->get('role') == 'admin'): ?>
                <!-- Nav Item - Profil (Admin) -->
                <li class="nav-item <?= strpos(uri_string(), 'admin/profile') !== false ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/profile') ?>">
                        <i class="fas fa-user-cog"></i>
                        <span>Pengaturan Profil</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Nav Item - Logout -->
            <li class="nav-item">
                <a class="nav-link text-white fw-bold" href="<?= base_url('logout') ?>" id="btn-logout">
                    <i class="fas fa-power-off text-danger"></i>
                    <span>Keluar Sistem</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle" style="background: var(--bs-red);"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
