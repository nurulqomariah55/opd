<body style="background: url('assets/img/bic.jpg') center center no-repeat;
background-size: cover;
background-color: rgba(13,60,78,0.8);
height: 100vh;">
  <div class="overlay-bg">
    <div class="container">
      <div class="col-12 col-md-4 offset-0 offset-md-4 card card-login text-center"><br><br><br><br><br><br><br>
        <div class="container">          
          <h5 class="font-weight-bold">Checkpoint Application </h5>
          <h5 class="font-weight-bold">Operation Security Department </h5><br>        
          <?= $this->session->flashdata('message'); ?> <br>
          <form class="user" method="post" action="<?= base_url() ?>">
            <div class="form-group">
            <?php echo form_error('username'); ?>
              <input type="text" name="username" class="form-control form-login" placeholder="Username">
            </div>
            <div class="form-group">

            <?php echo form_error('password'); ?>
              <input type="password" name="password" class="form-control form-login" id="exampleInputPassword1" placeholder="Password">
            </div>
            <br>
            <input type="submit" class="form-control font-weight-bold text-center col-12 col-md-6 btn btn-info btn-login" value="Login">
            <br>
            <a href="<?php echo base_url('forget'); ?>" class="nav-link  nav-forgot text-white text-right">Forgot password</a>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->