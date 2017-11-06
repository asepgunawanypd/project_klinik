<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- meta -->
    <?php echo @$_meta; ?>
    <title>CMIS</title>
    <link rel="icon" type="image/jpg" href="<?php echo base_url(); ?>assets/img/favicon.png">
    <!-- css --> 
    <?php echo @$_css; ?>
    <!-- jQuery 2.2.3 -->
    <script src="<?php echo base_url(); ?>assets/build/js/jquery-2.2.3.min.js"></script>
  </head>

  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <!--div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-plus"></i> <span>CMIS</span></a>
            </div-->

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <?php echo @$_header; ?> 
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <?php echo @$_sidebar; ?>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
       <?php echo @$_nav; ?>
        <!-- /top navigation -->

        <!-- page content -->
        <?php echo @$_content; ?>
        <!-- /page content -->

        <!-- footer content -->
        <?php echo @$_footer; ?>
        <!-- /footer content -->
      </div>
    </div>

    <?php echo @$_js; ?>
  </body>
</html>