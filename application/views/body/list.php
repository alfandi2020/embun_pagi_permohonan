      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        <?php if ($this->uri->segment(3)== true) {?>
        <div class="container-xxl flex-grow-1 container-p-y">
          <div class="row mb-3">
            <div class="col-md-5">
              <a href="<?= base_url('permohonan/list2') ?>" class="btn btn-warning"><i
                  class="tf-icons bx bx-chevron-left"></i> Back </a> &nbsp;&nbsp;&nbsp;&nbsp;
              <?php if($data[0]->status_permohonan_atasan != 'Approved') { ?>
              <?php $status_approve = $this->session->userdata('filterPermohonan') == 'waiting' ? 'confirm_admin' : 'confirm_atasan' ?>
              <a href="<?= base_url('permohonan/status/'.$this->uri->segment(3).'/Approved'.'/'.$status_approve) ?>"
                class="btn btn-primary approve-confirm"><i class="tf-icons bx bx-task"></i> Approved
              </a>&nbsp;&nbsp;&nbsp;&nbsp;
              <button type="button" id="<?= $this->uri->segment(3) ?>" class="btn btn-danger reject-confirm"><i
                  class="tf-icons bx bx-task-x"></i> Reject </button>
                <?php } ?>
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
                      <tr style="background-color: rgba(105,108,255,.1);color:black;">
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
          <?php if($data[0]->status_permohonan_atasan == 'Approved') {?>
            <div class="row mt-5">
              <div class="col-md-12">
                <div class="card">
                  <h5 class="card-header">Timeline Permohonan</h5>
                  <div class="card-body">
                    <ul class="timeline timeline-dashed mt-3">
                      <li class="timeline-item timeline-item-primary mb-4">
                        <span class="timeline-indicator timeline-indicator-primary">
                          <i class="bx bx-paper-plane"></i>
                        </span>
                        <div class="timeline-event">
                          <div class="timeline-header border-bottom mb-3">
                            <h6 class="mb-0">Get on the flight</h6>
                            <small class="text-muted">3rd October</small>
                          </div>
                          <div class="d-flex justify-content-between flex-wrap mb-2">
                            <div>
                              <span>Charles de Gaulle Airport, Paris</span>
                              <i class="bx bx-right-arrow-alt scaleX-n1-rtl mx-3"></i>
                              <span>Heathrow Airport, London</span>
                            </div>
                            <div>
                              <span>6:30 AM</span>
                            </div>
                          </div>
                          <a href="javascript:void(0)">
                            <i class="bx bx-link"></i>
                            bookingCard.pdf
                          </a>
                        </div>
                      </li>
                      <li class="timeline-item timeline-item-success mb-4">
                        <span class="timeline-indicator timeline-indicator-success">
                          <i class="bx bx-paint"></i>
                        </span>
                        <div class="timeline-event">
                          <div class="timeline-header mb-sm-0 mb-3">
                            <h6 class="mb-0">Design Review</h6>
                            <small class="text-muted">4th October</small>
                          </div>
                          <p>
                            Weekly review of freshly prepared design for our new
                            application.
                          </p>
                          <div class="d-flex justify-content-between">
                            <h6>New Application</h6>
                            <div class="d-flex">
                              <div class="avatar avatar-xs me-2">
                                <img src="../../assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                              </div>
                              <div class="avatar avatar-xs">
                                <img src="../../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="timeline-item timeline-item-danger mb-4">
                        <span class="timeline-indicator timeline-indicator-danger">
                          <i class="bx bx-shopping-bag"></i>
                        </span>
                        <div class="timeline-event">
                          <div class="d-flex flex-sm-row flex-column">
                            <img src="../../assets/img/elements/16.jpg" class="rounded mb-sm-0 mb-3 me-3" alt="Shoe img"
                              height="62" width="62" />
                            <div>
                              <div class="timeline-header flex-wrap mb-2">
                                <h6 class="mb-0">Sold Puma POPX Blue Color</h6>
                                <small class="text-muted">5th October</small>
                              </div>
                              <p>
                                PUMA presents the latest shoes from its collection. Light &
                                comfortable made with highly durable material.
                              </p>
                            </div>
                          </div>
                          <div class="d-flex justify-content-between flex-wrap flex-sm-row flex-column text-center">
                            <div class="mb-sm-0 mb-2">
                              <p class="mb-0">Customer</p>
                              <span class="text-muted">Micheal Scott</span>
                            </div>
                            <div class="mb-sm-0 mb-2">
                              <p class="mb-0">Price</p>
                              <span class="text-muted">$375.00</span>
                            </div>
                            <div>
                              <p class="mb-0">Quantity</p>
                              <span class="text-muted">1</span>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="timeline-item timeline-item-info mb-4">
                        <span class="timeline-indicator timeline-indicator-info">
                          <i class="bx bx-user-circle"></i>
                        </span>
                        <div class="timeline-event">
                          <div class="timeline-header">
                            <h6 class="mb-0">Interview Schedule</h6>
                            <small class="text-muted">6th October</small>
                          </div>
                          <p>
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                            Possimus quos, voluptates voluptas rem veniam expedita.
                          </p>
                          <hr />
                          <div class="d-flex justify-content-between flex-wrap gap-2">
                            <div class="d-flex flex-wrap">
                              <div class="avatar me-3">
                                <img src="../../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle" />
                              </div>
                              <div>
                                <p class="mb-0">Rebecca Godman</p>
                                <span class="text-muted">Javascript Developer</span>
                              </div>
                            </div>
                            <div class="d-flex flex-wrap align-items-centers cursor-pointer">
                              <i class="bx bx-message me-2"></i>
                              <i class="bx bx-phone-call"></i>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="timeline-item timeline-item-dark mb-4">
                        <span class="timeline-indicator timeline-indicator-dark">
                          <i class="bx bx-bell"></i>
                        </span>
                        <div class="timeline-event">
                          <div class="timeline-header">
                            <h6 class="mb-0">2 Notifications</h6>
                            <small class="text-muted">7th October</small>
                          </div>
                          <ul class="list-group list-group-flush">
                            <li
                              class="list-group-item d-flex justify-content-between align-items-center flex-wrap border-top-0 p-0">
                              <div class="d-flex flex-wrap align-items-center">
                                <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 my-3 me-2">
                                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                    title="Vinnie Mostowy" class="avatar avatar-xs pull-up">
                                    <img class="rounded-circle" src="../../assets/img/avatars/5.png" alt="Avatar" />
                                  </li>
                                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                    title="Allen Rieske" class="avatar avatar-xs pull-up">
                                    <img class="rounded-circle" src="../../assets/img/avatars/12.png" alt="Avatar" />
                                  </li>
                                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                    title="Julee Rossignol" class="avatar avatar-xs pull-up">
                                    <img class="rounded-circle" src="../../assets/img/avatars/6.png" alt="Avatar" />
                                  </li>
                                </ul>
                                <span>Commented on your post.</span>
                              </div>
                              <button class="btn btn-primary btn-sm my-sm-0 my-3">
                                View
                              </button>
                            </li>
                            <li
                              class="list-group-item d-flex justify-content-between align-items-center flex-wrap pb-0 px-0">
                              <div class="d-flex flex-sm-row flex-column align-items-center">
                                <img src="../../assets/img/avatars/4.png" class="rounded-circle me-3" alt="avatar"
                                  height="24" width="24" />
                                <div class="user-info">
                                  <p class="my-0">Dwight repaid you</p>
                                  <span class="text-muted">30 minutes ago</span>
                                </div>
                              </div>
                              <h5 class="mb-0">$20</h5>
                            </li>
                          </ul>
                        </div>
                      </li>
                      <li class="timeline-end-indicator">
                        <i class="bx bx-check-circle"></i>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        <?php } ?>

        </div>
        <?php }else{ ?>
        <div class="container-xxl flex-grow-1 container-p-y">
          <div class="row mb-3">
            <div class="col-md-5 col-sm-12">
              <a href="<?= base_url('permohonan/filter/waiting') ?>"
                class="btn btn-label-primary <?= $this->session->userdata('filterPermohonan') == 'waiting' ? 'active' : '' ?>">Waiting</a>&nbsp;&nbsp;
              <a href="<?= base_url('permohonan/filter/data_baru') ?>"
                class="btn btn-label-primary <?= $this->session->userdata('filterPermohonan') == 'data_baru' ? 'active' : '' ?>">Data
                Baru</a>&nbsp;&nbsp;
              <a href="<?= base_url('permohonan/filter/data_lama') ?>"
                class="btn btn-label-primary <?= $this->session->userdata('filterPermohonan') == 'data_lama' ? 'active' : '' ?>">Data
                lama</a>
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
                        <th>No</th>
                        <th width="200">Nama Pemohon</th>
                        <th>Nomor Pemohon</th>
                        <th width="200">Tanggal Permohonan</th>
                        <?php if($this->session->userdata('filterPermohonan') == 'data_baru' || $this->session->userdata('filterPermohonan') == 'data_lama'){ ?>
                        <th width="200">Status Admin</th>
                        <th width="200">Status Atasan</th>
                        <?php } ?>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
                <!-- <div class="row">
                    <div class="col-md-4 col-sm-6">
                      <span class="btn btn-warning"><i class="bx bx-check"></i></span> Approved
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4 col-sm-6">
                      <span class="btn btn-danger"><i class="bx bx-x-circle"></i></span> Rejected
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4 col-sm-6">
                      <span class="btn btn-primary"><i class="bx bx-check-circle"></i></span> Done
                    </div>
                </div> -->
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