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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">ID <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
				<input type="hidden" name="created_at" id="created_at">
                <input type="hidden" name="created_by" id="created_by">
				<input type="number" id="id" name="id" autofocus="autofocus" required="required" autocomplete="off" class="form-control col-md-8 col-xs-12"><div id="msg_username"></div>
				<div id="msg_id"></div>
			</div> 
          </div>
		  <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="provinsi_id">Provinsi <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="provinsi_id" required name="provinsi_id" class="form-control col-md-8 col-xs-12" >
                <option></option>
                 <?php
                   foreach ($dataSelect as $val) {
                     ?>
                     <option value="<?php echo $val->id; ?>">
                       <?php echo $val->provinsi; ?>
                     </option>
                     <?php
                   }
                 ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Kabupaten">Kabupaten / Kota <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="kabupaten" name="kabupaten" required="required" autocomplete="off" class="form-control col-md-8 col-xs-12">
            </div>
			</div>  
        </div>
    </div>
  </div>
  <div class="modal-footer" style="text-align: center">
      <button class="btn btn-warning" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
      <button class="btn btn-info" type="reset"><i class="glyphicon glyphicon-refresh"></i> Reset</button>
      <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-saved"></i> Save</button>
  </div>
</form>



