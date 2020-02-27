<!-- Styles -->
<style>
#chartdiv3 {
  width: 100%;
  height: 500px;
}

</style>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv3", am4charts.XYChart3D);

// Add data
chart.data = [<?php for($y = 1; $y < $duration; $y++){ ?>{
    "year": "<?php echo $year[$y] ?>",
    <?php for($class= 1; $class < 6; $class++){  ?>
	"<?php echo $name[$class] ?>": "<?php echo $total_not_exempt_class[$y][$class] ?>",
	<?php } ?>
	
}, <?php } ?>];

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "year";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Traffic Classification on Class";
valueAxis.renderer.labels.template.adapter.add("text", function(text) {
  return text;
});
<?php for($class = 1; $class < 6; $class++){  ?>
// Create series
var series<?php if($class !=1){echo $class;} ?> = chart.series.push(new am4charts.ColumnSeries3D());
series<?php if($class !=1){echo $class;} ?>.dataFields.valueY = "<?php echo $name[$class] ?>";
series<?php if($class !=1){echo $class;} ?>.dataFields.categoryX = "year";
series<?php if($class !=1){echo $class;} ?>.name = "<?php echo $name[$class] ?>";
series<?php if($class !=1){echo $class;} ?>.clustered = true;
series<?php if($class !=1){echo $class;} ?>.columns.template.tooltipText = "<?php echo $name[$class]; ?> Traffic in {year}: [bold]{valueY}[/]";
series<?php if($class !=1){echo $class;} ?>.columns.template.fillOpacity = 0.9;
<?php }  ?>
/*var series2 = chart.series.push(new am4charts.ColumnSeries3D());
series2.dataFields.valueY = "wagon";
series2.dataFields.categoryX = "year";
series2.name = "Wagon";
series2.clustered = true;
series2.columns.template.tooltipText = "GDP grow in {category} (2017): [bold]{valueY}[/]";

var series3 = chart.series.push(new am4charts.ColumnSeries3D());
series3.dataFields.valueY = "<?php echo $name[2] ?>";
series3.dataFields.categoryX = "year";
series3.name = "<?php echo $name[2] ?>";
series3.clustered = true;
series3.columns.template.tooltipText = "GDP grow in {category} (2017): [bold]{valueY}[/]";
	
var series4 = chart.series.push(new am4charts.ColumnSeries3D());
series4.dataFields.valueY = "bus";
series4.dataFields.categoryX = "year";
series4.name = "Bus";
series4.clustered = true;
series4.columns.template.tooltipText = "GDP grow in {category} (2017): [bold]{valueY}[/]";

var series5 = chart.series.push(new am4charts.ColumnSeries3D());
series5.dataFields.valueY = "at-truck";
series5.dataFields.categoryX = "year";
series5.name = "Bus";
series5.clustered = true;
series5.columns.template.tooltipText = "GDP grow in {category} (2017): [bold]{valueY}[/]";*/

}); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv3"></div>