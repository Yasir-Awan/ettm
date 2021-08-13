
<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 100%;
}

</style>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end



// Create chart instance
var chart = am4core.create("chartdiv", am4charts.PieChart);

// Add data
chart.data = [
  { "DSR": "Not Uploaded", "count": "<?php echo $dsr[0][0]['not_uploaded']; ?>", "outerradius": 60 },
   { "DSR": "Not Supervised", "count": "<?php echo $dsr[0][0]['unsupervised']; ?>", "outerradius": 60 }, 
    { "DSR": "Approved", "count": "<?php echo $dsr[0][0]['approved']; ?>", "outerradius": 60 },
    { "DSR": "Rejected", "count": "<?php echo $dsr[0][0]['rejected']; ?>" , "outerradius": 60},
  
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

pieSeries.dataFields.category = "DSR";
pieSeries.dataFields.radiusValue = "outerradius";
// Animate chart data
var radius = "outerradius";
function getCurrentData() {
  label.text = radius;
  var data = chart.data[radius];
  radius++;
  if (radius > 80)
    radius = 70;
  return data;
}

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
<div id="chartdiv"></div>