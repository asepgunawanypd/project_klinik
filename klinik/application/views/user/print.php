<!DOCTYPE html>
<html>
<head>
    <title><?php echo $judul; ?></title>
    <!-- Bootstrap -->
    <link href="<?php echo base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   <!-- Bootstrap -->
    <script src="<?php echo base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
</head>
<body>
    <table  width="100%" border="0" cellspacing="5" cellpadding="5">
      <tr>
        <td align="center"><strong><h3><?php echo $judul; ?></h3></strong></td>
      </tr>
    </table>
    <p></p>
    <table class="table table-bordered dt-responsive nowrap" width="100%" border="1" cellspacing="5" cellpadding="5">>
        <thead> 
            <tr>   
                <th style="padding: 5px;" align="center">Username</th>
                <th style="padding: 5px;" align="center">Full Name</th>
                <th style="padding: 5px;" align="center">status</th>
                <th style="padding: 5px;" align="center">Clinic Name</th>
                <th style="padding: 5px;" align="center">Address</th>         
            </tr>    
        </thead>
        <tbody> 
            <?php
            foreach ($data_list as $val) {
                ?>
                <tr><td style="padding: 5px;"><?php echo $val->username; ?></td>
                    <td style="padding: 5px;"><?php echo $val->nama; ?></td>
                    <td style="padding: 5px;"><?php echo $val->status; ?></td>
                    <td style="padding: 5px;"><?php echo $val->nama_klinik; ?></td>
                    <td style="padding: 5px;"><?php echo $val->alamat; ?></td>
                </tr>
            <?php } ?> 
        </tbody>
    </table>
</body>
</html>