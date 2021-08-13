<!-- Styles -->
<style>
#chartdiv1 {
  width: 100%;
  height: 500px;
}

</style>

<!-- Resources -->
<script src="<?php echo base_url(); ?>assets/amcharts4/core.js"></script>
<script src="<?php echo base_url(); ?>assets/amcharts4/charts.js"></script>
<script src="<?php echo base_url(); ?>assets/amcharts4/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv1", am4charts.XYChart3D);

// Add data
	
chart.data = [<?php for($y = 1; $y < $duration; $y++){ ?>{
    "year": "<?php echo $year[$y]; ?>",
    
    "revenue": "<?php echo $revenue[$y] ?>"
}, <?php } ?>];
chart.fill = am4core.color("green");
// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "year";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Revenue";
	valueAxis.min = 0;
valueAxis.renderer.labels.template.adapter.add("text", function(text) {
  return text ;
});

// Create series

var series = chart.series.push(new am4charts.ColumnSeries3D());
series.dataFields.valueY = "revenue";
series.dataFields.categoryX = "year";
series.name = "Revenue";
series.clustered = false;
series.columns.template.tooltipText = "Revenue in {year}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = 0.8;
}); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv1"></div>