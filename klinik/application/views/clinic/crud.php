<div class="modal-header">
  	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
  	</button>
  	<h4 class="modal-title"></h4>
</div>
<div class="modal-body">
	<div class="row">
		<form class="form-horizontal form-label-right" id="form" enctype="multipart/form-data">
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Name <span class="required">*</span></label>
            <div class="col-md-9 col-sm-9 col-xs-12">
	        	<input type="hidden" name="created_at" id="created_at">
	            <input type="hidden" name="created_by" id="created_by">
	            <input type="hidden" name="id" id="id">
              <input type="text" name="nama" id="nama" required autocomplete="off" class="form-control" placeholder="Name"><div id="msg_nama"></div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Address <span class="required">*</span></label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <textarea class="form-control" name="alamat" autocomplete="off" id="alamat" required rows="3" placeholder="Address"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Up <span class="required">*</span></label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" name="up" id="up" autocomplete="off" class="form-control" required placeholder="Up">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Phone</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" autocomplete="off" name="phone" id="phone">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Email</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="email" class="form-control" autocomplete="off" name="email" id="email">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="img">Logo </label>
            <div class="col-md-6 col-sm-6 col-xs-8">
              <input type="file" name="photo" id="photo" class="form-control col-md-6 col-xs-8" style="width: 90%;padding: 6px 12px;">&nbsp;<img class="delfile" src="<?php echo base_url('assets/img/btn-del.png');?>" style="cursor:pointer;width:30px;" title="Delete File" data-toggle="tooltip" data-placement="top" id="img_remove"/>
              <script>
                //$("#form .delfile").tooltip();            
                $("#form .delfile").on("click", function(e){
                  e.preventDefault();
                  //var $fileid = $(e.currentTarget).attr("fileid");
                  var $id = id;
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
                      $.post("<?php echo base_url('Clinic/remove_photo'); ?>", { id: $id }, function(resp){
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
<div class="modal-footer" style="text-align: left">
  	<button class="btn btn-warning" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
  	<button class="btn btn-info" type="reset"><i class="glyphicon glyphicon-refresh"></i> Reset</button>
  	<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-saved"></i> Save</button>
</div>
</form>