<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gudang /</span> Stock</h4>
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                  <a href="" class="btn btn-primary mb-3"  data-bs-toggle="modal" data-bs-target="#modalCenter">Barang Baru ?</a>
                  <!-- Responsive Table -->
              <div class="card">
                 <h4 class="card-header">Stock Barang</h4>
           <div class="table-responsive card-datatable text-nowrap">
                  <table id="tabel-data" class="table">
                    <thead>
                      <tr class="text-nowrap">
                        <th>#</th>
                        <th>Nama Barang</th>
                        <th>Merk</th>
                        <th>Harga/pt</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php $x = 1; ?>
                      <?php foreach($user as $users) : ?>
                      <tr>
                        <th scope="row"><?= $x; ?></th>
                        <td><?= $users['nama_barang'];?></td>
                        <td><?= $users['merk'];?></td>
                        <td><?= $users['harga'];?></td>
                        <td><?= $users['jumlah'];?></td>
                        <td>
                          <a href="<?= base_url('index/detail_gudang/'.$users['id_barang']);?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: #5F61E6;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                            Lihat
                          </a>
                        </td>
                      </tr>
                      <?php $x++;?>
                      <?php endforeach; ?>
                     
                      <!-- <tr>
                        <th scope="row">2</th>
                        <td>Deigo Wangky Polos Navy</td>
                        <td>Deigo</td>
                        <td>Rp 57.500</td>
                        <td>320</td>
                        <td>
                          <a href="<?= base_url('index/detail_gudang');?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: #5F61E6;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                            Lihat
                          </a>
                        </td>
                      </tr> -->
                    
                      <!-- <tr>
                        <th scope="row">3</th>
                        <td>CR5 Wangky Polos Hitam</td>
                        <td>CR5</td>
                        <td>Rp 57.500</td>
                        <td>415</td>
                        <td>
                          <a href="<?= base_url('index/detail_gudang');?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: #5F61E6;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                            Lihat
                          </a>
                        </td>
                      </tr> -->

                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /Table -->

            </div>
            <!-- / Content -->


             <!-- Vertically Centered Modal -->
             <div class="col-lg-4 col-md-6">
                      <div class="mt-3">
                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <form method="POST" action="<?= base_url('index/data_baru_gudang');?>">
                        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="col">
                                  <h5 class="modal-title text" id="modalCenterTitle">Tambah Data</h5>
                                  <p class="modal-title" id="modalCenterTitle">Form ini diperuntukkan untuk data barang yang belum terdaftar.</p>
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
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input class="form-control" type="date" name="tanggal" id="html5-date-input" required/>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <input
                                      type="text"
                                      id="nama_barang"
                                      name="nama_barang"
                                      class="form-control"
                                      placeholder="Masukkan Nama Barang"
                                      required
                                    />
                                  </div>
                                 
                                  <div class="col mb-3">
                                    <label for="merk" class="form-label">Merk</label>
                                    <input
                                      type="text"
                                      id="merk"
                                      name="merk"
                                      class="form-control"
                                      placeholder="Masukkan Nama Merk"
                                      required
                                    />
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="harga" class="form-label">Harga/pt</label>
                                    <input
                                      type="text"
                                      id="harga"
                                      name="harga"
                                      class="form-control"
                                      placeholder="Masukkan Harga/potong"
                                      required
                                    />
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
                                    <label for="desk" class="form-label">Deskripsi</label>
                                    <input
                                      type="text"
                                      id="desk"
                                      name="desk"
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