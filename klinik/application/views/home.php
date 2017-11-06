<div class="row">
  <div class="col-lg-4 col-xs-6">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo $count_goods; ?></h3>

        <p>Goods</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-briefcase-outline"></i>
      </div>
      <?php if($access->mn_goods_r == 1){ ?><a href="<?php echo base_url('Goods') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a><?php } ?>
      <?php if($access->mn_goods_r == ""){ ?><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a><?php } ?>
    </div>
  </div>
  <div class="col-lg-4 col-xs-6">
    <div class="small-box bg-green">
      <div class="inner">
        <h3><?php echo $stock; ?></h3>

        <p>Goods Stock</p>
      </div>
      <div class="icon">
        <i class="fa fa-database"></i>
      </div>
      <?php if($access->mn_inout_r == 1){ ?><a href="<?php echo base_url('Inout') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a><?php } ?>
      <?php if($access->mn_inout_r = ""){ ?><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a><?php } ?>
    </div>
  </div>
  <div class="col-lg-4 col-xs-6">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3><?php echo $count_inout; ?></h3>

        <p>Goods Out</p>
      </div>
      <div class="icon">
        <i class="fa fa-sign-out"></i>
      </div>
      <?php if($access->mn_inout_r == 1){ ?><a href="<?php echo base_url('Inout') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a><?php } ?>
      <?php if($access->mn_inout_r == ""){ ?><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a><?php } ?>
    </div>
  </div>

  <div class="col-lg-6 col-xs-12">
    <div class="box box-info">
      <div class="box-header with-border">
        <i class="fa fa-pie-chart"></i>
        <h3 class="box-title">Chart <small>Good of Supplier</small></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <canvas id="data-inout" style="height:250px"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-6 col-xs-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <i class="fa fa-pie-chart"></i>
        <h3 class="box-title">Chart <small>Good Stock in Storage</small></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <canvas id="data-goods" style="height:250px"></canvas>
      </div>
    </div>
  </div>

</div>

<script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.min.js"></script>
<script>
  //data posisi
  var pieChartCanvas = $("#data-inout").get(0).getContext("2d");
  var pieChart = new Chart(pieChartCanvas);
  var PieData = <?php echo $data_inout; ?>;

  var pieOptions = {
    segmentShowStroke: true,
    segmentStrokeColor: "#fff",
    segmentStrokeWidth: 2,
    percentageInnerCutout: 50,
    animationSteps: 100,
    animationEasing: "easeOutBounce",
    animateRotate: true,
    animateScale: false,
    responsive: true,
    maintainAspectRatio: true,
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
  };

  pieChart.Doughnut(PieData, pieOptions);

  //data kota
  var pieChartCanvas = $("#data-goods").get(0).getContext("2d");
  var pieChart = new Chart(pieChartCanvas);
  var PieData = <?php echo $data_goods; ?>;

  var pieOptions = {
    segmentShowStroke: true,
    segmentStrokeColor: "#fff",
    segmentStrokeWidth: 2,
    percentageInnerCutout: 50,
    animationSteps: 100,
    animationEasing: "easeOutBounce",
    animateRotate: true,
    animateScale: false,
    responsive: true,
    maintainAspectRatio: true,
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
  };

  pieChart.Doughnut(PieData, pieOptions);
</script>