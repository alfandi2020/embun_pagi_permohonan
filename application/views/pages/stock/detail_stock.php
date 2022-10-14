<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
                
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Stock Barang / Detail /</span> <?= $dataToko['nama_toko'];?></h4>
            <div class="row">
                <a href="<?= base_url('index/stock');?>" class="mb-3">
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
                          data-bs-target="#barang_masuk"
                          aria-controls="barang_masuk"
                          aria-selected="false"
                        >
                          Barang Masuk
                        </button>
                      </li>
                      
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#penjualan"
                          aria-controls="penjualan"
                          aria-selected="false"
                        >
                          Barang Keluar
                        </button>
                      </li>
                    </ul>
                    <!-- Detail -->
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="navs-top-detail" role="tabpanel">
                      <div class="card-header d-flex  justify-content-center">
                            <div class="col">
                                <h5 class="modal-title" id="modalCenterTitle" style="text-align: center"><small style="color: #566a7f; font-weight: 400">Cabang:</small> <b><?= $dataToko['nama_toko'];?></b></h5>
                                <p style="text-align: center">Block C, LT. Ground LOS B, No. 75-76</p>
                                <a href="" class="btn btn-primary modaltambahbarang" data-bs-toggle="modal" data-bs-target="#modaltambahbarang" style="text-align: center; margin: auto; display: block; width: fit-content">Tambah Barang Baru ?</a>
                            </div>
                        </div>

                        <div class="table-responsive text-nowrap">
                        <table class="table" id="tabel-data">
                            <thead>
                            <tr class="text-nowrap">
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                <th>Harga/pt</th>
                                <th>Stock</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $x = 1; ?>
                            <?php foreach($stok_toko as $st) : ?> 
                            <tr>
                                <th scope="row"><?= $x; ?></th>
                                <td><?= $st['nama_barang'];?></td>
                                <td><?= $st['merk'];?></td>
                                <td>Rp <?= number_format($st['harga']);?></td>
                                <td><?= number_format($st['stok']);?></td>
                                <td>
                                <a href="#" class="btn btn-primary detailbarangbaru" id="<?= $st['id_barang_stok'] ?>">Detail</a>
                                </td>
                                </td>
                            </tr>
                            <?php $x++;?>
                            <?php endforeach; ?>
                      

                            </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- //Detail  -->

                    <!-- Barang Masuk -->
                      <div class="tab-pane fade" id="barang_masuk" role="tabpanel">
                      <div class="card-header d-flex  justify-content-center">
                            <div class="col">
                                <h5 class="modal-title" id="modalCenterTitle" style="text-align: center"><small style="color: #566a7f; font-weight: 400">Cabang:</small> <b><?= $dataToko['nama_toko'];?></b></h5>
                                <p style="text-align: center"><?= $dataToko['alamat'];?></p>
                                <a href="" class="btn btn-primary modaltambahbarangmasuk" data-bs-toggle="modal" data-bs-target="#modaltambahbarangmasuk" style="text-align: center; margin: auto; display: block; width: fit-content">Tambah Data ?</a>
                            </div>
                        </div>

                        <div class="table-responsive text-nowrap">
                        <table class="table" id="tabel-data2">
                            <thead>
                            <tr class="text-nowrap">
                                <th>#</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
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
                                <td><?=  date('d F Y',strtotime($bm['tanggal']));?></td>
                                <td><?= $bm['nama_barang'];?></td>
                                <td><?= number_format($bm['jumlah']);?></td>
                                <td>
                                <a href="#" class="btn btn-success updatebarangmasuk" id="<?= $bm['id_pb'] ?>" >Update</a>
                                &nbsp;
                                <a href="#" class="btn btn-primary detailbarangmasuk" id="<?= $bm['id_pb'] ?>">Detail</a>
                                </td>
                            </tr>
                            <?php $x++;?>
                            <?php endforeach; ?>
                        

                            </tbody>
                            </table>
                        </div>
                      </div>
                      <!-- // barang masuk -->
                   
                   
                      <!-- Barang Keluar -->
                      <div class="tab-pane fade" id="penjualan" role="tabpanel">
                      <div class="card-header d-flex  justify-content-center">
                            <div class="col">
                                <h5 class="modal-title" id="modalCenterTitle" style="text-align: center"><small style="color: #566a7f; font-weight: 400">Cabang:</small> <b><?= $dataToko['nama_toko'];?></b></h5>
                                <p style="text-align: center"><?= $dataToko['alamat'];?></p>
                                <a href="" class="tambahbarangkeluar btn btn-primary" data-bs-toggle="modal" data-bs-target="#modaltambahbarangkeluar"  style="text-align: center; margin: auto; display: block; width: fit-content">Tambah Data ?</a>
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
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php $x = 1; ?>
                              <?php foreach($barang_keluar as $bk) : ?>
                            <tr>
                                <th scope="row"><?= $x; ?></th>
                                <td><p class="" style="margin:0; color: red">
                                  <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: red;"><path d="M19.071 4.929c-3.899-3.898-10.243-3.898-14.143 0-3.898 3.899-3.898 10.244 0 14.143 3.899 3.898 10.243 3.898 14.143 0 3.899-3.9 3.899-10.244 0-14.143zm-3.536 10.607-2.828-2.829-3.535 3.536-1.414-1.414 3.535-3.536-2.828-2.829h7.07v7.072z"></path></svg></span>
                                    Barang Keluar
                                  </p></td>
                              <td><?= $bk['tanggal'];?></td>
                              <td><?= $bk['nama_barang'];?></td>
                              <td><?= number_format($bk['jumlah']);?></td>
                              <td>
                                <a href="#" class="btn btn-success updatebarangkeluar" id="<?= $bk['id_pb'] ?>" >Update</a>
                                &nbsp;
                                <a href="#" class="btn btn-primary detailbarangkeluar" id="<?= $bk['id_pb'] ?>">Detail</a>
                                </td>
                            </tr>
                            <?php $x++; ?>
                            <?php endforeach; ?>

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


             <!-- Modal Tambah Barang Baru -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <form method="POST" action="<?= base_url('index/tambah_barang');?>">
                        <div class="modal fade" id="modaltambahbarang" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title" id="modalCenterTitle">Tambah Barang Baru</h5>
                                  <p class="modal-title" id="modalCenterTitle">Form ini diperuntukkan untuk data barang yang tidak ada di daftar barang rincian toko.</p>
                                </div>
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
                                    <input type="hidden" name="id_toko" value="<?= $dataToko['id_toko'];?>">
                                    <label for="nameWithTitle" class="form-label">Nama Barang</label>
                                    <input
                                      type="text"
                                      name="nama"
                                      id="nameWithTitle"
                                      class="form-control"
                                      placeholder="Masukkan Nama Barang"
                                    />
                                  </div>
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Merk</label>
                                    <input
                                      type="text"
                                      id="nameWithTitle"
                                      name="merk"
                                      class="form-control"
                                      placeholder="Masukkan Merk"
                                    />
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Harga/Pt</label>
                                    <input
                                      type="text"
                                      name="harga"
                                      id="nameWithTitle"
                                      class="form-control"
                                      placeholder="Harga/potong"
                                    />
                                  </div>
                                </div>
                              
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Deskripsi</label>
                                    <textarea
                                      id="deskripsi"
                                      class="form-control"
                                      name="deskripsi"
                                      placeholder="Masukkan Catatan"
                                    ></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Batal
                                </button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                    <!-- //Akhir Modal Tambah Barang Baru -->

                    <!-- Modal Detail Barang Baru -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <div class="modal fade" id="modaldetailbarangbaru" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title" id="modalCenterTitle">Detail Barang Masuk</h5>
                                </div>
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
                                    <input type="hidden" name="id_barang_stok">
                                    <input type="hidden" name="id_toko" value="<?= $dataToko['id_toko'];?>">
                                    <label for="nameWithTitle" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" name="nama_barang">
                                  </div>
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Merk</label>
                                    <input type="text" class="form-control" name="merk">
                                  </div>
                                </div>
                               
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Harga/Pt</label>
                                    <input type="text" class="form-control" name="harga">
                                  </div>
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">stok</label>
                                    <input type="text" class="form-control" name="stok">
                                  </div>
                                </div>
                              
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Deskripsi</label>
                                    <textarea
                                      id="deskripsi"
                                      class="form-control"
                                      name="deskripsi"
                                      placeholder="Masukkan Catatan"
                                    ></textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                    <!-- //Akhir Modal Detail Barang Baru -->


             <!-- Modal Tambah Barang Masuk -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <form method="POST" action="<?= base_url('index/tambah_barang_keluar');?>">
                        <div class="modal fade" id="modaltambahbarangkeluar" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title" id="modalCenterTitle">Tambah Barang Keluar</h5>
                                </div>
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
                                    <input type="hidden" name="id_toko" value="<?= $dataToko['id_toko'];?>">
                                    <label for="nameWithTitle" class="form-label">Pilih Tanggal Keluar</label>
                                    <input class="form-control" type="date" name="tanggal_keluar" id="html5-date-input" />
                                  </div>
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Pilih Barang</label>
                                    <select name="id_barang" id="defaultSelect" class="form-select">
                                      <option value="-">Pilih Barang</option>
                                      <?php foreach($stok_toko as $tk) :?>
                                      <option value="<?= $tk['id_barang_stok'];?>"><?= $tk['nama_barang'];?></option>
                                      <?php endforeach;?>
                                    </select>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Jumlah</label>
                                    <input
                                      type="text"
                                      name="jumlah"
                                      id="nameWithTitle"
                                      class="form-control"
                                      placeholder="Jumlah Barang Keluar"
                                    />
                                  </div>
                                </div>
                              
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Deskripsi</label>
                                    <textarea
                                      id="deskripsi"
                                      class="form-control"
                                      name="deskripsi"
                                      placeholder="Masukkan Catatan"
                                    ></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Batal
                                </button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                    <!-- //Akhir Tambah barang Masuk -->
            
            
                    <!-- Modal Update Barang Masuk -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <form method="POST" action="<?= base_url('index/update_barang_masuk/');?>">
                        <div class="modal fade" id="modalupdatebarangmasuk" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title" id="modalCenterTitle">Edit Barang Masuk</h5>
                                </div>
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
                                    <input type="hidden" name="id_pb" value="">
                                    <input type="hidden" name="id_toko" value="<?= $dataToko['id_toko'];?>">
                                    <label for="nameWithTitle" class="form-label">Pilih Tanggal Masuk</label>
                                    <input class="form-control" type="date" name="tanggal_masuk" id="html5-date-input" />
                                  </div>
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" name="barang" disabled>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Jumlah</label>
                                    <input
                                      type="text"
                                      name="jumlah"
                                      id="nameWithTitle"
                                      class="form-control"
                                      placeholder="Jumlah Barang Masuk"
                                    />
                                   
                                  </div>
                                </div>
                              
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Deskripsi</label>
                                    <textarea
                                      id="deskripsi"
                                      class="form-control"
                                      name="deskripsi"
                                      placeholder="Masukkan Catatan"
                                    ></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Batal
                                </button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                    <!-- //Akhir Modal Update Barang Masuk -->
                    
                    <!-- Modal Detail Barang Masuk -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <div class="modal fade" id="modaldetailbarangmasuk" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title" id="modalCenterTitle">Detail Barang Masuk</h5>
                                </div>
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
                                    <input type="hidden" name="id_pb" value="">
                                    <input type="hidden" name="id_toko" value="<?= $dataToko['id_toko'];?>">
                                    <label for="nameWithTitle" class="form-label">Pilih Tanggal Masuk</label>
                                    <input class="form-control" disabled type="date" name="tanggal_masuk" id="html5-date-input" />
                                  </div>
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" name="barang" disabled>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Jumlah</label>
                                    <input
                                      type="text"
                                      name="jumlah"
                                      id="nameWithTitle"
                                      class="form-control"
                                      placeholder="Jumlah Barang Masuk" disabled
                                    />
                                   
                                  </div>
                                </div>
                              
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Deskripsi</label>
                                    <textarea
                                      id="deskripsi"
                                      class="form-control"
                                      name="deskripsi"
                                      placeholder="Masukkan Catatan" disabled
                                    ></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                    <!-- //Akhir Modal Detail Barang Masuk -->


                      <!-- Modal Tambah Barang Masuk -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <form method="POST" action="<?= base_url('index/tambah_barang_masuk');?>">
                        <div class="modal fade" id="modaltambahbarangmasuk" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title" id="modalCenterTitle">Tambah Barang Masuk</h5>
                                </div>
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
                                    <input type="hidden" name="id_toko" value="<?= $dataToko['id_toko'];?>">
                                    <label for="nameWithTitle" class="form-label">Pilih Tanggal Masuk</label>
                                    <input class="form-control" type="date" name="tanggal_masuk" id="html5-date-input" value="0"/>
                                  </div>
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Pilih Barang</label>
                                    <select name="id_barang" id="defaultSelect" class="form-select">
                                      <option value="-">Pilih Barang</option>
                                      <?php foreach($stok_toko as $tk) :?>
                                      <option value="<?= $tk['id_barang_stok'];?>"><?= $tk['nama_barang'];?></option>
                                      <?php endforeach;?>
                                    </select>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Jumlah</label>
                                    <input
                                      type="text"
                                      name="jumlah"
                                      id="nameWithTitle"
                                      class="form-control"
                                      placeholder="Jumlah Barang Masuk"
                                      value="0"
                                    />
                                  </div>
                                </div>
                              
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Deskripsi</label>
                                    <textarea
                                      id="deskripsi"
                                      class="form-control"
                                      name="deskripsi"
                                      placeholder="Masukkan Catatan"
                                    ></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Batal
                                </button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                    <!-- //Akhir Tambah barang Masuk -->


                      <!-- Modal Update Barang Keluar -->
                      <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <form method="POST" action="<?= base_url('index/update_barang_keluar/');?>">
                        <div class="modal fade" id="modalupdatebarangkeluar" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title" id="modalCenterTitle">Edit Barang Keluar</h5>
                                </div>
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
                                    <input type="hidden" name="id_pb" value="">
                                    <input type="hidden" name="id_toko" value="<?= $dataToko['id_toko'];?>">
                                    <label for="nameWithTitle" class="form-label">Pilih Tanggal Keluar</label>
                                    <input class="form-control" type="date" name="tanggal_keluar" id="html5-date-input" />
                                  </div>
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" name="barang_keluar" disabled>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Jumlah</label>
                                    <input
                                      type="text"
                                      name="jumlah_keluar"
                                      id="nameWithTitle"
                                      class="form-control"
                                      placeholder="Jumlah Barang Keluar"
                                    />
                                   
                                  </div>
                                </div>
                              
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Deskripsi</label>
                                    <textarea
                                      id="deskripsi"
                                      class="form-control"
                                      name="deskripsi_keluar"
                                      placeholder="Masukkan Catatan"
                                    ></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Batal
                                </button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                    <!-- //Akhir Modal Update Barang Keluar -->
                    
                    <!-- Modal Detail Barang keluar -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <div class="modal fade" id="modaldetailbarangkeluar" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title" id="modalCenterTitle">Edit Barang Keluar</h5>
                                </div>
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
                                    <input type="hidden" name="id_pb" value="">
                                    <input type="hidden" name="id_toko" value="<?= $dataToko['id_toko'];?>">
                                    <label for="nameWithTitle" class="form-label">Pilih Tanggal Keluar</label>
                                    <input class="form-control" type="date" name="tanggal_keluar" id="html5-date-input" />
                                  </div>
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" name="barang">
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Jumlah</label>
                                    <input
                                      type="text"
                                      name="jumlah"
                                      id="nameWithTitle"
                                      class="form-control"
                                      placeholder="Jumlah Barang Keluar"
                                    />
                                   
                                  </div>
                                </div>
                              
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Deskripsi</label>
                                    <textarea
                                      id="deskripsi"
                                      class="form-control"
                                      name="deskripsi"
                                      placeholder="Masukkan Catatan"
                                    ></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                    <!-- //Akhir Modal Detail Barang Keluar -->

            

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