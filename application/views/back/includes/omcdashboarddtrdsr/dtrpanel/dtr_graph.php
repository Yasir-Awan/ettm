
<!-- Styles -->
<style>
#chartdiv-dtr {
  width: 100%;
  height: 100%;
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

/**
 * Define data for each year
 */
var chartData = {
  "MONTH": [
    { "dtr": "Not Uploaded", "count": "<?php if(isset($toolplaza_dtr)) echo $toolplaza_dtr ?>" },
    { "dtr": "Uploaded", "count": "<?php if(isset($dtr_count)) echo $dtr_count ?>" } ],
  "DAY": [
    { "dtr": "Not Uploaded", "count": "<?php if(isset($toolplaza_dtr)) echo $toolplaza_dtr ?>" },
    { "dtr": "Uploaded", "count": "<?php if(isset($dtr_count)) echo $dtr_count ?>" } ],
  
};

// Create chart instance
var chart = am4core.create("chartdiv-dtr", am4charts.PieChart);

// Add data
chart.data = [
  { "dtr": "Not Uploaded", "count": "<?php echo $toolplaza_dtr ?>" },
  { "dtr": "Uploaded", "count": "<?php echo $dtr_count ?>" },
  
];

// Add label
chart.innerRadius = 50;
var label = chart.seriesContainer.createChild(am4core.Label);
label.text = "U / NU";
label.horizontalCenter = "middle";
label.verticalCenter = "middle";
label.fontsize = 75;

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "count";
pieSeries.dataFields.category = "dtr";

// Animate chart data
/*var currentYear = "MONTH";
function getCurrentData() {
  label.text = currentYear;
  var data = chartData[currentYear];
  currentYear++;
  if (currentYear > 2014)
    currentYear = 1995;
  return data;
}*/

/*function loop() {
  //chart.allLabels[0].text = currentYear;
  var data = getCurrentData();
  for(var i = 0; i < data.length; i++) {
    chart.data[i].count = data[i].count;
  }
  chart.invalidateRawData();
  chart.setTimeout( loop, 4000 );
}

loop();*/

}); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv-dtr"></div>
