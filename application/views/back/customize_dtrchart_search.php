	<!-- Styles -->
<style>
#charttraffic {
  width: 100%;
  height: 400px;
}
#chartrevenue {
  width: 100%;
  height: 400px;
}

</style>

<!-- Resources -->
<script src="<?php echo base_url()?>assets/amcharts4/core.js"></script>
<script src="<?php echo base_url()?>assets/amcharts4/charts.js"></script>
<script src="<?php echo base_url()?>assets/amcharts4/animated.js"></script>
<script src="<?php echo base_url()?>assets/amcharts4/dataviz.js"></script>

<!-- Traffic Bar Chart Start -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("charttraffic", am4charts.XYChart);

// Add data
chart.data = [
	<?php 
		$i = 1;
		
			foreach($dtr1 as $id){
				if($tollplaza){
	?>
				{			
				  "date": "<?php echo $tollplaza['chart'][$i]['label']; ?>",
				  "traffic": <?php echo $tollplaza['chart'][$i]['total']; ?>,
				},
	<?php	}
				$i++;
			}
		
	?>
];

// Create axes

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "date";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.line.strokeOpacity = 1;
categoryAxis.renderer.minGridDistance = 30;

categoryAxis.renderer.cellStartLocation = 0.2;
categoryAxis.renderer.cellEndLocation = 0.8;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.min = 0;
	
// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "traffic";
series.dataFields.categoryX = "date";
series.name = "Traffic";
series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

}); // end am4core.ready()
</script>
<!--Traffic Bar Chart Ends-->
<!-- Revenue Bar Chart Start -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartrevenue", am4charts.XYChart);

// Add data
chart.data = [
	<?php 
		$i = 1;
		
			foreach($dtr1 as $id){
				if($tollplaza){	?>
				{			
				  "date": "<?php echo $tollplaza['revenue'][$i]['label']; ?>",
				  "revenue": <?php echo $tollplaza['revenue'][$i]['total']; ?>,
				},
	<?php	}
				$i++;
			}
		
	?>
];

// Create axes

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "date";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.line.strokeOpacity = 1;
categoryAxis.renderer.minGridDistance = 30;

categoryAxis.renderer.cellStartLocation = 0.2;
categoryAxis.renderer.cellEndLocation = 0.8;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.min = 0;
// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "revenue";
series.dataFields.categoryX = "date";
series.name = "Revenue";
series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

}); // end am4core.ready()
</script>
<!-- Revenue Bar Chart Ends -->

<!-- HTML -->
<div class="chart_div" style="margin-top: 0px !important;">
   <!-- Content row Start-->
<div class="row mb-2" style="margin-left:-20px; margin-right:0px;">

<!-- plaza and month filter START -->
<div class="search-box pull-left col-xl-3 col-md-6 mb-1 " style="">

  <!-- Hidden Form START -->
<!-- Hidden Form END -->

                  
             <!--<?php echo form_open_multipart(base_url().'admin/searchfordtrchart', array('id' => 'searchfordtrchart', 'method' => 'post'));?>

                     <select class="form-control required text-primary mb-1" name="tollplaza" id="tollplaza" class="card border-left-primary shadow h-100 py-2" style="height: 35px !important; padding-bottom: 6px; padding-left: 5px; border-left: .25rem solid #4e73df!important;">
                        <option value="">Select Toll Plaza</option>
                        <?php foreach($tollplaza as $row){?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php } ?>
                     </select> 
                    
                  <div class="date" style="display:none; width:50.25px; margin-right:30px !mportant; ">
                    <input type="text" id="formonth" name="formonth" class="form-control" placeholder="Select month" class="card border-left-primary shadow h-100 py-2" style="height: 30px !important; ">
                  </div>
            <?php echo form_close(); ?>-->
      </div>
	  <!--plaza and month filter END -->

<!-- Plazas (Name) Card -->
<!--
<div class="col-xl-3 col-md-6 mb-1" style="height: 8%;">
  <div class="card border-left-primary shadow h-100 py-2" style="border-left: .25rem solid #f6c23e!important;">
    <div class="card-body" style="padding: 1% !important;">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2" style="padding-left: 8%;">
          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="">               
            <h5 class="card-category text-warning" style="font-size: 16px;"><?php  echo $tollplaza['name'];?>
            <span class="pull-right text-warning" ></span></h5></div>
          <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 16px;"><?php echo $month.','.$year; ?></div>
        </div>
        <div class="col-auto" style="padding-right: 15%;">
          <i class="fas fa-calendar fa-2x text-gray-300" style="color:#f6c23e !important; margin-right: 5% !important;"></i>
        </div>
      </div>
    </div>
  </div>
</div>
-->

<!-- Total Traffic Card -->
<!--
<div class="col-xl-3 col-md-6 mb-1" style="height: 8%;">
  <div class="card border-left-primary shadow h-100 py-2" style="border-left: .25rem solid #36b9cc!important;">
    <div class="card-body" style="padding: 1% !important;">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2" style="padding-left: 8%;">
          <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><h5 style="font-size: 16px;">Total Traffic</h5></div>
          <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 16px;"><?php ?></div>
        </div>
        <div class="col-auto" style="padding-right: 10%;">
          <i class="fa fa-bus fa-2x text-gray-300" style="color:#36b9cc !important;" ></i>
        </div>
      </div>
    </div>
  </div>
</div>
-->

<!-- Total REVENUE Card -->
<!--<div class="col-xl-3 col-md-6 mb-1" style="height: 8%;">
  <div class="card border-left-success shadow h-100 py-2" style="border-left: .25rem solid #1cc88a!important;">
    <div class="card-body" style="padding: 1% !important;">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2" style="padding-left: 8%;">
          <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><h5 style="font-size: 16px;">Total Revenue</h5></div>
          <?php $exempt = $this->db->get_where('dtr_exempt',array('dtr_id' => $dtrid))->result_array(); ?>
         
		  <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 16px;"><?php echo $revenue['lrevenue'][0]['total']; ?></div>
        </div>
        <div class="col-auto" style="padding-right: 13%;">
          <i ><img style="width:40px;height:40px;" src="<?php echo base_url();?>assets/back/images/icon/pkr.png" alt="logo"></i>
        </div>
      </div>
    </div>
  </div>
</div>-->

</div><!-- Content row End -->

<div class="main-content-inner">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-tasks">
				<div class="card-header border-top-info shadow h-100 py-1" style=" padding-left:1rem; padding-right:1rem; padding-top:2px; border-top: .25rem solid #36b9cc!important;">
					<div class="row">
						<div class="col-md-4">
							<h4 class="card-title text-info" >Traffic </h4> 
						</div>
						<div class="col-md-4">
							<h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php  echo $tollplaza['name'];?> </h5>
						</div>
						<div class="col-md-4">
							<h6 class="pull-right"><?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div id="charttraffic"></div>
				</div>
			</div>			
		</div>
		<div class="col-md-12">
			<div class="card card-tasks">
				<div class="card-header border-top-info shadow h-100 py-1" style=" padding-left:1rem; padding-right:1rem; padding-top:2px; border-top: .25rem solid #36b9cc!important;">
					<div class="row">
						<div class="col-md-4">
							<h4 class="card-title text-info" >Revenue </h4> 
						</div>
						<div class="col-md-4">
							<h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php if(!empty($chart)){ echo $chart['tollplaza'];}?> </h5>
						</div>
						<div class="col-md-4">
							<h6 class="pull-right"><?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div id="chartrevenue"></div>
				</div>
			</div>			
		</div>
	</div>	
</div>
</div>
