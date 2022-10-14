<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary">Total Kas Saldo</h5>
                          <h1>Rp 73.455.000</h1>
                          <p class="mb-4">
                            You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in
                            your profile.
                          </p>

                          <a href="javascript:;" class="btn btn-sm btn-outline-primary">Lihat Riwayat</a>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="<?= base_url('assets/img/illustrations/man-with-laptop-light.png');?>"
                            height="140"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- table -->
              <div class="row">
              <div class="col-lg-12 mb-4 order-0">
                  <div class="nav-align-top mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link active"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#kas-toko"
                          aria-controls="kas-toko"
                          aria-selected="true"
                        >
                          Kas Toko
                        </button>
                      </li>
                    </ul>
                    <!-- Detail -->
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="kas-toko" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                        <table class="table" id="tabel-data">
                            <thead>
                            <tr class="text-nowrap">
                                <th>#</th>
                                <th>Nama Cabang / Toko</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php $x = 1; ?>
                              <?php foreach($toko as $tk) :?>
                            <tr>
                                <th scope="row"><?= $x; ?></th>
                                <td><?= $tk['nama_toko'];?></td>
                                <td><?= $tk['alamat']?></td>
                                <td>
                                <a href="<?= base_url('index/detail_transaksi/'. $tk['id_toko']);?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: #5F61E6;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                                View
                                </a>
                                </td>
                            </tr>
                            <?php $x++; ?>
                            <?php endforeach; ?>

                            </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- //Detail  -->

                    <!-- Barang Masuk -->
                      <div class="tab-pane fade" id="riwayat" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                        <table class="table" id="tabel-data2">
                            <thead>
                            <tr class="text-nowrap">
                                <th>#</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                <th>Harga</th>
                                <th>Jumlah Barang</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php $x = 1; ?>
                              <?php foreach($barang_masuk as $bm) : ?>
                            <tr>
                                <th scope="row"><?= $x; ?></th>
                                <td><p class="" style="margin:0; color: green">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: green;"><path d="M19.071 19.071c3.898-3.899 3.898-10.244 0-14.143-3.899-3.899-10.244-3.898-14.143 0-3.898 3.899-3.899 10.243 0 14.143 3.9 3.899 10.244 3.899 14.143 0zM8.464 8.464l2.829 2.829 3.535-3.536 1.414 1.414-3.535 3.536 2.828 2.829H8.464V8.464z"></path></svg></span>
                                    Barang Masuk
                                  </p></td>
                                <td><?= date('d F Y',strtotime($bm['tanggal']));?></td>
                                <td><?= $bm['nama_barang'];?></td>
                                <td><?= $bm['merk'];?></td>
                                <td>Rp <?= $bm['harga'];?></td>
                                <td><?= $bm['jumlah'];?> /Pt</td>
                                <td>
                                <a href="<?= base_url('index/detail_stock');?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: #5F61E6;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                                View
                                </a>
                                </td>
                            </tr>
                            <?php $x++; ?>
                            <?php endforeach; ?>

                            </tbody>
                            </table>
                        </div>
                      </div>
                      <!-- // barang masuk -->
                   
                   
                      <!-- Penjualan -->
                      <div class="tab-pane fade" id="penjualan" role="tabpanel">
                      <div class="card-header d-flex  justify-content-center">
                            <div class="col">
                                <h5 class="modal-title" id="modalCenterTitle" style="text-align: center"><small style="color: #566a7f; font-weight: 400">Cabang:</small> <b><?= $dataToko['nama_toko'];?></b></h5>
                                <p style="text-align: center"><?= $dataToko['alamat'];?></p>
                                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalbarangkeluar" style="text-align: center; margin: auto; display: block; width: fit-content">Tambah Data</a>
                            </div>
                          </div>
                          

                        <div class="table-responsive text-nowrap">
                        <table class="table" id="tabel-data3">
                            <thead>
                            <tr class="text-nowrap">
                                <th>#</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                <th>Jumlah Barang</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php $x = 1; ?>
                              <?php foreach($barang_keluar as $bk) :?>
                            <tr>
                                <th scope="row"><?= $x; ?></th>
                                <td><p class="" style="margin:0; color: red">
                                  <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: red;"><path d="M19.071 4.929c-3.899-3.898-10.243-3.898-14.143 0-3.898 3.899-3.898 10.244 0 14.143 3.899 3.898 10.243 3.898 14.143 0 3.899-3.9 3.899-10.244 0-14.143zm-3.536 10.607-2.828-2.829-3.535 3.536-1.414-1.414 3.535-3.536-2.828-2.829h7.07v7.072z"></path></svg></span>
                                    Barang Keluar
                                  </p></td>
                                <td><?= date('d F Y',strtotime($bk['tanggal']));?></td>
                                <td><?= $bk['nama_barang'];?></td>
                                <td><?= $bk['merk'];?></td>
                                <td><?= $bk['harga'];?></td>
                                <td><?= $bk['jumlah'];?> /Pt</td>
                                <td>
                                <a href="<?= base_url('index/detail_stock');?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: #5F61E6;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                                View
                                </a>
                                </td>
                            </tr>
                            <?php $x++;?>
                            <?php endforeach;?>

                            </tbody>
                            </table>
                        </div>
                      </div>
                      <!-- // Penjualan -->

                    </div>
                  </div>
                    
                  <!-- Responsive Table -->
              <!-- /Table -->

            </div>
            <!-- / Content -->


             <!-- Vertically Centered Modal -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Tambah Toko</h5>
                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Nama Cabang / Toko</label>
                                    <input
                                      type="text"
                                      id="nameWithTitle"
                                      class="form-control"
                                      placeholder="Masukkan Nama"
                                    />
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Alamat</label>
                                    <input
                                      type="text"
                                      id="nameWithTitle"
                                      class="form-control"
                                      placeholder="Masukkan Alamat"
                                    />
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Batal
                                </button>
                                <button type="button" class="btn btn-primary">Simpan</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- //Vertikal -->


                     <!-- Modal Barang Keluar -->
             <!-- Vertically Centered Modal -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <form method="POST" action="<?= base_url('index/tambah_barang_keluar');?>">
                        <div class="modal fade" id="modalbarangkeluar" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title text" id="modalCenterTitle">Tambah Data Barang Masuk Gudang</h5>
                                  <p class="modal-title" id="modalCenterTitle">Form ini diperuntukkan untuk data barang masuk kedalam gudang.</p>
                                </div>

                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>

                              <div class="modal-body">
                                <hr>
                                <div class="row">
                                  <div class="col mb-3">
                                    <input type="hidden" name="id_toko" value="<?= $dataToko['id_toko'];?>">
                                    <label for="merk" class="form-label">Tanggal</label>
                                    <input class="form-control" type="date" name="tanggal" id="html5-date-input" required/>
                                  </div>

                                  <div class="col mb-3">
                                    <label for="deskripsi" class="form-label">Nama Barang</label>
                                      <select name="id_barang" id="defaultSelect" class="form-select">
                                        <option>Pilih Barang</option>
                                        <?php foreach($stok as $st) :?>
                                        <option value="<?= $st['id_barang'];?>"><?= $st['nama_barang'];?></option>
                                        <?php endforeach;?>
                                      </select>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input
                                      type="text"
                                      id="jumlah"
                                      name="jumlah"
                                      class="form-control"
                                      placeholder="Masukkan Nama Barang"
                                      required
                                    />
                                  </div>

                                  <div class="col mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <input
                                      type="text"
                                      id="deskripsi"
                                      name="deskripsi"
                                      class="form-control"
                                      placeholder="Masukkan Alamat"
                                    />
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Batal
                                </button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                              </div>
                             
                              <!-- Akhir Form -->

                            </div>
                          </div>
                        </div>
                        </form>
                      </div>
                    </div>
              </div>
            </div>
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