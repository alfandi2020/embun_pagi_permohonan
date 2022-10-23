<!-- Content -->

<div class="container-xxl">
     <div class="authentication-wrapper authentication-basic container-p-y">
       <div class="authentication-inner">
         <!-- Register -->
         <div class="card">
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
                 <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
               </div>
             </form>

             <!-- <p class="text-center">
               <span>New on our platform?</span>
               <a href="auth-register-basic.html">
                 <span>Create an account</span>
               </a>
             </p> -->
           </div>
         </div>
         <!-- /Register -->
       </div>
     </div>
   </div>

   <!-- / Content -->
