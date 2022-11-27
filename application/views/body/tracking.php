      <!-- Content wrapper -->
      <div class="content-wrapper">


        <div class="container-xxl flex-grow-1 container-p-y">
          <!-- <div class="row mb-3">
            <div class="col-md-5 col-sm-12">
              <?php if($this->session->userdata('level') != 1){ ?>
              <a href="<?= base_url('permohonan/filter/permohonan_baru') ?>"
                class="btn btn-label-primary <?= $this->session->userdata('filterPermohonan') == 'permohonan_baru' ? 'active' : '' ?>">Permohonan Baru</a>&nbsp;&nbsp;
                <?php } ?>
              <?php if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 3){ ?>
              <a href="<?= base_url('permohonan/filter/permohonan_baru') ?>"
                class="btn btn-label-primary <?= $this->session->userdata('filterPermohonan') == 'permohonan_baru' ? 'active' : '' ?>">Permohonan Dalam Proses</a>&nbsp;&nbsp;
                <?php } ?>


              <?php if($this->session->userdata('level') == 2){ ?>
              <a href="<?= base_url('permohonan/filter/permohonan_selesai') ?>"
                class="btn btn-label-primary <?= $this->session->userdata('filterPermohonan') == 'permohonan_selesai' ? 'active' : '' ?>">
                Upload Bukti</a>&nbsp;&nbsp;
                <?php } ?>
            </div>
          </div> -->
          <div class="row">
            <!-- Form controls -->
            <div class="col-md-12">
              <div class="card mb-3" style="background-color:#f5f5f9;">
                <div class="card-datatable table-responsive">
                  <div class="container row mt-2">
                    <div class="col-md-3">
                      <form action="<?= base_url('permohonan/filter_sekolah2') ?>" method="POST">
                        <label>Status Sekolah</label>
                        <select onchange="form.submit()" name="sekolah" id="" class="form-control">
                          <option value="">Pilih Sekolah</option>
                          <option <?= $this->session->userdata('filterSekolah') == 'TK' ? 'selected' : '' ?> value="TK">
                            TK </option>
                          <option <?= $this->session->userdata('filterSekolah') == 'SD' ? 'selected' : '' ?> value="SD">
                            SD</option>
                          <option <?= $this->session->userdata('filterSekolah') == 'SMP' ? 'selected' : '' ?>
                            value="SMP">SMP</option>
                          <option <?= $this->session->userdata('filterSekolah') == 'SMA' ? 'selected' : '' ?>
                            value="SMA">SMA</option>
                        </select>
                      </form>
                    </div>
                    <div class="col-md-2">
                      <a href="<?= base_url('permohonan/reset_sekolah2') ?>" class="btn btn-warning mt-4">Reset</a>
                    </div>
                    <!-- <div class="col-md-3">
                    <label>Search</label>
                    <input type="text" class="form-control">
                  </div>
                  <div class="col-md-2">
                    <a href="<?= base_url('permohonan/reset_sekolah') ?>" class="btn btn-warning mt-4">Search</a>
                  </div> -->
                  </div>
                  <div class="row container">
                    <div class="col-md">
                      <div id="accordionIcon" class="accordion mt-3 accordion-without-arrow">
                        <?php foreach ($track as $x) { 
                            if ($x->no_permohonan == null) {
                              $color = 'warning';
                            }else{
                              $color = 'primary';
                            }
                        ?>
                        <div class="accordion-item card">
                          <h2 class="accordion-header text-body d-flex justify-content-between" id="accordionIconOne">
                            <button type="button" class="btn btn-label-<?= $color ?> accordion-button collapsed"
                              data-bs-toggle="collapse" data-bs-target="#accordionIcon-<?= $x->id ?>"
                              aria-controls="accordionIcon-1">
                              No Pemohon : <?= $x->no_permohonan ==  null ? 0 : $x->no_permohonan ?> <i
                                class='bx bx-right-arrow-alt'></i> Nama Pemohon : <?= $x->nama_pemohon ?> -
                              <?= date('d M Y',strtotime($x->tgl_permohonan)) ?>
                            </button>
                          </h2>
                          <div id="accordionIcon-<?= $x->id ?>" class="collapse"
                            data-bs-parent="#accordionIcon">
                            <div class="accordion-body" style="background-color: #f5f5f9;">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="">
                                    <h5 class="card-header">Progress Permohonan</h5>
                                    <div class="card-body">
                                      <ul class="timeline timeline-dashed mt-3">
                                        <?php 
                                          $this->db->where('unik',$x->unik);
                                          $datax = $this->db->get('tb_atasan')->result();
                                        ?>
                                        <li class="timeline-item timeline-item-success mb-4">
                                          <span class="timeline-indicator timeline-indicator-primary">
                                            <i class="bx bx-paper-plane"></i>
                                          </span>
                                          <div class="timeline-event">
                                            <div class="timeline-header border-bottom mb-3">
                                              <b class="mb-0">Status Admin Filter</b>
                                            </div>
                                            <?php 
                                            $no = 1;
                                            // foreach($datax as $x) { 
                                              if ($x->status_permohonan == 'Approved') {
                                                $color = '#1abc9c';
                                              }else if ($x->status_permohonan == 'Rejected') {
                                                $color = '#e74c3c';
                                              }else{
                                                $color ='';
                                              }
                                              ?>
                                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                              <div>
                                                <span>Admin Filter</span>
                                                <i class="bx bx-right-arrow-alt scaleX-n1-rtl mx-3"></i>
                                                <span><?= $x->nama_admin ?></span>
                                              </div>
                                              <div>
                                                <span><?= date('d-M-Y H:i:s',strtotime($x->date_created)) ?></span>
                                              </div>
                                            </div>
                                            <b style="color: <?= $color ?>;"><?= $x->status_permohonan ?></b> <br>
                                            <?= $x->status_permohonan == 'Rejected' ? 'Keterangan : '. '<b>' .$x->keterangan.'</b>' : '' ?>
                                            <hr>
                                            <?php //} ?>
                                   
                                          </div>
                                        </li>

                                        <li class="timeline-end-indicator">
                                          <i class="bx bx-check-circle"></i>
                                        </li>
                                      </ul>
                                    </div>
                                    <?php if($x->no_permohonan == true) { ?>
                                    <div class="card-body">
                                      <ul class="timeline timeline-dashed mt-3">
                                        <?php 
                                          $this->db->where('unik',$x->unik);
                                          $datax = $this->db->get('tb_atasan')->result();
                                        ?>
                                        <li class="timeline-item timeline-item-primary mb-4">
                                          <span class="timeline-indicator timeline-indicator-primary">
                                            <i class="bx bx-paper-plane"></i>
                                          </span>
                                          <div class="timeline-event">
                                            <div class="timeline-header border-bottom mb-3">
                                              <b class="mb-0">Admin Approved</b>
                                            </div>
                                            <?php 
                                            $no = 1;
                                            foreach($datax as $xx) { 
                                              if ($xx->status == 'Approved') {
                                                $color = '#1abc9c';
                                              }else if ($xx->status == 'Rejected') {
                                                $color = '#e74c3c';
                                              }else{
                                                $color ='';
                                              }
                                              ?>
                                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                              <div>
                                                <span>Admin <?= $no++; ?></span>
                                                <i class="bx bx-right-arrow-alt scaleX-n1-rtl mx-3"></i>
                                                <span><?= $xx->nama ?></span>
                                              </div>
                                              <div>
                                                <span><?= date('d-M-Y H:i:s',strtotime($xx->date_created)) ?></span>
                                              </div>
                                            </div>
                                            <b style="color: <?= $color ?>;"><?= $xx->status ?></b> <br>
                                            <?= $xx->status == 'Rejected' ? 'Keterangan : '. '<b>' .$xx->keterangan.'</b>' : '' ?>
                                            <hr>
                                            <?php } ?>
                                   
                                          </div>
                                        </li>

                                        <li class="timeline-end-indicator">
                                          <i class="bx bx-check-circle"></i>
                                        </li>
                                      </ul>
                                    </div>
                                    <?php } ?>
                                    <?php if($x->status_bayar == 'Sudah Dibayar') { ?>
                                    <div class="card-body">
                                      <ul class="timeline timeline-dashed mt-3">
                                        <?php 
                                          // $this->db->where('unik',$x->unik);
                                          // $datax = $this->db->get('tb_atasan')->result();
                                        ?>
                                        <li class="timeline-item timeline-item-success mb-4">
                                          <span class="timeline-indicator timeline-indicator-primary">
                                            <i class="bx bx-paper-plane"></i>
                                          </span>
                                          <div class="timeline-event">
                                            <div class="timeline-header border-bottom mb-3">
                                              <b class="mb-0">Status Admin Filter</b>
                                            </div>
                                            <?php 
                                            $no = 1;
                                            // foreach($datax as $x) { 
                                              if ($x->status_permohonan == 'Approved') {
                                                $color = '#1abc9c';
                                              }else if ($x->status_permohonan == 'Rejected') {
                                                $color = '#e74c3c';
                                              }else{
                                                $color ='';
                                              }
                                              ?>
                                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                              <div>
                                                <span>File Upload Bukti Transfer</span>
                                                <i class="bx bx-right-arrow-alt scaleX-n1-rtl mx-3"></i>
                                                <a download href="<?= base_url('upload/bukti_bayar/'.$x->file_bukti_bayar) ?>"><?= $x->file_bukti_bayar ?></a>
                                              </div>
                                              <div>
                                                <span><?= date('d-M-Y H:i:s',strtotime($x->date_created)) ?></span>
                                              </div>
                                            </div>
                                            <!-- <b style="color: <?= $color ?>;"><?= $x->status_bayar ?></b> <br> -->
                                            <?= $x->status_bayar == 'Sudah Dibayar' ? 'Status : '. '<b>' .$x->status_bayar.'</b>' : '' ?>
                                            <hr>
                                            <?php //} ?>
                                   
                                          </div>
                                        </li>

                                        <li class="timeline-end-indicator">
                                          <i class="bx bx-check-circle"></i>
                                        </li>
                                      </ul>
                                    </div>
                                    <?php } ?>
                                  </div>
                                </div>
                              </div>
                              <!-- <div class="row overflow-hidden">
                                <div class="col-12">
                                  <ul class="timeline timeline-center mt-5">
                                    <li class="timeline-item mb-md-4 mb-5">
                                      <span class="timeline-indicator timeline-indicator-primary" data-aos="zoom-in"
                                        data-aos-delay="200">
                                        <i class="bx bx-paint"></i>
                                      </span>
                                      <div class="timeline-event card p-0" data-aos="fade-right">
                                        <div
                                          class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                          <h6 class="card-title mb-0">Status Admin Filter</h6>
                                          <div class="meta">
                                            <span class="badge rounded-pill bg-label-primary">Approved</span>
                                          </div>
                                        </div>
                                        <div class="card-body">
                                          <p>
                                              Alfandi
                                          </p>
                                        </div>
                                        <div class="timeline-event-time">1st January</div>
                                      </div>
                                    </li>
                                    <li class="timeline-item mb-md-4 mb-5">
                                      <span class="timeline-indicator timeline-indicator-danger" data-aos="zoom-in"
                                        data-aos-delay="200">
                                        <i class="bx bx-line-chart"></i>
                                      </span>

                                      <div class="timeline-event card p-0" data-aos="fade-right">
                                        <h6 class="card-header
                                         ">Financial Reports</h6>

                                        <div class="card-body">
                                          <p class="mb-2">Click the button below to read financial reports</p>
                                          <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExample" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            Show Report
                                          </button>
                                          <div class="collapse" id="collapseExample">
                                            <ul class="list-group list-group-flush mt-3">
                                              <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                <span>Last Years's Profit : <strong>$20000</strong></span>
                                                <i class="bx bx-share-alt cursor-pointer"></i>
                                              </li>
                                              <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                <span> This Years's Profit : <strong>$25000</strong></span>
                                                <i class="bx bx-share-alt cursor-pointer"></i>
                                              </li>
                                              <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                <span> Last Years's Commission : <strong>$5000</strong></span>
                                                <i class="bx bx-share-alt cursor-pointer"></i>
                                              </li>
                                              <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                <span> This Years's Commission : <strong>$7000</strong></span>
                                                <i class="bx bx-share-alt cursor-pointer"></i>
                                              </li>
                                              <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                <span>
                                                  This Years's Total Balance : <strong>$70000</strong></span>
                                                <i class="bx bx-share-alt cursor-pointer"></i>
                                              </li>
                                            </ul>
                                          </div>
                                        </div>
                                        <div class="timeline-event-time">5th January</div>
                                      </div>
                                    </li>
                                    <li class="timeline-item mb-md-4 mb-5 timeline-item-left">
                                      <span class="timeline-indicator timeline-indicator-primary" data-aos="zoom-in"
                                        data-aos-delay="200">
                                        <i class="bx bx-dumbbell"></i>
                                      </span>
                                      <div class="timeline-event card p-0" data-aos="fade-right">
                                        <div class="card-header border-0 d-flex justify-content-between">
                                          <h6 class="card-title mb-0">Gym Program</h6>
                                          <span class="text-muted">5:00 - 6:10AM</span>
                                        </div>
                                        <div class="card-body pb-3 pt-0">
                                          <div class="hours mb-2">
                                            <i class="bx bx-time"></i>
                                            <span>1.1 Hours</span>
                                            <i class="bx bx-transfer mx-2"></i>
                                            <span>Weekly</span>
                                          </div>
                                          <div class="location">
                                            <i class="bx bx-map"></i>
                                            <span class="align-middle">Rock's Gym</span>
                                          </div>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between">
                                          <div class="tags">
                                            <span class="badge rounded-pill bg-label-danger">Gym</span>
                                            <span class="badge rounded-pill bg-label-info">Power</span>
                                          </div>
                                          <div>
                                            <i class="bx bx-dots-vertical-rounded cursor-pointer"></i>
                                          </div>
                                        </div>
                                        <div class="timeline-event-time">15th January</div>
                                      </div>
                                    </li>
                                    <li class="timeline-item mb-md-4 mb-5">
                                      <span class="timeline-indicator timeline-indicator-success" data-aos="zoom-in"
                                        data-aos-delay="200">
                                        <i class="bx bx-dollar"></i>
                                      </span>
                                      <div class="timeline-event card p-0" data-aos="fade-right">
                                        <h6 class="card-header">General Reserve</h6>
                                        <div class="card-body">
                                          <ul class="list-unstyled">
                                            <li
                                              class="d-flex justify-content-start align-items-center text-success mb-3">
                                              <i class="bx bx-dollar bx-sm me-3"></i>
                                              <div class="ps-3 border-start">
                                                <small class="text-muted mb-1">Cash</small>
                                                <h5 class="mb-0">$500</h5>
                                              </div>
                                            </li>
                                            <li class="d-flex justify-content-start align-items-center text-info mb-3">
                                              <i class="bx bx-credit-card bx-sm me-3"></i>
                                              <div class="ps-3 border-start">
                                                <small class="text-muted mb-1">Credit Card</small>
                                                <h5 class="mb-0">$5000</h5>
                                              </div>
                                            </li>
                                            <li class="d-flex justify-content-start align-items-center text-primary">
                                              <i class="bx bx-line-chart bx-sm me-3"></i>
                                              <div class="ps-3 border-start">
                                                <small class="text-muted mb-1">Investments</small>
                                                <h5 class="mb-0">$300</h5>
                                              </div>
                                            </li>
                                          </ul>
                                        </div>
                                        <div class="timeline-event-time">16th January</div>
                                      </div>
                                    </li>
                                    <li class="timeline-item mb-md-4 mb-5">
                                      <span class="timeline-indicator timeline-indicator-danger" data-aos="zoom-in"
                                        data-aos-delay="200">
                                        <i class="bx bx-server"></i>
                                      </span>
                                      <div class="timeline-event card p-0" data-aos="fade-left">
                                        <div class="card-header border-0 d-flex justify-content-between">
                                          <h6 class="card-title mb-0">
                                            <span class="align-middle">Ubuntu Server</span>
                                          </h6>
                                          <span class="badge rounded-pill bg-label-danger">Inactive</span>
                                        </div>
                                        <div class="card-body pb-2 pt-0">
                                          <ul class="list-group list-group-flush">
                                            <li
                                              class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                              <div>
                                                <i class="bx bx-globe"></i>
                                                <span>IP Address</span>
                                              </div>
                                              <div>
                                                192.654.8.566
                                              </div>
                                            </li>
                                            <li
                                              class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                              <div>
                                                <i class="bx bx-chip"></i>
                                                <span>CPU</span>
                                              </div>
                                              <div>
                                                4 Cores
                                              </div>
                                            </li>
                                            <li
                                              class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                              <div>
                                                <i class="bx bx-server"></i>
                                                <span>Ram</span>
                                              </div>
                                              <div>
                                                500 MB
                                              </div>
                                            </li>
                                          </ul>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between">
                                          <div class="server-icons">
                                            <i class="bx bx-share-alt me-2"></i>
                                            <i class="bx bx-sync"></i>
                                          </div>
                                          <label class="switch me-n2">
                                            <input type="checkbox" class="switch-input" />
                                            <span class="switch-toggle-slider">
                                              <span class="switch-on"></span>
                                              <span class="switch-off"></span>
                                            </span>
                                            <span class="switch-label"></span>
                                          </label>
                                        </div>
                                        <div class="timeline-event-time">20th January</div>
                                      </div>
                                    </li>
                                    <li class="timeline-item">
                                      <span class="timeline-indicator timeline-indicator-info" data-aos="zoom-in"
                                        data-aos-delay="200">
                                        <i class="bx bx-store"></i>
                                      </span>
                                      <div class="timeline-event card p-0" data-aos="fade-right">
                                        <div class="card-header border-0 d-flex justify-content-between">
                                          <h6 class="card-title mb-0"><span class="align-middle">Online Store</span>
                                          </h6>
                                          <i class="bx bx-dots-vertical-rounded cursor-pointer"></i>
                                        </div>
                                        <div class="card-body pt-0">
                                          <p>
                                            Develop an online store of electronic devices for the provided
                                            layout, as well as develop a mobile version of it. The must be
                                            compatible with any CMS.
                                          </p>
                                          <div class="d-flex flex-wrap flex-sm-row flex-column">
                                            <div class="mb-sm-0 mb-3 me-5">
                                              <p class="text-muted mb-2">Developers</p>
                                              <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xs me-2">
                                                  <span class="avatar-initial rounded-circle bg-label-primary">A</span>
                                                </div>
                                                <div class="avatar avatar-xs me-2">
                                                  <span class="avatar-initial rounded-circle bg-label-success">B</span>
                                                </div>
                                                <div class="avatar avatar-xs">
                                                  <span class="avatar-initial rounded-circle bg-label-danger">C</span>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="mb-sm-0 mb-3 me-5">
                                              <p class="text-muted mb-2">Deadline</p>
                                              <p class="mb-0">20 Dec 2077</p>
                                            </div>
                                            <div>
                                              <p class="text-muted mb-2">Budget</p>
                                              <p class="mb-0">$50000</p>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="timeline-event-time">25th January</div>
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                              </div> -->
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <!-- <table id="table_x" class="datatables-basic table border-top">
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
                    <tbody>
                      <tr>
                          <td>awda</td>    
                          <td>awda</td>    
                          <td>awda</td>    
                          <td>awda</td>    
                          <td>awda</td>    
                          <td>awda</td>    
                          <td>awda</td>    
                          <td>awda</td>    
                      </tr>
                    </tbody>
                  </table> -->
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