<!-- Bar Graph Script START -->
<script src="<?php echo base_url()?>assets/amcharts4/core.js"></script>
<script src="<?php echo base_url()?>assets/amcharts4/charts.js"></script>
<script src="<?php echo base_url()?>assets/amcharts4/animated.js"></script>
<script src="<?php echo base_url()?>assets/amcharts4/dataviz.js"></script>

<script>
  /**
  * --------------------------------------------------------
  * This demo was created using amCharts V4 preview release.
  *
  * V4 is the latest installement in amCharts data viz
  * library family, to be released in the first half of
  * 2018.
  *
  * For more information and documentation visit:
  * https://www.amcharts.com/docs/v4/
  * --------------------------------------------------------
  */

  am4core.useTheme(am4themes_animated);
  am4core.useTheme(am4themes_dataviz);

  var chart = am4core.create("chartdiv33", am4charts.XYChart);

  chart.data = [
    {
      category: "<?php echo $chart['class1']['label']?>",
      "fill": '#e20404',
      value1: <?php echo $chart['class1']['data'];?>,
      <?php if(!empty($pre_month_chart['month'])){?>
          value2: <?php echo $pre_month_chart['class1']['data'];?>,
          <?php }if(!empty($pre_year_chart['month'])){?>
          value3: <?php echo $pre_year_chart['class1']['data'];?>,
          <?php } ?>
    },
    {
      category: "<?php echo $chart['class2']['label']?>",
      value1: <?php echo $chart['class2']['data'];?>,
      <?php if(!empty($pre_month_chart['month'])){?>
          value2: <?php echo $pre_month_chart['class2']['data'];?>,
          <?php }if(!empty($pre_year_chart['month'])){?>
          value3: <?php echo $pre_year_chart['class2']['data'];?>,
          <?php } ?>
    },
    {
      category: "<?php echo $chart['class3']['label']?>",
      value1: <?php echo $chart['class3']['data'];?>,
      <?php if(!empty($pre_month_chart['month'])){?>
          value2: <?php echo $pre_month_chart['class3']['data'];?>,
          <?php }if(!empty($pre_year_chart['month'])){?>
          value3: <?php echo $pre_year_chart['class3']['data'];?>,
          <?php } ?>
    },
    {
      category: "<?php echo $chart['class4']['label']?>",
      value1: <?php echo $chart['class3']['data'];?>,
      <?php if(!empty($pre_month_chart['month'])){?>
          value2: <?php echo $pre_month_chart['class4']['data'];?>,
          <?php }if(!empty($pre_year_chart['month'])){?>
          value3: <?php echo $pre_year_chart['class4']['data'];?>,
          <?php } ?>
    },
    {
      category: "<?php echo $chart['class5']['label']?>",
      value1: <?php echo $chart['class5']['data'];?>,
    <?php if(!empty($pre_month_chart['month'])){?>
          value2: <?php echo $pre_month_chart['class5']['data'];?>,
          <?php }if(!empty($pre_year_chart['month'])){?>
          value3: <?php echo $pre_year_chart['class5']['data'];?>,
          <?php } ?>
    }

  ];

  chart.colors.step = 2;
  chart.legend = new am4charts.Legend();
  chart.legend.useDefaultMarker = true;
  let marker = chart.legend.markers.template.children.getIndex(0);



  var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
  categoryAxis.dataFields.category = "category";
  categoryAxis.renderer.grid.template.location = 0;
  categoryAxis.renderer.line.strokeOpacity = 1;
  categoryAxis.renderer.minGridDistance = 30;

  categoryAxis.renderer.cellStartLocation = 0.2;
  categoryAxis.renderer.cellEndLocation = 0.8;

  var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());  

  var series1 = chart.series.push(new am4charts.ColumnSeries());
  series1.columns.template.width = am4core.percent(100);
  series1.columns.template.tooltipText = "{name}: {valueY.value}";
  series1.columns.template.strokeWidth = 0;
  series1.name = "<?php  echo date('F, Y',strtotime($chart['month'])); ?>";
  series1.dataFields.categoryX = "category";
  series1.dataFields.valueY = "value1";
  series1.fill = am4core.color("#000080");
  //series1.legend = new am4charts.Legend();

  <?php if(!empty($pre_month_chart['month'])){?>
  var series2 = chart.series.push(new am4charts.ColumnSeries());
  series2.columns.template.width = am4core.percent(100);
  series2.columns.template.tooltipText = "{name}: {valueY.value}";
  series2.columns.template.strokeWidth = 0;
  series2.name = "<?php  echo date('F, Y',strtotime($pre_month_chart['month'])); ?>";
  series2.dataFields.categoryX = "category";
  series2.dataFields.valueY = "value2";
  series2.fill = am4core.color("#D3D3D3");
  //series2.legend = new am4charts.Legend();
  <?php }if(!empty($pre_year_chart['month'])){?>
  var series3 = chart.series.push(new am4charts.ColumnSeries());
  series3.columns.template.width = am4core.percent(100);
  series3.columns.template.tooltipText = "{name}: {valueY.value}";
  series3.columns.template.strokeWidth = 0;
  series3.name = "<?php  echo date('F, Y',strtotime($pre_year_chart['month'])); ?>";
  series3.dataFields.categoryX = "category";
  series3.dataFields.valueY = "value3";
  series3.fill = am4core.color("rgb(102, 153, 255)");
  <?php } ?>
  //series3.legend = new am4charts.Legend();
</script>
<script>
  /**
  * --------------------------------------------------------
  * This demo was created using amCharts V4 preview release.
  *
  * V4 is the latest installement in amCharts data viz
  * library family, to be released in the first half of
  * 2018.
  *
  * For more information and documentation visit:
  * https://www.amcharts.com/docs/v4/
  * --------------------------------------------------------
  */

  am4core.useTheme(am4themes_animated);
  am4core.useTheme(am4themes_dataviz);

  var chart = am4core.create("chartdiv34", am4charts.XYChart);

  chart.data = [
    {
      category: "<?php echo $revenue['class1']['label']?>",
      "fill": '#e20404',
      value1: <?php echo $revenue['class1']['data'];?>,
      <?php if(!empty($pre_month_revenue['month'])){?>
          value2: <?php echo $pre_month_revenue['class1']['data'];?>,
          <?php }if(!empty($pre_year_revenue['month'])){?>
          value3: <?php echo $pre_year_revenue['class1']['data'];?>,
          <?php } ?>
    },
    {
      category: "<?php echo $revenue['class2']['label']?>",
      value1: <?php echo $revenue['class2']['data'];?>,
      <?php if(!empty($pre_month_revenue['month'])){?>
          value2: <?php echo $pre_month_revenue['class2']['data'];?>,
          <?php }if(!empty($pre_year_revenue['month'])){?>
          value3: <?php echo $pre_year_revenue['class2']['data'];?>,
          <?php } ?>
    },
    {
      category: "<?php echo $revenue['class3']['label']?>",
      value1: <?php echo $revenue['class3']['data'];?>,
      <?php if(!empty($pre_month_revenue['month'])){?>
          value2: <?php echo $pre_month_revenue['class3']['data'];?>,
          <?php }if(!empty($pre_year_revenue['month'])){?>
          value3: <?php echo $pre_year_revenue['class3']['data'];?>,
          <?php } ?>
    },
    {
      category: "<?php echo $revenue['class4']['label']?>",
      value1: <?php echo $revenue['class3']['data'];?>,
      <?php if(!empty($pre_month_revenue['month'])){?>
          value2: <?php echo $pre_month_revenue['class4']['data'];?>,
          <?php }if(!empty($pre_year_revenue['month'])){?>
          value3: <?php echo $pre_year_revenue['class4']['data'];?>,
          <?php } ?>
    },
    {
      category: "<?php echo $revenue['class5']['label']?>",
      value1: <?php echo $revenue['class5']['data'];?>,
    <?php if(!empty($pre_month_revenue['month'])){?>
          value2: <?php echo $pre_month_revenue['class5']['data'];?>,
          <?php }if(!empty($pre_year_revenue['month'])){?>
          value3: <?php echo $pre_year_revenue['class5']['data'];?>,
          <?php } ?>
    }

  ];

  chart.colors.step = 2;
  chart.legend = new am4charts.Legend();

  marker.stroke = am4core.color("#ccc");
  var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
  categoryAxis.dataFields.category = "category";
  categoryAxis.renderer.grid.template.location = 0;
  categoryAxis.renderer.line.strokeOpacity = 1;
  categoryAxis.renderer.minGridDistance = 30;

  categoryAxis.renderer.cellStartLocation = 0.2;
  categoryAxis.renderer.cellEndLocation = 0.8;

  var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());  

  var series1 = chart.series.push(new am4charts.ColumnSeries());
  series1.columns.template.width = am4core.percent(100);
  series1.columns.template.tooltipText = "{name}: {valueY.value}";
  series1.columns.template.strokeWidth = 0;
  series1.name = "<?php  echo date('F, Y',strtotime($chart['month'])); ?>";
  series1.dataFields.categoryX = "category";
  series1.dataFields.valueY = "value1";
  series1.fill = am4core.color("#000080");

  <?php if(!empty($pre_month_chart['month'])){?>
  var series2 = chart.series.push(new am4charts.ColumnSeries());
  series2.columns.template.width = am4core.percent(100);
  series2.columns.template.tooltipText = "{name}: {valueY.value}";
  series2.columns.template.strokeWidth = 0;
  series2.name = "<?php  echo date('F, Y',strtotime($pre_month_chart['month'])); ?>";
  series2.dataFields.categoryX = "category";
  series2.dataFields.valueY = "value2";
  series2.fill = am4core.color("#D3D3D3");
  <?php }if(!empty($pre_year_chart['month'])){?>
  var series3 = chart.series.push(new am4charts.ColumnSeries());
  series3.columns.template.width = am4core.percent(100);
  series3.columns.template.tooltipText = "{name}: {valueY.value}";
  series3.columns.template.strokeWidth = 0;
  series3.name = "<?php  echo date('F, Y',strtotime($pre_year_chart['month'])); ?>";
  series3.dataFields.categoryX = "category";
  series3.dataFields.valueY = "value3";
  series3.fill = am4core.color("rgb(102, 153, 255)");
  <?php } ?>
</script>
<!-- Bar Graph Script END -->