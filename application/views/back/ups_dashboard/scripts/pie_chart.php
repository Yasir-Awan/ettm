<script>
            // first pie chart for traffic show start
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
            } ); //first pie chart end


            // second Pie chart to show the revenues 
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
            } );// second Pie chart to show the revenue end
          </script>