<style type="text/css">
  .table{
    overflow: auto;
  }
</style>

<div class="" role="tabpanel" data-example-id="togglable-tabs">
  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
    <?php if($access->user_r == 1){ ?>
    <li><a href="<?php echo base_url('User'); ?>" id="home-tab">User Management</a>
    </li>
    <?php } ?>
    <li class="active"><a href="<?php echo base_url('Access'); ?>" id="access-tab">Access Management</a>
    </li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Access List<small>Management</small></h2>
            <ul class="nav navbar-right panel_toolbox">        
              <li><a class="collapse-link"><i class="fa fa-circle-o"></i></a></li>
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="tableData" class="table table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="width: 5%;"><div align="center">No</div></th>
                  <th><div align="center">Username</div></th>
                  <th><div align="center">Registration</div></th>
                  <th><div align="center">Medical Services</div></th>
                  <th><div align="center">Chashier</div></th>
                  <th><div align="center">Pharmacy</div></th>
                  <th><div align="center">Pharmacy Werehouse</div></th>
                  <th><div align="center">User Management</div></th>
                  <th><div align="center">Access Management</div></th>
                  <th><div align="center">Clinic Management</div></th>
                </tr>
              </thead>
            </table>
            <div class="clearfix"></div>
              <div class="x_content">
                  <button id="view" type="button" class="btn btn-info" data-toggle="modal"><i class="glyphicon glyphicon-eye-open"></i> View</button>
                  <?php if($access->acc_c != 0){ ?>
                  <button id="add" type="button" class="btn btn-primary" data-toggle="modal" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Add</button>
                  <?php } if($access->acc_u != 0){ ?>
                  <button id="edit" type="button" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
                  <?php } if($access->acc_d != 0){ ?>
                  <button id="delete" type="button" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                  <?php } if($access->acc_p != 0){ ?>
                  <a href="<?php echo base_url('User/printpdf'); ?>" target="_blank" class="btn btn-info" title="Print"><i class="glyphicon glyphicon-print"></i> Print</a>
                  <?php } if($access->acc_ex != 0){ ?>
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
  function add(){
      save_method = 'add';
      $('#form')[0].reset();
      $('#modal_crud').modal({show:true});
      $('.modal-title').text('Add Access');
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
            url: "<?php echo base_url('Access/dataTable')?>",
            type: "POST"
        },
        language: {
          infoFiltered: " "
        },
        order: [],
        columns: [
            { "data": null },
            { "data": "username" },
            { "data": "reg_c",
              fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                   if(oData.reg_c){var ac ='<a class="btn btn-primary btn-xs">C</a>';}else{var ac ='';}
                   if(oData.reg_r){ var ar = '<a class="btn btn-info btn-xs">R</a>'; }else{var ar ='';}
                   if(oData.reg_u){ var au = '<a class="btn btn-warning btn-xs">U</a>'; }else{var au ='';}
                   if(oData.reg_d){ var ad = '<a class="btn btn-danger btn-xs">D</a>'; }else{var ad ='';}
                   if(oData.reg_p){ var ap = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var ap ='';}
                   if(oData.reg_ex){ var aex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var aex ='';}
                   $(nTd).html(ac+' '+ar+' '+au+' '+ad+' '+ap+' '+aex);
                }
            },
            { "data": "ms_c",
              fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                   if(oData.ms_c){var bc ='<a class="btn btn-primary btn-xs">C</a>';}else{var bc ='';}
                   if(oData.ms_r){ var br = '<a class="btn btn-info btn-xs">R</a>'; }else{var br ='';}
                   if(oData.ms_u){ var bu = '<a class="btn btn-warning btn-xs">U</a>'; }else{var bu ='';}
                   if(oData.ms_d){ var bd = '<a class="btn btn-danger btn-xs">D</a>'; }else{var bd ='';}
                   if(oData.ms_p){ var bp = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var bp ='';}
                   if(oData.ms_ex){ var bex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var bex ='';}
                   $(nTd).html(bc+' '+br+' '+bu+' '+bd+' '+bp+' '+bex);
                }
            },
            { "data": "cs_c",
              fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                   if(oData.cs_c){var cc ='<a class="btn btn-primary btn-xs">C</a>';}else{var cc ='';}
                   if(oData.cs_r){ var cr = '<a class="btn btn-info btn-xs">R</a>'; }else{var cr ='';}
                   if(oData.cs_u){ var cu = '<a class="btn btn-warning btn-xs">U</a>'; }else{var cu ='';}
                   if(oData.cs_d){ var cd = '<a class="btn btn-danger btn-xs">D</a>'; }else{var cd ='';}
                   if(oData.cs_p){ var cp = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var cp ='';}
                   if(oData.cs_ex){ var cex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var cex ='';}
                   $(nTd).html(cc+' '+cr+' '+cu+' '+cd+' '+cp+' '+cex);
                }
            },
            { "data": "far_c",
              fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                   if(oData.far_c){var dc ='<a class="btn btn-primary btn-xs">C</a>';}else{var dc ='';}
                   if(oData.far_r){ var dr = '<a class="btn btn-info btn-xs">R</a>'; }else{var dr ='';}
                   if(oData.far_u){ var du = '<a class="btn btn-warning btn-xs">U</a>'; }else{var du ='';}
                   if(oData.far_d){ var dd = '<a class="btn btn-danger btn-xs">D</a>'; }else{var dd ='';}
                   if(oData.far_p){ var dp = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var dp ='';}
                   if(oData.far_ex){ var dex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var dex ='';}
                   $(nTd).html(dc+' '+dr+' '+du+' '+dd+' '+dp+' '+dex);
                }
            },
            { "data": "farw_c",
              fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                   if(oData.farw_c){var ec ='<a class="btn btn-primary btn-xs">C</a>';}else{var ec ='';}
                   if(oData.farw_r){ var er = '<a class="btn btn-info btn-xs">R</a>'; }else{var er ='';}
                   if(oData.farw_u){ var eu = '<a class="btn btn-warning btn-xs">U</a>'; }else{var eu ='';}
                   if(oData.farw_d){ var ed = '<a class="btn btn-danger btn-xs">D</a>'; }else{var ed ='';}
                   if(oData.farw_p){ var ep = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var ep ='';}
                   if(oData.farw_ex){ var eex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var eex ='';}
                   $(nTd).html(ec+' '+er+' '+eu+' '+ed+' '+ep+' '+eex);
                }
            },
            { "data": "user_c",
              fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                   if(oData.user_c){var fc ='<a class="btn btn-primary btn-xs">C</a>';}else{var fc ='';}
                   if(oData.user_r){ var fr = '<a class="btn btn-info btn-xs">R</a>'; }else{var fr ='';}
                   if(oData.user_u){ var fu = '<a class="btn btn-warning btn-xs">U</a>'; }else{var fu ='';}
                   if(oData.user_d){ var fd = '<a class="btn btn-danger btn-xs">D</a>'; }else{var fd ='';}
                   if(oData.user_p){ var fp = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var fp ='';}
                   if(oData.user_ex){ var fex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var fex ='';}
                   $(nTd).html(fc+' '+fr+' '+fu+' '+fd+' '+fp+' '+fex);
                }
            },
            { "data": "acc_c",
              fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                   if(oData.acc_c){var gc ='<a class="btn btn-primary btn-xs">C</a>';}else{var gc ='';}
                   if(oData.acc_r){ var gr = '<a class="btn btn-info btn-xs">R</a>'; }else{var gr ='';}
                   if(oData.acc_u){ var gu = '<a class="btn btn-warning btn-xs">U</a>'; }else{var gu ='';}
                   if(oData.acc_d){ var gd = '<a class="btn btn-danger btn-xs">D</a>'; }else{var gd ='';}
                   if(oData.acc_p){ var gp = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var gp ='';}
                   if(oData.acc_ex){ var gex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var gex ='';}
                   $(nTd).html(gc+' '+gr+' '+gu+' '+gd+' '+gp+' '+gex);
                }
            },
            { "data": "cli_c",
              fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                   if(oData.cli_c){var hc ='<a class="btn btn-primary btn-xs">C</a>';}else{var hc ='';}
                   if(oData.cli_r){ var hr = '<a class="btn btn-info btn-xs">R</a>'; }else{var hr ='';}
                   if(oData.cli_u){ var hu = '<a class="btn btn-warning btn-xs">U</a>'; }else{var hu ='';}
                   if(oData.cli_d){ var hd = '<a class="btn btn-danger btn-xs">D</a>'; }else{var hd ='';}
                   if(oData.cli_p){ var hp = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var hp ='';}
                   if(oData.cli_ex){ var hex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var hex ='';}
                   $(nTd).html(hc+' '+hr+' '+hu+' '+hd+' '+hp+' '+hex);
                }
            }
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
          $.post("<?php echo base_url('Access/view'); ?>", { id:row.id  }, function(data) {
            var obj = JSON.parse(data);
            if (obj) {
              if(obj.reg_c ){var ac ='<a class="btn btn-primary btn-xs">C</a>';}else{var ac ='';}
              if(obj.reg_r){ var ar = '<a class="btn btn-info btn-xs">R</a>'; }else{var ar ='';}
              if(obj.reg_u){ var au = '<a class="btn btn-warning btn-xs">U</a>'; }else{var au ='';}
              if(obj.reg_d){ var ad = '<a class="btn btn-danger btn-xs">D</a>'; }else{var ad ='';}
              if(obj.reg_p){ var ap = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var ap ='';}
              if(obj.reg_ex){ var aex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var aex ='';}

              if(obj.ms_c ){var bc ='<a class="btn btn-primary btn-xs">C</a>';}else{var bc ='';}
              if(obj.ms_r){ var br = '<a class="btn btn-info btn-xs">R</a>'; }else{var br ='';}
              if(obj.ms_u){ var bu = '<a class="btn btn-warning btn-xs">U</a>'; }else{var bu ='';}
              if(obj.ms_d){ var bd = '<a class="btn btn-danger btn-xs">D</a>'; }else{var bd ='';}
              if(obj.ms_p){ var bp = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var bp ='';}
              if(obj.ms_ex){ var bex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var bex ='';}

              if(obj.cs_c ){var cc ='<a class="btn btn-primary btn-xs">C</a>';}else{var cc ='';}
              if(obj.cs_r){ var cr = '<a class="btn btn-info btn-xs">R</a>'; }else{var cr ='';}
              if(obj.cs_u){ var cu = '<a class="btn btn-warning btn-xs">U</a>'; }else{var cu ='';}
              if(obj.cs_d){ var cd = '<a class="btn btn-danger btn-xs">D</a>'; }else{var cd ='';}
              if(obj.cs_p){ var cp = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var cp ='';}
              if(obj.cs_ex){ var cex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var cex ='';}

              if(obj.far_c ){var dc ='<a class="btn btn-primary btn-xs">C</a>';}else{var dc ='';}
              if(obj.far_r){ var dr = '<a class="btn btn-info btn-xs">R</a>'; }else{var dr ='';}
              if(obj.far_u){ var du = '<a class="btn btn-warning btn-xs">U</a>'; }else{var du ='';}
              if(obj.far_d){ var dd = '<a class="btn btn-danger btn-xs">D</a>'; }else{var dd ='';}
              if(obj.far_p){ var dp = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var dp ='';}
              if(obj.far_ex){ var dex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var dex ='';}

              if(obj.farw_c ){var ec ='<a class="btn btn-primary btn-xs">C</a>';}else{var ec ='';}
              if(obj.farw_r){ var er = '<a class="btn btn-info btn-xs">R</a>'; }else{var er ='';}
              if(obj.farw_u){ var eu = '<a class="btn btn-warning btn-xs">U</a>'; }else{var eu ='';}
              if(obj.farw_d){ var ed = '<a class="btn btn-danger btn-xs">D</a>'; }else{var ed ='';}
              if(obj.farw_p){ var ep = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var ep ='';}
              if(obj.far_ex){ var eex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var eex ='';}

              if(obj.user_c ){var fc ='<a class="btn btn-primary btn-xs">C</a>';}else{var fc ='';}
              if(obj.user_r){ var fr = '<a class="btn btn-info btn-xs">R</a>'; }else{var fr ='';}
              if(obj.user_u){ var fu = '<a class="btn btn-warning btn-xs">U</a>'; }else{var fu ='';}
              if(obj.user_d){ var fd = '<a class="btn btn-danger btn-xs">D</a>'; }else{var fd ='';}
              if(obj.user_p){ var fp = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var fp ='';}
              if(obj.user_ex){ var fex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var fex ='';}

              if(obj.acc_c ){var gc ='<a class="btn btn-primary btn-xs">C</a>';}else{var gc ='';}
              if(obj.acc_r){ var gr = '<a class="btn btn-info btn-xs">R</a>'; }else{var gr ='';}
              if(obj.acc_u){ var gu = '<a class="btn btn-warning btn-xs">U</a>'; }else{var gu ='';}
              if(obj.acc_d){ var gd = '<a class="btn btn-danger btn-xs">D</a>'; }else{var gd ='';}
              if(obj.acc_p){ var gp = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var gp ='';}
              if(obj.acc_ex){ var gex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var gex ='';}

              if(obj.cli_c ){var hc ='<a class="btn btn-primary btn-xs">C</a>';}else{var hc ='';}
              if(obj.cli_r){ var hr = '<a class="btn btn-info btn-xs">R</a>'; }else{var hr ='';}
              if(obj.cli_u){ var hu = '<a class="btn btn-warning btn-xs">U</a>'; }else{var hu ='';}
              if(obj.cli_d){ var hd = '<a class="btn btn-danger btn-xs">D</a>'; }else{var hd ='';}
              if(obj.cli_p){ var hp = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-print"></i></a>'; }else{var hp ='';}
              if(obj.cli_ex){ var hex = '<a class="btn btn-info btn-xs"><i class="glyphicon glyphicon glyphicon-floppy-save"></i></a>'; }else{var hex ='';}

              $('#username_view').text(': '+obj.username);
              $('#menu1_view').html(': '+ac+' '+ar+' '+au+' '+ad+' '+ap+' '+aex);
              $('#menu2_view').html(': '+bc+' '+br+' '+bu+' '+bd+' '+bp+' '+bex);
              $('#menu3_view').html(': '+cc+' '+cr+' '+cu+' '+cd+' '+cp+' '+cex);
              $('#menu4_view').html(': '+dc+' '+dr+' '+du+' '+dd+' '+dp+' '+dex);
              $('#menu5_view').html(': '+ec+' '+er+' '+eu+' '+ed+' '+ep+' '+eex);
              $('#menu6_view').html(': '+fc+' '+fr+' '+fu+' '+fd+' '+fp+' '+fex);
              $('#menu7_view').html(': '+gc+' '+gr+' '+gu+' '+gd+' '+gp+' '+gex);
              $('#menu8_view').html(': '+hc+' '+hr+' '+hu+' '+hd+' '+hp+' '+hex);
              $('#modal_view').modal({show:true}); 
              $('.modal-title').text('Detail');
            }else{
               $('#username_view').text(': '+obj.username);
              $('#menu1_view').html('');
              $('#menu2_view').html('');
              $('#menu3_view').html('');
              $('#menu4_view').html('');
              $('#menu5_view').html('');
              $('#menu6_view').html('');
              $('#menu7_view').html('');
              $('#menu8_view').html('');
              $('#modal_view').modal({show:true}); 
              $('.modal-title').text('Detail');
            }
            
          });
        }
    });
     $('#form').submit(function(e){
         e.preventDefault(); 
         var url;
         var cek;
         if(save_method == 'add'){
           url = "<?php echo site_url('Access/add')?>";
           cek = globalVar;
         }else{
           url = "<?php echo site_url('Access/update')?>";
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
     $( "#user_id" ).on('change', function( event ) {
         event.preventDefault();
         $("#msg_username").html('<img src="<?php echo base_url('assets/img/loader.gif')?>" align="absmiddle">&nbsp;Checking availability...');
         var username = $(this).val();
         $.post("<?php echo base_url('Access/filename_exists'); ?>", { id:username  }, function(data) {   
           if (data == 'error') {
             $('#msg_username').html('<span style="color:red;">Value does not exist</span>');
           } else{
             $('#msg_username').html('');
           }
           window.globalVar = data;
         });
      });
  });

</script>