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
          </div>
          <!-- Revenue Pie chart END -->