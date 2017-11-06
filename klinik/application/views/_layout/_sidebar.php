<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>Main Menu</h3>
    <ul class="nav side-menu">
      <li class=""><a href="<?php echo base_url('Home'); ?>" ><i class="fa fa-home"></i> Home</a>
      </li>
      <?php if($access->reg_r == 1){ ?>
      <li><a><i class="fa fa-hospital-o"></i> Registration</a></li>
      <?php } if($access->ms_r == 1){ ?>
      <li><a><i class="fa fa-stethoscope"></i> Medical Services</a></li>
      <?php } if($access->cs_r == 1){ ?>
      <li><a><i class="fa fa-money"></i> Cashier</a></li>
      <?php } if($access->far_r == 1 || $access->farw_r == 1 ){ ?>
      <li><a><i class="fa fa-medkit"></i>Pharmacy Management<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <?php if($access->far_r == 1){ ?>
          <li><a href="#">Pharmacy</a></li>
          <?php } if($access->farw_r == 1){ ?>
          <li><a href="#">Pharmacy Warehouse</a></li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>
      <li><a><i class="fa fa-database"></i>Master Data Reference<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <?php if($access->location_r) { ?>
            <?php if($page=="Provinsi") { ?>
              <li><a href="<?php echo base_url('Provinsi'); ?>">Location</a></li>
            <?php }else if($page=="Kabupaten") { ?>
              <li><a href="<?php echo base_url('Kabupaten'); ?>">Location</a></li>
            <?php }else if($page=="Kecamatan") { ?>
              <li><a href="<?php echo base_url('Kecamatan'); ?>">Location</a></li>
            <?php }else if($page=="Kelurahan") { ?>
              <li><a href="<?php echo base_url('Kelurahan'); ?>">Location</a></li>
            <?php } else { ?>
              <li><a href="<?php echo base_url('Provinsi'); ?>">Location</a></li>
          <?php } } ?>

          <li><a href="#">Data 2</a></li>
          <li><a href="#">Data 3</a></li>
          <li><a href="#">Data 4</a></li>
          <li><a href="#">Data 5</a></li>
          <li><a href="#">Data 6</a></li>
          <li><a href="#">Data 7</a></li>
          <li><a href="#">Data 8</a></li>
          <li><a href="#">Data 9</a></li>
          <li><a href="#">Data 10</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-bar-chart-o"></i>Report<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="#">Report 1</a></li>
          <li><a href="#">Report 2</a></li>
          <li><a href="#">Report 3</a></li>
          <li><a href="#">Report 4</a></li>
          <li><a href="#">Report 5</a></li>
          <li><a href="#">Report 6</a></li>
        </ul>
      </li>
      <?php if($access->user_r == 1 || $access->cli_r == 1 ){ ?>
      <li><a><i class="fa fa-cogs"></i> Setting <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <?php if($access->user_r == 1){ ?>
              <?php if($page=='User'){ ?>
              <li class=""><a href="<?php echo base_url('User'); ?>">User Management</a></li>
              <?php }else if($page=='Access'){ ?>
              <li class=""><a href="<?php echo base_url('Access'); ?>">User Management</a></li>
              <?php }else{ ?>
              <li class=""><a href="<?php echo base_url('User'); ?>">User Management</a></li>
              <?php } ?>
          <?php } if($access->cli_r == 1){ ?>
          <li class=""><a href="<?php echo base_url('Clinic'); ?>">Clinic Management</a></li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>
      <li><a href="<?php echo base_url('Auth/logout'); ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </div>
</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
