<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
                
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gudang / Detail /</span> <?= $data['nama_barang'];?></h4>
            <div class="row">
                <a href="<?= base_url('index/gudang');?>" class="mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: blue;"><path d="M12.707 17.293 8.414 13H18v-2H8.414l4.293-4.293-1.414-1.414L4.586 12l6.707 6.707z"></path></svg>Kembali
                </a>
                <div class="col-lg-12 mb-4 order-0">
                  <div class="nav-align-top mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link active"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-detail"
                          aria-controls="navs-top-detail"
                          aria-selected="true"
                        >
                          Detail
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-terima"
                          aria-controls="navs-top-terima"
                          aria-selected="false"
                        >
                          Terima
                        </button>
                      </li>
                      
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-kirim"
                          aria-controls="navs-top-kirim"
                          aria-selected="false"
                        >
                          Kirim
                        </button>
                      </li>
                    </ul>
                    <!-- Detail -->
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="navs-top-detail" role="tabpanel">
                     
                        <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr class="text-nowrap">
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                <th>Harga/pt</th>
                                <th>Stock</th>
                                <th>Deskripsi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?= $data['nama_barang'];?></td>
                                <td><?= $data['merk'];?></td>
                                <td>Rp <?= $data['harga'];?></td>
                                <td><?= $data['jumlah'];?></td>
                                <td><?= $data['deskripsi'];?> </td>
                                <td>
                                <!-- <a href="<?= base_url('index/detail_stock');?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: #5F61E6;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                                View
                                </a> -->
                                </td>
                            </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- //Detail  -->

                    <!-- Terima Barang / Barang Masuk Ke Gudang -->
                      <div class="tab-pane fade" id="navs-top-terima" role="tabpanel">
                      <div class="card-header d-flex  justify-content-center">
                            <div class="col">
                                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalterima">Tambah Data</a>
                            </div>
                        </div>

                        <div class="table-responsive text-nowrap">
                        <table class="table" id="tabel-data">
                            <thead>
                            <tr class="text-nowrap">
                                <th>#</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php $x = 1; ?>
                              <?php foreach($terima_barang as $tb) :?>
                            <tr>
                                <th scope="row"><?= $x; ?></th>
                                <td><p class="" style="margin:0; color: green">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: green;"><path d="M19.071 19.071c3.898-3.899 3.898-10.244 0-14.143-3.899-3.899-10.244-3.898-14.143 0-3.898 3.899-3.899 10.243 0 14.143 3.9 3.899 10.244 3.899 14.143 0zM8.464 8.464l2.829 2.829 3.535-3.536 1.414 1.414-3.535 3.536 2.828 2.829H8.464V8.464z"></path></svg></span>
                                    Barang Masuk Gudang
                                  </p></td>
                                <td><?= date('d F Y',strtotime($tb['tanggal']));?></td>
                                <td><?= $tb['jumlah'];?> Potong</td>
                                <td>
                                    <a href="#" class="btn btn-success updatetgudang" id="<?= $tb['id_barang'] ?>" >Update</a>
                                    &nbsp;
                                    <a href="#" class="btn btn-primary detailgudang" id="<?= $tb['id_barang'] ?>">Detail</a>
                                </td>
                            </tr>
                            <?php $x++;?>
                            <?php endforeach;?>
                            
                            </tbody>
                            </table>
                        </div>
                      </div>
                       <!-- //Terima Barang / Barang Masuk Ke Gudang -->
                   
                   
                   
                       <!-- Kirim Barang / Barang Keluar Ke Gudang -->
                      <div class="tab-pane fade" id="navs-top-kirim" role="tabpanel">
                      <div class="card-header d-flex  justify-content-center">
                            <div class="col">
                                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalkirim">Tambah Data</a>
                            </div>
                        </div>

                        <div class="table-responsive text-nowrap">
                        <table class="table" id="tabel-data2">
                            <thead>
                            <tr class="text-nowrap">
                                <th>#</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                              
                            <?php $x = 1; ?>
                            <?php foreach($kirim_barang as $kb) :?>
                            <tr>
                                <th scope="row"><?= $x; ?></th>
                                <td><p class="" style="margin:0; color: red">
                                  <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: red;"><path d="M19.071 4.929c-3.899-3.898-10.243-3.898-14.143 0-3.898 3.899-3.898 10.244 0 14.143 3.899 3.898 10.243 3.898 14.143 0 3.899-3.9 3.899-10.244 0-14.143zm-3.536 10.607-2.828-2.829-3.535 3.536-1.414-1.414 3.535-3.536-2.828-2.829h7.07v7.072z"></path></svg></span>
                                    Barang Keluar Gudang
                                  </p></td>
                                <td><?= date('d F Y',strtotime($kb['tanggal']));?></td>
                                <td><?= $kb['jumlah'];?> Potong</td>
                                <td>
                                <a href="">
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
                       <!-- //Kirim Barang / Barang Keluar Ke Gudang -->

                    </div>
                  </div>
                    
                  <!-- Responsive Table -->
              <!-- /Table -->

            </div>
            <!-- / Content -->

            <!-- Modal Terima Barang -->
             <!-- Vertically Centered Modal -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <form method="POST" action="<?= base_url('index/tambah_terima_barang');?>">
                        <div class="modal fade" id="modalterima" tabindex="-1" aria-hidden="true">
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
                                    <input type="hidden" name="id_barang" value="<?= $data['id_barang'];?>">
                                    <label for="merk" class="form-label">Tanggal</label>
                                    <input class="form-control" type="date" name="tanggal" id="html5-date-input" required/>
                                  </div>

                                  <div class="col mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input
                                      type="text"
                                      id="jumlah"
                                      name="jumlah"
                                      class="form-control"
                                      placeholder="Masukkan Jumlah Barang"
                                      required
                                    />
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <input
                                      type="text"
                                      id="deskripsi"
                                      name="deskripsi"
                                      class="form-control"
                                      placeholder="Masukkan Deskripsi"
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
                    <!-- //Vertikal -->
                   <!-- //Modal Terima Barang -->
            
                   <!-- Modal Update Terima Barang -->
             <!-- Vertically Centered Modal -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <form method="POST" action="<?= base_url('index/update_terima_barang');?>">
                        <div class="modal fade" id="modalterima" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title text" id="modalCenterTitle">Edit Data Barang Masuk Gudang</h5>
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
                                    <input type="hidden" name="id_barang" value="<?= $data['id_barang'];?>">
                                    <label for="merk" class="form-label">Tanggal</label>
                                    <input class="form-control" type="date" name="tanggal" id="html5-date-input" required/>
                                  </div>

                                  <div class="col mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input
                                      type="text"
                                      id="jumlah"
                                      name="jumlah"
                                      class="form-control"
                                      placeholder="Masukkan Jumlah Barang"
                                      required
                                    />
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <input
                                      type="text"
                                      id="deskripsi"
                                      name="deskripsi"
                                      class="form-control"
                                      placeholder="Masukkan Deskripsi"
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
                    <!-- //Vertikal -->
                   <!-- //Modal Terima Barang -->
           
           
                   <!-- Modal Kirim Barang -->
             <!-- Vertically Centered Modal -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <form method="POST" action="<?= base_url('index/tambah_kirim_barang');?>">
                        <div class="modal fade" id="modalkirim" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title text" id="modalCenterTitle">Tambah Data Barang Keluar Gudang</h5>
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
                                    <input type="hidden" name="id_barang" value="<?= $data['id_barang'];?>">
                                    <label for="merk" class="form-label">Tanggal</label>
                                    <input class="form-control" type="date" name="tanggal" id="html5-date-input" required/>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="deskripsi" class="form-label">Cabang / Toko</label>
                                    <select name="toko" id="defaultSelect" class="form-select">
                                      <option>Pilih Toko</option>
                                      <?php foreach($toko as $tk) :?>
                                      <option value="<?= $tk['id_toko'];?>"><?= $tk['nama_toko'];?></option>
                                      <?php endforeach;?>
                                    </select>
                                  </div>

                                  <div class="col mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input
                                      type="text"
                                      id="jumlah"
                                      name="jumlah"
                                      class="form-control"
                                      placeholder="Masukkan Jumlah Barang"
                                      required
                                    />
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <input
                                      type="text"
                                      id="deskripsi"
                                      name="deskripsi"
                                      class="form-control"
                                      placeholder="Masukkan Deskripsi"
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
                    <!-- //Vertikal -->
                   <!-- //Modal Kirim Barang -->

            

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