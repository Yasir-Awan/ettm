<?php include('includes/header.php'); ?>
<!-- plaza and month filter START -->
<div class="row">
  <div class="search-box pull-left col-xl-3 col-md-6 mb-1 " style="">

  <!-- Hidden Form START -->
<!-- Hidden Form END -->

                  
             <?php echo form_open_multipart(base_url().'admin/searchfordtrmchart', array('id' => 'searchfordtrmchart', 'method' => 'post'));?>

                     <!--<select class="form-control required text-primary mb-1" name="tollplaza" id="tollplaza" class="card border-left-primary shadow h-100 py-2" style="height: 35px !important; padding-bottom: 6px; padding-left: 5px; border-left: .25rem solid #4e73df!important;">
                        <option value="">Select Toll Plaza</option>
                        <?php $j = 1; foreach($toolplaza as $row){?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php $j++; } ?>
                     </select> -->
                    
                  <div class="date" style="width:50.25px; margin-right:30px !mportant; ">
                    <input type="text" id="formonth" name="formonth" class="form-control" placeholder="Select month" class="card border-left-primary shadow h-100 py-2" style="height: 30px !important; ">
                  </div>
            <?php echo form_close(); ?>
      </div>
</div>
	  <!--plaza and month filter END -->
<div class='chart_div' style="margin-top: -10px !important;"></div>
<div id="chart">
<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>


<!-- Styles -->
<?php $i = 1; foreach($tollplaza_asc as $tollplaza){ if($tollplaza){ ?>



<style>

#chartdiv<?php echo $i ?>{
  width: 100%;
  height: 500px;
}
#chartdiv0<?php echo $i ?>{
	width: 100%;
	height: 500px;
}
</style>



<!-- Chart code -->
<!--Traffic Charts Start-->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance

var chart = am4core.create("chartdiv<?php echo $i; ?>", am4charts.XYChart);

// Add data
chart.data = [
	<?php $j= 1; foreach($tollplaza['dtr']['chart'] as $chart){ if ($chart){ ?>
				{
				  "date": "<?php echo $chart['label']?>",
				  "class1": "<?php echo $chart['class1']['data']?>",
				  "class2": "<?php echo $chart['class2']['data']?>",
				  "class3": "<?php echo $chart['class3']['data']?>",
				  "class4": "<?php echo $chart['class4']['data']?>",
				  "class5": "<?php echo $chart['class5']['data']?>", 
				  "none"  : 0,
				}, 
		<?php } $j++; }  ?>
];
// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "date";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;



var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
/*valueAxis.renderer.inside = true;
valueAxis.renderer.labels.template.disabled = true;*/
valueAxis.min = 0;
valueAxis.renderer.line.strokeOpacity = 0.5;
valueAxis.renderer.ticks.template.stroke = am4core.color("#495C43");
valueAxis.calculateTotals = true;
// Create series
function createSeries(field, name, color) {
  
  // Set up series
  var series = chart.series.push(new am4charts.ColumnSeries());
  series.name = name;
  series.dataFields.valueY = field;
  series.dataFields.categoryX = "date";
  series.sequencedInterpolation = true;
  series.columns.template.fill = am4core.color(color);
  /*series.dataFields.valueYShow = valueAxis.calculateTotals;*/
	
	
  // Make it stacked
  series.stacked = true;
  
  // Configure columns
  series.columns.template.width = am4core.percent(40);
  series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";
 /* series.columns.template.alwaysShowTooltip = true;*/
	

 
  return series;
}
createSeries("class1", "Car ", "yellow");
createSeries("class2", "Wagon", "orange");
createSeries("class3", "Truck", "green");
createSeries("class4", "Bus", "brown");
createSeries("class5", "AT Truck", "red");


 // Add label
  /*var labelBullet = series.bullets.push(new am4charts.LabelBullet());
  labelBullet.label.text = "{valueY}";
  labelBullet.label.fill = am4core.color("black");
  labelBullet.locationY = 0.5;*/
	//labelBullet.locationY = 0.5;
	var totalSeries = chart.series.push(new am4charts.ColumnSeries());
totalSeries.dataFields.valueY = "none";
totalSeries.dataFields.categoryX = "date";
totalSeries.stacked = true;
totalSeries.hiddenInLegend = true;
totalSeries.columns.template.strokeOpacity = 0;

var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
totalBullet.dy = -20;
totalBullet.label.text = "{valueY.total}";

  
/*totalBullet.label.hideOversized = false;
totalBullet.label.fontSize = 18;
totalBullet.label.background.fill = totalSeries.stroke;
totalBullet.label.background.fillOpacity = 0.2;*/
totalBullet.label.padding(10);
/*chart.cursor= new am4charts.XYCursor();*/
// Legend
chart.legend = new am4charts.Legend();


}); // end am4core.ready()
	
</script>
<!--Traffic Charts End-->
<!--Revenue Charts Start-->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance

var chart = am4core.create("chartdiv0<?php echo $i; ?>", am4charts.XYChart);

// Add data
chart.data = [
	<?php $j= 1; foreach($tollplaza['dtr']['revenue'] as $revenue){ if ($revenue){ ?>
				{
				  "date": "<?php echo $revenue['label']?>",
				  "class1": "<?php echo $revenue['class1']['data']?>",
				  "class2": "<?php echo $revenue['class2']['data']?>",
				  "class3": "<?php echo $revenue['class3']['data']?>",
				  "class4": "<?php echo $revenue['class4']['data']?>",
				  "class5": "<?php echo $revenue['class5']['data']?>", 
				  "none": 0
				}, 
		<?php } $j++; }  ?>
];
// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "date";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;



var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
/*valueAxis.renderer.inside = true;
valueAxis.renderer.labels.template.disabled = true;*/
valueAxis.min = 0;
valueAxis.renderer.line.strokeOpacity = 0.5;
valueAxis.renderer.ticks.template.stroke = am4core.color("#495C43");
valueAxis.calculateTotals = true;

// Create series
function createSeries(field, name, color) {
  
  // Set up series
  var series = chart.series.push(new am4charts.ColumnSeries());
  series.name = name;
  series.dataFields.valueY = field;
  series.dataFields.categoryX = "date";
  series.sequencedInterpolation = true;
  series.columns.template.fill = am4core.color(color);
	
  // Make it stacked
  series.stacked = true;
  
  // Configure columns
  series.columns.template.width = am4core.percent(40);
  series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";
  
  // Add label
  var labelBullet = series.bullets.push(new am4charts.LabelBullet());
  //labelBullet.label.text = "{valueY.total}";
  //labelBullet.locationY = 0.5;
  
  return series;
}
createSeries("class1", "Car ", "yellow");
createSeries("class2", "Wagon", "orange");
createSeries("class3", "Truck", "green");
createSeries("class4", "Bus", "brown");
createSeries("class5", "AT Truck", "red");

	// Add label
  /*var labelBullet = series.bullets.push(new am4charts.LabelBullet());
  labelBullet.label.text = "{valueY}";
  labelBullet.label.fill = am4core.color("black");
  labelBullet.locationY = 0.5;*/
	//labelBullet.locationY = 0.5;
	var totalSeries = chart.series.push(new am4charts.ColumnSeries());
totalSeries.dataFields.valueY = "none";
totalSeries.dataFields.categoryX = "date";
totalSeries.stacked = true;
totalSeries.hiddenInLegend = true;
totalSeries.columns.template.strokeOpacity = 0;

var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
totalBullet.dy = -20;
totalBullet.label.text = "{valueY.total}";

  
/*totalBullet.label.hideOversized = false;
totalBullet.label.fontSize = 18;
totalBullet.label.background.fill = totalSeries.stroke;
totalBullet.label.background.fillOpacity = 0.2;*/
totalBullet.label.padding(10);
// Legend
chart.legend = new am4charts.Legend();


}); // end am4core.ready()
	
</script>
<!--Revenue Start End-->
<!-- HTML -->

<div class="row mb-2" style="margin-left:0px; margin-top:30px; margin-right:0px;" id="dtr_month">


<div class="main-content-inner col-md-12" id="dtrm">
	<div class="row" >
		<div class="col-md-12">			
				<div class="card card-tasks">
					<div class="card-header border-top-info shadow h-100 py-1" style=" padding-left:1rem; padding-right:1rem; padding-top:2px; border-top: .25rem solid #36b9cc!important;">
						<div class="row">
							<div class="col-md-4">
								<h4 class="card-title text-info" >Traffic </h4> 
							</div>
							<div class="col-md-4">
								<h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php echo $tollplaza['name'];?> </h5>
							</div>
							<div class="col-md-4">
								<h6 class="pull-right"><?php echo date("F, Y",strtotime($month_asc))?></h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div id="chartdiv<?php echo $i ?>"></div>
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
								<h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php echo $tollplaza['name'];?> </h5>
							</div>
							<div class="col-md-4">
								<h6 class="pull-right"><?php echo date("F, Y",strtotime($month_asc))?></h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div id="chartdiv0<?php echo $i ?>"></div>
					</div>
				</div>	
		</div>
	</div>	
</div>
</div>
<?php  $i++; } } ?> 
</div>
<?php include('includes/footer.php') ?>