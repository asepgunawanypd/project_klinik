<div class="" role="tabpanel" data-example-id="togglable-tabs">
  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
    <li class=""><a href="<?php echo base_url('Provinsi'); ?>" id="pro-tab">Province</a></li>
    <li class=""><a href="<?php echo base_url('Kabupaten'); ?>" id="kab-tab">District / City</a></li>
    <li class="active"><a href="<?php echo base_url('Kecamatan'); ?>" id="kec-tab">Districts</a></li>
    <li class=""><a href="<?php echo base_url('Kelurahan'); ?>" id="kel-tab">Village</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="kab-tab">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>List Districts<small>Management</small></h2>
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
                  <th style="width: 10%;"><div align="center">ID District</div></th>
                  <th style="width: 10%;"><div align="center">ID Districts</div></th>
                  <th><div align="center">District/ City</div></th>
                  <th><div align="center">Districts</div></th>
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
                  <a href="<?php echo base_url('User/printpdf'); ?>" target="_blank" class="btn btn-info" title="Print"><i class="glyphicon glyphicon-print"></i> Print</a>
                  <!--?php } if($access->user_ex != 0){ ?-->
                  <a href="<?php echo base_url('User/export'); ?>" class="btn btn-info"><i class="glyphicon glyphicon glyphicon-floppy-save"></i> Export Excel</a>
                  <!--?php } ?-->
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
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
            url: "<?php echo base_url('Kecamatan/dataTable')?>",
            type: "POST"
        },
        language: {
          infoFiltered: " "
        },
        order: [],
        columns: [
            { "data": null },
            { "data": "kabupaten_id",
               fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                $(nTd).html('<div align="center">'+oData.kabupaten_id+'</div>');
               }
            },
            { "data": "id",
               fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                $(nTd).html('<div align="center">'+oData.id+'</div>');
               }
            },
            { "data": "kabupaten"},
            { "data": "kecamatan"}
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
  });
</script>