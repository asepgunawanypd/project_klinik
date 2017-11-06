<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>..::Login::..</title>
    <link rel="icon" type="image/jpg" href="<?php echo base_url(); ?>assets/img/favicon.png">

    <!-- Bootstrap -->
    <link href="<?php echo base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url('assets/vendors/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url('assets/vendors/nprogress/nprogress.css'); ?>" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url('assets/vendors/animate.css/animate.min.css'); ?>" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url('assets/build/css/custom.min.css'); ?>" rel="stylesheet">
    <style type="text/css">
      .login0 {
        background-image: url("<?php echo base_url('assets/img/background.jpg'); ?>");
      }
      .login_form0 {
            background-color: #e7e7e7;
        padding: 10px;
      }
    </style>
  </head>

  <body class="login">
    <div>
      <!--a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a-->

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="<?php echo base_url('Auth/login'); ?>" method="POST">
              <h1>Login Form</h1>
              <div>
                <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" autofocus required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div align="right">
                <button class="btn btn-primary submit"><i class="fa fa-sign-in"></i> Log in</button>
              </div>

              <div class="clearfix"></div>
               <?php if (validation_errors() || $this->session->flashdata('error_msg')) { ?>
                  <div class="alert alert-danger animated fadeInDown" role="alert" id="alert" style="color: rgba(255,255,255,.15);">
                    <!--button type="button" class="close" data-dismiss="alert">&times;</button-->
                    <strong>Warning !</strong>
                    <?php echo validation_errors(); ?>
                    <?php echo $this->session->flashdata('error_msg'); ?>
                  </div>
                <?php } ?>
              <div class="separator">
                <!--p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p-->

                <div class="clearfix"></div>
                <br />
                <div>
                  <h2>Clinical Management Information System</h2>
                  <p>©2018 All Rights Reserved. v.01</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <!--div id="register" class="animate form registration_form">
          <section class="login_content">
            <form>
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <a class="btn btn-default submit" href="index.html">Submit</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div-->

      </div>
    </div>
  </body>
</html>
