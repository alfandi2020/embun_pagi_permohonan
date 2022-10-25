<!-- Content -->

<div class="container-xxl">
     <div class="authentication-wrapper authentication-basic container-p-y">
       <div class="authentication-inner">
         <!-- Register -->
         <div class="card">
           <?php if($this->uri->segment(2) == 'registrasi'){ ?>
            <div class="card-body">
             <!-- Logo -->
             <div class="app-brand justify-content-center">
               <a href="index.html" class="app-brand-link gap-2">
                 <span class="app-brand-logo demo">
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="">
                  
                 </span>
                 <!-- <span class="app-brand-text demo text-body fw-bolder">Sneat</span> -->
               </a>
             </div>
             <!-- /Logo -->
             <?= $this->session->flashdata('msg') ?>
             <h5 class="mb-2">Registrasi User</h5>
             <!-- <p class="mb-4">Mohon isi dengan teliti</p> -->

             <form id="formAuthentication" class="mb-3"  method="POST" action="<?= base_url('auth/action_regis');?>">
               <div class="mb-3">
                 <label for="email" class="form-label">Nama</label>
                 <input
                   type="text"
                   class="form-control"
                   name="nama"
                   autocomplete="off"
                   value="<?= set_value('username');?>"
                   placeholder="Masukkan nama Pengguna "
                 />
                 <?= form_error('username', '<small class="text-danger pl-3">', '</small'); ?>
               </div>
               <div class="mb-3">
                 <label for="email" class="form-label">Username</label>
                 <input
                   type="text"
                   class="form-control"
                   name="username"
                   autocomplete="off"
                   value="<?= set_value('username');?>"
                   placeholder="Masukkan username "
                 />
                 <?= form_error('username', '<small class="text-danger pl-3">', '</small'); ?>
               </div>
               <div class="mb-3">
                 <label for="email" class="form-label">Email</label>
                 <input
                   type="email"
                   class="form-control"
                   name="email"
                   autocomplete="off"
                   value="<?= set_value('email');?>"
                   placeholder="Masukkan email "
                 />
                 <?= form_error('username', '<small class="text-danger pl-3">', '</small'); ?>
               </div>
               <div class="mb-3">
                 <label for="email" class="form-label">No Telp</label>
                 <input
                   type="number"
                   class="form-control"
                   name="telp"
                   autocomplete="off"
                   value="<?= set_value('email');?>"
                   placeholder="Masukkan No Telp "
                 />
                 <?= form_error('username', '<small class="text-danger pl-3">', '</small'); ?>
               </div>
              
               <div class="mb-3 form-password-toggle">
                 <div class="d-flex justify-content-between">
                   <label class="form-label" for="password">Password</label>
                 </div>
                 <div class="input-group input-group-merge">
                   <input
                     type="password"
                     id="password"
                     class="form-control"
                     name="password"
                     placeholder="Masukkan password"
                     aria-describedby="password"
                   />
                   <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                 </div>
                 <?= form_error('password', '<small class="text-danger pl-3">', '</small'); ?>
               </div>
               <div class="mb-3 form-password-toggle">
                 <div class="d-flex justify-content-between">
                   <label class="form-label" for="password">Password Konfirmasi</label>
                 </div>
                 <div class="input-group input-group-merge">
                   <input
                     type="password"
                     id="password"
                     class="form-control"
                     name="password_konfirmasi"
                     placeholder="Masukkan password konfirmasi"
                     aria-describedby="password"
                   />
                   <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                 </div>
                 <?= form_error('password', '<small class="text-danger pl-3">', '</small'); ?>
               </div>
               <div class="mb-3">
                  <label>Level</label>
                  <div class="input-group input-group-merge">
                    <select name="level" id="" class="form-control">
                      <option selected>Pilih Level</option>
                      <?php 
                      $d = $this->db->get_where('tb_level',['status' => 1])->result();
                      foreach($d as $x){ ?>
                        <option value="<?= $x->id ?>"><?= $x->nama ?></option>
                      <?php } ?>
                    </select>
                  </div>
               </div>
               <div class="mb-3">
                    <label class="form-label" for="modalAddCardCvv">Status Sekolah</label>
                    <div class="form-check">
                      <input name="status_sekolah[]" class="form-check-input" type="checkbox" value="TK" id="defaultRadio1" />
                      <label class="form-check-label" for="defaultRadio1">
                        TK
                      </label>
                    </div>
                    <div class="form-check">
                      <input name="status_sekolah[]" class="form-check-input" type="checkbox" value="SD" id="defaultRadio2"
                        />
                      <label class="form-check-label" for="defaultRadio2">
                        SD
                      </label>
                    </div>
                    <div class="form-check">
                      <input name="status_sekolah[]" class="form-check-input" type="checkbox" value="SMP" id="defaultRadio3"
                        />
                      <label class="form-check-label" for="defaultRadio3">
                        SMP
                      </label>
                    </div>
                  </div>
               <div class="mb-3">
                 <div class="form-check">
                   <label class="form-check-label" for="remember-me">  </label>
                 </div>
               </div>
               <div class="mb-3">
                 <button class="btn btn-primary d-grid w-100" type="submit">Registrasi</button><br>
                 <a href="<?= base_url('auth') ?>" class="btn btn-outline-primary d-grid w-100">Login</a>
               </div>
             </form>

             <!-- <p class="text-center">
               <span>New on our platform?</span>
               <a href="auth-register-basic.html">
                 <span>Create an account</span>
               </a>
             </p> -->
           </div>
            <?php }else{ ?>
           <div class="card-body">
             <!-- Logo -->
             <div class="app-brand justify-content-center">
               <a href="index.html" class="app-brand-link gap-2">
                 <span class="app-brand-logo demo">
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="">
                  
                 </span>
                 <!-- <span class="app-brand-text demo text-body fw-bolder">Sneat</span> -->
               </a>
             </div>
             <!-- /Logo -->
             <?= $this->session->flashdata('msg') ?>
             <h5 class="mb-2">Selamat Datang di Embun Pagi </h5>
             <p class="mb-4">Mohon masuk dengan akun anda</p>

             <form id="formAuthentication" class="mb-3"  method="POST" action="<?= base_url('auth');?>">
               <div class="mb-3">
                 <label for="email" class="form-label">Username</label>
                 <input
                   type="text"
                   class="form-control"
                   name="username"
                   autocomplete="off"
                   value="<?= set_value('username');?>"
                   placeholder="Masukkan nama Pengguna "
                 />
                 <?= form_error('username', '<small class="text-danger pl-3">', '</small'); ?>
               </div>
               <div class="mb-3 form-password-toggle">
                 <div class="d-flex justify-content-between">
                   <label class="form-label" for="password">Password</label>
                 </div>
                 <div class="input-group input-group-merge">
                   <input
                     type="password"
                     id="password"
                     class="form-control"
                     name="password"
                     placeholder="Masukkan password"
                     aria-describedby="password"
                   />
                   <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                 </div>
                 <?= form_error('password', '<small class="text-danger pl-3">', '</small'); ?>
               </div>
               <div class="mb-3">
                 <div class="form-check">
                
                   <label class="form-check-label" for="remember-me">  </label>
                 </div>
               </div>
               <div class="mb-3">
                 <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button><br>
                 <a href="<?= base_url('auth/registrasi') ?>" class="btn btn-outline-primary d-grid w-100">Registrasi</a>
               </div>
             </form>

             <!-- <p class="text-center">
               <span>New on our platform?</span>
               <a href="auth-register-basic.html">
                 <span>Create an account</span>
               </a>
             </p> -->
           </div>
           <?php } ?>
         </div>
         <!-- /Register -->
       </div>
     </div>
   </div>

   <!-- / Content -->
