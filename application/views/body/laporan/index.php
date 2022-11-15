      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
          <div class="row">
            <!-- Form controls -->
            <div class="col-md-12">
              <div class="card mb-3">
                <div class="card-datatable table-responsive">
                    <table id="table_laporan" class="datatables-basic table border-top">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th width="200">Nama Pemohon</th>
                            <th>Nomor Pemohon</th>
                            <th width="200">Tanggal Permohonan</th>
                            <?php if($this->session->userdata('filterPermohonan') == 'permohonan_baru' || $this->session->userdata('filterPermohonan') == 'data_lama'){ ?>
                            <th width="200">Status Admin</th>
                            <th width="200">Status Atasan</th>
                            <?php } ?>
                            <th>Upload Bukti</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </div>
              </div>
            </div>
          </div>
  


        </div>
        <!-- / Content -->




        <!-- Footer -->
        <!-- <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
              <div class="mb-2 mb-md-0">
                © <script>
                  document.write(new Date().getFullYear())
                </script>
                , made with ❤️ by <a href="https://themeselection.com" target="_blank"
                  class="footer-link fw-bolder">ThemeSelection</a>
              </div>
              <div>

                <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                  target="_blank" class="footer-link me-4">Documentation</a>


                <a href="https://themeselection.com/support/" target="_blank"
                  class="footer-link d-none d-sm-inline-block">Support</a>

              </div>
            </div>
          </footer> -->
        <!-- / Footer -->


        <div class="content-backdrop fade"></div>
      </div>
      <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
      </div>



      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>


      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>

      </div>



