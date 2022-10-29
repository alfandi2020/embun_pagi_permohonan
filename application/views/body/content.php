<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-sm-6 col-xl-3 mt-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span>
                  <div class="badge bg-warning">Data Waiting</div>
                </span>
                <div class="d-flex align-items-end mt-2">
                <?php if($this->session->userdata('level') == 1) { ?>

                    <a href="<?= base_url('permohonan/filter/data_baru') ?>">
                      <h4 class="mb-0 me-2"><?= $waiting ?></h4>
                    </a>
                <?php }else{ ?>
                  <a href="<?= base_url('permohonan/filter/waiting') ?>">
                      <h4 class="mb-0 me-2"><?= $waiting ?></h4>
                    </a>
                <?php } ?>
                  <!-- <small class="text-success">(+29%)</small> -->
                </div>
                <!-- <small>Total Users</small> -->
              </div>
              <span class="badge bg-label-warning rounded p-2">
                <i class="bx bx-time bx-sm"></i>
                <!-- <i class='bx bxs-time-five'></i> -->
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3 mt-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span>
                  <div class="badge bg-primary">Data Approved</div>
                </span>
                <div class="d-flex align-items-end mt-2">
                <?php if($this->session->userdata('level') == 2) { ?>
                  <a href="<?= base_url('permohonan/filter/waiting') ?>">
                    <h4 class="mb-0 me-2"><?= $approved ?></h4>
                  </a>
                  <?php }else{ ?>
                    <a href="<?= base_url('permohonan/filter/data_baru') ?>">
                    <h4 class="mb-0 me-2"><?= $approved ?></h4>
                  </a>
                  <?php } ?>
                  <!-- <small class="text-success">(+29%)</small> -->
                </div>
                <!-- <small>Total Users</small> -->
              </div>
              <span class="badge bg-label-primary rounded p-2">
                <i class="bx bx-check-circle bx-sm"></i>
                <!-- <i class='bx bxs-time-five'></i> -->
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3 mt-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span>
                  <div class="badge bg-danger">Data Rejected</div>
                </span>
                <div class="d-flex align-items-end mt-2">
                  <a href="<?= base_url('permohonan/filter/data_lama') ?>">
                    <h4 class="mb-0 me-2"><?= $rejected ?></h4>
                  </a>
                  <!-- <small class="text-success">(+29%)</small> -->
                </div>
                <!-- <small>Total Users</small> -->
              </div>
              <span class="badge bg-label-danger rounded p-2">
                <i class="bx bx-x-circle bx-sm"></i>
                <!-- <i class='bx bxs-time-five'></i> -->
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3 mt-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span>
                  <div class="badge bg-success">Data Done</div>
                </span>
                <div class="d-flex align-items-end mt-2">
                  <a href="<?= base_url('permohonan/filter/data_lama') ?>">
                    <h4 class="mb-0 me-2"><?= $done ?></h4>
                  </a>
                  <!-- <small class="text-success">(+29%)</small> -->
                </div>
                <!-- <small>Total Users</small> -->
              </div>
              <span class="badge bg-label-success rounded p-2">
                <i class="bx bx-check bx-sm"></i>
                <!-- <i class='bx bxs-time-five'></i> -->
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-2 text-center">
        <div class="col-sm-12 col-xl-12 mt-4">
          <div class="card">
            <div class="card-body">
              Selamat datang,  <b><?= $this->session->userdata('nama') ?></b><br>
              <b><?php if ($this->session->userdata('level') == 1) {
               echo "Admin Approval";
              }elseif ($this->session->userdata('level') == 2) {
                echo "Admin Filter";
              }else{
                echo "User";

              }  ?></b>
              <p><?= date('d M Y H:i:s') ?></p>
            </div>
          </div>
        </div>
    </div>
<?php if($this->session->userdata('level') != 3){ ?>
    <div class="row mt-4">
      <div class="col-md-12 col-lg-12 mb-4">
        <div class="card">
          <div class="row row-bordered g-0">
            <div class="col-md-12">

              <div class="row container mt-2">
                <form class="col-md-2" action="<?= base_url('laporan/filter') ?>" method="POST">
                  <b>Tahun</b>
                  <select name="tahun" id="" class="form-control" onchange="form.submit()">
                    <option value="">Pilih Tahun</option>
                    <option <?= $this->session->userdata('filterTahun') == date('Y')-2 ? 'selected' : '' ?>
                      value="<?= date('Y')-2 ?>"><?= date('Y')-2 ?></option>
                    <option <?= $this->session->userdata('filterTahun') == date('Y') ? 'selected' : '' ?>
                      value="<?= $this->session->userdata('filterTahun') == date('Y') ? $this->session->userdata('filterTahun') : date('Y') ?>">
                      <?= $this->session->userdata('filterTahun') == date('Y') ? $this->session->userdata('filterTahun') : date('Y') ?>
                    </option>
                    <option <?= $this->session->userdata('filterTahun') == date('Y')+1 ? 'selected' : '' ?>
                      value="<?= date('Y')+1 ?>"><?= date('Y')+1 ?></option>
                    <option <?= $this->session->userdata('filterTahun') == date('Y')+2 ? 'selected' : '' ?>
                      value="<?= date('Y')+2 ?>"><?= date('Y')+2 ?></option>
                  </select>
                </form>
                <form class="col-md-2" action="<?= base_url('laporan/get') ?>" method="POST">
                  <b> Bulan</b>
                  <select name="bulan" id="" class="form-control" onchange="form.submit()">
                    <option value="">Pilih Bulan</option>
                    <option value="01">Januari</option>
                    <option value="02">Febuari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agusutus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                  </select>
                </form>

              </div>
              <div class="card-header">
                <h5 class="card-title mb-0">Report</h5>
                <small class="card-subtitle">Yearly report</small>
              </div>
              <div class="card-body">
                <div id="chart2"></div>
              </div>
            </div>
            <!-- <div class="col-md-4">
          <div class="card-header d-flex justify-content-between">
            <div>
              <h5 class="card-title mb-0">Report</h5>
              <small class="card-subtitle">Monthly Avg. $45.578k</small>
            </div>
            <div class="dropdown">
              <button class="btn p-0" type="button" id="totalIncome" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalIncome">
                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="report-list">
              <div class="report-list-item rounded-2 mb-3">
                <div class="d-flex align-items-start">
                  <div class="report-list-icon shadow-sm me-2">
                    <img src="../../assets/svg/icons/paypal-icon.svg" width="22" height="22" alt="Paypal">
                  </div>
                  <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                    <div class="d-flex flex-column">
                      <span>Income</span>
                      <h5 class="mb-0">$42,845</h5>
                    </div>
                    <small class="text-success">+2.34k</small>
                  </div>
                </div>
              </div>
              <div class="report-list-item rounded-2 mb-3">
                <div class="d-flex align-items-start">
                  <div class="report-list-icon shadow-sm me-2">
                    <img src="../../assets/svg/icons/shopping-bag-icon.svg" width="22" height="22" alt="Shopping Bag">
                  </div>
                  <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                    <div class="d-flex flex-column">
                      <span>Expense</span>
                      <h5 class="mb-0">$38,658</h5>
                    </div>
                    <small class="text-danger">-1.15k</small>
                  </div>
                </div>
              </div>
              <div class="report-list-item rounded-2">
                <div class="d-flex align-items-start">
                  <div class="report-list-icon shadow-sm me-2">
                    <img src="../../assets/svg/icons/wallet-icon.svg" width="22" height="22" alt="Wallet">
                  </div>
                  <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                    <div class="d-flex flex-column">
                      <span>Profit</span>
                      <h5 class="mb-0">$18,220</h5>
                    </div>
                    <small class="text-success">+1.35k</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> -->
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
  </div>
  <!-- Content wrapper -->
</div>



<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->