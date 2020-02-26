<div class="panel-header panel-header-lg" style="height: 50%;">
 </div>
<div class="content">
        <div class="row">

          <div class="col-md-6">
            <div class="card  card-tasks">
              <div class="card-header ">
                <h5 class="card-category text-info"><?php if(!empty($chart)){ echo $chart['tollplaza'];}?><span class="pull-right text-warning"><?php if(!empty($chart)){  echo date("F, Y",strtotime($chart['month'])); } ?></span></h5>
                <h4 class="card-title">Traffic</h4>
              </div>
              <div class="card-body ">
                <div id="chartdiv2"></div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                </div>
              </div>
            </div>
          </div>


          <div class="col-md-6">
            <div class="card  card-tasks">
              <div class="card-header ">
                <h5 class="card-category text-info"><?php if(!empty($chart)){  echo $chart['tollplaza']; }?><span class="pull-right text-warning"><?php if(!empty($chart)){  echo date("F, Y",strtotime($chart['month'])); } ?></span></h5>
                <h4 class="card-title">Revenue<span class="text-danger"><?php if(!empty($chart)){  echo $revenue['special_message']; } ?></span></h4>
              </div>
              <div class="card-body ">
                <div id="chartdiv3"></div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card  card-tasks">
              <div class="card-header ">
                <h5 class="card-category text-info"><?php if(!empty($chart)){ echo $chart['tollplaza'];}?><span class="pull-right text-warning"><?php if(!empty($chart)){  echo date("F, Y",strtotime($chart['month'])); } ?></span></h5>
                <h4 class="card-title">Traffic</h4>
              </div>
              <div class="card-body ">
                <div id="chartdiv"></div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card  card-tasks">
              <div class="card-header ">
                <h5 class="card-category text-info"><?php if(!empty($chart)){  echo $chart['tollplaza']; }?><span class="pull-right text-warning"><?php if(!empty($chart)){  echo date("F, Y",strtotime($chart['month'])); } ?></span></h5>
                <h4 class="card-title">Revenue<span class="text-danger"><?php if(!empty($chart)){  echo $revenue['special_message']; } ?></span></h4>
              </div>
              <div class="card-body ">
                <div id="chartdiv1"></div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
<?php //if($page_name == "dashboard"){?>
<script src="<?php echo base_url()?>assets/amcharts/amcharts.js"></script>
<script src="<?php echo base_url()?>assets/amcharts/pie.js"></script>
<script src="<?php echo base_url()?>assets/amcharts/serial.js"></script>
<script src="<?php echo base_url()?>assets/amcharts/export.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/amcharts/export.css" type="text/css" media="all" />
<script src="<?php echo base_url()?>assets/amcharts/light.js"></script><!-- Chart code -->
<?php if(!empty($chart)){ ?>
<script>

var chart = AmCharts.makeChart( "chartdiv", {
  "type": "pie",
  "theme": "light",
  "dataProvider": [ 
{
  "class": "<?php echo $chart['class1']['label']?>",
  "traffic": <?php echo $chart['class1']['data'];?>
}, {
  "class": "<?php echo $chart['class2']['label']?>",
  "traffic": <?php echo $chart['class2']['data'];?>
}, {
  "class": "<?php echo $chart['class3']['label']?>",
  "traffic": <?php echo $chart['class3']['data'];?>
}, {
  "class": "<?php echo $chart['class4']['label']?>",
  "traffic": <?php echo $chart['class4']['data'];?>
}, {
  "class": "<?php echo $chart['class5']['label']?>",
  "traffic": <?php echo $chart['class5']['data'];?>
} ],
  "valueField": "traffic",
  "legend": {},
  "titleField": "class",
  "labelText": "[[percents]]%",
  "outlineAlpha": 0.4,
  "depth3D": 15,
  "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[traffic]]</b> ([[percents]]%)</span>",
  "angle": 30,
  "export": {
    "enabled": false
  }
} );

var chart = AmCharts.makeChart( "chartdiv1", {
  "type": "pie",
  "theme": "light",
  "dataProvider": [ 
{
  "class": "<?php echo $revenue['class1']['label']?>",
  "traffic": <?php echo $revenue['class1']['data'];?>
}, {
  "class": "<?php echo $revenue['class2']['label']?>",
  "traffic": <?php echo $revenue['class2']['data'];?>
}, {
  "class": "<?php echo $revenue['class3']['label']?>",
  "traffic": <?php echo $revenue['class3']['data'];?>
}, {
  "class": "<?php echo $revenue['class4']['label']?>",
  "traffic": <?php echo $revenue['class4']['data'];?>
}, {
  "class": "<?php echo $revenue['class5']['label']?>",
  "traffic": <?php echo $revenue['class5']['data'];?>
} ],
  "valueField": "traffic",
  "legend": {},
  "titleField": "class",
  "labelText": "[[percents]]%",
  "outlineAlpha": 0.4,
  "depth3D": 15,
  "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[traffic]]</b> ([[percents]]%)</span>",
  "angle": 30,
  "export": {
    "enabled": false
  }
} );
</script>

<script>
var chart = AmCharts.makeChart("chartdiv2", {
    "type": "serial",
    "theme": "light",
    "marginTop":0,
    "legend": {
    "useGraphSettings": true,
  },
    "marginRight": 10,
    "dataProvider": [{
        "year": "<?php echo $chart['class1']['label']?>",
        "value": <?php echo $chart['class1']['data'];?>,
        <?php if(!empty($pre_month_chart['month'])){?>
        "value2": <?php echo $pre_month_chart['class1']['data'];?>,
        <?php } ?>
        <?php if(!empty($pre_year_chart['month'])){?>
        "value3": <?php echo $pre_year_chart['class1']['data'];?>,
         <?php } ?>
    }, {
        "year": "<?php echo $chart['class2']['label']?>",
        "value": <?php echo $chart['class2']['data'];?>,
        <?php if(!empty($pre_month_chart['month'])){?>
        "value2": <?php echo $pre_month_chart['class2']['data'];?>,
        <?php } ?>
        <?php if(!empty($pre_year_chart['month'])){?>
        "value3": <?php echo $pre_year_chart['class2']['data'];?>,
         <?php } ?>
    }, {
        "year": "<?php echo $chart['class3']['label']?>",
        "value": <?php echo $chart['class3']['data'];?>,
        <?php if(!empty($pre_month_chart['month'])){?>
        "value2": <?php echo $pre_month_chart['class3']['data'];?>,
         <?php } ?>
        <?php if(!empty($pre_year_chart['month'])){?>
        "value3": <?php echo $pre_year_chart['class3']['data'];?>,
        <?php } ?>
    }, {
        "year": "<?php echo $chart['class4']['label']?>",
        "value": <?php echo $chart['class4']['data'];?>,
        <?php if(!empty($pre_month_chart['month'])){?>
        "value2": <?php echo $pre_month_chart['class4']['data'];?>,
         <?php } ?>
        <?php if(!empty($pre_year_chart['month'])){?>
        "value3": <?php echo $pre_year_chart['class4']['data'];?>,
         <?php } ?>
    }, {
        "year": "<?php echo $chart['class5']['label']?>",
        "value": <?php echo $chart['class5']['data'];?>,
        <?php if(!empty($pre_month_chart['month'])){?>
        "value2": <?php echo $pre_month_chart['class5']['data'];?>,
        <?php } ?>
        <?php if(!empty($pre_year_chart['month'])){?>
        "value3": <?php echo $pre_year_chart['class5']['data'];?>,
         <?php } ?>
    }],
   // "legend": {},
    "valueAxes": [{
        "axisAlpha": 0,
        "position": "left"
    }],
    "graphs": [{
        "id":"g1",
        "title": "<?php  echo date('F, Y',strtotime($chart['month'])); ?>",
        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
        "bullet": "round",
        "bulletSize": 8,         
        "lineColor": "#ff0000",
        "lineThickness": 2,

        "negativeLineColor": "#ff0000",
        "type": "smoothedLine",
        "valueField": "value"
    }<?php if(!empty($pre_month_chart['month'])){?>,{
        "id":"g2",
        "title": "<?php  echo date('F, Y',strtotime($pre_month_chart['month'])); ?>",
        
        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
        "bullet": "rectangle",
        "bulletSize": 8,         
        "lineColor": "#6699ff",
        "lineThickness": 2,
        "negativeLineColor": "#6699ff",
        "type": "smoothedLine",
        "valueField": "value2"
    }<?php }if(!empty($pre_year_chart['month'])){?>,{
        "id":"g3",
        "title": "<?php  echo date('F, Y',strtotime($pre_year_chart['month'])); ?>",
        "labelText": false,
        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
        "bullet": "rectangle",
        "bulletSize": 8,         
        "lineColor": "#1e8019",
        "lineThickness": 2,
        "negativeLineColor": "#6699ff",
        "type": "smoothedLine",
        "valueField": "value3"
    }<?php }?>],
    // "chartScrollbar": {
    //     "graph":"g1",
    //     "gridAlpha":0,
    //     "color":"#888888",
    //     "scrollbarHeight":10,
    //     "backgroundAlpha":0,
    //     "selectedBackgroundAlpha":0.1,
    //     "selectedBackgroundColor":"#888888",
    //     "graphFillAlpha":0,
    //     "autoGridCount":true,
    //     "selectedGraphFillAlpha":0,
    //     "graphLineAlpha":0.2,
    //     "graphLineColor":"#c2c2c2",
    //     "selectedGraphLineColor":"#888888",
    //     "selectedGraphLineAlpha":1

    // },
    "chartCursor": {
        "categoryBalloonDateFormat": "YYYY",
        "cursorAlpha": 0,
        "valueLineEnabled":true,
        "valueLineBalloonEnabled":true,
        "valueLineAlpha":0.5,
        "fullWidth":true
    },
    "dataDateFormat": "YYYY",
    "categoryField": "year",
    "categoryAxis": {
        "minPeriod": "YYYY",
        "parseDates": false,
        "minorGridAlpha": 0.1,
        "minorGridEnabled": false,
         "autoRotateAngle":15,
        "autoRotateCount":2
    },
    "export": {
        "enabled": false
    }
});

var chart = AmCharts.makeChart("chartdiv3", {
    "type": "serial",
    "theme": "light",
    "legend": {
    "useGraphSettings": true,
  },
    "marginTop":0,
    "marginRight": 10,
    "dataProvider": [{
        "year": "<?php echo $chart['class1']['label']?>",
        "value": <?php echo $revenue['class1']['data'];?>,
        <?php if(!empty($pre_month_revenue['month'])){?>
        "value2": <?php echo $pre_month_revenue['class1']['data'];?>,
        <?php }if(!empty($pre_year_revenue['month'])){?>
        "value3": <?php echo $pre_year_revenue['class1']['data'];?>,
        <?php } ?>
    }, {
        "year": "<?php echo $chart['class2']['label']?>",
        "value": <?php echo $revenue['class2']['data'];?>,
        <?php if(!empty($pre_month_revenue['month'])){?>
        "value2": <?php echo $pre_month_revenue['class2']['data'];?>,
        <?php }if(!empty($pre_year_revenue['month'])){?>
        "value3": <?php echo $pre_year_revenue['class2']['data'];?>,
        <?php } ?>
    }, {
        "year": "<?php echo $chart['class3']['label']?>",
        "value": <?php echo $revenue['class3']['data'];?>,
        <?php if(!empty($pre_month_revenue['month'])){?>
        "value2": <?php echo $pre_month_revenue['class3']['data'];?>,
        <?php }if(!empty($pre_year_revenue['month'])){?>
        "value3": <?php echo $pre_year_revenue['class3']['data'];?>,
        <?php } ?>
    },
     {
        "year": "<?php echo $chart['class4']['label']?>",
        "value": <?php echo $revenue['class4']['data'];?>,
        <?php if(!empty($pre_month_revenue['month'])){?>
        "value2": <?php echo $pre_month_revenue['class4']['data'];?>,
        <?php }if(!empty($pre_year_revenue['month'])){?>
        "value3": <?php echo $pre_year_revenue['class4']['data'];?>,
        <?php } ?>
    },
     {
        "year": "<?php echo $chart['class5']['label']?>",
        "value": <?php echo $revenue['class5']['data'];?>,
        <?php if(!empty($pre_month_revenue['month'])){?>
        "value2": <?php echo $pre_month_revenue['class5']['data'];?>,
        <?php }if(!empty($pre_year_revenue['month'])){?>
        "value3": <?php echo $pre_year_revenue['class5']['data'];?>,
        <?php } ?>
    }],
   // "legend": {},
    "valueAxes": [{
        "axisAlpha": 0,
        "position": "left"
    }],
    "graphs": [{
        "id":"g1",
        "title": "<?php  echo date('F, Y',strtotime($revenue['month'])); ?>",
        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
        "bullet": "round",
        "bulletSize": 8,         
        "lineColor": "#ff0000",
        "lineThickness": 2,

        "negativeLineColor": "#ff0000",
        "type": "smoothedLine",
        "valueField": "value"
    }<?php if(!empty($pre_month_revenue['month'])){?>,{
        "id":"g2",
       "title": "<?php  echo date('F, Y',strtotime($pre_month_revenue['month'])); ?>",
        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
        "bullet": "rectangle",
        "bulletSize": 8,         
        "lineColor": "#6699ff",
        "lineThickness": 2,
        "negativeLineColor": "#6699ff",
        "type": "smoothedLine",
        "valueField": "value2"
    }<?php }if(!empty($pre_year_revenue['month'])){?>,{
        "id":"g3",
        "title": "<?php  echo date('F, Y',strtotime($pre_year_revenue['month'])); ?>",
        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
        "bullet": "rectangle",
        "bulletSize": 8,         
        "lineColor": "#1e8019",
        "lineThickness": 2,
        "negativeLineColor": "#6699ff",
        "type": "smoothedLine",
        "valueField": "value3"
    }<?php } ?>],
    // "chartScrollbar": {
    //     "graph":"g1",
    //     "gridAlpha":0,
    //     "color":"#888888",
    //     "scrollbarHeight":10,
    //     "backgroundAlpha":0,
    //     "selectedBackgroundAlpha":0.1,
    //     "selectedBackgroundColor":"#888888",
    //     "graphFillAlpha":0,
    //     "autoGridCount":true,
    //     "selectedGraphFillAlpha":0,
    //     "graphLineAlpha":0.2,
    //     "graphLineColor":"#c2c2c2",
    //     "selectedGraphLineColor":"#888888",
    //     "selectedGraphLineAlpha":1

    // },
    "chartCursor": {
        "categoryBalloonDateFormat": "YYYY",
        "cursorAlpha": 0,
        "valueLineEnabled":true,
        "valueLineBalloonEnabled":true,
        "valueLineAlpha":0.5,
        "fullWidth":true
    },
    "dataDateFormat": "YYYY",
    "categoryField": "year",
    "categoryAxis": {
        "minPeriod": "YYYY",
        "parseDates": false,
        "minorGridAlpha": 0.1,
        "minorGridEnabled": false,
         "autoRotateAngle":15,
        "autoRotateCount":2
    },
    "export": {
        "enabled": false
    }
});

function zoomChart(){
    chart.zoomToIndexes(Math.round(chart.dataProvider.length * 0.4), Math.round(chart.dataProvider.length * 0.55));
}
</script>
<?php }//} ?>