
<script src="<?php echo base_url()?>assets/amcharts4/core.js"></script>
	<script src="<?php echo base_url()?>assets/amcharts4/charts.js"></script>
	<script src="<?php echo base_url()?>assets/amcharts4/animated.js"></script>
	<script src="<?php echo base_url()?>assets/amcharts4/dataviz.js"></script>
<script>
	am4core.ready(function() {

	// Themes begin
	am4core.useTheme(am4themes_animated);
	// Themes end

	// Create chart instance
	var chart = am4core.create("allcharttrafficpday", am4charts.XYChart);

	// Add data
	chart.data = [{
	"label": "<?php echo $tollplazatoday['dtr']['traffic']['class1']['label']; ?>",
	"total": "<?php echo $tollplazatoday['dtr']['traffic']['class1']['data'] ?>",
	}, {
	"label": "<?php echo $tollplazatoday['dtr']['traffic']['class2']['label']; ?>",
	"total": "<?php echo $tollplazatoday['dtr']['traffic']['class2']['data'] ?>",
	}, {
	"label": "<?php echo $tollplazatoday['dtr']['traffic']['class3']['label']; ?>",
	"total": "<?php echo $tollplazatoday['dtr']['traffic']['class3']['data'] ?>",
	}, {
	"label": "<?php echo $tollplazatoday['dtr']['traffic']['class4']['label']; ?>",
	"total": "<?php echo $tollplazatoday['dtr']['traffic']['class4']['data'] ?>",
	}, {
	"label": "<?php echo $tollplazatoday['dtr']['traffic']['class5']['label']; ?>",
	"total": "<?php echo $tollplazatoday['dtr']['traffic']['class5']['data'] ?>",
	}];

	// Create axes

	var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
	categoryAxis.dataFields.category = "label";
	categoryAxis.renderer.grid.template.location = 0;
	categoryAxis.renderer.minGridDistance = 5;

	categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
	if (target.dataItem && target.dataItem.index & 2 == 2) {
	return dy + 25;
	}
	return dy;
	});

	var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

	// Create series
	var series = chart.series.push(new am4charts.ColumnSeries());
	series.dataFields.valueY = "total";
	series.dataFields.categoryX = "label";
	series.name = "Total";
	series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
	series.columns.template.fillOpacity = .8;

	var columnTemplate = series.columns.template;
	columnTemplate.strokeWidth = 2;
	columnTemplate.strokeOpacity = 1;

	}); // end am4core.ready()
</script>
