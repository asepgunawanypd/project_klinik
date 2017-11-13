<div class="" role="tabpanel" data-example-id="togglable-tabs">
  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
    <li class=""><a href="<?php echo base_url('Obat'); ?>" id="obat-tab">Obat</a></li>
    <li class=""><a href="<?php echo base_url('Jenis_obat'); ?>" id="jenis-tab">Jenis Obat</a></li>
    <li class="active"><a href="<?php echo base_url('Golongan_obat'); ?>" id="gol-tab">Golongan Obat</a></li>
    <li class=""><a href="<?php echo base_url('Satuan_kecil'); ?>" id="kecil-tab">Satuan Kecil</a></li>
    <li class=""><a href="<?php echo base_url('Satuan_besar'); ?>" id="besar-tab">Satuan Besar</a></li>
    <li class=""><a href="<?php echo base_url('Terapi_obat'); ?>" id="besar-tab">Data Terapi Obat</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="status-tab">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>List Golongan Obat<small>Management</small></h2>
            <ul class="nav navbar-right panel_toolbox">        
              <li><a class="collapse-link"><i class="fa fa-circle-o"></i></a></li>
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="tableData" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="width: 2%;"><div align="center">No</div></th>
                  <th style="width: 10%;"><div align="center">Kode</div></th>
                  <th><div align="center">Golongan Obat</div></th>
                </tr>
              </thead>
            </table>
            <div class="clearfix"></div>
              <div class="x_content">
                  <button id="view" type="button" class="btn btn-info" data-toggle="modal"><i class="glyphicon glyphicon-eye-open"></i> View</button>
                  <!--?php if($access->user_c != 0){ ?-->
                  <button id="add" type="button" class="btn btn-primary" data-toggle="modal" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Add</button>
                  <!--?php } if($access->user_u != 0){ ?-->
                  <button id="edit" type="button" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
                  <!--?php } if($access->user_d != 0){ ?-->
                  <button id="delete" type="button" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                  <!--?php } if($access->user_p != 0){ ?-->
                  <a href="<?php echo base_url('golongan_obat/printpdf'); ?>" target="_blank" class="btn btn-info" title="Print"><i class="glyphicon glyphicon-print"></i> Print</a>
                  <!--?php } if($access->user_ex != 0){ ?-->
                  <a href="<?php echo base_url('golongan_obat/export'); ?>" class="btn btn-info"><i class="glyphicon glyphicon glyphicon-floppy-save"></i> Export Excel</a>
                  <!--?php } ?-->
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $modal_view; ?>
<?php echo $modal_crud; ?>
<script type="text/javascript">
  function add(){
    save_method = 'add';
    $('.modal-title').text('Tambah Golongan Obat');
    $('[name="kd"]').attr('readonly', false);
    $('#form')[0].reset();
    $('#modal_crud').modal({show:true});
  }
  $(document).ready(function(){ 
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
        return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };
    // ========= DataTable =============
    var table = $('#tableData').DataTable({ 
        processing: true, 
        serverSide: true,
        aLengthMenu: [5,10, 25, 50, 100],  
        ajax: {
            url: "<?php echo base_url('golongan_obat/dataTable')?>",
            type: "POST"
        },
        language: {
          infoFiltered: " "
        },
        order: [],
        columns: [
            { "data": null },
            { "data": "kd"},
            { "data": "golongan_obat"}
        ], 
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html('<div align="center">'+index+'</div>');
        },
        columnDefs: [
          { "orderable": false, "targets": 0 }
        ]
    });
    // ========= Select Row =============
    $('#tableData tbody').on( 'click', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
          $(this).removeClass('selected');
      }
      else {
          table.$('tr.selected').removeClass('selected');
          $(this).addClass('selected');
      }
    });
    $('#view').click( function (){
        var row = $('#tableData').DataTable().row('.selected').data();
        if( ! row ){ swal("Warning", "No data selected", "info"); }
        else{
          $.post("<?php echo base_url('golongan_obat/view'); ?>", { id:row.kd }, function(data) {
            var obj = JSON.parse(data);
            $('#modal_view').modal({show:true});
            $('#v_kd').text(': '+obj.kd);
            $('#v_golongan_obat').text(': '+obj.golongan_obat);
          });
        }
    });
    $( "#kd" ).on('keyup', function( event ) {
      event.preventDefault();
      $("#msg_kd").html('<img src="<?php echo base_url('assets/img/loader.gif')?>" align="absmiddle">&nbsp;Checking availability...');
      var id = $(this).val();
      $.post("<?php echo base_url('golongan_obat/filename_exists'); ?>", { id:id  }, function(data) {   
        if (data == 'error') {
         $('#msg_kd').html('<span style="color:red;">Value does not exist</span>');
        }else{
          $('#msg_kd').html('');
        }
    window.globalVar = data;
    });
    });
    $('#form').submit(function(e){
      e.preventDefault(); 
      var url;
      var cek;
      if(save_method == 'add'){
         url = "<?php echo site_url('golongan_obat/add')?>";
         cek = globalVar;
      }else{
         url = "<?php echo site_url('golongan_obat/update')?>";
         cek = 'ok';
      }
      if(cek == 'error'){
         swal("Warning", "Kode fileid", "warning");
      }else{
        $.ajax({
          url : url,
          type: "POST",
          data: new FormData(this),
          processData:false,
          contentType:false,
          cache:false,
          dataType: "JSON",
          success: function(data){
            $('#modal_form').modal('hide');
            swal('Success','Data Seved', 'success').then(function(){
              location.reload();
            }); 
          },
          error: function (data){
            swal("Insert/Update  Data Error", "", "info").then(function(){
              location.reload();
            }); 
          }
        });
      }
    });
    $('#edit').click(function(){
            save_method = 'update';
            var data = $('#tableData').DataTable().row('.selected').data();
            if( ! data ){ swal("No data selected", "", "info"); }
            else{
        $.post("<?php echo base_url('golongan_obat/view'); ?>", { id:data.kd }, function(data) {
          var obj = JSON.parse(data);
          $('[name="kd"]').val(obj.kd);
          $('[name="kd"]').attr('readonly', true);
          $('[name="golongan_obat"]').val(obj.golongan_obat);
          $('[name="created_by"]').val(obj.created_by);
          $('[name="created_at"]').val(obj.created_at);
          $('#modal_crud').modal({show:true});
          $('.modal-title').text('Edit Golongan Obat ');
          window.id = obj.kd;
        });
      }
    });
    $('#delete').click(function(){
            var data = $('#tableData').DataTable().row('.selected').data();
            if( ! data ){ swal("No data selected", "", "info"); }
            else{
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
                 $.ajax({
                   url : "<?php echo site_url('golongan_obat/delete')?>/"+data.kd,
                   type: "POST",
                   success: function(data){               
                     swal('success','data success delete','success').then(function(){
                       location.reload();
                     }); 
                   },
                   error: function (data){
                     swal('Error','data is ready not delete ','error').then(function(){
                        location.reload();
                     })
                   },
                 });
               });
            }
         });

  });
</script>