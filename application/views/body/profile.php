<div class="content-wrapper">
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
            <div class="col-md-6">
                <div class="card mb-4">
                    <h5 class="card-header">Update Profile</h5>
                    <div class="card-body">
                        <?= $this->session->flashdata('msg') ?>
                        <form id="formAuthentication" class="mb-3" method="POST"
                            action="<?= base_url('auth/update');?>">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="email" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" autocomplete="off"
                                        value="<?= $data['nama']?>" placeholder="Masukkan nama Pengguna " />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="email" class="form-label">Username</label>
                                    <input readonly type="text" class="form-control" name="username" autocomplete="off"
                                        value="<?= $data['username']?>" placeholder="Masukkan username " />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" autocomplete="off"
                                        value="<?= $data['email']?>" placeholder="Masukkan email " />
                                </div>
                            </div>
                            <!-- <div class="row mb-4">
                                <div class="col-md-4">
                                        <button class="btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Ganti Password</button>
                                </div>
                            </div>
                            <div class="collapse" id="collapseExample">
                   
                            </div> -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Level</label>
                                    <div class="input-group input-group-merge">
                                        <select name="level" id="" class="form-control">
                                            <option selected>Pilih Level</option>
                                            <?php 
                                                $d = $this->db->get_where('tb_level',['status' => 1])->result();
                                                foreach($d as $x){ ?>
                                            <option <?= $data['level'] == $x->id ? 'selected' : '' ?> value="<?= $x->id ?>"><?= $x->nama ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row col mb-3">
                                    <label class="form-label" for="modalAddCardCvv">Status Sekolah</label>
                                    <div class="col-md-2 form-check">
                                        <input name="status_sekolah[]" <?= strpos($data['status_sekolah'],'TK') !== false ? 'checked' : '' ?> class="form-check-input" type="checkbox" value="TK"
                                            id="defaultRadio1" />
                                        <label class="form-check-label" for="defaultRadio1">
                                            TK
                                        </label>
                                    </div>
                                    <div class="col-md-2 form-check">
                                        <input name="status_sekolah[]" <?= strpos($data['status_sekolah'],'SD') !== false ? 'checked' : '' ?>  class="form-check-input" type="checkbox" value="SD"
                                            id="defaultRadio2" />
                                        <label class="form-check-label" for="defaultRadio2">
                                            SD
                                        </label>
                                    </div>
                                    <div class="col-md-2 form-check">
                                        <input name="status_sekolah[]" <?= strpos($data['status_sekolah'],'SMP') !== false ? 'checked' : '' ?>  class="form-check-input" type="checkbox" value="SMP"
                                            id="defaultRadio3" />
                                        <label class="form-check-label" for="defaultRadio3">
                                            SMP
                                        </label>
                                    </div>
                                    <div class="col-md-2 form-check">
                                        <input name="status_sekolah[]" <?= strpos($data['status_sekolah'],'SMA') !== false ? 'checked' : '' ?>  class="form-check-input" type="checkbox" value="SMA"
                                            id="defaultRadio4" />
                                        <label class="form-check-label" for="defaultRadio4">
                                            SMA
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Update</button><br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <h5 class="card-header">Update Password</h5>
                    <div class="card-body">
                        <?= $this->session->flashdata('msg2') ?>
                        <form id="formAuthentication" class="mb-3" method="POST"
                            action="<?= base_url('auth/update');?>">
                            <input type="hidden" value="password" name="change">
                            <div class="row">
                                    <div class="col-md-4 mb-3 form-password-toggle">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="password">Password</label>
                                        </div>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" class="form-control" name="password"
                                                placeholder="Masukkan password" aria-describedby="password" />
                                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3 form-password-toggle">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="password">Password Konfirmasi</label>
                                        </div>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" class="form-control" name="password_konfirmasi"
                                                placeholder="Masukkan password konfirmasi" aria-describedby="password" />
                                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-2 mb-3">
                                <button class="btn btn-warning d-grid w-100" type="submit">Update</button><br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>