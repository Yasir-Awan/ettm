<style>
#chartdiv /* styling for Revenue Pie chart */
{
  width: 100%;
  height: 350px;
}
#chartdiv2 
{
  width: 100%;
  height: 300px;
}

#chartdiv3 
{
  width: 100%;
  height: 300px;
}
#chartdiv1 /* styling for Traffic Pie chart */
{
  width: 100%;
  height: 350px;
}
#chartdiv33 {/* styling for traffic bar graph */
  width: 100%;
  height: 300px;
}
#chartdiv34 {/* styling for Revenue bar graph */
  width: 100%;
  height: 300px;
}
#table_for_class_vise_traffic_reveneu{ 
  width: 100% ;
  height: auto;}
.amcharts-chart-div a {display:none !important;}

</style>

<br>
<div class="chart_div" style="margin-top: -10px !important;">
   <!-- Content row Start-->
<div class="row mb-2" style="margin-left:0px; margin-right:0px;">

<!-- plaza and month filter START -->
<div class="search-box pull-left col-xl-3 col-md-6 mb-1 " style="">

  <!-- Hidden Form START -->
<!-- Hidden Form END -->

        <?php ///if($page == "Desired Chart"){?>
                  
             <?php echo form_open_multipart(base_url().'admin/searchfordesiredchart', array('id' => 'searchfordchart', 'method' => 'post'));?>

                     <select class="form-control required text-primary mb-1" name="tollplaza" id="tollplaza" class="card border-left-primary shadow h-100 py-2" style="height: 35px !important; padding-bottom: 6px; padding-left: 5px; border-left: .25rem solid #4e73df!important;">
                        <option value="">Select Toll Plaza</option>
                        <?php foreach($tollplaza as $row){?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php } ?>
                     </select> 
                    
                  <div class="date" style="display:none; width:50.25px; margin-right:30px !mportant; ">
                    <input type="text" id="formonth" name="formonth" class="form-control" placeholder="Select month" class="card border-left-primary shadow h-100 py-2" style="height: 30px !important; ">
                  </div>
            </form>
            <?php //} ?>
      </div><!-- plaza and month filter END -->

<!-- Plazas (Name) Card -->
<div class="col-xl-3 col-md-6 mb-1" style="height: 8%;">
  <div class="card border-left-primary shadow h-100 py-2" style="border-left: .25rem solid #f6c23e!important;">
    <div class="card-body" style="padding: 1% !important;">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2" style="padding-left: 8%;">
          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="">               
            <h5 class="card-category text-warning" style="font-size: 16px;"><?php if(!empty($chart)){ echo $chart['tollplaza'];}?>
            <span class="pull-right text-warning" ></span></h5></div>
          <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 16px;"><?php if(!empty($chart)){  echo date("F, Y",strtotime($chart['month'])); } ?></div>
        </div>
        <div class="col-auto" style="padding-right: 15%;">
          <i class="fas fa-calendar fa-2x text-gray-300" style="color:#f6c23e !important; margin-right: 5% !important;"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Total Traffic Card -->
<div class="col-xl-3 col-md-6 mb-1" style="height: 8%;">
  <div class="card border-left-primary shadow h-100 py-2" style="border-left: .25rem solid #36b9cc!important;">
    <div class="card-body" style="padding: 1% !important;">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2" style="padding-left: 8%;">
          <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><h5 style="font-size: 16px;">Total Traffic</h5></div>
          <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 16px;"><?php echo number_format($chart['total']['traffic']); ?></div>
        </div>
        <div class="col-auto" style="padding-right: 10%;">
          <i class="fa fa-bus fa-2x text-gray-300" style="color:#36b9cc !important;" ></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Total REVENUE Card -->
<div class="col-xl-3 col-md-6 mb-1" style="height: 8%;">
  <div class="card border-left-success shadow h-100 py-2" style="border-left: .25rem solid #1cc88a!important;">
    <div class="card-body" style="padding: 1% !important;">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2" style="padding-left: 8%;">
          <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><h5 style="font-size: 16px;">Total Revenue</h5></div>
<?php 
$exempt = $this->db->get_where('exempt',array('mtr_id' => $mtrid))->result_array();
  if($terrif) 
  {
       if($exempt)
      {     
          $total_revenue = (($chart['class1']['data'] - $exempt[0]['class1']) * $terrif[0]['class_1_value'])+
                           (($chart['class2']['data'] - $exempt[0]['class2']) * $terrif[0]['class_2_value'])+
                           (($chart['class3']['data'] - $exempt[0]['class3'] - $exempt[0]['class5'] - $exempt[0]['class6']) *  $terrif[0]['class_3_value']  )+
                           (($chart['class4']['data'] - $exempt[0]['class4']) * $terrif[0]['class_4_value'])+
                           (($chart['class5']['data'] - $exempt[0]['class7'] - $exempt[0]['class8'] - $exempt[0]['class9'] - $exempt[0]['class10'] ) *  $terrif[0]['class_7_value']  );
                               
      }
      else
      {

          $total_revenue = (($chart['class1']['data'] ) * $terrif[0]['class_1_value'])+
                           (($chart['class2']['data'] ) * $terrif[0]['class_2_value'])+
                           (($chart['class3']['data'] ) *  $terrif[0]['class_3_value']  )+
                           (($chart['class4']['data'] ) * $terrif[0]['class_4_value'])+
                           (($chart['class5']['data'] ) *  $terrif[0]['class_7_value']  );
      }
 
 }
 else
 {           
     $total_revenue = 'Tarrif Not Added yet!';              
 } ?>

          <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 16px;"><?php echo number_format( $total_revenue); ?></div>
        </div>
        <div class="col-auto" style="padding-right: 13%;">
          <i ><img style="width:40px;height:40px;" src="<?php echo base_url();?>assets/back/images/icon/pkr.png" alt="logo"></i>
        </div>
      </div>
    </div>
  </div>
</div>

</div><!-- Content row End -->


      <div class="main-content-inner">
        <div class="row" >

<!-- Traffic summary table -->
 <div class="col-md-12 mb-2">
            <div class="card  card-tasks">
            <div class="card-header" class="card border-top-info shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:3px; border-top: .25rem solid #36b9cc!important;">
               <div class='row '>
                    <div class="col-md-12">
                    <h4 class="card-title text-info" style="color:#303641 !important;" >Traffic summary of  <?php if(!empty($chart)){ echo $chart['tollplaza'];}?>  <?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h4>
                    </div>
                  
                     
                </div>
             </div>
              
              <div class="card-body" style="padding:0px;">
                <div id="table_for_class_vise_traffic_reveneu">
                   <!-- Table START -->
                   <table class="table table-hover" style="line-height: 0.5;">
  <thead>
    <tr class="table-info">
      <th >Vehicle Type</th>
      <th >Car</th>
      <th >Wagon</th>
      <th >Bus</th>
      <th >Truck</th>
      <th >Art. Truck</th>
      <th >Total</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="col">Traffic</th>
      <td><?php echo number_format( $chart['class1']['data']);?></td>
      <td><?php echo number_format( $chart['class2']['data']);?></td>
      <td><?php echo number_format( $chart['class3']['data']);?></td>
      <td><?php echo number_format( $chart['class4']['data']);?></td>
      <td><?php echo number_format( $chart['class5']['data']);?></td>
      <td><?php echo number_format( $chart['total']['traffic']);?></td>
    </tr>
<?php
   if($exempt)
     {
?>
     <tr>
       <th scope="col">Exempt</th>
       <td><?php echo number_format( $exempt['0']['class1']);?></td>
       <td><?php echo number_format( $exempt['0']['class2']);?></td>
       <td><?php echo number_format( $exempt['0']['class3']+ $exempt['0']['class5']+$exempt['0']['class6'] );?></td>
       <td><?php echo number_format( $exempt['0']['class4']);?></td>
       <td><?php echo number_format( $exempt['0']['class7']+ $exempt['0']['class8']+$exempt['0']['class9']+$exempt['0']['class10'] );?></td>
       <td><?php echo number_format( $exempt['0']['class1']+ $exempt['0']['class2']+$exempt['0']['class3']+$exempt['0']['class4']+ $exempt['0']['class5']+$exempt['0']['class6']+$exempt['0']['class7']+ $exempt['0']['class8']+$exempt['0']['class9']+$exempt['0']['class10'] );?></td>
     </tr>
<?php }?>
<?php 
   if($terrif) 
   {
?>
<?php 
      if($exempt)
      {     
?>
         <tr>
             <th scope="col">Revenue</th>
             <td><?php echo number_format(($chart['class1']['data'] - $exempt[0]['class1']) * $terrif[0]['class_1_value']);?></td>
             <td><?php echo number_format(($chart['class2']['data'] - $exempt[0]['class2']) * $terrif[0]['class_2_value']);?></td>
             <td><?php echo number_format(($chart['class3']['data'] - $exempt[0]['class3'] - $exempt[0]['class5'] - $exempt[0]['class6']) *  $terrif[0]['class_3_value']  );?></td>
             <td><?php echo number_format(($chart['class4']['data'] - $exempt[0]['class4']) * $terrif[0]['class_4_value']);?></td>
             <td><?php echo number_format(($chart['class5']['data'] - $exempt[0]['class7'] - $exempt[0]['class8'] - $exempt[0]['class9'] - $exempt[0]['class10'] ) *  $terrif[0]['class_7_value']  );?></td>
<?php 
              $total_revenue = (($chart['class1']['data'] - $exempt[0]['class1']) * $terrif[0]['class_1_value'])+
                               (($chart['class2']['data'] - $exempt[0]['class2']) * $terrif[0]['class_2_value'])+
                               (($chart['class3']['data'] - $exempt[0]['class3'] - $exempt[0]['class5'] - $exempt[0]['class6']) *  $terrif[0]['class_3_value']  )+
                               (($chart['class4']['data'] - $exempt[0]['class4']) * $terrif[0]['class_4_value'])+
                               (($chart['class5']['data'] - $exempt[0]['class7'] - $exempt[0]['class8'] - $exempt[0]['class9'] - $exempt[0]['class10'] ) *  $terrif[0]['class_7_value']  );
?>
              <td><?php echo number_format($total_revenue) ;?></td>
          </tr>
<?php 
      }
      else
      {
?>               
           <tr>
              <th scope="col">Reveneu</th>
              <td><?php echo number_format(($chart['class1']['data']) * $terrif[0]['class_1_value']);?></td>
              <td><?php echo number_format(($chart['class2']['data'] ) * $terrif[0]['class_2_value']);?></td>
              <td><?php echo number_format(($chart['class3']['data'] ) *  $terrif[0]['class_3_value']  );?></td>
              <td><?php echo number_format(($chart['class4']['data'] ) * $terrif[0]['class_4_value']);?></td>
              <td><?php echo number_format(($chart['class5']['data'] ) *  $terrif[0]['class_7_value']  );?></td>
<?php 
              $total_revenue = (($chart['class1']['data'] ) * $terrif[0]['class_1_value'])+
                               (($chart['class2']['data'] ) * $terrif[0]['class_2_value'])+
                               (($chart['class3']['data'] ) *  $terrif[0]['class_3_value']  )+
                               (($chart['class4']['data'] ) * $terrif[0]['class_4_value'])+
                               (($chart['class5']['data'] ) *  $terrif[0]['class_7_value']  );
?>
              <td><?php echo number_format($total_revenue) ;?></td>
           </tr>
<?php 
          }
?>
<?php 
      }
      else
      {
?>
            <tr>
                <th scope="col">Reveneu</th>
                 <td colspan='6'><h2><?php echo 'Tarrif Not Added yet!';?></h2></td>
            </tr>
<?php } ?>
  </tbody>
</table> 
                   <!-- Table END -->

                </div>
              </div>
              
              
              
            </div>
          </div>
          
<!-- Traffic summary Table END -->
          <!-- Bar Chart START -->
          <div class="col-md-6 mb-2">
            <div class="card  card-tasks">
            <div class="card-header" class="card border-top-info shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:3px; border-top: .25rem solid #36b9cc!important;">
               <div class='row '>
                    <div class="col-md-4">
                    <h4 class="card-title text-info" >Traffic </h4> 
                    </div>
                    <div class='col-md-4'> 
                    <h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php if(!empty($chart)){ echo $chart['tollplaza'];}?> </h5>
                    </div>
                    <div class="col-md-4" style="color:black;"><h6 class="pull-right"><?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h6></div>
                </div>
             </div>
              
              <div class="card-body ">
              <div id="chartdiv33"></div>
              </div>
              
               
              </div>
    </div><!-- Bar Chart END -->
        <!-- Bar Chart START -->
        <div class="col-md-6 mb-2">
            <div class="card  card-tasks">
            <div class="card-header" class="card border-top-info shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:3px; border-top: .25rem solid #1cc88a!important;">
               <div class='row '>
                    <div class="col-md-4">
                    <h4 class="card-title text-success" >Revenue</h4> 
                    </div>
                    <div class='col-md-4'> 
                    <h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php if(!empty($chart)){ echo $chart['tollplaza'];}?> </h5>
                    </div>
                    <div class="col-md-4" style="color:black;"><h6 class="pull-right"><?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h6></div>
                </div>
             </div>
              
              <div class="card-body ">
              <div id="chartdiv34"></div>
              </div>
             
               
              </div>
    </div><!-- Bar Chart END -->
         <!--Pie chart Traffic-->
          <div class="col-md-6 mb-2">
            <div class="card  card-tasks">
            <div class="card-header" class="card border-top-info shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:6px; border-top: .25rem solid #36b9cc!important;">
               <div class='row '>
                    <div class="col-md-4">
                    <h4 class="card-title text-info" >Traffic </h4> 
                    </div>
                    <div class='col-md-4'> 
                    <h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php if(!empty($chart)){ echo $chart['tollplaza'];}?> </h5>
                    </div>
                    <div class="col-md-4" style="color:black;"><h6 class="pull-right"><?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h6></div>
                </div>
             </div>
              
              <div class="card-body ">
                <div id="chartdiv"></div>
              </div>
            
              
            </div>
          </div>

<!-- Pie chart Revenue -->
          <div class="col-md-6 mb-2">
            <div class="card  card-tasks">
            <div class="card-header" class="card border-top-info shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:3px; border-top: .25rem solid #1cc88a!important;">
               <div class='row '>
                    <div class="col-md-4">
                    <h4 class="card-title text-success" >Revenue</h4> 
                    </div>
                    <div class='col-md-4'> 
                    <h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php if(!empty($chart)){ echo $chart['tollplaza'];}?> </h5>
                    </div>
                    <div class="col-md-4" style="color:black;"><h6 class="pull-right"><?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h6></div>
                </div>
             </div>
              
              <div class="card-body ">
                <div id="chartdiv1"></div>
              </div>
              
            </div>
          </div><!-- Revenue Pie chart END -->

          <!-- comparison graph Traffic START -->
        <div class="col-md-6">
            <div class="card  card-tasks">
            <div class="card-header" class="card border-top-info shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:3px; border-top: .25rem solid #36b9cc!important;">
               <div class='row '>
                    <div class="col-md-4">
                    <h4 class="card-title text-info" >Traffic </h4> 
                    </div>
                    <div class='col-md-4'> 
                    <h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php if(!empty($chart)){ echo $chart['tollplaza'];}?> </h5>
                    </div>
                    <div class="col-md-4" style="color:black;"><h6 class="pull-right"><?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h6></div>
                </div>
             </div>
              
              <div class="card-body " style="border-bottom:0px;">
                <div id="chartdiv2"></div>
              </div>
             
              <div class="card-footer">
                  <div class="stats"></div>
                </div>

            </div>
          </div><!-- comparison graph Traffic END -->

<!-- comparison graph Revenue START -->
          <div class="col-md-6">
            <div class="card  card-tasks">
            <div class="card-header" class="card border-top-info shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:3px; border-top: .25rem solid #1cc88a!important;">
               <div class='row '>
                    <div class="col-md-4">
                    <h4 class="card-title text-success" >Revenue</h4> 
                    </div>
                    <div class='col-md-4'> 
                    <h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php if(!empty($chart)){ echo $chart['tollplaza'];}?> </h5>
                    </div>
                    <div class="col-md-4" style="color:black;"><h6 class="pull-right"><?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h6></div>
                </div>
             </div>
            
              
              <div class="card-body ">
                <div id="chartdiv3"></div>
              </div>
              
              <div class="card-footer">
                  <div class="stats"></div>
                </div>
              
            </div>
          </div><!-- comparison graph Revenue END -->

         

        </div>
      </div>

  <?php //if($page == "Desired Chart"){?>  

<script src="<?php echo base_url()?>assets/amcharts/amcharts.js"></script>
<script src="<?php echo base_url()?>assets/amcharts/pie.js"></script>
<script src="<?php echo base_url()?>assets/amcharts/serial.js"></script>
<script src="<?php echo base_url()?>assets/amcharts/export.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/amcharts/export.css" type="text/css" media="all" />
<script src="<?php echo base_url()?>assets/amcharts/light.js"></script><!-- Chart code -->
<?php if(!empty($chart)){ ?>





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


<script>

// first graph to show traffic comparison start
var chart = AmCharts.makeChart("chartdiv2", 
{
    "type": "serial",
    "theme": "light",
    "marginTop":0,
    "legend": 
    {
    "useGraphSettings": true,
  },
    "marginRight": 10,
    "dataProvider": [{
        "year": "<?php echo $chart['class1']['label']?>",
        "value": <?php echo $chart['class1']['data'];?>,
        <?php if(!empty($pre_month_chart['month'])){?>
        "value2": <?php echo $pre_month_chart['class1']['data'];?>,
        <?php } ?>
        <?php if(!empty($pre_pre_month_chart['month'])){?>
        "value3": <?php echo $pre_pre_month_chart['class1']['data'];?>,
         <?php } ?>
    }, {
        "year": "<?php echo $chart['class2']['label']?>",
        "value": <?php echo $chart['class2']['data'];?>,
        <?php if(!empty($pre_month_chart['month'])){?>
        "value2": <?php echo $pre_month_chart['class2']['data'];?>,
        <?php } ?>
        <?php if(!empty($pre_pre_month_chart['month'])){?>
        "value3": <?php echo $pre_pre_month_chart['class2']['data'];?>,
         <?php } ?>
    }, {
        "year": "<?php echo $chart['class3']['label']?>",
        "value": <?php echo $chart['class3']['data'];?>,
        <?php if(!empty($pre_month_chart['month'])){?>
        "value2": <?php echo $pre_month_chart['class3']['data'];?>,
         <?php } ?>
        <?php if(!empty($pre_pre_monthchart['month'])){?>
        "value3": <?php echo $pre_pre_monthchart['class3']['data'];?>,
        <?php } ?>
    }, {
        "year": "<?php echo $chart['class4']['label']?>",
        "value": <?php echo $chart['class4']['data'];?>,
        <?php if(!empty($pre_month_chart['month'])){?>
        "value2": <?php echo $pre_month_chart['class4']['data'];?>,
         <?php } ?>
        <?php if(!empty($pre_pre_month_chart['month'])){?>
        "value3": <?php echo $pre_pre_month_chart['class4']['data'];?>,
         <?php } ?>
    }, {
        "year": "<?php echo $chart['class5']['label']?>",
        "value": <?php echo $chart['class5']['data'];?>,
        <?php if(!empty($pre_month_chart['month'])){?>
        "value2": <?php echo $pre_month_chart['class5']['data'];?>,
        <?php } ?>
        <?php if(!empty($pre_pre_month_chart['month'])){?>
        "value3": <?php echo $pre_pre_month_chart['class5']['data'];?>,
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
    }<?php }if(!empty($pre_pre_month_chart['month'])){?>,{
        "id":"g3",
        "title": "<?php  echo date('F, Y',strtotime($pre_pre_month_chart['month'])); ?>",
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
});// first graph to show traffic comparison end

// Second graph to show reveneu comparison start
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
        <?php }if(!empty($pre_pre_month_revenue['month'])){?>
        "value3": <?php echo $pre_pre_month_revenue['class1']['data'];?>,
        <?php } ?>
    }, {
        "year": "<?php echo $chart['class2']['label']?>",
        "value": <?php echo $revenue['class2']['data'];?>,
        <?php if(!empty($pre_month_revenue['month'])){?>
        "value2": <?php echo $pre_month_revenue['class2']['data'];?>,
        <?php }if(!empty($pre_pre_month_revenue['month'])){?>
        "value3": <?php echo $pre_pre_month_revenue['class2']['data'];?>,
        <?php } ?>
    }, {
        "year": "<?php echo $chart['class3']['label']?>",
        "value": <?php echo $revenue['class3']['data'];?>,
        <?php if(!empty($pre_month_revenue['month'])){?>
        "value2": <?php echo $pre_month_revenue['class3']['data'];?>,
        <?php }if(!empty($pre_pre_month_revenue['month'])){?>
        "value3": <?php echo $pre_pre_month_revenue['class3']['data'];?>,
        <?php } ?>
    },
     {
        "year": "<?php echo $chart['class4']['label']?>",
        "value": <?php echo $revenue['class4']['data'];?>,
        <?php if(!empty($pre_month_revenue['month'])){?>
        "value2": <?php echo $pre_month_revenue['class4']['data'];?>,
        <?php }if(!empty($pre_pre_month_revenue['month'])){?>
        "value3": <?php echo $pre_pre_month_revenue['class4']['data'];?>,
        <?php } ?>
    },
     {
        "year": "<?php echo $chart['class5']['label']?>",
        "value": <?php echo $revenue['class5']['data'];?>,
        <?php if(!empty($pre_month_revenue['month'])){?>
        "value2": <?php echo $pre_month_revenue['class5']['data'];?>,
        <?php }if(!empty($pre_pre_month_revenue['month'])){?>
        "value3": <?php echo $pre_pre_month_revenue['class5']['data'];?>,
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
    }<?php }if(!empty($pre_pre_month_revenue['month'])){?>,{
        "id":"g3",
        "title": "<?php  echo date('F, Y',strtotime($pre_pre_month_revenue['month'])); ?>",
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
});// first graph to show traffic comparison end
function zoomChart()
{
    chart.zoomToIndexes(Math.round(chart.dataProvider.length * 0.4), Math.round(chart.dataProvider.length * 0.55));
}
</script>

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
        <?php }if(!empty($pre_pre_month_chart['month'])){?>
        value3: <?php echo $pre_pre_month_chart['class1']['data'];?>,
        <?php } ?>
  },
  {
    category: "<?php echo $chart['class2']['label']?>",
    value1: <?php echo $chart['class2']['data'];?>,
    <?php if(!empty($pre_month_chart['month'])){?>
        value2: <?php echo $pre_month_chart['class2']['data'];?>,
        <?php }if(!empty($pre_pre_month_chart['month'])){?>
        value3: <?php echo $pre_pre_month_chart['class2']['data'];?>,
        <?php } ?>
  },
  {
    category: "<?php echo $chart['class3']['label']?>",
    value1: <?php echo $chart['class3']['data'];?>,
    <?php if(!empty($pre_month_chart['month'])){?>
        value2: <?php echo $pre_month_chart['class3']['data'];?>,
        <?php }if(!empty($pre_pre_month_chart['month'])){?>
        value3: <?php echo $pre_pre_month_chart['class3']['data'];?>,
        <?php } ?>
  },
  {
    category: "<?php echo $chart['class4']['label']?>",
    value1: <?php echo $chart['class3']['data'];?>,
    <?php if(!empty($pre_month_chart['month'])){?>
        value2: <?php echo $pre_month_chart['class4']['data'];?>,
        <?php }if(!empty($pre_pre_month_chart['month'])){?>
        value3: <?php echo $pre_pre_month_chart['class4']['data'];?>,
        <?php } ?>
  },
  {
    category: "<?php echo $chart['class5']['label']?>",
    value1: <?php echo $chart['class5']['data'];?>,
   <?php if(!empty($pre_month_chart['month'])){?>
        value2: <?php echo $pre_month_chart['class5']['data'];?>,
        <?php }if(!empty($pre_pre_month_chart['month'])){?>
        value3: <?php echo $pre_pre_month_chart['class5']['data'];?>,
        <?php } ?>
  }

];

chart.colors.step = 2;
chart.legend = new am4charts.Legend();
chart.legend.useDefaultMarker = true;
//let marker = chart.legend.markers.template.children.getIndex(0);



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
<?php }if(!empty($pre_pre_month_chart['month'])){?>
var series3 = chart.series.push(new am4charts.ColumnSeries());
series3.columns.template.width = am4core.percent(100);
series3.columns.template.tooltipText = "{name}: {valueY.value}";
series3.columns.template.strokeWidth = 0;
series3.name = "<?php  echo date('F, Y',strtotime($pre_pre_month_chart['month'])); ?>";
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
        <?php }if(!empty($pre_pre_month_revenue['month'])){?>
        value3: <?php echo $pre_pre_month_revenue['class1']['data'];?>,
        <?php } ?>
  },
  {
    category: "<?php echo $revenue['class2']['label']?>",
    value1: <?php echo $revenue['class2']['data'];?>,
    <?php if(!empty($pre_month_revenue['month'])){?>
        value2: <?php echo $pre_month_revenue['class2']['data'];?>,
        <?php }if(!empty($pre_pre_month_revenue['month'])){?>
        value3: <?php echo $pre_pre_month_revenue['class2']['data'];?>,
        <?php } ?>
  },
  {
    category: "<?php echo $revenue['class3']['label']?>",
    value1: <?php echo $revenue['class3']['data'];?>,
    <?php if(!empty($pre_month_revenue['month'])){?>
        value2: <?php echo $pre_month_revenue['class3']['data'];?>,
        <?php }if(!empty($pre_pre_month_revenue['month'])){?>
        value3: <?php echo $pre_pre_month_revenue['class3']['data'];?>,
        <?php } ?>
  },
  {
    category: "<?php echo $revenue['class4']['label']?>",
    value1: <?php echo $revenue['class3']['data'];?>,
    <?php if(!empty($pre_month_revenue['month'])){?>
        value2: <?php echo $pre_month_revenue['class4']['data'];?>,
        <?php }if(!empty($pre_pre_month_revenue['month'])){?>
        value3: <?php echo $pre_pre_month_revenue['class4']['data'];?>,
        <?php } ?>
  },
  {
    category: "<?php echo $revenue['class5']['label']?>",
    value1: <?php echo $revenue['class5']['data'];?>,
   <?php if(!empty($pre_month_revenue['month'])){?>
        value2: <?php echo $pre_month_revenue['class5']['data'];?>,
        <?php }if(!empty($pre_pre_month_revenue['month'])){?>
        value3: <?php echo $pre_pre_month_revenue['class5']['data'];?>,
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


var series2 = chart.series.push(new am4charts.ColumnSeries());
series2.columns.template.width = am4core.percent(100);
series2.columns.template.tooltipText = "{name}: {valueY.value}";
series2.columns.template.strokeWidth = 0;
series2.name = "<?php  echo date('F, Y',strtotime($pre_month_chart['month'])); ?>";
series2.dataFields.categoryX = "category";
series2.dataFields.valueY = "value2";
series2.fill = am4core.color("#D3D3D3");

var series3 = chart.series.push(new am4charts.ColumnSeries());
series3.columns.template.width = am4core.percent(100);
series3.columns.template.tooltipText = "{name}: {valueY.value}";
series3.columns.template.strokeWidth = 0;
series3.name = "<?php  echo date('F, Y',strtotime($pre_pre_month_chart['month'])); ?>";
series3.dataFields.categoryX = "category";
series3.dataFields.valueY = "value3";
series3.fill = am4core.color("rgb(102, 153, 255)");
</script>

<!-- Bar Graph Script END -->
<?php// include('charts.php');?>
<?php } //}?>
</div>