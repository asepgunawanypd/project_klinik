<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title"></h4>
</div>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <form id="form" class="form-horizontal form-label-left" enctype="multipart/form-data">
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="username">Username <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="hidden" name="created_at" id="created_at">
                <input type="hidden" name="created_by" id="created_by">
              <input type="text" id="username" name="username" autofocus="autofocus" required="required" autocomplete="off" class="form-control col-md-7 col-xs-12"><div id="msg_username"></div>
            </div> 
          </div>
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="password">Password <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="password" id="password" name="password" required="required" autocomplete="off" class="form-control col-md-7 col-xs-12"><div id="pass" style="color: red;"><i>empty if not in edit</i></div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="nama">Full Name <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="nama" name="nama" autocomplete="off" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div> 
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="klinik_id">Clinic <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="klinik_id" required name="klinik_id" class="form-control col-md-7 col-xs-12" >
                <option></option>
                 <?php
                   foreach ($dataKlinik as $val) {
                     ?>
                     <option value="<?php echo $val->id; ?>">
                       <?php echo $val->nama; ?>
                     </option>
                     <?php
                   }
                 ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="status">Status <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
             
                Active
                <input type="radio" class="flat form-control col-md-7 col-xs-12" name="status" id="status1" value="Active" checked="" required />&nbsp; &nbsp; 
                Not Active
                <input type="radio" class="flat form-control col-md-7 col-xs-12" name="status" id="status" value="No Active" />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="img">Images </label>
            <div class="col-md-6 col-sm-6 col-xs-8">
              <input type="file" name="photo" id="photo" class="form-control col-md-6 col-xs-8" style="width: 90%;padding: 6px 12px;">&nbsp;<img class="delfile" src="<?php echo base_url('assets/img/btn-del.png');?>" style="cursor:pointer;width:30px;" title="Delete File" data-toggle="tooltip" data-placement="top" id="img_remove"/>
              <script>
                //$("#form .delfile").tooltip();            
                $("#form .delfile").on("click", function(e){
                  e.preventDefault();
                  //var $fileid = $(e.currentTarget).attr("fileid");
                  var $id = user;
                  swal({
                    title: 'Delete File Attachment',
                    text: 'Are You Sure Delete This File?',
                    type: 'warning',
                    html: '',
                    confirmButtonColor: '#d9534f',
                    confirmButtonText: "Yes, delete",
                    showCloseButton: true,
                    showCancelButton: true,
                  }).then(function(){
                    if( $id != '' ){
                      $.post("<?php echo base_url('User/remove_photo'); ?>", { id: $id }, function(resp){
                        //$(e.currentTarget.parentNode).remove();
                        swal("Deleted", "Your data has been deleted.", "success");
                        $("#img_remove").hide();
                        $('[id="photo"]').attr('readonly', false);
                        $('[id="photo"]').attr('type', 'file'); 
                        
                      });
                    }
                  });
                   
                });
              </script>
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



