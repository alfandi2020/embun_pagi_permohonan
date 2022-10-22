      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        <?php if ($this->uri->segment(3)== true) {?>
        <div class="container-xxl flex-grow-1 container-p-y">
          <!-- <div class="row mb-3">
            <div class="col-md-4">
              <a href="<?= base_url('permohonan/list') ?>" class="btn btn-warning"><i
                  class="tf-icons bx bx-chevron-left"></i> Back </a> &nbsp;&nbsp;&nbsp;&nbsp;
              <a href="<?= base_url('permohonan/status/'.$this->uri->segment(3).'/Approved') ?>"
                class="btn btn-primary approve-confirm"><i class="tf-icons bx bx-check"></i> Approved </a>
            </div>
          </div> -->
          <div class="row">
            <!-- Form controls -->
            <div class="col-md-12">
            <div class="card mb-4">
                   <h5 class="card-header">Add Permohonan Pengeluaran</h5>
                  <div class="card-body">
                    <div class="mb-3">
                      <div class="row">
                        <div class="col-md-8">
                        <label for="exampleFormControlInput1" class="form-label">Nama</label>
                            <input type="text" name="nama" value="<?= $data['nama'] ?>" class="form-control" id="exampleFormControlInput1"
                            />
                        </div>
                      </div>
                    </div>
                    <div class="mb-3">
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
                          <div class="col-md-3 mt-4">
                            <button id="add-permohonan" class="btn btn-primary"><i class="tf-icons bx bx-plus"></i></button>
                          </div>
                      </div>
                    </div>
                    <div id="permohonan-wrapper">
                    </div>
                    <div class="mb-3 text-center">
                    <!-- <label for="exampleFormControlInput1" class="form-label">Total Pengajuan</label> -->
                    <p>Total : Rp.0</p>
                    </div>
                    <div class="mb-3">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div>
            </div>
          </div>


        </div>
        <?php }else{ ?>
        <div class="container-xxl flex-grow-1 container-p-y">
          <div class="row mb-3">
            <div class="col-md-4">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewCCModal">
                Tambah User</button>
              <!-- <a href="<?= base_url('permohonan/filter/data_lama') ?>"
                class="btn btn-label-primary <?= $this->session->userdata('filterPermohonan') == 'data_lama' ? 'active' : '' ?>">Data
                lama</a> -->
            </div>
          </div>
          <div class="row">
            <!-- Form controls -->
            <div class="col-md-12">
              <div class="card mb-3">
                <div class="card-datatable table-responsive">
                  <table id="tabel-data" class="datatables-basic table border-top">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Level</th>
                        <th>Status Sekolah</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $x) { ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $x->nama ?></td>  
                        <td><?= $x->nama_level ?></td>
                        <td><?= $x->status_sekolah ?></td>
                        <td>
                          <form action="<?= base_url('user/status/'.$x->id_user) ?>" method="POST">
                            <label class="switch switch-primary">
                              <input type="checkbox" onchange="this.form.submit()" name="status" value="<?php if($x->status != 'Aktif')
                                {
                                  echo 'Aktif';
                                } ?>" class="switch-input" <?= $x->status == 'Aktif' ? 'checked' : 'unchecked' ?> />
                              <span class="switch-toggle-slider">
                                <span class="switch-on">
                                  <i class="bx bx-check"></i>
                                </span>
                                <span class="switch-off">
                                  <i class="bx bx-x"></i>
                                </span>
                              </span>
                              <span class="switch-label"><?= $x->status == 'Aktif' ? 'Aktif' : 'NonAktif' ?></span>
                            </label>
                          </form>
                        </td>
                        <td>
                          <a href="" class="btn btn-primary"><i class="bx bx-edit"></i></a>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
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
      <div class="modal fade" id="addNewCCModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
          <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="text-center mb-4">
                <h3>Tambah User</h3>
                <!-- <p>Add new card to complete payment</p> -->
              </div>
              <form id="addNewCCForm" class="row g-3" method="POST" action="<?= base_url('user') ?>">
              <input type="hidden" value="add" name="adduser">
                <div class="col-6">
                  <label class="form-label w-100" for="modalAddCard">Username</label>
                  <div class="input-group input-group-merge">
                    <input name="username" required class="form-control credit-card-mask" type="text" placeholder="Rani" />
                  </div>
                </div>
                <div class="col-6 col-md-6">
                  <label class="form-label" for="modalAddCardName">Nama</label>
                  <input type="text" required name="nama" id="modalAddCardName" class="form-control" placeholder="Rani001" />
                </div>
                <div class="col-12">
                  <label class="form-label" for="modalAddCardExpiryDate">Email</label>
                  <input type="text" name="email" class="form-control" placeholder="info@gmail.com" />
                </div>
                <div class="col-6 col-md-6">
                  <label class="form-label" for="modalAddCardCvv">Password</label>
                  <div class="input-group input-group-merge">
                    <input type="text"  required name="password" id="modalAddCardCvv" class="form-control cvv-code-mask" minlength="3"
                      placeholder="*****" />
                    <span class="input-group-text cursor-pointer" id="modalAddCardCvv2"><i
                        class="bx bx-check-shield text-muted" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Card Verification Value"></i></span>
                  </div>
                </div>
                <div class="col-6 col-md-6">
                  <label class="form-label" for="modalAddCardCvv">Konfirmasi Password</label>
                  <div class="input-group input-group-merge">
                    <input type="text" required name="password_konfirmasi" id="modalAddCardCvv" class="form-control cvv-code-mask" minlength="3"
                      placeholder="*****" />
                    <span class="input-group-text cursor-pointer" id="modalAddCardCvv2"><i
                        class="bx bx-check-shield text-muted" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Card Verification Value"></i></span>
                  </div>
                </div>
                <div id="msg"></div>
                <!-- <div class="alert alert-danger" role="alert">
                    Password harus sama
                </div> -->
                <div class="col-12">
                  <label class="form-label" for="modalAddCardCvv">Level</label>
                  <div class="input-group input-group-merge">
                    <select name="level" id="" class="form-control">
                      <option selected>Pilih Level</option>
                      <?php 
                      $d = $this->db->get_where('tb_level',['status' => 1])->result();
                      foreach($d as $x){ ?>
                        <option value="<?= $x->id ?>"><?= $x->nama ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>     
                  <div class="col-12">
                    <label class="form-label" for="modalAddCardCvv">Status Sekolah</label>
                    <div class="form-check">
                      <input name="status_sekolah" class="form-check-input" type="radio" value="TK" id="defaultRadio1" />
                      <label class="form-check-label" for="defaultRadio1">
                        TK
                      </label>
                    </div>
                    <div class="form-check">
                      <input name="status_sekolah" class="form-check-input" type="radio" value="SD" id="defaultRadio2"
                        />
                      <label class="form-check-label" for="defaultRadio2">
                        SD
                      </label>
                    </div>
                    <div class="form-check">
                      <input name="status_sekolah" class="form-check-input" type="radio" value="SMP" id="defaultRadio3"
                        />
                      <label class="form-check-label" for="defaultRadio3">
                        SMP
                      </label>
                    </div>
                  </div>
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Submit</button>
                  <button type="reset" class="btn btn-label-secondary btn-reset mt-3" data-bs-dismiss="modal"
                    aria-label="Close">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script>
          $(document).ready(function(){
            $(".alert").alert('close')
            $('input[name="password_konfirmasi"]').keyup(function(){
                  if ($('input[name="password"]').val() != $('input[name="password_konfirmasi"]').val()) {
                    // $('.alert').alert('show')
                    $("#msg").html("Password harus sama").css("color","red");

                  }else{
                    // $(".alert").hide();
                      $("#msg").html("").css("color","green");
                  }
            });
            // var pass = $('input[name="password"]').val();
            // var conf = $('input[name="password_konfirmasi"]').val();
            // if (pass == "" && conf == "") {
            //   $(".alert").hide()
            // }else if(pass != conf){
            //   $('.alert').alert('show')
            // }
          });

      //   function onChange() {
      //   var password = document.querySelector('input[name="password"]');
      //   var confirm = document.querySelector('input[name="password_konfirmasi"]');
      //   if (confirm.value === password.value) {
      //     // confirm.setCustomValidity('');
      //       $(".alert").hide()

      //   } else {
      //     // confirm.setCustomValidity('Passwords do not match');
      //     $('.alert').alert('show')
      //   }
      // }
      </script>