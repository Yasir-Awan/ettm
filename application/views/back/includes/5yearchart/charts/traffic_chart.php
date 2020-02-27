<!-- Styles -->
<style>
#chartdiv {
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
var chart = am4core.create("chartdiv", am4charts.XYChart3D);

// Add data
chart.data = [<?php for($y = 1; $y < $duration; $y++){ ?>{
    "year": "<?php echo $year[$y]; ?>",
    "traffic": "<?php echo $traffic[$y] ?>",
    /*"revenue": "<?php echo $revenue[$y] ?>"*/
}, <?php } ?>];

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "year";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Traffic";
valueAxis.min = 0;
valueAxis.calculateTotals = true;
valueAxis.renderer.labels.template.adapter.add("text", function(text) {
  return text ;
});

// Create series
var series = chart.series.push(new am4charts.ColumnSeries3D());
series.dataFields.valueY = "traffic";
series.dataFields.categoryX = "year";
/*series.dataFields.valueYShow = "average";*/
series.name = "Traffic";
series.clustered = false;
series.columns.template.tooltipText = "Traffic in {year}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = 0.8;

/*var series2 = chart.series.push(new am4charts.ColumnSeries3D());
series2.dataFields.valueY = "revenue";
series2.dataFields.categoryX = "year";
series2.name = "Revenue";
series2.clustered = false;
series2.columns.template.tooltipText = "Revenue in <?php echo $year[1]; ?>: [bold]{valueY}[/]";*/

}); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv"></div>