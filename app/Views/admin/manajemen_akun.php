<link rel="stylesheet" href="<?= base_url('assets/css/manajemen_akun.css') ?>">
<div class="container-fluid">

    <h1 class="h3 mb-4 text-white orbitron"><?= $judul; ?></h1>



    <div class="card shadow-sm mb-4" style="background: rgba(30, 41, 59, 0.8); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; backdrop-filter: blur(10px);">
        <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center flex-wrap" style="background: transparent; gap: 10px;">
            <h5 class="mb-0 text-white"><i class="fas fa-users-cog text-danger mr-2"></i> Daftar Akun Pengguna</h5>
            <button class="btn btn-danger btn-sm rounded-1" data-toggle="modal" data-target="#addUserModal" style="background-color: #ea1917; border: none; clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%); padding: 6px 15px; font-weight: bold;">
                <i class="fas fa-plus mr-1"></i> Tambah Akun
            </button>
        </div>
        <hr class="border-secondary mb-0 mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-hover table-borderless align-middle" id="dataTable" width="100%" cellspacing="0" style="background: transparent; min-width: 900px;">
                    <thead style="border-bottom: 2px solid #ea1917;">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th class="text-nowrap">Username</th>
                            <th class="text-nowrap">Email</th>
                            <th class="text-nowrap">Nomor Telepon</th>
                            <th class="text-nowrap">ID Game</th>
                            <th class="text-nowrap">Role</th>
                            <th class="text-center text-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = isset($pager) ? (($pager->getCurrentPage('user') - 1) * $pager->getPerPage('user')) + 1 : 1;
                        foreach ($users as $user) : 
                        ?>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <td><?= $no++; ?></td>
                                <td class="fw-bold text-light text-nowrap"><?= esc($user['username']); ?></td>
                                <td class="text-info small text-nowrap"><?= esc($user['email'] ?? '—'); ?></td>
                                <td class="text-nowrap"><?= esc($user['no_telp']); ?></td>
                                <td class="text-nowrap"><span class="badge bg-secondary"><?= esc($user['id_game']); ?></span></td>
                                <td class="text-nowrap">
                                    <?php if ($user['role'] == 'super_admin'): ?>
                                        <span class="badge" style="background: #f59e0b; color: #000; font-weight: bold;"><i class="fas fa-crown mr-1"></i> Super Admin</span>
                                    <?php elseif ($user['role'] == 'admin'): ?>
                                        <span class="badge bg-danger"><i class="fas fa-user-shield mr-1"></i> Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary"><i class="fas fa-user mr-1"></i> User</span>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle px-4 text-center text-nowrap">
                                    <?php if ($user['role'] === 'super_admin' && session()->get('role') !== 'super_admin'): ?>
                                        <span class="badge bg-dark border border-warning text-warning" style="font-size: 0.6rem; padding: 4px 8px;" title="Akun Super Admin terlindungi dari perubahan Admin biasa">
                                            <i class="fas fa-lock mr-1"></i> DIPROTEKSI
                                        </span>
                                    <?php else: ?>
                                        <div class="d-flex justify-content-center align-items-center" style="gap: 6px;">
                                            <button class="btn btn-outline-warning btn-sm p-1 border-0" data-toggle="modal" data-target="#editUserModal<?= $user['user_id'] ?>" title="Ubah Data">
                                                <i class="fas fa-pen-nib"></i>
                                            </button>
                                            <form method="POST" action="<?= base_url('admin/users/delete/' . $user['user_id']) ?>" style="display:inline-block; margin:0;">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btn btn-outline-danger btn-sm p-1 border-0 btn-delete-user" title="Hapus Akun">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if (isset($pager)): ?>
                <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
                    <div class="text-muted small orbitron" style="font-size: 0.7rem;">
                        Menampilkan <?= count($users) ?> akun di halaman ini
                    </div>
                    <div>
                        <?= $pager->links('user', 'default_full') ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Section: Redeem Code Kreator -->
<div class="container-fluid mt-2 mb-4">
    <div class="card shadow-sm" style="background: rgba(30, 41, 59, 0.8); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; backdrop-filter: blur(10px);">
        <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center flex-wrap" style="background: transparent; gap: 10px;">
            <h5 class="mb-0 text-white">
                <i class="fas fa-key text-danger mr-2"></i> Redeem Code Pendaftaran Kreator
            </h5>
            <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                <span class="text-muted small mr-2" style="font-size: 0.7rem;">
                    Link Registrasi: <code style="color: #ea1917; background: rgba(234,25,23,0.1); padding: 2px 8px; border-radius: 3px;"><?= $register_url ?></code>
                    <button onclick="copyLink('<?= $register_url ?>')" class="btn btn-sm p-0 ml-1 text-muted border-0" title="Salin Link" style="background:none;">
                        <i class="fas fa-copy" id="copyLinkIcon"></i>
                    </button>
                </span>
                <form action="<?= base_url('admin/users/generate-code') ?>" id="generateCodeForm" method="POST" class="d-flex align-items-center m-0" style="gap: 8px;">
                    <?= csrf_field() ?>
                    <div class="input-group input-group-sm" style="width: 130px;">
                        <span class="input-group-text text-white border-secondary" style="background: rgba(30, 41, 59, 0.6); border-color: rgba(255,255,255,0.1) !important; font-size: 0.75rem;">Jumlah</span>
                        <input type="number" name="jumlah" id="jumlahGenerate" class="form-control text-white border-secondary text-center" value="1" min="1" max="100" style="background: rgba(15, 23, 42, 0.6); border-color: rgba(255,255,255,0.1) !important; font-weight: bold;">
                    </div>
                    <button type="submit"
                            class="btn btn-sm"
                            style="background-color: #ea1917; border: none; color: white; clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%); padding: 6px 15px; font-weight: bold;">
                        <i class="fas fa-plus-circle mr-1"></i> Generate
                    </button>
                </form>
            </div>
        </div>
        <hr class="border-secondary mb-0 mt-3">
        <div class="card-body">
            <?php if (empty($redeem_codes)): ?>
                <p class="text-muted text-center small py-3">
                    <i class="fas fa-inbox mr-2"></i>Belum ada Redeem Code. Masukkan jumlah dan klik **Generate** di atas untuk membuat baru.
                </p>
            <?php else: ?>
                <?php if (!empty($unused_links_str)): ?>
                    <!-- Textarea tersembunyi untuk menyimpan string multiline agar tidak merusak JS -->
                    <textarea id="unusedLinksText" style="display: none;"><?= esc($unused_links_str) ?></textarea>

                    <div class="mb-3 d-flex justify-content-start">
                        <button onclick="copyFromTextarea('unusedLinksText', this, 'bulkCopyLinkIcon', 'Salin Semua Link (<?= $unused_codes_count ?>)')"
                                class="btn btn-sm btn-outline-info d-flex align-items-center"
                                style="border-color: rgba(0, 191, 255, 0.4); color: #00bfff; font-weight: bold; background: rgba(0, 191, 255, 0.05); padding: 6px 12px; border-radius: 4px; gap: 8px;">
                            <i class="fas fa-link" id="bulkCopyLinkIcon"></i> Salin Semua Link (<?= $unused_codes_count ?>)
                        </button>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover table-borderless align-middle" style="background: transparent; min-width: 850px;">
                        <thead style="border-bottom: 2px solid #ea1917;">
                            <tr>
                                <th style="width:50px;">No</th>
                                <th class="text-nowrap">Kode Redeem</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap">Dipakai Oleh</th>
                                <th class="text-nowrap">Waktu Dipakai</th>
                                <th class="text-nowrap">Dibuat Pada</th>
                                <th class="text-center text-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($redeem_codes as $i => $rc): ?>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td><?= $i + 1 ?></td>
                                    <td class="text-nowrap">
                                        <code style="font-size: 0.95rem; color: <?= $rc['is_used'] ? '#64748b' : '#ea1917' ?>; letter-spacing: 2px; background: rgba(255,255,255,0.05); padding: 3px 10px; border-radius: 3px;">
                                            <?= esc($rc['code']) ?>
                                        </code>
                                        <?php if (!$rc['is_used']): ?>
                                            <button onclick="copyLink('<?= $register_url . '?code=' . esc($rc['code']) ?>', this)"
                                                    class="btn btn-sm p-0 ml-2 text-muted border-0"
                                                    title="Salin Link Registrasi Langsung (Auto-fill Kode)"
                                                    style="background:none; font-size: 0.8rem;">
                                                <i class="fas fa-share-alt"></i>
                                            </button>
                                            <?php 
                                                $waText = "Halo kreator! Berikut adalah link pendaftaran akun Bloodstrike Hub Anda (Redeem Code otomatis terisi): " . $register_url . "?code=" . $rc['code'];
                                            ?>
                                            <a href="https://api.whatsapp.com/send?text=<?= urlencode($waText) ?>"
                                               target="_blank"
                                               class="btn btn-sm p-0 ml-2 text-success border-0"
                                               title="Kirim via WhatsApp"
                                               style="background:none; font-size: 0.85rem;">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php if ($rc['is_used']): ?>
                                            <span class="badge" style="background: rgba(100,116,139,0.3); color: #94a3b8; border: 1px solid #475569;">
                                                <i class="fas fa-check mr-1"></i> Sudah Dipakai
                                            </span>
                                        <?php else: ?>
                                            <span class="badge" style="background: rgba(34,197,94,0.15); color: #4ade80; border: 1px solid rgba(34,197,94,0.4);">
                                                <i class="fas fa-circle mr-1" style="font-size: 0.5rem;"></i> Tersedia
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted small text-nowrap">
                                        <?= $rc['used_by_username'] ? esc($rc['used_by_username']) : '<span class="text-muted">—</span>' ?>
                                    </td>
                                    <td class="text-muted small text-nowrap">
                                        <?= $rc['used_at'] ? date('d M Y, H:i', strtotime($rc['used_at'])) : '<span class="text-muted">—</span>' ?>
                                    </td>
                                    <td class="text-muted small text-nowrap">
                                        <?= $rc['created_at'] ? date('d M Y, H:i', strtotime($rc['created_at'])) : '—' ?>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <form method="POST" action="<?= base_url('admin/users/delete-code/' . $rc['redeem_id']) ?>" style="display:inline-block; margin:0;">
                                            <?= csrf_field() ?>
                                            <button type="button" class="btn btn-outline-danger btn-sm p-1 border-0 btn-delete-code" title="Hapus Kode" data-confirm-text="<?= $rc['is_used'] ? 'Kode ini sudah dipakai oleh kreator. Yakin ingin tetap menghapus riwayat kode ini?' : 'Yakin ingin menghapus/menonaktifkan kode me-1 ini?' ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if (isset($pager)): ?>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div class="text-muted small orbitron" style="font-size: 0.7rem;">
                            Menampilkan <?= count($redeem_codes) ?> kode di halaman ini
                        </div>
                        <div>
                            <?= $pager->links('redeem', 'default_full') ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Tambahkan Script DataTables Tanpa Paging -->


<!-- Modal Tambah Akun -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #1e293b; border: 1px solid rgba(234, 25, 23, 0.5); border-radius: 0; clip-path: polygon(0 0, 100% 0, 100% 95%, 95% 100%, 0% 100%);">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white"><i class="fas fa-user-plus text-danger me-2"></i> Tambah Akun Pengguna</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/users/save') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body text-white">
                    <!-- Fields Wrapper -->
                    <div class="form-fields-wrapper">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" name="username" placeholder="Masukkan Username..." required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email <span class="text-secondary">(Untuk Notifikasi)</span></label>
                            <input type="email" class="form-control bg-dark text-white border-secondary" name="email" placeholder="Contoh: admin@gmail.com">
                        </div>
                        
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" name="no_telp" placeholder="Contoh: 081234567890" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_game" class="form-label">ID Game</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" name="id_game" placeholder="Masukkan ID Game (UID)..." required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Level Akses (Role)</label>
                            <select class="form-select bg-dark text-white border-secondary" name="role" required>
                                <option value="user" selected>User / Kreator</option>
                                <option value="admin">Admin</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input type="password" class="form-control bg-dark text-white border-secondary" name="password" minlength="8" placeholder="Minimal 8 karakter" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-0" style="background-color: #ea1917; border: none;">Buat Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($users as $user) : ?>
<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal<?= $user['user_id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #1e293b; border: 1px solid rgba(234, 25, 23, 0.5); border-radius: 0; clip-path: polygon(0 0, 100% 0, 100% 95%, 95% 100%, 0% 100%);">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white"><i class="fas fa-edit text-danger me-2"></i> Edit Data Akun</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/users/update') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body text-white">
                    <input type="hidden" name="id" value="<?= $user['user_id'] ?>">
                    
                    <!-- Fields Wrapper -->
                    <div class="form-fields-wrapper">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" name="username" value="<?= esc($user['username']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email <span class="text-secondary">(Untuk Notifikasi)</span></label>
                            <input type="email" class="form-control bg-dark text-white border-secondary" name="email" value="<?= esc($user['email'] ?? '') ?>" placeholder="Contoh: admin@gmail.com">
                        </div>
                        
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" name="no_telp" value="<?= esc($user['no_telp']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_game" class="form-label">ID Game</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" name="id_game" value="<?= esc($user['id_game']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Level Akses (Role)</label>
                            <select class="form-select bg-dark text-white border-secondary" name="role" required>
                                <option value="user" <?= ($user['role'] == 'user') ? 'selected' : '' ?>>User / Kreator</option>
                                <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                                <option value="super_admin" <?= ($user['role'] == 'super_admin') ? 'selected' : '' ?>>Super Admin</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi Baru <span class="text-secondary">(Opsi Opsional)</span></label>
                            <input type="password" class="form-control bg-dark text-white border-secondary" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah sandi.">
                            <small class="text-muted">Isi hanya jika admin ingin me-reset kata sandi akun ini.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-0" style="background-color: #ea1917; border: none;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- SweetAlert2 Delete Confirmation for Account & Redeem Code (Admin) - Vanilla JS -->
<script src="<?= base_url('assets/js/manajemen_akun.js?v=' . time()) ?>"></script>
