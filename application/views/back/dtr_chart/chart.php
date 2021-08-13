<!-- Styles -->
<style>
#<?php echo $toll['div']; ?> {
  width: 850px;
  height: 612px;
}
@media print {
  
  #<?php echo $toll['div']; ?> {
    max-height: 700px;
    max-width: 800px;
  }
}
@page { size: landscape; } 
</style>

<!-- Resources -->


<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("<?php echo $toll['div'] ?>", am4charts.XYChart3D);

// Add data
chart.data = [ 
	<?php if(isset($toll['data'])){ $data_no = 0; foreach($toll['data'] as $data){ ?> 
	{
		"date": "<?php echo $data['date']; ?>",
		
		"traffic": "<?php echo $data['traffic']; ?>",
		"percentage": "<?php echo $data['percentage']; ?>",
		"color": "<?php if($data_no == 0){ echo '#90EE90'; }elseif($data['date'] == 'Avg Per Day'){ echo '#FFFF00'; }else{ echo '#87CEEB';}?>"
	}, 
	<?php $data_no++; } } ?> 
		];

// Create axes
let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "date";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.renderer.labels.template.hideOversized = false;
categoryAxis.renderer.minGridDistance = 20;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.tooltip.label.rotation = 270;
categoryAxis.tooltip.label.horizontalCenter = "right";
categoryAxis.tooltip.label.verticalCenter = "middle";
	
let categoryAxis2 = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis2.dataFields.category = "percentage";
categoryAxis2.renderer.labels.template.rotation = 0;
categoryAxis2.renderer.labels.template.hideOversized = false;
categoryAxis2.renderer.minGridDistance = 20;
categoryAxis2.renderer.labels.template.horizontalCenter = "middle";
categoryAxis2.renderer.labels.template.verticalCenter = "middle";
categoryAxis2.tooltip.label.rotation = 0;
categoryAxis2.tooltip.label.horizontalCenter = "middle";
categoryAxis2.tooltip.label.verticalCenter = "right";

let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Traffic";
valueAxis.title.fontWeight = "bold";
valueAxis.calculateTotals = true;
valueAxis.min = 0;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries3D());
series.dataFields.valueY = "traffic";
series.dataFields.categoryX = "date";
series.name = "Traffic";
series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;
series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";
series.columns.template.propertyFields.fill = "color";
series.columns.template.propertyFields.stroke = "color";

series.calculatePercent = true;

/*series.labels.template.adapter.add("text", percentBullet);
series.tooltip.label.adapter.add("text", percentBullet);*/

/*var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;
columnTemplate.stroke = am4core.color("#FFFFFF");*/

/*columnTemplate.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
})

columnTemplate.adapter.add("stroke", function(stroke, target) {
  return chart.colors.getIndex(target.dataItem.index);
})*/

chart.cursor = new am4charts.XYCursor();
chart.cursor.lineX.strokeOpacity = 0;
chart.cursor.lineY.strokeOpacity = 0;
	

	
var totalBullet = series.bullets.push(new am4charts.LabelBullet());
totalBullet.dy = +10;
totalBullet.label.text = "{valueY.total}";
	
/*var percentBullet = series.bullets.push(new am4charts.LabelBullet());
percentBullet.dy = -20;
percentBullet.label.text = "{valueY.percent}%";*/
	

(function() {
  var beforePrint = function() {
    for(var i = 0; i < AmCharts.charts.length; i++) {
      var chart = AmCharts.charts[i];
      chart.div.style.width = "800px";
      chart.validateNow();
    }
  };
  var afterPrint = function() {
    for(var i = 0; i < AmCharts.charts.length; i++) {
      var chart = AmCharts.charts[i];
      chart.div.style.width = "800px";
      chart.validateNow();
    }
  };

  if (window.matchMedia) {
    var mediaQueryList = window.matchMedia('print');
    mediaQueryList.addListener(function(mql) {
      if (mql.matches) {
        beforePrint();
      } else {
        afterPrint();
      }
    });
  }

  window.onbeforeprint = beforePrint;
  window.onafterprint = afterPrint;
}());
}); /*end am4core.ready()*/
</script>

<!-- HTML -->
<div id="<?php echo $toll['div'] ?>"></div>