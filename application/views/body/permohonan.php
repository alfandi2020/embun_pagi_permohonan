      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
          <div class="row">
            <!-- Form controls -->
            <form action="<?= base_url('permohonan/submit') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="1" name="row[]">
              <div class="col-md-12">
                <?= $this->session->flashdata('msg') ?>
                <div class="card mb-4">
                   <h5 class="card-header">Add Permohonan Pengeluaran</h5>
                  <div class="card-body">
                    <div class="mb-3">
                      <div class="row">
                        <div class="col-md-4">
                          <label for="exampleFormControlInput1" class="form-label">Nama</label>
                          <input type="text" name="nama" readonly value="<?= $this->session->userdata('nama') ?>" class="form-control" id="exampleFormControlInput1"
                          />
                        </div>
                        <div class="col-md-4">
                          <label for="exampleFormControlInput1" class="form-label">Tanggal</label>
                          <input type="text" readonly value="<?= date('Y-m-d H:i:s') ?>" class="form-control" id="exampleFormControlInput1"
                          />
                        </div>
                        <!-- <div class="col-md-4">
                          <label for="exampleFormControlInput1" class="form-label">Nama Admin</label>
                          <select name="admin" id="" class="form-control">
                            <option selected>Pilih Admin</option>
                            <?php
                              $this->db->where('level','Admin Approval');
                                $data = $this->db->get('users')->result();
                                foreach ($data as $x) { ?>
                              <option value="<?= $x->id ?>" > <?=  $x->nama?> </option>
                              <?php } ?>
                          </select>
                        </div> -->
                      </div>
                    </div>
                    <!-- <div class="mb-3">
                      <div class="row">
                          <div class="col-md-4">
                          <label for="exampleFormControlInput1" class="form-label">Isi Pengajuan</label>
                          <input required type="text" name="isi1" placeholder="Pengeluaran" class="form-control" id="exampleFormControlInput1"
                            />
                          </div>
                          <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label">Nominal</label>
                            <input required type="text" name="nominal1" id="rupiah" placeholder="1.000.000" class="form-control" id="exampleFormControlInput1"
                              />
                          </div>
                          <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label">File</label>
                            <input type="file" name="att1" class="form-control" id="exampleFormControlInput1"/>
                          </div>
                         
                      </div>
                    </div> -->
                    <div id="permohonan-wrapper">
                    </div>
                    <div class="mb-3 text-center">
                    <!-- <label for="exampleFormControlInput1" class="form-label">Total Pengajuan</label> -->
                    <!-- <p>Total : Rp.0</p> -->
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>&nbsp;&nbsp;&nbsp;
                      <div class="col-md-2">
                            <button id="add-permohonan" class="btn btn-warning"><i class="tf-icons bx bx-plus"></i> Tambah Item</button>
                        </div>
                    </div>
                   
                  </div>
                </div>
              </div>
            </form>
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

<div id="permohonanModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="post" id="sampel_form" class="form-horizontal form-label-left">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detil Contoh Uji</h4>
                </div>
                <div class="modal-body mdl-permohonanModal" style="overflow:hidden;">

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="permohonan_id" id="permohonan_id">
                    <?php
                    //$level = $this->session->userdata('level');
                    if ($level != 2 && $level != 22 ) {
                        //if ($this->session->userdata('filterPermohonan') === 'Belum_Dibayar') {
                            ?>
                             <input type="submit" name="action" value="Submit" class="btn btn-primary" id="submit_sampel_form"> 
                            <?php
                        }
                    //}
                    ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close </button>
                </div>
            </div>
        </form>
    </div>
</div>

          <!-- <div class="modal fade" id="permohonanModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Modal title</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Name</label>
                      <input type="text" id="nameWithTitle" class="form-control" placeholder="Enter Name">
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-0">
                      <label for="emailWithTitle" class="form-label">Email</label>
                      <input type="text" id="emailWithTitle" class="form-control" placeholder="xxxx@xxx.xx">
                    </div>
                    <div class="col mb-0">
                      <label for="dobWithTitle" class="form-label">DOB</label>
                      <input type="text" id="dobWithTitle" class="form-control" placeholder="DD / MM / YY">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div> -->