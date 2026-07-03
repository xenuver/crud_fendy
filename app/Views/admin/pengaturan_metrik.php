<div class="container-fluid py-4">

    <!-- HEADER STATUS -->
    <div class="d-flex align-items-center mb-4">
        <div class="bg-danger text-white px-3 py-1 orbitron small shadow-sm" style="clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);">
            Admin Settings
        </div>
        <div class="ml-2 text-secondary small orbitron" style="opacity: 0.8; letter-spacing: 1px;">
            Pengaturan Metrik Kelayakan & Akses Sistem
        </div>
    </div>

    <!-- PETUNJUK PENGGUNAAN -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-dark border-0 text-white shadow-sm" style="background: rgba(15, 23, 42, 0.6); border-left: 4px solid var(--bs-red) !important;">
                <h5 class="orbitron text-danger fw-bold mb-2"><i class="fas fa-exclamation-triangle"></i> PANDUAN PENGATURAN METRIK</h5>
                <p class="small text-secondary mb-0" style="line-height: 1.6;">
                    Pengaturan di bawah ini mengontrol kriteria kelayakan Tier/Pangkat untuk seluruh kreator di website ini. Setiap kali Anda mengubah metrik ini:
                    <br>1. Perhitungan pangkat pada <strong>Landing Page</strong> akan ter-update otomatis.
                    <br>2. Evaluasi pangkat para kreator berdasarkan <strong>4 laporan mingguan terakhir yang valid</strong> akan dikalkulasi ulang secara real-time.
                    <br>3. Harap masukkan nilai dalam bentuk angka bulat (integer) tanpa titik atau koma (misal: masukkan <code>40000</code> untuk 40 Ribu views).
                </p>
            </div>
        </div>
    </div>

    <form action="<?= base_url('admin/settings/update') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="row mb-4">
            <!-- TIER 1 (GOLD) -->
            <div class="col-lg-4 mb-4">
                <div class="hud-card h-100 shadow-lg" style="border-top: 4px solid #FFD700; background: rgba(15, 23, 42, 0.4); padding: 25px;">
                    <div class="text-center mb-4">
                        <i class="fas fa-crown fa-3x mb-3 text-warning" style="text-shadow: 0 0 15px rgba(255, 215, 0, 0.5);"></i>
                        <h4 class="orbitron text-white fw-bold">TIER 1 (GOLD)</h4>
                        <span class="text-muted small">Ambang Batas Tertinggi</span>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-secondary orbitron small fw-bold">TARGET MINIMAL CCV</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-warning"><i class="fas fa-users"></i></span>
                            <input type="number" name="tier1_ccv" class="form-control bg-dark text-white border-secondary orbitron" 
                                   value="<?= old('tier1_ccv', $settings['tier1_ccv']) ?>" min="0" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-secondary orbitron small fw-bold">VIEWS (YOUTUBE)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-danger"><i class="fab fa-youtube"></i></span>
                            <input type="number" name="tier1_yt" class="form-control bg-dark text-white border-secondary orbitron" 
                                   value="<?= old('tier1_yt', $settings['tier1_yt']) ?>" min="0" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-secondary orbitron small fw-bold">VIEWS (TIKTOK)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-info"><i class="fab fa-tiktok"></i></span>
                            <input type="number" name="tier1_tt" class="form-control bg-dark text-white border-secondary orbitron" 
                                   value="<?= old('tier1_tt', $settings['tier1_tt']) ?>" min="0" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TIER 2 (SILVER) -->
            <div class="col-lg-4 mb-4">
                <div class="hud-card h-100 shadow-lg" style="border-top: 4px solid #C0C0C0; background: rgba(15, 23, 42, 0.4); padding: 25px;">
                    <div class="text-center mb-4">
                        <i class="fas fa-medal fa-3x mb-3 text-secondary" style="text-shadow: 0 0 15px rgba(192, 192, 192, 0.4);"></i>
                        <h4 class="orbitron text-white fw-bold">TIER 2 (SILVER)</h4>
                        <span class="text-muted small">Ambang Batas Menengah</span>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-secondary orbitron small fw-bold">TARGET MINIMAL CCV</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-secondary"><i class="fas fa-users"></i></span>
                            <input type="number" name="tier2_ccv" class="form-control bg-dark text-white border-secondary orbitron" 
                                   value="<?= old('tier2_ccv', $settings['tier2_ccv']) ?>" min="0" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-secondary orbitron small fw-bold">VIEWS (YOUTUBE)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-danger"><i class="fab fa-youtube"></i></span>
                            <input type="number" name="tier2_yt" class="form-control bg-dark text-white border-secondary orbitron" 
                                   value="<?= old('tier2_yt', $settings['tier2_yt']) ?>" min="0" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-secondary orbitron small fw-bold">VIEWS (TIKTOK)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-info"><i class="fab fa-tiktok"></i></span>
                            <input type="number" name="tier2_tt" class="form-control bg-dark text-white border-secondary orbitron" 
                                   value="<?= old('tier2_tt', $settings['tier2_tt']) ?>" min="0" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TIER 3 (BRONZE) -->
            <div class="col-lg-4 mb-4">
                <div class="hud-card h-100 shadow-lg" style="border-top: 4px solid #CD7F32; background: rgba(15, 23, 42, 0.4); padding: 25px;">
                    <div class="text-center mb-4">
                        <i class="fas fa-medal fa-3x mb-3" style="color: #CD7F32; text-shadow: 0 0 15px rgba(205, 127, 50, 0.3);"></i>
                        <h4 class="orbitron text-white fw-bold">TIER 3 (BRONZE)</h4>
                        <span class="text-muted small">Ambang Batas Terendah</span>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-secondary orbitron small fw-bold">TARGET MINIMAL CCV</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary" style="color: #CD7F32;"><i class="fas fa-users"></i></span>
                            <input type="number" name="tier3_ccv" class="form-control bg-dark text-white border-secondary orbitron" 
                                   value="<?= old('tier3_ccv', $settings['tier3_ccv']) ?>" min="0" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-secondary orbitron small fw-bold">VIEWS (YOUTUBE)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-danger"><i class="fab fa-youtube"></i></span>
                            <input type="number" name="tier3_yt" class="form-control bg-dark text-white border-secondary orbitron" 
                                   value="<?= old('tier3_yt', $settings['tier3_yt']) ?>" min="0" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-secondary orbitron small fw-bold">VIEWS (TIKTOK)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-info"><i class="fab fa-tiktok"></i></span>
                            <input type="number" name="tier3_tt" class="form-control bg-dark text-white border-secondary orbitron" 
                                   value="<?= old('tier3_tt', $settings['tier3_tt']) ?>" min="0" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BUTTONS -->
        <div class="row mb-5">
            <div class="col-12 text-md-right">
                <a href="<?= base_url('admin') ?>" class="btn btn-outline-light orbitron px-4 rounded-0 mr-2"><i class="fas fa-times-circle mr-1"></i> BATAL</a>
                <button type="submit" class="btn btn-danger orbitron px-5 rounded-0" style="background-color: var(--bs-red); border: 1px solid #fff;">
                    <i class="fas fa-save mr-1"></i> SIMPAN PERUBAHAN
                </button>
            </div>
        </div>
    </form>
</div>
