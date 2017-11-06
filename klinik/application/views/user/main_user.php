<div class="" role="tabpanel" data-example-id="togglable-tabs">
  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
    <li class="active"><a href="<?php echo base_url('User'); ?>" id="home-tab">User Management</a>
    </li>
    <?php if($access->acc_r == 1){ ?>
    <li class=""><a href="<?php echo base_url('Access'); ?>" id="access-tab">Access Management</a>
    </li>
    <?php } ?>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>User List<small>Management</small></h2>
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
                  <th><div align="center">Username</div></th>
                  <th><div align="center">Full Name</div></th>
                  <th><div align="center">Status</div></th>
                  <th><div align="center">Clinic</div></th>
                </tr>
              </thead>
            </table>
            <div class="clearfix"></div>
              <div class="x_content">
                  <button id="view" type="button" class="btn btn-info" data-toggle="modal"><i class="glyphicon glyphicon-eye-open"></i> View</button>
                  <?php if($access->user_c != 0){ ?>
                  <button id="add" type="button" class="btn btn-primary" data-toggle="modal" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Add</button>
                  <?php } if($access->user_u != 0){ ?>
                  <button id="edit" type="button" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
                  <?php } if($access->user_d != 0){ ?>
                  <button id="delete" type="button" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                  <?php } if($access->user_p != 0){ ?>
                  <a href="<?php echo base_url('User/printpdf'); ?>" target="_blank" class="btn btn-info" title="Print"><i class="glyphicon glyphicon-print"></i> Print</a>
                  <?php } if($access->user_ex != 0){ ?>
                  <a href="<?php echo base_url('User/export'); ?>" class="btn btn-info"><i class="glyphicon glyphicon glyphicon-floppy-save"></i> Export Excel</a>
                  <?php } ?>
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
  // ================ Add ============== 
    function add(){
      save_method = 'add';
      $('#pass').hide();
      $('[name="username"]').attr('readonly', false);
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
            url: "<?php echo base_url('User/dataTable')?>",
            type: "POST"
        },
        language: {
          infoFiltered: " "
        },
        order: [],
        columns: [
            { "data": null },
            { "data": "username" },
            { "data": "nama" },
            { "data": "status" },
            { "data": "nama_klinik" }
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
          $.post("<?php echo base_url('User/view'); ?>", { id:row.id  }, function(data) {
            var obj = JSON.parse(data);
            $('#modal_view').modal({show:true});
            $('#v_user').text(': '+obj.username);
            $('#v_nama').text(': '+obj.nama);
            $('#v_status').text(': '+obj.status);
            $('#v_clinik').text(': '+obj.nama_klinik);
            $('#v_address').text(': '+obj.alamat);
            if (obj.foto != ' ') {
               $('#img_user').attr('src', '<?php echo base_url("assets/img/user/");?>'+obj.foto);  
            }else{
               $('#img_user').attr('src', '<?php echo base_url("assets/img/user/noimage.png");?>');
            }
          });
        }
    });
    // ========================================== check username on db ===========
     $( "#username" ).on('change', function( event ) {
         event.preventDefault();
         $("#msg_username").html('<img src="<?php echo base_url('assets/img/loader.gif')?>" align="absmiddle">&nbsp;Checking availability...');
         var username = $(this).val();
         $.post("<?php echo base_url('User/filename_exists'); ?>", { username:username  }, function(data) {   
           if (data == 'error') {
             $('#msg_username').html('<span style="color:red;">Value does not exist</span>');
           } else{
             $('#msg_username').html('');
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
           url = "<?php echo site_url('User/add')?>";
           cek = globalVar;
         }else{
           url = "<?php echo site_url('User/update')?>";
           cek = 'ok';
         }
         if(cek == 'error'){
           swal("Warning", "Username fileid", "warning");
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
                   url : "<?php echo site_url('User/delete')?>/"+id.id,
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
               $.post("<?php echo base_url('User/edit_view'); ?>", { id:id.id  }, function(data) {
                 var obj = JSON.parse(data);
                 $('[name="username"]').val(obj.username);
                 $('[name="username"]').attr('readonly', true);
                 $('#msg_username').hide();
                 $('#password').attr('required', false);
                 $('[name="nama"]').val(obj.nama);
                 $('#pass').show();
                 $('[name="klinik_id"]').val(obj.id_klinik);
                 $('[name="created_by"]').val(obj.created_by);
                 $('[name="created_at"]').val(obj.created_at);
                 if(obj.status == 'Active'){
                   $('#status1').attr('checked', true);
                   $('#status').attr('checked', false);  
                 }else{
                   $('#status1').attr('checked', false);
                   $('#status').attr('checked', true);
                 }
                 if(obj.foto !=' '){
                   $('#photo').attr('type', 'text');
                   $('#photo').val(obj.foto);
                   $('[name="photo"]').val(obj.foto);
                   $('#photo').attr('readonly', true); 
                   $('#img_remove').show();               
                 }else{
                   $('#img_remove').hide();
                   $('#photo').attr('readonly', false);
                   $('#photo').attr('type', 'file');  
                 } 
                 $('#modal_crud').modal({show:true});
                 $('.modal-title').text('Edit User');
                 window.user = obj.id;
              });
            }
          });
    //================= end ===================
  });
</script>