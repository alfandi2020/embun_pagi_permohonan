<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Stock Barang /</span> Cabang</h4>
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                  <a href="" class="btn btn-primary mb-3"  data-bs-toggle="modal" data-bs-target="#tambahToko">Tambah Toko</a>
                  <!-- Responsive Table -->
              <div class="card">
                 <h4 class="card-header">Toko</h4>
                <div class="table-responsive card-datatable text-nowrap">
                  <table id="tabel-data" class="table">
                    <thead>
                      <tr class="text-nowrap">
                        <th>#</th>
                        <th>Nama Cabang</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $x = 1; ?>
                      <?php foreach($allToko as $at) :?>
                      <tr>
                        <th scope="row"><?= $x; ?></th>
                        <td><?= $at['nama_toko'];?></td>
                        <td><?= $at['alamat'];?></td>
                        <td>
                          <a href="<?= base_url('index/detail_stock/'. $at['id_toko']);?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: #5F61E6;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                          Lihat
                          </a>
                        </td>
                      </tr>
                      <?php $x++;?>
                      <?php endforeach; ?>

                      
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
                        <form action="<?= base_url('index/tambahToko');?>" method="post">
                        <div class="modal fade" id="tambahToko" tabindex="-1" aria-hidden="true">
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
                                    <label for="nama_toko" class="form-label">Nama Cabang / Toko</label>
                                    <input
                                      type="text"
                                      id="nama_toko"
                                      name="nama_toko"
                                      class="form-control"
                                      placeholder="Masukkan Nama"
                                    />
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input
                                      type="text"
                                      id="alamat"
                                      name="alamat"
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