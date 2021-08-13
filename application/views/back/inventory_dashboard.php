<?php include('includes/header.php'); ?>
<style>
#table_for_class_vise_traffic_reveneu{ 
  width: 100% ;
  height: auto;}
  td {
    font-family: verdana;
    font-size: 15px;
    font-weight: 400;
}
th {
    font-family: cursive;
    font-size: 17px;
    font-weight: 400;
}
h4{font-family: cursive;}
</style>
<div class="chart_div" style="margin-top: -10px !important;">
   <!-- Content row Start-->
  <div class="row mb-2" style="margin-left:0px; margin-right:0px;">
  <!-- plaza and month filter START -->
    <div class="search-box pull-left col-xl-3 col-md-6 mb-1">
    <!-- Total Traffic Card -->
    </div> 
  </div>
  </div> 
  <!-- Content row End -->
  <div class="modal fade" style="padding-left:4rem;" id="inventoryModal">
                  <div class="modal-dialog modal-xl">
                      <div class="modal-content ">
                          <div class="modal-header">
                              <h5 class="modal-title">Equipment Detail</h5>
                              <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                          </div>
                          <div class="modal-body">
                            <div id="display_installed_details">
                            </div>  
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                      </div>
                  </div>
              </div>

      <div class="main-content-inner">
      <!-- <div id='display_installed_details' style="display:none;">
             </div> -->
        <div class="row dashboard_div">

<!-- Traffic summary table -->
 <div class="col-md-12">
            <div class="card  card-tasks mb-6">
            <div class="card-header primary" class="card border-top-warning shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:3px; border-top: .25rem solid #a728285e">
               <div class='row '>
                    <div class="col-md-4">
                    <?php if($gl){ ?>
                    <h4 class="card-title mt-2 mb-0" style="color:#a728285e;">Building</h4>
                    <?php }?>
                    </div>
                    <div class="col-md-4 mt-1 mb-0" >
                    <h1 class="card-title text-primary" style="font-family: cursive;" ><?php echo $specificSite[0]['name'] ?></h1>
                    </div>
                    <div class="col-md-1 mt-1 mb-0">                    <a class="btn btn-primary btn-xs mt-1" target="_blank" style="margin-left:1.5rem;" href='<?php echo base_url()?>inventory_dashboard/Inventory_Report/<?php echo $specificSite[0]['id'] ?>'><i class="fa fa-file"></i> Report</a></div>
                    <div class="col-md-3 mt-2 mb-0" >
                      <select class="form-control text-primary mb-1" name="site_type" id="site_type" class="card border-left-primary shadow h-100 py-2" style="height: 35px !important; padding-bottom: 6px; padding-left: 5px; border-left: .25rem solid #a728285e!important;" onchange="site_type(this.value)">
                        <option value="">Site Type</option>
                        <option value="2">Weigh Station</option>
                        <option value="1">Toll Plaza</option>
                      </select> 

                      <?php echo form_open_multipart(base_url().'inventory_dashboard/index', array('id' => 'tollplazaId', 'method' => 'post'));?>
                      <select class="form-control text-primary mb-1" name="site" id="sitewt" class="card border-left-primary shadow h-100 py-2" style="display:none; height: 35px !important; padding-bottom: 6px; padding-left: 5px; border-left: .25rem solid #a728285e!important;" onchange="this.form.submit()">
                        
                      </select> 
                      </form>

                    </div>
                                     
                </div>
             </div>

             <?php if($gl){?>
              <div class="card-body" style="padding:0px;">
                <div id="table_for_class_vise_traffic_reveneu">
                   <!-- Table START -->
                   <table class="table" style="line-height: 0.5;">
                        <thead>
                          <tr style="background-color:#a728285e;">
          
                          <?php foreach ($gl as $row){?>
                          <?php $loc = $this->db->get_where('locations', array('id' => $row))->result_array(); ?>
                          <th style="border: 0.20px solid #a728285e; text-align:center;"><?php echo $loc[0]['location'] ?></th>
                          <?php } ?>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($max_gen_data)){
                        for($general_counter=0; $general_counter<$max_gen_data; $general_counter++)
                        { ?>
                        <tr>
                           <?php 
                            $gen_td = count($gd);
                            $i = 0;
                           for($td_counter=0; $td_counter<$gen_td; $td_counter++){ 
                             if(!empty($gd[$td_counter][$general_counter])){
                             $name = $this->db->get_where('items', array('id' => $gd[$td_counter][$general_counter]['name']))->result_array(); 
                             ?>
                             <?php if($gd[$td_counter][$general_counter]['transaction_type']!=3){ ?>
                                      <td style="border: 0.20px solid #a728285e; text-align:center; background:#ff7851;"><a href="#" style="font-family:cursive;color:white;" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$gd[$td_counter][$general_counter]['identification_no'];?>','display_installed_details');" data-toggle="modal" data-target="#inventoryModal"> <?php echo $name[0]['name']; ?></a></td>
                                      <?php 
                                      }
                                      if($gd[$td_counter][$general_counter]['transaction_type']==3){
                                      ?>
                                       <td style="border: 0.20px solid #a728285e; text-align:center; background:#42c692;"><a href="#" style="font-family: cursive;color:white;" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$gd[$td_counter][$general_counter]['identification_no'];?>','display_installed_details');" data-toggle="modal" data-target="#inventoryModal"> <?php echo $name[0]['name']; ?></a></td>
                                      <?php } ?>
                                
                            <?php }
                            if(empty($gd[$td_counter][$general_counter])){ 
                              ?>
                            <td style="border: 0.20px solid #a728285e; text-align:center;"><a href="#" ></a> 
                            </td>   
                             <?php }
                                } ?>
                        </tr>
                        <?php
                        }
                      }
                      if(!isset($max_gen_data)){
                        ?>
                        <h4 class="text-info"> inventory not installed in this building yet!</h4>
                        <?php } ?>
                        </tbody>
                      </table> 
                   <!-- Table END -->
                </div>
              </div>
          <?php } ?>
            </div>
          </div>
<!-- Traffic summary Table END -->

          <!-- Bar Chart START -->
          <?php if(!empty($north)){?>
          <div class="col-md-12 mb-3" style="margin-top:2rem;">
            <div class="card  card-tasks">
            <div class="card-header" class="card border-top-primary shadow h-100 py-2" style="padding-left:1rem; padding-right:1rem; padding-top:3px; border-top: .25rem solid #6f6c7d73!important;">
               <div class='row '>
                    <div class="col-md-4">
                    <h4 class="card-title mt-2 mb-0" style="color:#1a237e;">North Lanes</h4> 
                    </div>
                    <div class='col-md-4'> 
                    <h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php if(!empty($chart)){ echo $chart['tollplaza'];}?> </h5>
                    </div>
                    <div class="col-md-4" style="color:black;"><h6 class="pull-right"><?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h6></div>
                </div>
             </div>
              
              <div class="card-body " style="padding:0px;">
  <!-- Table START -->
  <table class="table" style="line-height: 0.5;">
                        <thead>
                        <?php if($specificSite[0]['site_type']==1){ ?>
                        <tr scope="col">
                        <?php 
                        $var = 'yasir';
                        foreach ($nd as $array){
                                  foreach ($array as $row){
                                    $ptz = $this->db->get_where('items', array('id' => $row['name']))->result_array();
                                     ?>
                                    <?php
                                    if($ptz[0]['name']=='PTZ Camera')
                                    {
                                      ?>
                                          <?php if($row['transaction_type']==3 || $row['transaction_type']==9 || $row['transaction_type']==14){ ?> 
                                              <th colspan="6" style="background:#42c692;"><a href="#" style="font-family:cursive;color:white;" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$row['identification_no'];?>','display_installed_details');"  data-toggle="modal" data-target="#inventoryModal"><?php echo $ptz[0]['name']; $var = 'set'; ?></a></th> 
                                          <!-- <i class="fa fa-check"  style="color:green;"></i> -->
                                          <?php } else {?>
                                              <th colspan="6" style="background:#ff7851;"><a href="#" style="font-family:cursive;color:white;" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$row['identification_no'];?>','display_installed_details');"  data-toggle="modal" data-target="#inventoryModal"> <?php echo $ptz[0]['name']; $var = 'set'; ?></a></th>
                                            <!-- <i class="fa fa-close"  style="color:red;"></i> -->
                                          <?php } ?>                                       
                                  <?php  }
                                  }
                        }
                        if($var == 'yasir'){
                        ?>
                        <th colspan="6"><h4 class="text-info">PTZ Camera not installed in this bound yet!</h4></th>
                        <?php } ?>
                          </tr>
                        <?php } ?>
                          <tr style="background-color:#6f6c7d73;text-align:center;">
                          <?php foreach ($north as $row){?>
                          <?php $nloc = $this->db->get_where('locations', array('id' => $row))->result_array(); ?>
                          <?php if($nloc[0]['location_type']==2 && $nloc[0]['inside_booth']==0){ ?>
                          <th style="border: 0.20px solid #6f6c7d73;" ><?php echo $nloc[0]['location'] ?></th>
                          <?php } ?>
                          <?php } ?>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($max_north_data)){
                          for($north_counter=0; $north_counter<$max_north_data; $north_counter++) 
                          {
                          ?>
                        <tr >
                        <?php 
                            $n_outer_td = count($nd);
                            $i = 0;
                           for($no_counter=0; $no_counter<$n_outer_td; $no_counter++){ 
                             if(!empty($nd[$no_counter][$north_counter])){
                             $nOName = $this->db->get_where('items', array('id' => $nd[$no_counter][$north_counter]['name']))->result_array(); 
                            if($nOName[0]['name']!='PTZ Camera'){
                             ?> 
                                      <?php if($nd[$no_counter][$north_counter]['transaction_type']==3 || $nd[$no_counter][$north_counter]['transaction_type']==9 || $nd[$no_counter][$north_counter]['transaction_type']==14){ ?>
                                        <td class="table-hover" style="line-height:initial;text-align:center;padding:inherit;white-space:nowrap;border:1px solid #6f6c7d73;background:#42c692;"><a href="#" style="font-family:cursive;color:white;" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$nd[$no_counter][$north_counter]['identification_no'];?>','display_installed_details');" data-toggle="modal" data-target="#inventoryModal"> <?php echo $nOName[0]['name']; ?></a>
                                        </td>
                                        <!-- <i class="fa fa-check"  style="color:green;"></i> -->
                                      <?php 
                                      }
                                      else{
                                      ?>
                                      <td class="table-hover" style="line-height:initial;text-align:center;padding:inherit;white-space:nowrap;border:1px solid #6f6c7d73;background:#ff7851;"><a href="#" style="font-family:cursive;color:white;" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$nd[$no_counter][$north_counter]['identification_no'];?>','display_installed_details');" data-toggle="modal" data-target="#inventoryModal"> <?php echo $nOName[0]['name']; ?></a>
                                        </td>
                                      <!-- <i class="fa fa-close"  style="color:red;"></i> -->
                                      <?php } ?>
                            <?php }
                            ?>
                           <?php 
                             }
                             if(empty($nd[$no_counter][$north_counter])){
                             ?>
                             <td style="line-height:initial; text-align:center; padding:inherit; white-space:nowrap; border: 1px solid #6f6c7d73;"></td>
                            <?php } }  ?> 
                          </tr>
                          <?php
                        }
                      }
                      if(!isset($max_north_data)){
                        ?>
                        <h4 class="text-info"> inventory not installed in these lanes yet!</h4>
                        <?php } ?>
                        </tbody>
                      </table>
              </div>
              
               
              </div>
    </div>
    <?php } ?>
    <!-- Bar Chart END -->
     <!-- North bound Inside Booth START -->
     <?php if(!empty($north_inside_booth)){ ?>
     <div class="col-md-12 mb-8">
            <div class="card  card-tasks">
            <div class="card-header" class="card border-top-primary shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:6px; border-top: .25rem solid #6f6c7d73;!important;">
               <div class='row '>
                    <div class="col-md-10">
                    <h4 class="card-title mt-2 mb-0" style="color:#1a237e;">North Booths</h4> 
                    </div>
                    <div class='col-md-1'> 
                    <h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php if(!empty($chart)){ echo $chart['tollplaza'];}?> </h5>
                    </div>
                    <div class="col-md-1" style="color:black;"><h6 class="pull-right"><?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h6></div>
                </div>
             </div>
              
              <div class="card-body " style="padding:0px;">
              <table class="table" style="line-height: 0.5;">
                        <thead>
                          <tr style="color:#1a237e;background-color:#6f6c7d73;text-align:center;">
                          <?php   
                           foreach ($north_inside_booth as $row){?>
                          <?php $nILoc = $this->db->get_where('locations', array('id' => $row))->result_array(); ?>
                          <?php 
                          if($nILoc[0]['location_type']==2 && $nILoc[0]['inside_booth']==1){ ?>
                          <th style="border: 0.20px solid #6f6c7d73;"><?php
                                      if($nILoc[0]['location']=="N1 Inside Booth")
                                      echo "N1";
                                      if($nILoc[0]['location']=="N2 Inside Booth")
                                      echo "N2";
                                      if($nILoc[0]['location']=="N3 Inside Booth")
                                      echo "N3"; 
                                      if($nILoc[0]['location']=="N4 Inside Booth")
                                      echo "N4"; 
                                      if($nILoc[0]['location']=="N5 Inside Booth")
                                      echo "N5"; 
                                      if($nILoc[0]['location']=="N6 Inside Booth")
                                      echo "N6"; 
                              ?></th>
                          <?php } ?>
                          <?php } ?>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($max_north_booth_data)){
                          for($north_booth_counter=0; $north_booth_counter<$max_north_booth_data; $north_booth_counter++) 
                           {
                          ?>
                        <tr >
                        <?php 
                            $nb_td = count($nbd);
                           for($nb_counter=0; $nb_counter<$nb_td; $nb_counter++){ 
                             if(!empty($nbd[$nb_counter][$north_booth_counter])){
                             $nBName = $this->db->get_where('items', array('id' => $nbd[$nb_counter][$north_booth_counter]['name']))->result_array(); 
                            if($nBName[0]['name']!='PTZ Camera'){
                             ?> 
                                      <?php 
                                      if($nbd[$nb_counter][$north_booth_counter]['transaction_type']==3 || $nbd[$nb_counter][$north_booth_counter]['transaction_type']==9 || $nbd[$nb_counter][$north_booth_counter]['transaction_type']==14){ 
                                        ?> 
                                        <td style="line-height:initial;padding:inherit;text-align:center;border:1px solid #6f6c7d73;white-space:nowrap;background:#42c692;"><a href="#" style="font-family:cursive;color:white;" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$nbd[$nb_counter][$north_booth_counter]['identification_no'];?>','display_installed_details');" data-toggle="modal" data-target="#inventoryModal"> <?php echo $nBName[0]['name']; ?></a>
                                        </td>
                                        <!-- <i class="fa fa-check"  style="color:green;"></i> -->
                                      <?php 
                                      }
                                      else{
                                      ?>
                                       <td style="line-height:initial;padding:inherit;text-align:center;border:1px solid #6f6c7d73;white-space:nowrap;background:#ff7851;"><a href="#" style="font-family:cursive;color:white;" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$nbd[$nb_counter][$north_booth_counter]['identification_no'];?>','display_installed_details');" data-toggle="modal" data-target="#inventoryModal"> <?php echo $nBName[0]['name']; ?></a>
                                        </td>
                                      <!-- <i class="fa fa-close"  style="color:red;"></i> -->
                                      <?php  } ?>
                            <?php  }
                            ?>
                           <?php 
                             }
                              if(empty($nbd[$nb_counter][$north_booth_counter])){
                             ?>
                             <td style="line-height:initial; padding:inherit; text-align:center; border: 1px solid #6f6c7d73; white-space:nowrap;"></td>
                            <?php  } }  ?> 
                          </tr>
                          <?php
                        }
                       }
                      if(!isset($max_north_booth_data)){
                        ?>
                        <h5 class="text-info"> inventory not installed in these booths yet!</h5>
                        <?php } ?>
                        </tbody>
                      </table>
                </div>
            </div>
          </div>
          <?php } ?>
<!-- North bound Inside booth END -->
        <!-- South Lanes START -->
        <?php if(!empty($south)){ ?>
        <div class="col-md-12 mb-3" style="margin-top:3rem;">
            <div class="card  card-tasks">
            <div class="card-header" class="card border-top-info shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:3px; border-top: .25rem solid #d0b192!important;">
               <div class='row '>
                    <div class="col-md-4">
                    <h4 class="card-title mt-2 mb-0" style="color:#d0b192;">South Lanes</h4> 
                    </div>
                    <div class='col-md-4'> 
                    <h5 class="card-category text-warning" style='text-align: center; text-info:solid #f6c23e !important;'> <?php if(!empty($chart)){ echo $chart['tollplaza'];}?> </h5>
                    </div>
                    <div class="col-md-4" style="color:black;"><h6 class="pull-right"><?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h6></div>
                </div>
             </div>
              
              <div class="card-body " style="padding:0px;">
              <table class="table" style="line-height: 0.5;">
                        <thead>
                        <?php if($specificSite[0]['site_type']==1){ ?>
                        <tr scope="col">
                        <?php 
                        $var1 = 'nha';
                        foreach ($sd as $array){
                                  foreach ($array as $row){
                                    $ptzSouth = $this->db->get_where('items', array('id' => $row['name']))->result_array();
                                     ?>
                                    <?php
                                    if($ptzSouth[0]['name']=='PTZ Camera')
                                    {
                                      ?> 
                                          <?php if($row['transaction_type']==3 || $row['transaction_type']==9 || $row['transaction_type']==14){ ?>
                                            <th colspan="6" style="background:#42c692;" ><a href="#" style="color:white;" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$row['identification_no'];?>','display_installed_details');" data-toggle="modal" data-target="#inventoryModal"> <?php echo $ptzSouth[0]['name']; $var1 = 'ne'; ?></a></th>  
                                          <!-- <i class="fa fa-check"  style="color:green;"></i> -->
                                          <?php } else {?>
                                            <th colspan="6" style="background:#ff7851;"><a href="#" style="color:whtie;" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$row['identification_no'];?>','display_installed_details');" data-toggle="modal" data-target="#inventoryModal"> <?php echo $ptzSouth[0]['name']; $var1 = 'ne'; ?></a></th>
                                            <!-- <i class="fa fa-close"  style="color:red;"></i> -->
                                          <?php } ?>                                          
                                  <?php  }
                                  }
                        }
                        if($var1 == 'nha'){
                        ?>
                        <th colspan="4"><h4 class="text-info"> PTZ Camera not installed in this bound yet!</h4></th>
                        <?php } ?>
                          </tr>
                        <?php } ?>
                          <tr style="background-color:#d0b192;text-align:center;">
                          <?php foreach ($south as $row){?>
                          <?php $sloc = $this->db->get_where('locations', array('id' => $row))->result_array(); ?>
                          <?php if($sloc[0]['location_type']==3 && $sloc[0]['inside_booth']==0){ ?>
                          <th style="border: 0.20px solid #d0b192;"><?php echo $sloc[0]['location'] ?></th>
                          <?php } ?>
                          <?php } ?>
                            <!-- <th >Total</th> -->
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($max_south_data)){
                          for($south_counter=0; $south_counter<$max_south_data; $south_counter++) 
                          {
                          ?>
                        <tr >
                        <?php 
                            $s_outer_td = count($sd);
                            $i = 0;
                           for($so_counter=0; $so_counter<$s_outer_td; $so_counter++){ 
                             if(!empty($sd[$so_counter][$south_counter])){
                             $sOName = $this->db->get_where('items', array('id' => $sd[$so_counter][$south_counter]['name']))->result_array(); 
                            if($sOName[0]['name']!='PTZ Camera'){
                             ?>
                                      <?php if($sd[$so_counter][$south_counter]['transaction_type']==3 || $sd[$so_counter][$south_counter]['transaction_type']==9 || $sd[$so_counter][$south_counter]['transaction_type']==14){ ?> 
                                        <td style="line-height:initial;text-align:center; border:1px solid #d0b192; padding:inherit;white-space:nowrap;background:#42c692;"><a href="#" style="font-family:cursive;color:white;" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$sd[$so_counter][$south_counter]['identification_no'];?>','display_installed_details');" data-toggle="modal" data-target="#inventoryModal"> <?php echo $sOName[0]['name']; ?></a></td>
                                        <!-- <i class="fa fa-check"  style="color:green;"></i> -->
                                      <?php 
                                      }
                                      else{
                                      ?>
                                      <td style="line-height:initial;text-align:center;border:1px solid #d0b192;padding:inherit;white-space:nowrap;background:#42c692;background:#ff7851;"><a href="#" style="font-family:cursive;color:white;" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$sd[$so_counter][$south_counter]['identification_no'];?>','display_installed_details');" data-toggle="modal" data-target="#inventoryModal"> <?php echo $sOName[0]['name']; ?></a></td>
                                      <!-- <i class="fa fa-close"  style="color:red;"></i> -->
                                      <?php } ?>
                            <?php }
                            ?>
                           <?php 
                             }
                             if(empty($sd[$so_counter][$south_counter])){
                             ?>
                             <td style="line-height:initial;text-align:center; border:1px solid #d0b192; padding:inherit; white-space:nowrap;"></td>
                            <?php } }  ?> 
                          </tr>
                          <?php
                        }
                      }
                      if(!isset($max_south_data)){
                        ?>
                        <h4 class="text-info"> inventory not installed in these lanes yet!</h4>
                        <?php } ?>
                        </tbody>
                      </table>
              </div>
              </div>
    </div>
                      <?php } ?>
    <!-- South Lanes END -->
            <!-- South Booths Start -->
            <?php if(!empty($south_inside_booth)){ ?>
          <div class="col-md-12 mb-2">
            <div class="card  card-tasks">
            <div class="card-header" class="card border-top-info shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:3px; border-top: .25rem solid #d0b192!important;">
               <div class='row '>
                    <div class="col-md-10">
                    <h4 class="card-title mt-2 mb-0"  style="color:#d0b192;">South Booths</h4> 
                    </div>
                    <div class='col-md-1'> 
                    <h5 class="card-category text-warning" style='text-align: center; text-info:solid #d0b192 !important;'> <?php if(!empty($chart)){ echo $chart['tollplaza'];}?> </h5>
                    </div>
                    <div class="col-md-1" style="color:black;"><h6 class="pull-right"><?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h6></div>
                </div>
             </div>
              
              <div class="card-body" style="padding:unset;">
              <table class="table" style="line-height: 0.5;">
                        <thead>
                          <tr style="background-color:#d0b192;">
                          <?php   
                           foreach ($south_inside_booth as $row){?>
                          <?php $sILoc = $this->db->get_where('locations', array('id' => $row))->result_array(); ?>
                          <?php 
                          if($sILoc[0]['location_type']==3 && $sILoc[0]['inside_booth']==1){ ?>
                          <th style="border: 0.20px solid #d0b192; text-align:center;"><?php
                                      if($sILoc[0]['location']=="S1 Inside Booth")
                                      echo "S1";
                                      if($sILoc[0]['location']=="S2 Inside Booth")
                                      echo "S2";
                                      if($sILoc[0]['location']=="S3 Inside Booth")
                                      echo "S3"; 
                                      if($sILoc[0]['location']=="S4 Inside Booth")
                                      echo "S4"; 
                                      if($sILoc[0]['location']=="S5 Inside Booth")
                                      echo "S5"; 
                                      if($sILoc[0]['location']=="S6 Inside Booth")
                                      echo "S6"; 
                              ?></th>
                          <?php } ?>
                          <?php } ?>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($max_south_booth_data)){
                          for($south_booth_counter=0; $south_booth_counter<$max_south_booth_data; $south_booth_counter++) 
                           {
                          ?>
                        <tr >
                        <?php 
                            $sb_td = count($sbd);
                           for($sb_counter=0; $sb_counter<$sb_td; $sb_counter++){ 
                             if(!empty($sbd[$sb_counter][$south_booth_counter])){
                             $sBName = $this->db->get_where('items', array('id' => $sbd[$sb_counter][$south_booth_counter]['name']))->result_array(); 
                            if($sBName[0]['name']!='PTZ Camera'){
                             ?>
                              
                                      <?php 
                                      if($sbd[$sb_counter][$south_booth_counter]['transaction_type']==3 || $sbd[$sb_counter][$south_booth_counter]['transaction_type']==9 || $sbd[$sb_counter][$south_booth_counter]['transaction_type']==14){ 
                                        ?> 
                                        <td style="line-height:initial;text-align:center;border: 1px solid #d0b192;padding:inherit; white-space:nowrap;background:#42c692;"><a href="#" style="font-family:cursive;color:white" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$sbd[$sb_counter][$south_booth_counter]['identification_no'];?>','display_installed_details');" data-toggle="modal" data-target="#inventoryModal"> <?php echo $sBName[0]['name']; ?></a>
                                        </td>
                                        <!-- <i class="fa fa-check"  style="color:green;"></i> -->
                                      <?php 
                                      }
                                      else{
                                      ?>
                                        <td style="line-height:initial;text-align:center;border: 1px solid #d0b192;padding:inherit; white-space:nowrap;background:#ff7851;"><a href="#" style="font-family:cursive;color:white" onclick="show_dashboard_details('<?php echo base_url().'inventory/selected_install/listfromdashboard/'.$sbd[$sb_counter][$south_booth_counter]['identification_no'];?>','display_installed_details');" data-toggle="modal" data-target="#inventoryModal"> <?php echo $sBName[0]['name']; ?></a>
                                        </td>
                                      <!-- <i class="fa fa-close"  style="color:red;"></i> -->
                                      <?php  } ?>
                            <?php  }
                            ?>
                           <?php 
                             }
                              if(empty($sbd[$sb_counter][$south_booth_counter])){
                             ?>
                             <td style="line-height:initial; text-align:center; border: 1px solid #d0b192; padding:inherit; white-space:nowrap;"></td>
                            <?php  } }  ?> 
                          </tr>
                          <?php
                        }
                       }
                      if(!isset($max_south_booth_data)){
                        ?>
                        <h4 class="text-info"> inventory not installed in these booths yet!</h4>
                        <?php } ?>
                        </tbody>
                      </table>
              </div>
              
            </div>
                      <?php } ?>
            <!-- South Booths End -->
        </div>
      </div>
</div>
             <script>
function show_dashboard_details(url,id)
{
var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
  var list = $('#'+id);
  $.ajax({
    url: url,
    beforeSend: function() {
      list.html(loading_set);
    },
    success: function(data){
      console.log(data);
      // $('.dashboard_div').toggle();
      $('#display_installed_details').html(data).show();
    },
    error: function(e) {
      //notify('An error occurred. Please refresh page and try again.','danger','bottom','right');
    }
  });
}
function site_type(val)
{
  console.log(val);
  var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
  // var list = $('#'+id);
  $.ajax({
    url: "<?php echo base_url() ?>inventory_dashboard/SiteType/"+val,
    beforeSend: function() {
      // list.html(loading_set);
    },
    success: function(data){
      sites = JSON.parse(data);
            console.log(sites);
              $('#sitewt').show('slow');
              $('#sitewt').empty().append('<option value="">Select Site</option>');
              sites.forEach(site => {
              $('#sitewt').append('<option value="'+site.id+'">'+ site.name +'</option>');
              }); 
    },
    error: function(e) {
      //notify('An error occurred. Please refresh page and try again.','danger','bottom','right');
    }
  });
}
  </script>
       <?php include('includes/footer.php')?>