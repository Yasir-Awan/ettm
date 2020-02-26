<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Newline CSS Template with a video background</title>
<!--

Newline Template
http://www.templatemo.com/tm-503-newline
-->
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

       <script src="<?php echo base_url()?>assets/front/member/js/core/jquery.min.js"></script>
 </head>
    <body>
      

<!-- Resources -->


<!-- HTML -->
<div id="chartdiv"></div>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script>
var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "light",
    "marginTop":0,
    "marginRight": 10,
    "dataProvider": [{
        "year": "Class1",
        "value": 300,
        "value2": 500,
        "value3": 400,
    }, {
        "year": "Class2",
        "value": 500,
        "value2": 300,
        "value3": 200,
    }, {
        "year": "Class3",
        "value": 600,
        "value2": 900,
        "value3": 100,
    }],
   // "legend": {},
    "valueAxes": [{
        "axisAlpha": 0,
        "position": "left"
    }],
    "graphs": [{
        "id":"g1",
        "legend": 'JANUARY',
        "labelText": "March",
        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
        "bullet": "round",
        "bulletSize": 8,         
        "lineColor": "#ff0000",
        "lineThickness": 2,

        "negativeLineColor": "#ff0000",
        "type": "smoothedLine",
        "valueField": "value"
    },{
        "id":"g2",
        "legend": 'JANUARY',
        "labelText": "february",
        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
        "bullet": "round",
        "bulletSize": 8,         
        "lineColor": "#6699ff",
        "lineThickness": 2,
        "negativeLineColor": "#6699ff",
        "type": "smoothedLine",
        "valueField": "value2"
    },{
        "id":"g3",
        "legend": 'JANUARY',
        "labelText": "january",
        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
        "bullet": "round",
        "bulletSize": 8,         
        "lineColor": "#6699ff",
        "lineThickness": 2,
        "negativeLineColor": "#6699ff",
        "type": "smoothedLine",
        "valueField": "value3"
    }],
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
        "minorGridEnabled": false
    },
    "export": {
        "enabled": true
    }
});



function zoomChart(){
    chart.zoomToIndexes(Math.round(chart.dataProvider.length * 0.4), Math.round(chart.dataProvider.length * 0.55));
}
</script>

<!-- Chart code -->

    </body>
</html>
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}

