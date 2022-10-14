<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
                
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Detail Kas / Cabang /</span> <?= $detail_toko['nama_toko'];?></h4>
            <div class="row">
                <a href="<?= base_url('index/kas');?>" class="mb-3">
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
                          data-bs-target="#detail"
                          aria-controls="detail"
                          aria-selected="true"
                        >
                          Detail
                        </button>
                      </li>
                    </ul>
                    <!-- Detail -->
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="detail" role="tabpanel">
                      <div class="card-header d-flex  justify-content-end">
                            <div class="col">
                                <h5 class="modal-title" id="modalCenterTitle" style="text-align: start"><small style="color: #566a7f; font-weight: 400">Cabang:</small> <b><?= $detail_toko['nama_toko'];?></b></h5>
                                <p style="text-align: start"><?= $detail_toko['alamat'];?></p>
                            </div>
                            <div class="col">
                              <?php if(isset($cektransaksi['id_transaksi'])) : ?>
                              <?php foreach($saldoAkhir as $sd) :?>
                              <?php if($sd['totalkas'] > 0) : ?>
                                <h5 class="modal-title" id="modalCenterTitle" style="text-align: end; font-weight: 700; color: green"><small style="color: #566a7f; font-weight: 400">Saldo Akhir</small> <?= number_format($sd['totalkas']);?></h5>
                              <?php else :?>
                                <h5 class="modal-title" id="modalCenterTitle" style="text-align: end; font-weight: 700; color: red"><small style="color: #566a7f; font-weight: 400">Saldo Akhir</small> <?= number_format($sd['totalkas']);?></h5>
                              <?php endif; ?>
                              <?php endforeach; ?>
                              <?php else: ?>
                                <h5 class="modal-title" id="modalCenterTitle" style="text-align: end; font-weight: 700; color: green"><small style="color: #566a7f; font-weight: 400">Saldo Akhir</small>-</h5>
                              <?php endif; ?>
                              <?php if(isset($cektransaksi['id_transaksi']) == NULL) :?>
                                <p style="text-align: end">Terakhir update: - </p>
                              <?php else : ?>
                                <p style="text-align: end">Terakhir update: <?= date('d F Y',strtotime($cektransaksi['date_created']));?></p>
                              <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                          <div class="col">
                          <a href="" class="btn btn-primary modaltambahtransaksi" data-bs-toggle="modal" data-bs-target="#modaltambahtransaksi">Tambah Data</a>
                          </div>
                        </div>

                        <div class="table-responsive text-nowrap">
                        <table class="table" id="tabel-data">
                            <thead>
                            <tr class="text-nowrap">
                                <th>#</th>
                                <th>Tgl Dana Masuk</th>
                                <th>Tgl Dana Keluar</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $x = 1; ?>
                              <?php foreach($transaksi as $tr) :?>
                            <tr>
                                <th scope="row"><?= $x; ?></th>
                                <td>
                                  <?php if($tr['tanggal_masuk'] == NULL) :?>
                                  <?php echo "-" ; else :?> 
                                  <?= date('d F Y',strtotime($tr['tanggal_masuk']));?>
                                  <?php endif;?>
                                </td>

                                <td><?= date('d F Y',strtotime($tr['tanggal_keluar']));?></td> 
                                
                                  <?php if($tr['tanggal_masuk'] == NULL OR $tr['total'] < 0) :?>
                                <td style="color: red; font-weight: 600">Rp <?= number_format($tr['total']);?></td>
                                  <?php else: ?>
                                <td style="color: green; font-weight: 600">Rp <?= number_format($tr['total']);?></td>
                                  <?php endif; ?>
                                <td>
                                <a href="#" class="btn btn-success updatetransaksi" id="<?= $tr['id_transaksi'] ?>" >Update</a>
                                &nbsp;
                                <a href="#" class="btn btn-primary detailtransaksi" id="<?= $tr['id_transaksi'] ?>">Detail</a>
                                </td>
                            </tr>
                            <?php $x++;?>
                      
                            <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- //Detail  -->

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
                        <form method="POST" action="<?= base_url('index/tambah_transaksi');?>">
                        <input type="hidden" name="id_toko" value="<?= $detail_toko['id_toko'];?>">

                        <div class="modal fade" id="modaltambahtransaksi" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
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
                                <p class="" style="margin:0; color: green; font-weight: 600">Dana Masuk</p>
                                <div class="row">
                                  <div class="col-4 mb-3">
                                    <label for="merk" class="form-label">Tanggal</label>
                                    <input class="form-control" type="date" name="tanggal_masuk" id="html5-date-input"/>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Jumlah Barang Keluar</label>
                                    <input
                                      type="text"
                                      id="nameWithTitle"
                                      class="form-control"
                                      name="barang_terjual"
                                      placeholder="Jumlah Barang"
                                    />
                                  </div>
                                  
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Tunai</label>
                                    <input
                                      type="text"
                                      class="form-control"
                                      name="tunai"
                                      placeholder="Jumlah Tunai"
                                    />
                                  </div>
                                 
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Transfer</label>
                                    <input
                                      type="text"
                                      name="transfer"
                                      class="form-control"
                                      placeholder="Jumlah Transfer"
                                    />
                                  </div>
                                  
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Pengiirim</label>
                                    <input
                                      type="text"
                                      id="nameWithTitle"
                                      name="pengirim_masuk"
                                      class="form-control"
                                      placeholder="Masukkan Nama"
                                    />
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Catatan</label>
                                    <textarea
                                      id="catatan_masuk"
                                      class="form-control"
                                      name="catatan_masuk"
                                      placeholder="Masukkan Catatan Tambahan"
                                    ></textarea>
                                  </div>
                                </div>

                                <hr style="border: 1px dashed grey; width: auto">
                                <p class="" style="margin:0; color: #d61204; font-weight: 600">Dana Keluar</p>

                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="merk" class="form-label">Tanggal</label>
                                    <input class="form-control" type="date" name="tanggal_keluar" id="html5-date-input" />
                                  </div>

                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Biaya Dikeluarkan</label>
                                    <input
                                      type="text"
                                      name="nominal_keluar"
                                      class="form-control"
                                      placeholder="Jumlah Biaya"
                                    />
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Catatan</label>
                                    <textarea
                                      id="catatan_keluar"
                                      name="catatan_keluar"
                                      class="form-control"
                                      placeholder="Masukkan Catatan Tambahan"
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
                    <!-- //Vertikal -->
            
            
            
                    <!-- Update -->
                  
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <form method="POST" action="<?= base_url('index/update_transaksi');?>">
                        <input type="hidden" name="id_toko">

                        <div class="modal fade" id="modalupdatetransaksi" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
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

                              <div class="modal-body bodymodaltransaksi">
                                <hr>
                                <p class="" style="margin:0; color: green; font-weight: 600">Dana Masuk</p>
                                <div class="row">
                                  <div class="col-4 mb-3">
                                    <label for="merk" class="form-label">Tanggal</label>
                                    <input class="form-control" type="date" name="tanggal_masuk" id="html5-date-input"/>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <input type="hidden" name="id_toko">
                                    <input type="hidden" name="id_transaksi">
                                    <label for="nameWithTitle" class="form-label">Jumlah Barang Keluar</label>
                                    <input
                                      type="text"
                                      id="nameWithTitle"
                                      class="form-control"
                                      name="barang_terjual"
                                      placeholder="Jumlah Barang"
                                    />
                                  </div>
                                  
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Tunai</label>
                                    <input
                                      type="text"
                                      class="form-control"
                                      name="tunai"
                                      placeholder="Jumlah Tunai"
                                    />
                                  </div>
                                 
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Transfer</label>
                                    <input
                                      type="text"
                                      name="transfer"
                                      class="form-control"
                                      placeholder="Jumlah Transfer"
                                    />
                                  </div>
                                  
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Pengirim</label>
                                    <input
                                      type="text"
                                      id="nameWithTitle"
                                      name="pengirim_masuk"
                                      class="form-control"
                                      placeholder="Masukkan Nama"
                                    />
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Catatan</label>
                                    <textarea
                                      id="catatan_masuk"
                                      class="form-control"
                                      name="catatan_masuk"
                                      placeholder="Masukkan Catatan Tambahan"
                                    ></textarea>
                                  </div>
                                </div>

                                <hr style="border: 1px dashed grey; width: auto">
                                <p class="" style="margin:0; color: #d61204; font-weight: 600">Dana Keluar</p>

                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="merk" class="form-label">Tanggal</label>
                                    <input class="form-control" type="date" name="tanggal_keluar" id="html5-date-input" />
                                  </div>

                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Biaya Dikeluarkan</label>
                                    <input
                                      type="text"
                                      name="nominal_keluar"
                                      class="form-control"
                                      placeholder="Jumlah Biaya"
                                    />
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Catatan</label>
                                    <textarea
                                      id="catatan_keluar"
                                      name="catatan_keluar"
                                      class="form-control"
                                      placeholder="Masukkan Catatan Tambahan"
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
                        <div class="modal fade" id="modaldetailtransaksi" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title text" id="modalCenterTitle">Detail Data Barang Masuk Gudang</h5>
                                  <p class="modal-title" id="modalCenterTitle">Form ini diperuntukkan untuk data barang masuk kedalam gudang.</p>
                                </div>

                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>

                              <div class="modal-body bodymodaltransaksi">
                                <hr>
                                <p class="" style="margin:0; color: green; font-weight: 600">Dana Masuk</p>
                                <div class="row">
                                  <div class="col-4 mb-3">
                                    <label for="merk" class="form-label">Tanggal</label>
                                    <input class="form-control" type="date" name="tanggal_masuk" id="html5-date-input"/>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <input type="hidden" name="id_toko">
                                    <input type="hidden" name="id_transaksi">
                                    <label for="nameWithTitle" class="form-label">Jumlah Barang Keluar</label>
                                    <input
                                      type="text"
                                      id="nameWithTitle"
                                      class="form-control"
                                      name="barang_terjual"
                                      placeholder="Jumlah Barang"
                                    />
                                  </div>
                                  
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Tunai</label>
                                    <input
                                      type="text"
                                      class="form-control"
                                      name="tunai"
                                      placeholder="Jumlah Tunai"
                                    />
                                  </div>
                                 
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Transfer</label>
                                    <input
                                      type="text"
                                      name="transfer"
                                      class="form-control"
                                      placeholder="Jumlah Transfer"
                                    />
                                  </div>
                                  
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Pengirim</label>
                                    <input
                                      type="text"
                                      id="nameWithTitle"
                                      name="pengirim_masuk"
                                      class="form-control"
                                      placeholder="Masukkan Nama"
                                    />
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Catatan</label>
                                    <textarea
                                      id="catatan_masuk"
                                      class="form-control"
                                      name="catatan_masuk"
                                      placeholder="Masukkan Catatan Tambahan"
                                    ></textarea>
                                  </div>
                                </div>

                                <hr style="border: 1px dashed grey; width: auto">
                                <p class="" style="margin:0; color: #d61204; font-weight: 600">Dana Keluar</p>

                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="merk" class="form-label">Tanggal</label>
                                    <input class="form-control" type="date" name="tanggal_keluar" id="html5-date-input" />
                                  </div>

                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Biaya Dikeluarkan</label>
                                    <input
                                      type="text"
                                      name="nominal_keluar"
                                      class="form-control"
                                      placeholder="Jumlah Biaya"
                                    />
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Catatan</label>
                                    <textarea
                                      id="catatan_keluar"
                                      name="catatan_keluar"
                                      class="form-control"
                                      placeholder="Masukkan Catatan Tambahan"
                                    ></textarea>
                                  </div>
                                </div>

                              </div>
                              <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Batal
                                </button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                              </div> -->

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                 
                    <!-- //Update -->


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
                                    <input class="form-control" type="date" name="tanggal" id="html5-date-input"/>
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
                    <!-- //Vertikal -->
                   <!-- //Modal Barang Keluar -->

            

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