<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Profile<small>Management</small></h2>
      <ul class="nav navbar-right panel_toolbox">        
        <li><a class="collapse-link"><i class="fa fa-circle-o"></i></a></li>
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        <li><a class="close-link"><i class="fa fa-close"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <div class="row">
        <div class="col-md-4">
          <!-- Profile Image -->
               <img class="img-responsive avatar-view" src="<?php echo base_url(); ?>assets/img/user/<?php echo $userdata->foto; ?>" id="img_user" alt="Avatar" title="Change the avatar">

              <h3 class="profile-username"><?php echo $userdata->nama; ?></h3>

             
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Clinic Name</b> <a class="pull-right"><?php echo $userdata->nama_klinik; ?></a>
                </li>
              </ul>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Username</b> <a class="pull-right"><?php echo $userdata->username; ?></a>
                </li>
              </ul>   
        </div>

        <div class="col-md-8">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
              <li><a href="#password" data-toggle="tab">Ubah Password</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="settings">
                <p></p>
                <form class="form-horizontal" action="<?php echo base_url('Profile/update') ?>" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="inputUsername" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="username" placeholder="Username" readonly name="username" value="<?php echo $userdata->username; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputNama" class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" autocomplete="off" placeholder="Name" name="nama" value="<?php echo $userdata->nama; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputFoto" class="col-sm-2 control-label">Photo</label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control" placeholder="Foto" name="foto">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-save"></i> Save</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane" id="password">
                <p></p>
                <form class="form-horizontal" action="<?php echo base_url('Profile/ubah_password') ?>" method="POST">
                  <div class="form-group">
                    <label for="passLama" class="col-sm-2 control-label">Password Lama</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" autocomplete="off" placeholder="Password Lama" name="passLama">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="passBaru" class="col-sm-2 control-label">Password Baru</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" autocomplete="off" placeholder="Password Baru" name="passBaru">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="passKonf" class="col-sm-2 control-label">Konfirmasi Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" autocomplete="off" placeholder="Konfirmasi Password" name="passKonf">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-save"></i> Save</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>
          <?php if ($this->session->flashdata('msg')) { ?>
          <div class="alert alert-success alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <strong><?php echo $this->session->flashdata('msg'); ?></strong>
          </div>
          <?php } if (validation_errors()){ ?>
          <div class="alert alert-success alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <strong>Warning !</strong> <?php echo $this->session->flashdata('msg'); ?>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
