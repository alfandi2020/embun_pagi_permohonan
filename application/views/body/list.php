      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        <?php if ($this->uri->segment(3)== true) {?>
        <div class="container-xxl flex-grow-1 container-p-y">
          <div class="row mb-3">
            <div class="col-md-5">
              <a href="<?= base_url('permohonan/list') ?>" class="btn btn-warning"><i class="tf-icons bx bx-chevron-left"></i> Back </a> &nbsp;&nbsp;&nbsp;&nbsp;
              <a href="<?= base_url('permohonan/status/'.$this->uri->segment(3).'/Approved') ?>" class="btn btn-primary approve-confirm"><i class="tf-icons bx bx-task"></i> Approved  </a>&nbsp;&nbsp;&nbsp;&nbsp;
              <button type="button" id="<?= $this->uri->segment(3) ?>" class="btn btn-danger reject-confirm"><i class="tf-icons bx bx-task-x"></i> Reject  </button>
            </div>
          </div>
          <div class="row">
            <!-- Form controls -->
            <div class="col-md-12">
              <div class="card mb-3">
                <div class="card-datatable table-responsive">
                  <table class="datatables-basic table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Isi Permohonan</th>
                        <th>Nominal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; foreach ($data as $x) {?>
                      <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $x->isi_permohonan ?></td>
                        <td>Rp.<?= number_format($x->nominal,0,'.','.') ?></td>
                      </tr>

                      <?php } ?>
                      <tr style="background-color: #fff6de;color:black;">
                        <td><?= $no ?></td>
                        <td>TOTAL</td>
                        <td>Rp.<?= number_format($total_nominal['nominal'],0,'.','.') ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>


        </div>
        <?php }else{ ?>
        <div class="container-xxl flex-grow-1 container-p-y">
          <div class="row mb-3">
            <div class="col-md-5">
              <a href="<?= base_url('permohonan/filter/waiting') ?>" class="btn btn-label-primary <?= $this->session->userdata('filterPermohonan') == 'waiting' ? 'active' : '' ?>">Waiting</a>&nbsp;&nbsp;&nbsp;&nbsp;
              <a href="<?= base_url('permohonan/filter/data_baru') ?>" class="btn btn-label-primary <?= $this->session->userdata('filterPermohonan') == 'data_baru' ? 'active' : '' ?>">Data Baru</a>&nbsp;&nbsp;&nbsp;&nbsp;
              <a href="<?= base_url('permohonan/filter/data_lama') ?>" class="btn btn-label-primary <?= $this->session->userdata('filterPermohonan') == 'data_lama' ? 'active' : '' ?>">Data lama</a>
            </div>
          </div>
          <div class="row">
            <!-- Form controls -->
            <div class="col-md-12">
              <div class="card mb-3">
                <div class="card-datatable table-responsive">
                  <table id="table_permohonan" class="datatables-basic table border-top">
                    <thead>
                      <tr>
                        <th>id</th>
                        <th>Nama</th>
                        <th>No Permohonan</th>
                        <th>Tanggal Permohonan</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>


        </div>
        <?php } ?>
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