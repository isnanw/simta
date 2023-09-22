<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login | SIMTA</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("logo.png"); ?>">
  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700" rel="stylesheet">
  <!-- Icon Font -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/login/fonts/ionicons/css/ionicons.css">
  <!-- Text Font -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/login/fonts/font.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/login/css/bootstrap.css">
  <!-- Normal style CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/login/css/style.css">
  <!-- Normal media CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/login/css/media.css">
</head>

<body>

  <!-- Header start -->

  <!-- Header end -->
  <main class="cd-main">
    <section class="cd-section index3 visible">
      <div class="cd-content style3">
        <div class="login-box">
          <div class="login-form-slider">
            <!-- login slide start -->
            <div class="login-slide slide">
              <div class="d-flex height-100-percentage">
                <div class="align-self-center width-100-percentage">
                  <form class="floating-form" autocomplete="off" id="loginform" action="<?= base_url(); ?>auth/dologin"
                  method="post">
                  <small style='color:red'>
                    <?= $this->session->flashdata('login_msg'); ?>
                    </small>
                    <div class="form-group">
                      <input type="text" class="form-control" id="userX">
                      <input type='hidden' name='username' id='user'>
                      <label class="label">User name</label>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="passX">
                      <input type='hidden' name='password' id='pass'>
                      <label class="label">Password</label>
                    </div>
                    <div class="form-group">
                      <input type="submit" class="submit" value="Login">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <div id="cd-loading-bar" data-scale="1" class="index"></div>

  <script src="<?= base_url('assets'); ?>/AdminLTE-3.1.0/plugins/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets'); ?>/AdminLTE-3.1.0/plugins/jquery/md5.js"></script>

  <!-- JS File -->
  <script src="<?= base_url(); ?>assets/login/js/modernizr.js"></script>
  <!-- <script type="text/javascript" src="<?= base_url(); ?>assets/login/js/jquery.js"></script> -->
  <script type="text/javascript" src="<?= base_url(); ?>assets/login/js/popper.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/login/js/bootstrap.js"></script>
  <script src="<?= base_url(); ?>assets/login/js/velocity.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/login/js/script.js"></script>

  <script type="text/javascript">
    $("#loginform").submit(function(event) {
      str = $("#userX").val().replace(/\s+/g, '');
      $("#userX").val(str);
      $("#user").val($.md5($("#userX").val().toLowerCase()) ); //escape case sesitive username
      $("#pass").val($.md5($("#passX").val()) );
      //event.preventDefault();
    });
  </script>
</body>

</html>