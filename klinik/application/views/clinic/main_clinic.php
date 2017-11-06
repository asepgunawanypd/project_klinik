<div role="tabpanel" class="tab-pane fade active in" id="tab_content2" aria-labelledby="access-tab">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Clinic List<small>Management</small></h2>
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
              <th style="width: 5%;"><div align="center">No</div></th>
              <th><div align="center">Name</div></th>
              <th><div align="center">Address</div></th>
              <th><div align="center">Up</div></th>
              <th><div align="center">Phone</div></th>
              <th><div align="center">Email</div></th>
            </tr>
          </thead>
        </table>
        <div class="clearfix"></div>
          <div class="x_content">
              <button id="view" type="button" class="btn btn-info" data-toggle="modal"><i class="glyphicon glyphicon-eye-open"></i> View</button>
              <?php if($access->cli_r != 0){ ?>
              <button id="add" type="button" class="btn btn-primary" data-toggle="modal" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Add</button>
              <?php } if($access->cli_u != 0){ ?>
              <button id="edit" type="button" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
              <?php } if($access->cli_d != 0){ ?>
              <button id="delete" type="button" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
              <?php } if($access->cli_p != 0){ ?>
              <a href="<?php echo base_url('Clinic/printpdf'); ?>" target="_blank" class="btn btn-info" title="Print"><i class="glyphicon glyphicon-print"></i> Print</a>
              <?php } if($access->cli_ex != 0){ ?>
              <a href="<?php echo base_url('Clinic/export'); ?>" class="btn btn-info"><i class="glyphicon glyphicon glyphicon-floppy-save"></i> Export Excel</a>
              <?php } ?>
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
    $('.modal-title').text('Add User');
    $('#form')[0].reset();
    $('#modal_crud').modal({show:true});
    $('#photo').attr('readonly', false);
    $('#photo').attr('type', 'file');
    $('#img_remove').hide();
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
            url: "<?php echo base_url('Clinic/dataTable')?>",
            type: "POST"
        },
        language: {
          infoFiltered: " "
        },
        order: [],
        columns: [
            { "data": null },
            { "data": "nama" },
            { "data": "alamat" },
            { "data": "up" },
            { "data": "phone" },
            { "data": "email" }
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
    // ========= View ===================
    $('#view').click( function (){
        var row = $('#tableData').DataTable().row('.selected').data();
        if( ! row ){ swal("Warning", "No data selected", "info"); }
        else{
          $.post("<?php echo base_url('Clinic/view'); ?>", { id:row.id  }, function(data) {
            var obj = JSON.parse(data);
            $('#modal_view').modal({show:true});
            $('#v_nama').text(': '+obj.nama);
            $('#v_alamat').text(': '+obj.alamat);
            $('#v_up').text(': '+obj.up);
            $('#v_phone').text(': '+obj.phone);
            $('#v_email').text(': '+obj.email);
            if (obj.logo != " ") {
               $('#img_clinic').attr('src', '<?php echo base_url("assets/img/clinic/");?>'+obj.logo);  
            }
            if(obj.logo == ""){
               $('#img_clinic').attr('src', '<?php echo base_url("assets/img/clinic/noimage.png");?>');
            }
          });
        }
    });
    // ========================================== check name on db ===========
     $( "#nama" ).on('change', function( event ) {
         event.preventDefault();
         $("#msg_nama").html('<img src="<?php echo base_url('assets/img/loader.gif')?>" align="absmiddle">&nbsp;Checking availability...');
         var nama = $(this).val();
         $.post("<?php echo base_url('Clinic/filename_exists'); ?>", { nama:nama  }, function(data) {   
           if (data == 'error') {
             $('#msg_nama').html('<span style="color:red;">Value does not exist</span>');
           } else{
             $('#msg_nama').html('');
           }
           window.globalVar = data;
         });
      });
     //====================== Metod Save/Update ==========================//
      $('#form').submit(function(e){
         e.preventDefault(); 
         var url;
         var cek;
         if(save_method == 'add'){
           url = "<?php echo site_url('Clinic/add')?>";
           cek = globalVar;
         }else{
           url = "<?php echo site_url('Clinic/update')?>";
           cek = 'ok';
         }
         if(cek == 'error'){
           swal("Warning", "Name fileid", "warning");
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
               $('#modal_crud').modal('hide');
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
       // ============================================= Delete =========================================// 
         $('#delete').click(function(){
            var id = $('#tableData').DataTable().row('.selected').data();
            if( ! id ){ swal("No data selected", "", "info"); }
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
                   url : "<?php echo site_url('Clinic/delete')?>/"+id.id,
                   type: "POST",
                   success: function(data){               
                     swal('success','data success delete','success').then(function(){
                        $('#tableData').DataTable().ajax.reload();
                     }); 
                   },
                   error: function (data){
                     swal('Error','data is ready not delete ','error').then(function(){
                        $('#tableData').DataTable().ajax.reload();
                     })
                   },
                 });
               });
            }
         });
         //================================ Edit ==========================
          $('#edit').click(function(){
            save_method = 'update';
            var id = $('#tableData').DataTable().row('.selected').data();
            if( ! id ){ swal("No data selected", "", "info"); }
            else{
               $.post("<?php echo base_url('Clinic/edit_view'); ?>", { id:id.id  }, function(data) {
                 var obj = JSON.parse(data);
                 $('[name="nama"]').val(obj.nama);
                 $('#msg_nama').hide();
                 $('[name="alamat"]').val(obj.alamat);
                 $('[name="up"]').val(obj.up);
                 $('[name="phone"]').val(obj.phone);
                 $('[name="email"]').val(obj.email);
                 $('[name="id"]').val(obj.id);
                 if(obj.logo != " "){
                   $('#photo').attr('type', 'text');
                   $('#photo').val(obj.logo);
                   $('[name="photo"]').val(obj.logo);
                   $('#photo').attr('readonly', true); 
                   $('#img_remove').show();               
                 }
                 if(obj.logo == ""){
                   $('#img_remove').hide({hide:true});
                   $('#photo').attr('readonly', false);
                   $('#photo').attr('type', 'file');  
                 } 
                 $('#modal_crud').modal({show:true});
                 $('.modal-title').text('Edit Clinic');
                 window.id = obj.id;
              });
            }
          });
    //================= end ===================
  });

</script>