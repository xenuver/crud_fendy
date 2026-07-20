            <!-- Footer -->
            <footer class="sticky-footer" style="background: rgba(0, 0, 0, 0.5); color: #64748b; font-family: 'Orbitron', sans-serif; font-size: 0.7rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <div class="orbitron small mb-1" style="letter-spacing: 1px; color: #94a3b8; font-size: 0.65rem;">SISTEM MONITORING KREATOR BLOODSTRIKE</div>
                        <div class="orbitron small" style="letter-spacing: 1px; font-size: 0.75rem;">Copyright 2026 - Developed by <span class="text-danger fw-bold">Fendy A.K.A Kaiser</span></div>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top" style="background: var(--bs-red);">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background: #1e293b; color: #fff; border: 1px solid var(--bs-red); border-radius: 0;">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title orbitron-font small" id="exampleModalLabel">Konfirmasi Keluar</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body small-tactical">Pilih "LOGOUT" di bawah ini jika Anda ingin mengakhiri sesi akses intelijen saat ini.</div>
                <div class="modal-footer border-top-0">
                    <button class="btn btn-secondary btn-sm orbitron-font" type="button" data-dismiss="modal" style="border-radius: 0;">CANCEL</button>
                    <a class="btn btn-danger btn-sm orbitron-font" href="<?= base_url('logout') ?>" style="border-radius: 0; background: var(--bs-red);">LOGOUT_MIMINBS</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

    <script src="<?= base_url('assets/js/global-admin.js') ?>"></script>

</body>

</html>