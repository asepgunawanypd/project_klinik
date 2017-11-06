<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title"></h4>
</div>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <form class="form-horizontal" id="form" enctype="multipart/form-data">
             <div class="box-body">
                <div class="col-md-12">
                  <div class="col-xs-12">
                      <div class="form-group">
                         <label for="Level">Username</label>
                         <input type="hidden" name="id" id="id">                   
                         <select class="form-control" required id="user_id" name="user_id" required>
                           <option>Select</option>
                          <?php
                             foreach ($dataUser as $val) {
                               ?>
                               <option value="<?php echo $val->id; ?>">
                                 <?php echo $val->username; ?>
                               </option>
                               <?php
                             }
                           ?>
                        </select>
                        <div id="msg_username">
                      </div>
                   </div>

                   <div class="form-group">
                    <label for="Menu Registration">Menu Registration</label>  
                     <table width="100%" border="0">
                        <tr>
                          <td><input type="checkbox" value="1" id="reg_c" name="reg_c"> Creat</td>
                          <td><input type="checkbox" value="1" id="reg_r" name="reg_r"> Read </td>
                          <td><input type="checkbox" value="1" id="reg_u" name="reg_u"> Update</td>
                          <td><input type="checkbox" value="1" id="reg_d" name="reg_d"> Delete</td>
                          <td><input type="checkbox" value="1" id="reg_p" name="reg_p"> Print</td>
                          <td><input type="checkbox" value="1" id="reg_ex" name="reg_ex"> Export Xls</td>
                        </tr>
                      </table>                              
                    </div>

                    <div class="form-group">
                    <label for="Meical Services">Menu Meical Services</label>  
                     <table width="100%" border="0">
                        <tr>
                          <td><input type="checkbox" value="1" id="ms_c" name="ms_c"> Creat</td>
                          <td><input type="checkbox" value="1" id="ms_r" name="ms_r"> Read </td>
                          <td><input type="checkbox" value="1" id="ms_u" name="ms_u"> Update</td>
                          <td><input type="checkbox" value="1" id="ms_d" name="ms_d"> Delete</td>
                          <td><input type="checkbox" value="1" id="ms_p" name="ms_p"> Print</td>
                          <td><input type="checkbox" value="1" id="ms_ex" name="ms_ex"> Export Xls</td>
                        </tr>
                      </table>                              
                    </div>

                    <div class="form-group">
                    <label for="chashier">Menu chashier</label>  
                     <table width="100%" border="0">
                        <tr>
                          <td><input type="checkbox" value="1" id="cs_c" name="cs_c"> Creat</td>
                          <td><input type="checkbox" value="1" id="cs_r" name="cs_r"> Read </td>
                          <td><input type="checkbox" value="1" id="cs_u" name="cs_u"> Update</td>
                          <td><input type="checkbox" value="1" id="cs_d" name="cs_d"> Delete</td>
                          <td><input type="checkbox" value="1" id="cs_p" name="cs_p"> Print</td>
                          <td><input type="checkbox" value="1" id="cs_ex" name="cs_ex"> Export Xls</td>
                        </tr>
                      </table>                              
                    </div>

                    <div class="form-group">
                    <label for="Pharmacy">Menu Pharmacy </label>  
                     <table width="100%" border="0">
                        <tr>
                          <td><input type="checkbox" value="1" id="far_c" name="far_c"> Creat</td>
                          <td><input type="checkbox" value="1" id="far_r" name="far_r"> Read </td>
                          <td><input type="checkbox" value="1" id="far_u" name="far_u"> Update</td>
                          <td><input type="checkbox" value="1" id="far_d" name="far_d"> Delete</td>
                          <td><input type="checkbox" value="1" id="far_p" name="far_p"> Print</td>
                          <td><input type="checkbox" value="1" id="far_ex" name="far_ex"> Export Xls</td>
                        </tr>
                      </table>                              
                    </div>

                    <div class="form-group">
                    <label for="Pharmacy Werehouse">Menu Pharmacy Werehouse</label>  
                     <table width="100%" border="0">
                        <tr>
                          <td><input type="checkbox" value="1" id="farw_c" name="farw_c"> Creat</td>
                          <td><input type="checkbox" value="1" id="farw_r" name="farw_r"> Read </td>
                          <td><input type="checkbox" value="1" id="farw_u" name="farw_u"> Update</td>
                          <td><input type="checkbox" value="1" id="farw_d" name="farw_d"> Delete</td>
                          <td><input type="checkbox" value="1" id="farw_p" name="farw_p"> Print</td>
                          <td><input type="checkbox" value="1" id="farw_ex" name="farw_ex"> Export Xls</td>
                        </tr>
                      </table>                              
                    </div>

                    <div class="form-group">
                    <label for="Pharmacy User Management">Menu User Management</label>  
                     <table width="100%" border="0">
                        <tr>
                          <td><input type="checkbox" value="1" id="user_c" name="user_c"> Creat</td>
                          <td><input type="checkbox" value="1" id="user_r" name="user_r"> Read </td>
                          <td><input type="checkbox" value="1" id="user_u" name="user_u"> Update</td>
                          <td><input type="checkbox" value="1" id="user_d" name="user_d"> Delete</td>
                          <td><input type="checkbox" value="1" id="user_p" name="user_p"> Print</td>
                          <td><input type="checkbox" value="1" id="user_ex" name="user_ex"> Export Xls</td>
                        </tr>
                      </table>                              
                    </div>

                    <div class="form-group">
                    <label for="Access Management">Menu Access Management</label>  
                     <table width="100%" border="0">
                        <tr>
                          <td><input type="checkbox" value="1" id="acc_c" name="acc_c"> Creat</td>
                          <td><input type="checkbox" value="1" id="acc_r" name="acc_r"> Read </td>
                          <td><input type="checkbox" value="1" id="acc_u" name="acc_u"> Update</td>
                          <td><input type="checkbox" value="1" id="acc_d" name="acc_d"> Delete</td>
                          <td><input type="checkbox" value="1" id="acc_p" name="acc_p"> Print</td>
                          <td><input type="checkbox" value="1" id="acc_ex" name="acc_ex"> Export Xls</td>
                        </tr>
                      </table>                              
                    </div>

                    <div class="form-group">
                    <label for="Clinic Management">Clinic Management</label>  
                     <table width="100%" border="0">
                        <tr>
                          <td><input type="checkbox" value="1" id="cli_c" name="cli_c"> Creat</td>
                          <td><input type="checkbox" value="1" id="cli_r" name="cli_r"> Read </td>
                          <td><input type="checkbox" value="1" id="cli_u" name="cli_u"> Update</td>
                          <td><input type="checkbox" value="1" id="cli_d" name="cli_d"> Delete</td>
                          <td><input type="checkbox" value="1" id="cli_p" name="cli_p"> Print</td>
                          <td><input type="checkbox" value="1" id="cli_ex" name="cli_ex"> Export Xls</td>
                        </tr>
                      </table>                              
                    </div>

                 </div>
             </div>
           </div>
      </div>
    </div>
  </div>
  <div class="modal-footer" style="text-align: left">
      <button class="btn btn-warning" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
      <button class="btn btn-info" type="reset"><i class="glyphicon glyphicon-refresh"></i> Reset</button>
      <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-saved"></i> Save</button>
  </div>
</form>



