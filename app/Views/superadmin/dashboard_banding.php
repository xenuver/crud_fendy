<div class="container-fluid py-3 py-md-4" style="font-family: 'Inter', system-ui, -apple-system, sans-serif;">

    <style>
        .font-sans {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        }
        .modal-tinjau-content {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        }
        @keyframes shakeField {
            0%, 100% { transform: translateX(0); }
            15%       { transform: translateX(-7px); }
            30%       { transform: translateX(7px); }
            45%       { transform: translateX(-5px); }
            60%       { transform: translateX(5px); }
            75%       { transform: translateX(-3px); }
            90%       { transform: translateX(3px); }
        }
        .shake-error {
            animation: shakeField 0.45s ease-in-out;
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 2px rgba(239,68,68,0.35) !important;
        }
        .banner-wajib-review {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: rgba(245,158,11,0.1);
            border: 1px solid rgba(245,158,11,0.4);
            border-left: 3px solid #f59e0b;
            border-radius: 4px;
            padding: 10px 14px;
            margin-bottom: 14px;
        }
        .banner-wajib-review .bwr-icon {
            color: #f59e0b;
            font-size: 0.95rem;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .banner-wajib-review .bwr-text {
            font-size: 0.78rem;
            line-height: 1.55;
            color: #e2e8f0;
            font-family: 'Inter', sans-serif;
        }
        .banner-wajib-review .bwr-text strong {
            color: #f59e0b;
        }
        @media (max-width: 576px) {
            .modal-tinjau-dialog {
                margin: 0.5rem;
            }
            .modal-tinjau-body {
                padding: 1rem !important;
            }
            .btn-decision-mobile {
                width: 100% !important;
                margin-bottom: 0.5rem;
            }
            .footer-decision-mobile {
                flex-direction: column-reverse !important;
                gap: 0.5rem !important;
            }
            .footer-decision-mobile button {
                width: 100% !important;
            }
        }
    </style>

    <!-- HEADER STATUS SISTEM -->
    <div class="d-flex align-items-center mb-4 flex-wrap gap-2">
        <div class="text-white px-3 py-1 orbitron small shadow-sm"
            style="background: linear-gradient(90deg, #b45309, #f59e0b); clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
            PANEL SUPER ADMIN
        </div>
        <div class="text-secondary small font-sans" style="opacity: 0.9; letter-spacing: 0.5px;">
            Panel Banding Kreator | Bloodstrike Creator Hub
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert border-0 mb-4 d-flex align-items-center"
            style="background: rgba(16,185,129,0.15); border-left: 4px solid #10b981 !important;">
            <i class="fas fa-check-circle mr-3" style="color: #10b981; font-size: 1.1rem;"></i>
            <span class="text-white small font-sans"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert border-0 mb-4 d-flex align-items-center"
            style="background: rgba(239,68,68,0.15); border-left: 4px solid #ef4444 !important;">
            <i class="fas fa-exclamation-circle mr-3" style="color: #ef4444; font-size: 1.1rem;"></i>
            <span class="text-white small font-sans"><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <!-- STATS CARD -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="hud-card p-3 d-flex align-items-center" style="border-left: 3px solid #f59e0b; background: rgba(245,158,11,0.08);">
                <div class="mr-3 text-center" style="width: 48px; height: 48px; background: rgba(245,158,11,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-balance-scale" style="color: #f59e0b; font-size: 1.2rem;"></i>
                </div>
                <div>
                    <div class="orbitron" style="color: #f59e0b; font-size: 1.6rem; font-weight: bold; line-height: 1;"><?= $jumlahMenunggu ?></div>
                    <div class="text-secondary small mt-1 font-sans">Banding Menunggu Keputusan</div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="hud-card p-3 d-flex align-items-center h-100" style="border-left: 3px solid #6366f1; background: rgba(99,102,241,0.05);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle mr-2" style="color: #6366f1; font-size: 1.2rem; flex-shrink: 0;"></i>
                    <span class="text-secondary small font-sans" style="line-height: 1.5;">
                        Sebagai <strong class="text-white">Super Admin</strong>, Anda dapat meninjau seluruh data laporan, bukti foto, serta pesan perbandingan untuk memutuskan pengajuan banding kreator. Keputusan bersifat <strong class="text-white">final</strong>.
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER TAB -->
    <div class="hud-card mb-0" style="border-left: 3px solid #f59e0b;">
        <div class="hud-body p-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <i class="fas fa-filter mr-2" style="color: #f59e0b;"></i>
                    <span class="font-sans small fw-bold text-white" style="letter-spacing: 0.5px;">DAFTAR BANDING KREATOR</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('superadmin?filter=menunggu') ?>"
                        class="btn btn-sm px-3 font-sans <?= $filter === 'menunggu' ? '' : 'btn-outline-secondary' ?>"
                        style="<?= $filter === 'menunggu' ? 'background: #f59e0b; color: #000; border: none; font-weight: bold;' : '' ?> font-size: 0.75rem; border-radius: 4px;">
                        <i class="fas fa-clock mr-1"></i> MENUNGGU
                        <?php if ($jumlahMenunggu > 0): ?>
                            <span class="badge ml-1" style="background: <?= $filter === 'menunggu' ? '#7c3300' : '#f59e0b' ?>; color: <?= $filter === 'menunggu' ? '#fff' : '#000' ?>; border-radius: 8px; font-size: 0.65rem;"><?= $jumlahMenunggu ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?= base_url('superadmin?filter=selesai') ?>"
                        class="btn btn-sm px-3 font-sans <?= $filter === 'selesai' ? '' : 'btn-outline-secondary' ?>"
                        style="<?= $filter === 'selesai' ? 'background: #6366f1; color: #fff; border: none; font-weight: bold;' : '' ?> font-size: 0.75rem; border-radius: 4px;">
                        <i class="fas fa-history mr-1"></i> RIWAYAT
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL BANDING -->
    <div class="hud-card" style="border-left: 3px solid #f59e0b;">
        <div class="hud-body p-0">
            <div class="table-responsive">
                <table class="table table-tactical table-hover mb-0 font-sans" style="min-width: 1000px;">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 40px;">NO</th>
                            <th>IDENTITAS KREATOR</th>
                            <th>LAPORAN</th>
                            <th>ALASAN PENOLAKAN ADMIN</th>
                            <th>ALASAN BANDING KREATOR</th>
                            <th>STATUS</th>
                            <th class="text-center pe-4">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($banding)): ?>
                            <?php $no = 1; foreach ($banding as $b): ?>
                                <tr>
                                    <!-- NO -->
                                    <td class="ps-4 align-middle">
                                        <span class="text-secondary font-sans" style="font-size: 0.8rem; font-weight: 600;">
                                            <?= str_pad($no++, 2, '0', STR_PAD_LEFT) ?>
                                        </span>
                                    </td>

                                    <!-- IDENTITAS KREATOR -->
                                    <td class="align-middle">
                                        <div class="fw-bold text-white" style="font-size: 0.85rem;"><?= esc($b['kreator']['nama'] ?? '-') ?></div>
                                        <div class="text-secondary" style="font-size: 0.7rem;">UID: <?= esc($b['kreator']['id_game'] ?? '-') ?></div>
                                        <div class="mt-1 d-flex gap-1">
                                            <?php if (!empty($b['kreator']['tiktok_link'])): ?>
                                                <a href="<?= esc($b['kreator']['tiktok_link']) ?>" target="_blank"
                                                    class="badge bg-dark border border-secondary text-white" style="font-size: 0.6rem; font-weight: normal;">
                                                    <i class="fab fa-tiktok mr-1"></i>TikTok
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!empty($b['kreator']['youtube_link'])): ?>
                                                <a href="<?= esc($b['kreator']['youtube_link']) ?>" target="_blank"
                                                    class="badge bg-danger text-white" style="font-size: 0.6rem; font-weight: normal;">
                                                    <i class="fab fa-youtube mr-1"></i>YouTube
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- INFO LAPORAN -->
                                    <td class="align-middle">
                                        <div class="text-info font-sans" style="font-size: 0.8rem; font-weight: 600;">
                                            <?= esc($b['nama_lengkap']) ?>
                                        </div>
                                        <div class="mt-1">
                                            <?php if ($b['platform'] === 'youtube'): ?>
                                                <span class="badge bg-danger font-sans" style="font-size: 0.6rem;">YOUTUBE</span>
                                            <?php else: ?>
                                                <span class="badge bg-dark border border-secondary font-sans" style="font-size: 0.6rem;">TIKTOK</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-muted mt-1" style="font-size: 0.7rem;">
                                            Dikirim: <?= date('d M Y', strtotime($b['created_at'])) ?>
                                        </div>
                                    </td>

                                    <!-- ALASAN PENOLAKAN ADMIN -->
                                    <td class="align-middle" style="max-width: 220px;">
                                        <?php if (!empty($b['pesan_admin'])): ?>
                                            <div class="text-warning" style="font-size: 0.8rem; line-height: 1.5; word-break: break-word;">
                                                <i class="fas fa-quote-left mr-1" style="font-size: 0.6rem; opacity: 0.6;"></i>
                                                <?= esc($b['pesan_admin']) ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-secondary" style="font-size: 0.75rem;"><i>Tidak ada pesan dari admin</i></span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- ALASAN BANDING KREATOR -->
                                    <td class="align-middle" style="max-width: 220px;">
                                        <div class="text-white" style="font-size: 0.8rem; line-height: 1.5; word-break: break-word;">
                                            <i class="fas fa-quote-left mr-1" style="font-size: 0.6rem; opacity: 0.6; color: #f59e0b;"></i>
                                            <?= esc($b['alasan_banding']) ?>
                                        </div>
                                    </td>

                                    <!-- STATUS BANDING -->
                                    <td class="align-middle text-center">
                                        <?php if ($b['status_banding'] === 'menunggu'): ?>
                                            <span class="badge font-sans" style="background: rgba(245,158,11,0.2); color: #f59e0b; border: 1px solid #f59e0b; font-size: 0.65rem; padding: 4px 8px;">
                                                <i class="fas fa-clock mr-1"></i>MENUNGGU
                                            </span>
                                        <?php elseif ($b['status_banding'] === 'diterima'): ?>
                                            <span class="badge font-sans" style="background: rgba(16,185,129,0.2); color: #10b981; border: 1px solid #10b981; font-size: 0.65rem; padding: 4px 8px;">
                                                <i class="fas fa-check mr-1"></i>DITERIMA
                                            </span>
                                        <?php else: ?>
                                            <span class="badge font-sans" style="background: rgba(239,68,68,0.2); color: #ef4444; border: 1px solid #ef4444; font-size: 0.65rem; padding: 4px 8px;">
                                                <i class="fas fa-times mr-1"></i>DITOLAK FINAL
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- AKSI -->
                                    <td class="align-middle text-center pe-4">
                                        <button type="button"
                                            class="btn btn-sm font-sans px-3"
                                            style="background: linear-gradient(90deg, #b45309, #f59e0b); color: #000; font-weight: bold; border: none; font-size: 0.75rem; border-radius: 4px;"
                                            onclick='bukaModalTinjau(<?= json_encode($b) ?>)'>
                                            <i class="fas fa-search mr-1"></i> <?= $filter === 'menunggu' ? 'TINJAU & PUTUSKAN' : 'LIHAT DETAIL' ?>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div style="opacity: 0.5;">
                                        <i class="fas fa-balance-scale mb-3" style="font-size: 2.5rem; color: #f59e0b; display: block;"></i>
                                        <div class="text-secondary small font-sans">
                                            <?= $filter === 'menunggu' ? 'Tidak ada banding yang perlu ditinjau.' : 'Belum ada riwayat keputusan banding.' ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($pager): ?>
            <div class="hud-body px-4 py-3 border-top" style="border-color: rgba(245,158,11,0.2) !important;">
                <?= $pager->links('banding', 'default_full') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ========== MODAL POPUP TINJAU DATA & KEPUTUSAN BANDING (RESPONSIVE & CLEAR FONT) ========== -->
<div class="modal fade" id="modalTinjauBanding" tabindex="-1" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-tinjau-dialog">
        <div class="modal-content modal-tinjau-content" style="background: #0f172a; border: 1px solid rgba(245,158,11,0.4); border-radius: 8px; box-shadow: 0 20px 60px rgba(0,0,0,0.8);">
            
            <!-- MODAL HEADER -->
            <div class="modal-header align-items-center" style="border-bottom: 1px solid rgba(245,158,11,0.2); background: rgba(245,158,11,0.05); padding: 1rem 1.25rem;">
                <div class="d-flex align-items-center">
                    <div style="width: 38px; height: 38px; background: rgba(245,158,11,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                        <i class="fas fa-balance-scale" style="color: #f59e0b; font-size: 1.1rem;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-sans text-white fw-bold mb-0" style="font-size: 0.95rem; letter-spacing: 0.3px;">Tinjau Data & Keputusan Banding</h5>
                        <div class="text-secondary" style="font-size: 0.75rem; line-height: 1.3;">Periksa bukti laporan kreator sebelum membuat keputusan final</div>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8; font-size: 1.5rem;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formKeputusan" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="keputusan" id="inputKeputusan">
                
                <div class="modal-body modal-tinjau-body p-3 p-md-4 text-white" style="max-height: 75vh; overflow-y: auto;">

                    <!-- INFORMASI KREATOR & LAPORAN HEADER -->
                    <div class="row mb-3 p-3 rounded" style="background: rgba(30,41,59,0.6); border: 1px solid rgba(255,255,255,0.08);">
                        <div class="col-12 col-md-7 mb-2 mb-md-0">
                            <div class="text-secondary small font-sans fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">IDENTITAS KREATOR</div>
                            <div class="fw-bold text-warning text-uppercase" id="mNamaKreator" style="font-size: 1rem; word-break: break-word;">-</div>
                            <div class="text-secondary" style="font-size: 0.75rem;">UID Game: <span id="mUidKreator" class="text-white fw-bold"></span></div>
                        </div>
                        <div class="col-12 col-md-5 text-md-right">
                            <div class="text-secondary small font-sans fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">PLATFORM & WAKTU SUBMIT</div>
                            <div id="mPlatformBadge" class="mb-1"></div>
                            <div class="text-muted" style="font-size: 0.7rem;" id="mWaktuSubmit"></div>
                        </div>
                    </div>

                    <!-- METRIK UTAMA & BUKTI FOTO -->
                    <div class="font-sans text-white small fw-bold mb-2" style="letter-spacing: 0.5px; color: #f59e0b !important;">
                        <i class="fas fa-chart-line mr-1"></i> METRIK KINERJA & BUKTI FOTO
                    </div>
                    <div class="row mb-4">
                        <!-- VIDEO REGULER -->
                        <div class="col-6 col-sm-3 mb-2 px-1 px-sm-2">
                            <div class="p-2 text-center rounded h-100 d-flex flex-column justify-content-between" style="background: rgba(15,23,42,0.9); border: 1px solid rgba(255,255,255,0.08);">
                                <div>
                                    <div class="text-secondary" style="font-size: 0.65rem; font-weight: 600;">VIDEO REGULER</div>
                                    <div class="fw-bold text-white mt-1" id="mViewsVideo" style="font-size: 0.85rem;">-</div>
                                    <div class="text-muted" style="font-size: 0.65rem;" id="mJumlahVideo">0 Vids</div>
                                </div>
                                <div id="mBuktiVideo" class="mt-2"></div>
                            </div>
                        </div>
                        <!-- SHORTS (YT) -->
                        <div class="col-6 col-sm-3 mb-2 px-1 px-sm-2">
                            <div class="p-2 text-center rounded h-100 d-flex flex-column justify-content-between" style="background: rgba(15,23,42,0.9); border: 1px solid rgba(255,255,255,0.08);">
                                <div>
                                    <div class="text-secondary" style="font-size: 0.65rem; font-weight: 600;">YT SHORTS</div>
                                    <div class="fw-bold text-danger mt-1" id="mViewsShorts" style="font-size: 0.85rem;">-</div>
                                    <div class="text-muted" style="font-size: 0.65rem;" id="mJumlahShorts">0 Shorts</div>
                                </div>
                                <div id="mBuktiShorts" class="mt-2"></div>
                            </div>
                        </div>
                        <!-- LIVE STREAM -->
                        <div class="col-6 col-sm-3 mb-2 px-1 px-sm-2">
                            <div class="p-2 text-center rounded h-100 d-flex flex-column justify-content-between" style="background: rgba(15,23,42,0.9); border: 1px solid rgba(255,255,255,0.08);">
                                <div>
                                    <div class="text-secondary" style="font-size: 0.65rem; font-weight: 600;">LIVE VIEWS</div>
                                    <div class="fw-bold text-warning mt-1" id="mViewsLive" style="font-size: 0.85rem;">-</div>
                                    <div class="text-muted" style="font-size: 0.65rem;" id="mJumlahLive">0 Sessions</div>
                                </div>
                                <div id="mBuktiLive" class="mt-2"></div>
                            </div>
                        </div>
                        <!-- PEAK CCV -->
                        <div class="col-6 col-sm-3 mb-2 px-1 px-sm-2">
                            <div class="p-2 text-center rounded h-100 d-flex flex-column justify-content-between" style="background: rgba(15,23,42,0.9); border: 1px solid rgba(255,255,255,0.08);">
                                <div>
                                    <div class="text-secondary" style="font-size: 0.65rem; font-weight: 600;">PEAK CCV</div>
                                    <div class="fw-bold text-info mt-1" id="mPeakCcv" style="font-size: 0.85rem;">-</div>
                                    <div class="text-muted" style="font-size: 0.65rem;">Puncak Live</div>
                                </div>
                                <div id="mBuktiCcv" class="mt-2"></div>
                            </div>
                        </div>
                    </div>

                    <!-- COMPARISON BOX ALASAN PENOLAKAN VS ALASAN BANDING -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="p-3 rounded h-100" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3);">
                                <div class="font-sans small text-danger fw-bold mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> ALASAN PENOLAKAN ADMIN
                                </div>
                                <div id="mPesanAdmin" class="text-white" style="font-size: 0.85rem; line-height: 1.6; white-space: pre-wrap; word-break: break-word;">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded h-100" style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3);">
                                <div class="font-sans small text-warning fw-bold mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-comment-dots mr-1"></i> ALASAN BANDING KREATOR
                                </div>
                                <div id="mAlasanBanding" class="text-white" style="font-size: 0.85rem; line-height: 1.6; white-space: pre-wrap; word-break: break-word;">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- FORM CATATAN SUPER ADMIN (JIKA STATUS MENUNGGU) -->
                    <div id="sectionFormKeputusan">

                        <!-- BANNER PERINGATAN WAJIB ISI REVIEW -->
                        <div class="banner-wajib-review">
                            <i class="fas fa-exclamation-triangle bwr-icon"></i>
                            <div class="bwr-text">
                                <strong>Wajib diisi sebelum mengambil keputusan.</strong><br>
                                Isi kolom <strong>Catatan Keputusan</strong> di bawah ini terlebih dahulu sebelum menekan tombol Terima atau Tolak Banding.
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="text-white small fw-bold mb-1 font-sans">
                                Catatan Keputusan Super Admin <span class="text-danger">*</span>
                            </label>
                            <textarea name="catatan_superadmin" id="catatanSuperadmin" rows="3"
                                class="form-control bg-dark text-white border-secondary font-sans"
                                style="font-size: 0.85rem; border-radius: 4px; resize: none; line-height: 1.5; transition: border-color 0.2s, box-shadow 0.2s;"
                                placeholder="Tuliskan catatan atau alasan keputusan Anda secara jelas..."
                                required></textarea>
                            <!-- PESAN WAJIB DIISI (muncul saat validasi gagal) -->
                            <div id="pesanWajibDiisi" class="d-none mt-1 font-sans d-flex align-items-center" style="font-size: 0.75rem; color: #ef4444;">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                <span>Catatan keputusan <strong>wajib diisi</strong> sebelum mengambil keputusan!</span>
                            </div>
                            <div class="text-secondary mt-1 font-sans" style="font-size: 0.7rem;">
                                <i class="fas fa-info-circle mr-1"></i>Catatan ini akan dikirimkan dan dapat dibaca langsung oleh kreator.
                            </div>
                        </div>
                    </div>

                    <!-- HASIL RIWAYAT KEPUTUSAN (JIKA SUDAH SELESAI) -->
                    <div id="sectionRiwayatKeputusan" class="p-3 rounded mb-2 d-none" style="background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.3);">
                        <div class="font-sans small text-info fw-bold mb-1" style="font-size: 0.75rem;">
                            <i class="fas fa-shield-alt mr-1"></i> CATATAN SUPER ADMIN
                        </div>
                        <div id="mCatatanSuperadminSelesai" class="text-white font-sans" style="font-size: 0.85rem; line-height: 1.6;">-</div>
                    </div>

                </div>

                <!-- FOOTER MODAL & TOMBOL KEPUTUSAN -->
                <div class="modal-footer footer-decision-mobile d-flex justify-content-between align-items-center" style="border-top: 1px solid rgba(245,158,11,0.2); background: rgba(15,23,42,0.9); padding: 1rem 1.25rem;">
                    <button type="button" class="btn btn-sm btn-outline-secondary font-sans px-3" data-dismiss="modal"
                        style="font-size: 0.75rem; border-radius: 4px; font-weight: 600;">TUTUP</button>
                    
                    <div id="footerAksiKeputusan" class="d-flex flex-column flex-sm-row gap-2 w-100 w-sm-auto justify-content-end">
                        <button type="button" class="btn btn-sm font-sans px-3 btn-decision-mobile"
                            style="background: #ef4444; color: #fff; font-size: 0.75rem; border-radius: 4px; border: none; font-weight: bold; padding: 8px 16px;"
                            onclick="kirimKeputusan('ditolak_final')">
                            <i class="fas fa-times mr-1"></i> TOLAK BANDING FINAL
                        </button>
                        <button type="button" class="btn btn-sm font-sans px-3 btn-decision-mobile"
                            style="background: #10b981; color: #fff; font-size: 0.75rem; border-radius: 4px; border: none; font-weight: bold; padding: 8px 16px;"
                            onclick="kirimKeputusan('diterima')">
                            <i class="fas fa-check mr-1"></i> TERIMA BANDING
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function fotoUrl(path) {
    if (!path) return '#';
    if (path.startsWith('http://') || path.startsWith('https://')) return path;
    return `<?= base_url('uploads/laporan/') ?>/` + path;
}

function renderBadgeBukti(fotoPath, label) {
    if (!fotoPath) return '<span class="text-muted" style="font-size: 0.6rem;">-</span>';
    const url = fotoUrl(fotoPath);
    return `<a href="${url}" target="_blank" class="badge bg-secondary text-white font-sans" style="font-size: 0.6rem; padding: 3px 6px; font-weight: normal;"><i class="fas fa-image mr-1"></i>${label}</a>`;
}

function bukaModalTinjau(data) {
    const form = document.getElementById('formKeputusan');
    form.action = `<?= base_url('superadmin/banding/putuskan') ?>/` + data.laporan_id;

    // Set Data Kreator
    document.getElementById('mNamaKreator').textContent = data.kreator ? data.kreator.nama : data.nama_lengkap;
    document.getElementById('mUidKreator').textContent = data.kreator ? data.kreator.id_game : '-';
    document.getElementById('mWaktuSubmit').textContent = 'Dikirim: ' + data.created_at;

    // Platform Badge
    const pBadge = document.getElementById('mPlatformBadge');
    if (data.platform === 'youtube') {
        pBadge.innerHTML = '<span class="badge bg-danger font-sans" style="font-size: 0.65rem;">YOUTUBE</span>';
    } else {
        pBadge.innerHTML = '<span class="badge bg-dark border border-secondary font-sans" style="font-size: 0.65rem;">TIKTOK</span>';
    }

    // Metrik
    document.getElementById('mViewsVideo').textContent = (parseInt(data.total_views_video) || 0).toLocaleString() + ' Views';
    document.getElementById('mJumlahVideo').textContent = (data.jumlah_video || 0) + ' Vids';
    document.getElementById('mBuktiVideo').innerHTML = renderBadgeBukti(data.foto_views_konten, 'BUKTI');

    document.getElementById('mViewsShorts').textContent = (parseInt(data.views_shorts) || 0).toLocaleString() + ' Views';
    document.getElementById('mJumlahShorts').textContent = (data.jumlah_shorts || 0) + ' Shorts';
    document.getElementById('mBuktiShorts').innerHTML = renderBadgeBukti(data.foto_views_shorts, 'BUKTI');

    document.getElementById('mViewsLive').textContent = (parseInt(data.total_views_live) || 0).toLocaleString() + ' Views';
    document.getElementById('mJumlahLive').textContent = (data.jumlah_live || 0) + ' Sessions';
    document.getElementById('mBuktiLive').innerHTML = renderBadgeBukti(data.foto_views_livestream, 'BUKTI');

    document.getElementById('mPeakCcv').textContent = (parseInt(data.penonton_puncak_live) || 0).toLocaleString();
    document.getElementById('mBuktiCcv').innerHTML = renderBadgeBukti(data.foto_penonton_puncak_live, 'CCV');

    // Comparison Alasan
    document.getElementById('mPesanAdmin').textContent = data.pesan_admin ? data.pesan_admin : 'Tidak ada pesan penolakan dari admin.';
    document.getElementById('mAlasanBanding').textContent = data.alasan_banding ? data.alasan_banding : '-';

    // Toggle Form / Riwayat Selesai
    const sectionForm = document.getElementById('sectionFormKeputusan');
    const sectionRiwayat = document.getElementById('sectionRiwayatKeputusan');
    const footerAksi = document.getElementById('footerAksiKeputusan');

    if (data.status_banding === 'menunggu') {
        sectionForm.classList.remove('d-none');
        sectionRiwayat.classList.add('d-none');
        footerAksi.style.setProperty('display', 'flex', 'important');
        const ta = document.getElementById('catatanSuperadmin');
        ta.value = '';
        ta.classList.remove('shake-error');
        ta.style.borderColor = '';
        ta.style.boxShadow = '';
        const pw = document.getElementById('pesanWajibDiisi');
        if (pw) { pw.classList.add('d-none'); pw.style.display = ''; }
    } else {
        sectionForm.classList.add('d-none');
        sectionRiwayat.classList.remove('d-none');
        footerAksi.style.setProperty('display', 'none', 'important');
        document.getElementById('mCatatanSuperadminSelesai').textContent = data.catatan_superadmin ? data.catatan_superadmin : '-';
    }

    $('#modalTinjauBanding').modal('show');
}

function kirimKeputusan(keputusan) {
    const catatanInput = document.getElementById('catatanSuperadmin');
    const catatan = catatanInput.value.trim();

    const pesanWajib = document.getElementById('pesanWajibDiisi');

    if (!catatan) {
        // Tampilkan pesan inline wajib diisi
        if (pesanWajib) {
            pesanWajib.classList.remove('d-none');
            pesanWajib.style.display = 'flex';
        }

        // Efek shake + border merah pada textarea
        catatanInput.classList.remove('shake-error');
        void catatanInput.offsetWidth; // reflow agar animasi ulang
        catatanInput.classList.add('shake-error');
        catatanInput.addEventListener('animationend', () => {
            catatanInput.classList.remove('shake-error');
        }, { once: true });

        // Sembunyikan pesan saat user mulai mengetik
        catatanInput.addEventListener('input', function hidePesan() {
            if (this.value.trim()) {
                if (pesanWajib) {
                    pesanWajib.classList.add('d-none');
                    pesanWajib.style.display = '';
                }
                catatanInput.removeEventListener('input', hidePesan);
            }
        });

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'CATATAN KEPUTUSAN KOSONG',
                html: `<div style="font-size:0.85rem; color:#d1d5db; line-height:1.6;">
                            Kolom <strong style="color:#f59e0b;">Catatan Keputusan Super Admin</strong> wajib diisi sebelum mengambil keputusan.<br>
                            <span style="color:#6b7280; font-size:0.78rem;">Tuliskan alasan atau catatan keputusan Anda secara jelas.</span>
                       </div>`,
                icon: 'warning',
                background: '#0f172a',
                color: '#fff',
                confirmButtonText: '<i class="fas fa-pen mr-1"></i> ISI SEKARANG',
                customClass: {
                    popup: 'swal-tactical',
                    title: 'swal-tactical-title',
                    htmlContainer: 'swal-tactical-text',
                    confirmButton: 'swal-tactical-btn-confirm'
                },
                buttonsStyling: false
            }).then(() => {
                catatanInput.focus();
            });
        } else {
            alert('Mohon isi Catatan Keputusan Super Admin (Review) terlebih dahulu.');
            catatanInput.focus();
        }
        return;
    }

    // Sembunyikan pesan jika catatan sudah terisi
    if (pesanWajib) {
        pesanWajib.classList.add('d-none');
        pesanWajib.style.display = '';
    }

    // Popup konfirmasi sebelum submit
    if (typeof Swal !== 'undefined') {
        const isDiterima = keputusan === 'diterima';
        Swal.fire({
            title: isDiterima ? '⚖️ TERIMA BANDING?' : '⚖️ TOLAK BANDING FINAL?',
            html: isDiterima
                ? `<div style="font-size:0.88rem; line-height:1.6; color:#d1d5db;">
                        Anda akan <strong style="color:#10b981;">MENERIMA</strong> pengajuan banding kreator ini.<br>
                        <span style="color:#6b7280; font-size:0.8rem;">Laporan akan disetujui dan kreator akan mendapat notifikasi.</span>
                   </div>`
                : `<div style="font-size:0.88rem; line-height:1.6; color:#d1d5db;">
                        Anda akan <strong style="color:#ef4444;">MENOLAK SECARA FINAL</strong> pengajuan banding kreator ini.<br>
                        <span style="color:#6b7280; font-size:0.8rem;">Keputusan bersifat final dan tidak dapat dibatalkan.</span>
                   </div>`,
            icon: isDiterima ? 'question' : 'warning',
            background: '#0f172a',
            color: '#fff',
            showCancelButton: true,
            confirmButtonText: isDiterima
                ? '<i class="fas fa-check mr-1"></i> YA, TERIMA BANDING'
                : '<i class="fas fa-times mr-1"></i> YA, TOLAK FINAL',
            cancelButtonText: '<i class="fas fa-arrow-left mr-1"></i> BATAL',
            customClass: {
                popup: 'swal-tactical',
                title: 'swal-tactical-title',
                htmlContainer: 'swal-tactical-text',
                confirmButton: isDiterima ? 'swal-tactical-btn-success' : 'swal-tactical-btn-confirm',
                cancelButton: 'swal-tactical-btn-cancel'
            },
            buttonsStyling: false,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('inputKeputusan').value = keputusan;
                document.getElementById('formKeputusan').submit();
            }
        });
    } else {
        const label = keputusan === 'diterima' ? 'TERIMA' : 'TOLAK FINAL';
        if (confirm(`Apakah Anda yakin ingin ${label} banding ini? Keputusan bersifat final.`)) {
            document.getElementById('inputKeputusan').value = keputusan;
            document.getElementById('formKeputusan').submit();
        }
    }
}
</script>
