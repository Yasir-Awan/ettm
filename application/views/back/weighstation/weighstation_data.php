<?php include('includes/header.php'); ?>
<style>

/*----------------------------------------*/
/*  12.  Dashboard v.1.0 income
/*----------------------------------------*/
.income-monthly{
  background:linear-gradient(to bottom, #b52ea4 0%, #f13800 100%);
}
.overloaded-motorway {
    background: linear-gradient(to bottom, #f31c50 0%, #e6929a 100%);
}
.total-motorway {
    background: linear-gradient(to bottom, #785ce6 0%, #ce6e52 100%);
}
.overload-percent{
background: linear-gradient(to bottom, #7e801b 0%, #d1d42c 100%);
}
.average-overloaded {
    background: linear-gradient(to bottom, #16847f 0%, rgb(59, 234, 210) 100%);
}
.orders-monthly{
  background:linear-gradient(to bottom, #ad6c7c 0%, rgb(216, 0, 255) 100%);
}
.visitor-monthly{
  background:linear-gradient(to bottom, #039477 0%, #2dda7a 100%);
}
.user-monthly{
  background:linear-gradient(to bottom, #b96f77 0%, #ca0e0e 100%);
}
.income-title{
  padding:15px 20px;
  border-bottom:1px solid rgba(233, 157, 128, 0.18);
}
.income-dashone-pro {
    padding: 20px;
}
.main-income-head{
  position:relative;
}
.income-title h2{
  font-size:20px;
  color:#fff;
  margin:0px;
}
.income-title p{
  position:absolute;
  right:0;
  top:0px;
  font-size: 13px;
    color: #fff;
    padding: 2px 10px;
    background: #1c84c6;
    border-radius: 2px;
  margin:0;
}
.main-income-phara.visitor-cl p{
    background: #1ab394;
}
.income-rate-total h3{
  color:#fff;
  font-size:23px;
}
.income-range p{
  font-size:14px;
  color:#fff;
  margin:0;
  float:left;
}
.income-range .income-percentange{
  font-size:14px;
  color:#fff;
  float:right;
}
.income-range.visitor-cl .income-percentange{
  color:#fff;
}
.income-rate-total{
  position:relative;
}
.price-graph{
  position:absolute;
  top:0;
  right:0;
}
.main-income-phara.order-cl p{
  background:#23c6c8;
}
.main-income-phara.low-value-cl p{
  background:#ed5565;
}
.income-range.order-cl .income-percentange{
  color:#fff;
}
.income-range.low-value-cl .income-percentange{
  color:#fff;
}

</style>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="income-order-visit-user-area">
                                    
                    <div class="row">
                       <table class="table" style="width:74%; border-collapse: separate;border: solid #d4320d 5px;border-radius: 6px;">
                        <tr>
                          <td colspan="4" style="padding:0" class="text-center">
                            <span class="text-center" style="font-weight:900;color:purple; font-size: 28px;">National Highways</span>
                          </td>
                        </tr>
                        <tr>

                          <td style="width: 25%;padding: 0.25rem;">
                            <div class="income-dashone-total income-monthly shadow-reset nt-mg-b-30">
                                    <div class="income-title">
                                        <div class="main-income-head">
                                            <h2>Total Weighed<i class="fa fa-truck pull-right" style="font-size: 30px;" aria-hidden="true"></i></h2>
                                            
                                        </div>
                                    </div>
                                    <div class="income-dashone-pro">
                                        <div class="income-rate-total">
                                            <div class="price-adminpro-rate">
                                                <h3><div id="total_month_h" class="odometer" style="font-size:20px" data-min-integer-len="4" data-format="d"><?php echo $month_count[0]['total_vehicles_m_h'];?></div></h3>
                                            </div>
                                            <div class="price-graph">
                                                <span id="sparkline1"></span>
                                            </div>
                                        </div>
                                       <div class="income-range low-value-cl">
                                            <p class="month"><?php echo $month_count[0]['date'];?></p>
                                            <!-- <span class="income-percentange">33% <i class="fa fa-level-down"></i></span> -->
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                            </div>
                            
                          </td>
                          <td style="width: 25%;padding: 0.25rem;">
                             <div class="income-dashone-total orders-monthly shadow-reset nt-mg-b-30">
                                    <div class="income-title">
                                        <div class="main-income-head">
                                            <h2>Overloaded <i class="fa fa-truck pull-right" style="font-size: 30px;" aria-hidden="true"></i></h2>
                                            <!-- <div class="main-income-phara order-cl">
                                                <p>Annual</p>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="income-dashone-pro">
                                        <div class="income-rate-total">
                                            <div class="price-adminpro-rate">
                                                <h3><div id="overload_month_h" class="odometer" style="font-size:20px" data-min-integer-len="4" data-format="d"><?php echo $month_count[0]['overloaded_m_h'];?></div></h3>
                                            </div>
                                            <div class="price-graph">
                                                <span id="sparkline6"></span>
                                            </div>
                                        </div>
                                        <div class="income-range low-value-cl">
                                            <p class="month"><?php echo $month_count[0]['date'];?></p>
                                            <!-- <span class="income-percentange">33% <i class="fa fa-level-down"></i></span> -->
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                             </div>
                       
                          </td>
                          <td style="width: 25%;padding: 0.25rem;">
                              <div class="income-dashone-total overload-percent shadow-reset nt-mg-b-30">
                            <div class="income-title">
                                <div class="main-income-head">
                                    <h2>Overload <i class="fa fa-percent" style="font-size: 16px;" aria-hidden="true"></i><i class="fa fa-truck pull-right" style="font-size: 30px;" aria-hidden="true"></i></h2>
                                    
                                </div>
                            </div>
                            <div class="income-dashone-pro">
                                <div class="income-rate-total">
                                    <div class="price-adminpro-rate">
                                        <h3><div id="overload_avg" class="odometer" style="font-size:20px" data-min-integer-len="3" data-format="(,ddd).dd"><?php echo @round($month_count[0]['overloaded_m_h'] * 100 / $month_count[0]['total_vehicles_m_h'],2);?></div></h3>
                                    </div>
                                    <div class="price-graph">
                                        <span id="sparkline1"></span>
                                    </div>
                                </div>
                               <div class="income-range low-value-cl">
                                    <p class="month"><?php echo $month_count[0]['date'];?></p>
                                    <!-- <span class="income-percentange">33% <i class="fa fa-level-down"></i></span> -->
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                          
                    </td>
                      
                      </tr>
                      <tr>
                        <td style="width: 25%;padding: 0.25rem;">
                            
                               <div class="income-dashone-total user-monthly shadow-reset nt-mg-b-30">
                                <div class="income-title">
                                    <div class="main-income-head">
                                        <h2>Due Fine <img src="<?php echo base_url()?>assets/images/currencylogo.png" class="pull-right" style="max-width:25%;"/></h2>
                                        <!-- <div class="main-income-phara low-value-cl">
                                            <p>Low Value</p>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="income-dashone-pro">
                                    <div class="income-rate-total">
                                        <div class="price-adminpro-rate">
                                            <h3><div id="without_fine" class="odometer" style="font-size:20px" data-min-integer-len="4" data-format="d"><?php echo ($month_count[0]['without_fine'] * 1000);?></div></h3>
                                        </div>
                                        <div class="price-graph">
                                            <span id="sparkline5"></span>
                                        </div>
                                    </div>
                                    <div class="income-range low-value-cl">
                                        <p class="month"><?php echo $month_count[0]['date'];?></p>
                                        <!-- <span class="income-percentange">33% <i class="fa fa-level-down"></i></span> -->
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        
                      </td >
                      <td style="width: 25%;padding: 0.25rem;">
                          <div class="income-dashone-total visitor-monthly shadow-reset nt-mg-b-30">
                                    <div class="income-title">
                                        <div class="main-income-head">
                                            <h2>Fine Collected <img src="<?php echo base_url()?>assets/images/currencylogo.png" class="pull-right" style="max-width:25%;"/></h2>
                                            <!-- <div class="main-income-phara visitor-cl">
                                                <p>Today</p>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="income-dashone-pro">
                                        <div class="income-rate-total">
                                            <div class="price-adminpro-rate">
                                                <h3><div id="fine_month" class="odometer" style="font-size:20px" data-min-integer-len="4" data-format="d"><?php echo $month_count[0]['fined_m'];?></div></h3>
                                            </div>
                                            <div class="price-graph">
                                                <span id="sparkline2"></span>
                                            </div>
                                        </div>
                                        <div class="income-range low-value-cl">
                                            <p class="month"><?php echo $month_count[0]['date'];?></p>
                                            <!-- <span class="income-percentange">33% <i class="fa fa-level-down"></i></span> -->
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                             </div>
                       
                      </td>
                      <td style="width: 25%;padding: 0.25rem;">
                         <div class="income-dashone-total average-overloaded  shadow-reset nt-mg-b-30">
                                <div class="income-title">
                                    <div class="main-income-head">
                                        <h2>Average Overload <i class="fa fa-percent" style="font-size: 16px;" aria-hidden="true"></i><i class="fa fa-truck pull-right" style="font-size: 30px;" aria-hidden="true"></i></h2>
                                        <!-- <div class="main-income-phara order-cl">
                                            <p>Annual</p>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="income-dashone-pro">
                                    <div class="income-rate-total">
                                        <div class="price-adminpro-rate">
                                            <h3><div id="avg_percent" class="odometer" style="font-size:20px" data-min-integer-len="3" data-format="(,ddd).dd"><?php echo round($month_count[0]['sum_percentage'] / $month_count[0]['overloaded_m_h'],2);?></div></h3>
                                        </div>
                                        <div class="price-graph">
                                            <span id="sparkline6"></span>
                                        </div>
                                    </div>
                                    <div class="income-range low-value-cl">
                                        <p class="month"><?php echo $month_count[0]['date'];?></p>
                                        <!-- <span class="income-percentange">33% <i class="fa fa-level-down"></i></span> -->
                                    </div>
                                    <div class="clear"></div>
                                </div>
                          </div>
                     
                      </td>
                    </tr>
                    </table>
                      <table class="table" style="width:24%; margin-left: 0.5%; border-collapse: separate;border: solid #b20fbd 5px;border-radius: 6px;">
                          <tr>
                          <td colspan="4" style="padding:0" class="text-center">
                            <span class="text-center" style="font-size: 28px;font-weight:900;color:#1224a0;">Motorway</span>
                          </td>
                        </tr>
                          <tr>
                              <td style="width: 25%;padding: 0.25rem;">
                                  <div class="income-dashone-total total-motorway shadow-reset nt-mg-b-30">
                                    <div class="income-title">
                                        <div class="main-income-head">
                                            <h2>Total Weighed<i class="fa fa-truck pull-right" style="font-size: 30px;" aria-hidden="true"></i></h2>
                                            
                                        </div>
                                    </div>
                                    <div class="income-dashone-pro">
                                        <div class="income-rate-total">
                                            <div class="price-adminpro-rate">
                                                <h3><div id="total_month_m" class="odometer" style="font-size:20px" data-min-integer-len="4" data-format="d"><?php echo $month_count[0]['total_vehicles_m_m'];?></div></h3>
                                            </div>
                                            <div class="price-graph">
                                                <span id="sparkline1"></span>
                                            </div>
                                        </div>
                                       <div class="income-range low-value-cl">
                                            <p class="month"><?php echo $month_count[0]['date'];?></p>
                                            <!-- <span class="income-percentange">33% <i class="fa fa-level-down"></i></span> -->
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                  </div>
                                
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 25%;padding: 0.25rem;">
                              <div class="income-dashone-total overloaded-motorway shadow-reset nt-mg-b-30">
                                  <div class="income-title">
                                      <div class="main-income-head">
                                          <h2>Overloaded <i class="fa fa-truck pull-right" style="font-size: 30px;" aria-hidden="true"></i></h2>
                                          <!-- <div class="main-income-phara order-cl">
                                              <p>Annual</p>
                                          </div> -->
                                      </div>
                                  </div>
                                  <div class="income-dashone-pro">
                                      <div class="income-rate-total">
                                          <div class="price-adminpro-rate">
                                              <h3><div id="overload_month_m1" class="odometer" style="font-size:20px" data-min-integer-len="4" data-format="d"><?php echo $month_count[0]['overloaded_m_m'];?></div></h3>
                                          </div>
                                          <div class="price-graph">
                                              <span id="sparkline6"></span>
                                          </div>
                                      </div>
                                      <div class="income-range low-value-cl">
                                          <p class="month"><?php echo $month_count[0]['date'];?></p>
                                          <!-- <span class="income-percentange">33% <i class="fa fa-level-down"></i></span> -->
                                      </div>
                                      <div class="clear"></div>
                                  </div>
                              </div>
                            </td>
                          </tr>
                      </table>
                    
                    
                </div>
                <div class="row">
                    <!-- data table start -->
                    
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                        
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="header-title">Weighstations Report</h4>
                                    </div>
                                    
                                </div>
                                
                                <div class='list' id='list'>
                                        <table id="dataTable3" class="text-center" style="width:100% !important;">
                                            <thead class="text-capitalize">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name of Weigh Station</th>
                                                    <th>Operation Date</th>
                                                    <th>Total Vehicle Weighed</th>
                                                    <th>Overloaded</th>
                                                    <th>Fined</th>
                                                    <th>Update Request</th>
                                                    <th>Live Status</th>
                                                    <th>Reports</th>
                                                     
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if($record){
                                                  $counter = 0;
                                                    foreach($record as $row){
                                                        $counter ++;
                                                          

                                                ?>
                                                 <tr>
                                                    <td><?php echo $counter;?></td>
                                                    <td class="text-info" style="font-weight: 600;"><?php echo $row['name'];?></td>
                                                    <td class="text-success"><span id="date_<?php echo $row['id']?>"><?php echo date("F j, Y",strtotime($row['date']));?></span></td>
                                                    <td  style="font-size: 16px;min-width:60px;"><span id="total_<?php echo $row['id']?>" class="odometer"  data-min-integer-len="4" data-format="d"><?php echo $row['total_vehicles'];?></span></td>
                                                    <td  style="font-size: 16px;"><span id="overloaded_<?php echo $row['id']?>" class="odometer"  data-min-integer-len="4" data-format="d"><?php echo $row['overloaded'];?></span></td>
                                                    <td  style="font-size: 16px;min-width:60px;"><span id="fined_<?php echo $row['id']?>" class="odometer"  data-min-integer-len="4" data-format="d"><?php echo $row['fined'];?></span></td>
                                                    <td class="text-info"> <span id="update_<?php echo $row['id']?>"><?php if($row['last_updated']){echo date("F j, Y, g:i a",$row['last_updated']);}else{echo "<span class='badge badge-danger'>Not triggered</span>";}?></span></td>
                                                    <td id="connectivity_status_<?php echo $row['id'];?>"><?php if($row['con_status'] == 0){?><span class="fa fa-exclamation-triangle" style="color: red;font-size:25px;" data-toggle="tooltip" data-placement="top" title="Not Connected"></span><?php }else{?><span class="fa fa-check-square" style="color: green;font-size:25px;" data-toggle="tooltip" data-placement="top" title="Connected"></span><?php } ?></td>
                                                    <td><a href="<?php echo base_url().'admin/weighstation_daily_report/by_weighstation/'.$row['id'];?>" class="btn-xs btn-success fa fa-calendar">&nbsp;Daily</a>&nbsp; <a href="<?php echo base_url().'admin/weighstation_monthly_report/by_weighstation/'.$row['id'];?>" class="btn-xs btn-info fa fa-calendar">&nbsp; Monthly</a></td>
                                                    
                                                </tr> 
                                                <?php    }
                                                }?>
                                               
                                            </tbody>
                                        </table>
   
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dark table end -->
                </div>
            </div>
        </div>
<script>
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'weighstations';
    var module = 'weighstation_daily_report';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });    
</script>
<script src="<?php echo base_url();?>assets/back/js/odometer.js"></script>
<script>
  var k = 0;
  var odometers = document.querySelectorAll(".odometer");

  for (var i = 0, len = odometers.length; i < len; ++i) {
    var it = odometers[i];
    var desc = it.parentNode.querySelector(".desc");
    var valuee = it.textContent || it.innerText; 
    var format = it.getAttribute("data-format");
    var minIntegerLen = it.getAttribute("data-min-integer-len");
    if (minIntegerLen) {
      minIntegerLen = parseInt(minIntegerLen);
    } else {
      minIntegerLen = 0;
    }
    if (!format) {
      //desc.textContent = "real value";
    } else {
      try {
         od = new Odometer({
            el: it,
            value: valuee,
             format: format,
              minIntegerLen: minIntegerLen
          });
        
      } catch (e) {
        alert(e.message);
      }
    }
  }


</script>
 <script>



    $(document).ready(function(){
        $('#dataTable3').DataTable();
    });
      var timer =  setInterval(function(){
    
        $.ajax({   
           url: "<?php echo base_url().'weighstations/get_weighstation_data';?>", // form action url
           type: 'POST', // form submit method get/post
           dataType: 'html',
           success: function(data) {
                var obj = JSON.parse(data);
                obj.records.forEach(function(element) {
                      
                     $('#date_' + element.id).text(element.date) ;
                     $('#total_' + element.id).html(element.total_vehicles) ;
                     $('#overloaded_' + element.id).html(element.overloaded);
                     $('#fined_' + element.id).html(element.fined) ;
                     if(element.last_updated){
                      $('#update_' + element.id).text(element.last_updated) ;
                     
                    }else{
                      $('#update_' + element.id).html("<span class='badge badge-danger'>Not triggered</span>") ;
                    }
                     if(element.con_status == 0){
                        $('#connectivity_status_' + element.id).html('<span class="fa fa-exclamation-triangle" style="color: red;font-size:25px;" data-toggle="tooltip" data-placement="top" title="Not Connected"></span>');
                     }else{
                        $('#connectivity_status_' + element.id).html('<span class="fa fa-check-square" style="color: green;font-size:25px;" data-toggle="tooltip" data-placement="top" title="Connected"></span>');
                     }
                     
                }); 
                //alert(obj.monthly[0].total_vehicles_m);
                     $('#total_month_h').html(obj.monthly[0].total_vehicles_m_h);
                     $('#overload_month_h').html(obj.monthly[0].overloaded_m_h);
                     $('#total_month_m').html(obj.monthly[0].total_vehicles_m_m);
                     $('#overload_month_m').html(obj.monthly[0].overloaded_m_m);
                     $('#fine_month').html(obj.monthly[0].fined_m);
                     $('#overload_avg').html((obj.monthly[0].overloaded_m_h * 100 / obj.monthly[0].total_vehicles_m_h).toFixed(2));
                     $('#avg_percent').html((obj.monthly[0].sum_percentage / obj.monthly[0].overloaded_m_h).toFixed(2));
                     $('#without_fine').html(obj.monthly[0].without_fine * 1000);
                     $('.month').html(obj.monthly[0].date);
                     $('[rel=tooltip]').tooltip('disable')
                     $('[rel=tooltip]').tooltip('destry');
                     $('[data-toggle="tooltip"]').tooltip();          
           },
           error: function(e) {
               console.log(e)
           }
       }); 
        
    },30000); 

    </script>

        <!-- footer area start-->
   <?php include('includes/footer.php')?>       