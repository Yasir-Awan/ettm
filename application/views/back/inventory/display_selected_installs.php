<div class="table-responsive">
<table class="table table-borderless">
<thead>
<?php foreach($selected_assets as $asset) {
   $site = $this->db->get_where('sites',array('id' => $asset['site']))->result_array();
   $assetName = $this->db->get_where('items',array('id' => $asset['name']))->result_array();?>   
  <span align='center'><h1 style="color: #030a10;font-family: cursive;" class='mb-3 mt-3'><?php echo $site[0]['name'];?></h1></span>
  <?php if($installed_components){ ?>
  <?php $totalComponents = count($installed_components);
          $i = 0;
        if($i <  4){ ?>
          <tr >
        <?php for($i; $i<4; $i++){ 
            $compName = $this->db->get_where('sub_items', array('id' => $installed_components[$i]['subitem_id']))->result_array();
            if(!empty($compName)){
            ?>
                  <th colspan="2" ><a href="#" style="font-family: cursive;"> <?php echo $compName[0]['name']; ?></a> 
                  <?php if($installed_components[$i]['transaction_type']==3 || $installed_components[$i]['transaction_type']==9 || $installed_components[$i]['transaction_type']==14){ ?> 
                  <i class="fa fa-check"  style="color:green;"></i>
                  <?php } else {?>
                    <i class="fa fa-close"  style="color:red;"></i>
                  <?php } ?>   
              </th> 
                  <?php }
             } ?>
          </tr>
      <?php }
              if($i > 3 && $i < 8){ ?>
                <tr>
              <?php for($i; $i<8; $i++){ 
                  $compName = $this->db->get_where('sub_items', array('id' => $installed_components[$i]['subitem_id']))->result_array();
                  if(!empty($compName)){
                  ?>
                        <th colspan="2" ><a href="#" style="font-family: cursive;"> <?php echo $compName[0]['name']; ?></a> 
                        <?php if($installed_components[$i]['transaction_type']==3 || $installed_components[$i]['transaction_type']==9 || $installed_components[$i]['transaction_type']==14){ ?> 
                        <i class="fa fa-check"  style="color:green;"></i>
                        <?php } else {?>
                          <i class="fa fa-close"  style="color:red;"></i>
                        <?php } ?>   
                    </th> 
                        <?php }
               } ?>
                </tr>
            <?php }
                          if($i > 7 && $i < 12){ ?>
                            <tr>
                          <?php for($i; $i<12; $i++){ 
                              $compName = $this->db->get_where('sub_items', array('id' => $installed_components[$i]['subitem_id']))->result_array();
                              if(!empty($compName)){
                              ?>
                                    <th colspan="2" ><a href="#" style="font-family: cursive;"> <?php echo $compName[0]['name']; ?></a> 
                                    <?php if($installed_components[$i]['transaction_type']==3 || $installed_components[$i]['transaction_type']==9 || $installed_components[$i]['transaction_type']==14){ ?> 
                                    <i class="fa fa-check"  style="color:green;"></i>
                                    <?php } else {?>
                                      <i class="fa fa-close"  style="color:red;"></i>
                                    <?php } ?>   
                                </th> 
                                    <?php }
                           } ?>
                            </tr>
                        <?php }
        } ?> 
  <br><br>
<div class"row">

<span align='center'><h5 style="color: #030a10;font-family:'lato', sans-serif;"><?php echo $assetName[0]['name']; ?></h5></span>
        <div class="row"> 
        <div class="col-md-6">
        </div>
        <div class="col-md-2">
        <!-- <span class="btn btn-success pull-right btn-xs btn-labeled " id="cancel_reason" name="asset_edit" onclick="ajax_html('<?php echo base_url().'inventory/asset_edit/'.$asset['id'];?>','edit_asset_contents');" data-toggle="modal" data-target="#assets-edit" style='margin-right:-260px;'> <i class="fa fa-edit"> </i> &nbsp; Edit</span> -->
        </div>             
        <div class="col-md-2">
                    <span class="btn btn-danger btn-md  fas fa-trash-alt" style="margin-left:18rem;margin-top:-50px;" onclick="delete_confirm_tab('Really want to delete This','<?php echo base_url().'inventory/installed_inventory/delete/'.$asset['identification_no'];?>')"> 
                    Delete</span>
                    </div> 
                    </div>              
</thead>
<tbody>
    <tr>
      <th scope="row"><span class="text-left" style=" color:#08842c;float:left;">Description:</span></th>
      <td ><span style="color:#030a10;font-weight:750;font-family:'lato', sans-serif;"><?php echo $assetName[0]['description'];?></span></td>
      <th scope="row"><span class="text-left" style="color: #08842c;float: left;margin-left: ;">Name:</span></th>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"><?php echo $assetName[0]['name'];?></span></td>
      <th><span  style="color:#08842c;">Purchase Cost:</span></th>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"><?php echo $asset['cost_price'];?></span></td>
      <th scope="row"><span style="color:#08842c;float:left;">Purchase On:</span></th>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"><?php echo date("F j, Y",strtotime($asset['purchased_on']))?></span></td>
    </tr> 
    <tr>
    <th scope="row"><span class="text-left" style="color:#08842c;float:left;">Serial:</span></th>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"><?php echo $asset['serial_no'];?></span></td>
      <th><span class="text-left" style="color:#08842c;float:left;">Model:</span></th>
      <td><span style="margin-left:-15px;font-weight:750;font-family:'lato', sans-serif;"><?php echo $asset['product_model_no'];?></span></td>
      <th scope="row"><span class="text-left" style="color:#08842c;float:left;">Supplier:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"><?php echo $supplierName[0]['name'];?></span></td>
      <th><span class="text-left" style="color:#08842c;float:left;">Manufecturer:</span></th>
      <?php $manufacturer = $this->db->get_where('manufacturers',array('id' => $asset['manufacturer']))->result_array();?>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"><?php echo $manufacturer[0]['name'];?></span></td>    
    </tr> 
    <tr>
    <th scope="row"><span class="text-left" style="color:#08842c;float:left;">Site:</span></th>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"><?php echo $site[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="color:#08842c;float:left;">Warranty Type:</span></th>&nbsp
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-weight:750;font-family:'lato', sans-serif;"> <?php  if($asset['warranty_type']==0) { echo " Have no Warranty."; } if($asset['warranty_type']==1) { echo " Replacement Warranty." ; } if($asset['warranty_type']==2) { echo " Repairing Warranty." ; } ?></span> </td>
      <th><span class="text-left" style="color:#08842c;float: left;">Warranty Duration:</span></th>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"><?php echo $asset['warranty_duration'];?></span></td>
      <th scope="row"><span class="text-left" style="color:#08842c;float:left;">This asset Added on:</span></th>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"><?php echo date('F j, Y, g:i a',$asset['add_date']);?></span></td>
    </tr> 
    <tr>
    <th scope="row"><span class="text-left" style="color:#08842c;float:left;">Added by User Type:</span></th>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"> <?php  if($asset['user_type']==1) { echo "Admin"; } if($asset['user_type']==2) { echo "Supervisor" ; } if($asset['user_type']==3) { echo "Member" ; } ?></span> </td>
    <th scope="row"><span class="text-left" style="color:#08842c;float:left;">Added by User Name:</span></th>
      <?php 
      if($asset['user_type']==1) 
      {
        $userName = $this->db->get_where('admin',array('id' => $asset['checkin_by']))->result_array();
      } 
      if($asset['user_type']==2) 
      {
        $userName = $this->db->get_where('tpsupervisor',array('id' => $asset['checkin_by']))->result_array();
      } 
      if($asset['user_type']==3) 
      {
        $userName = $this->db->get_where('member',array('id' => $asset['checkin_by']))->result_array();
      } 
      ?>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"> <?php   echo $userName[0]['fname']." ".$userName[0]['lname'];  ?></span> </td>
      <th><span  style="color:#08842c;">Asset Ratting:</span></th>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"><?php echo $asset['asset_comment'];?></span></td>
      <th><span  style="color:#08842c;">Id No:</span></th>
      <td><span style="font-weight:750;font-family:'lato', sans-serif;"><?php echo $asset['identification_no'];?></span></td>
    </tr> 
  </tbody>
  </table>      
<?php } ?> 
 </row>
</div>
<br>
<br>
<br>
<br>
    
<table class="table table-borderless">
<thead>
<tr>
    <span align='center'><h3 style="color: #030a10;font-family:'lato', sans-serif;">Equipment Current Status</h3></span>  
</tr> 
<br>            
</thead>
<tbody>
    <tr>
    <th scope="row"><span class="text-left" style="color:#08842c;float:left;">Current Status</span></th>
      <?php
      if($selected_assets[0]['action_status']==0) 
      {
        $actionStatus = "Brand New";  
      } 
      if($selected_assets[0]['action_status']==1) 
      {
        $actionStatus = "Checked Out";
      } 
      if($selected_assets[0]['action_status']==2) 
      {
        $actionStatus = "Checked In";
      } 
      if($selected_assets[0]['action_status']==3) 
      {
        $actionStatus = "Installed";
      } 
      if($selected_assets[0]['action_status']==4) 
      {
        $actionStatus = "Repairing Mode";
      } 
      if($selected_assets[0]['action_status']==5) 
      {
        $actionStatus = "Repaired";
      } 
      if($selected_assets[0]['action_status']==6) 
      {
        $actionStatus = "Retired";
      }
      if($selected_assets[0]['action_status']==9) 
      {
        $actionStatus = "Re Installed";
      } 
      if($selected_assets[0]['action_status']==10) 
      {
        $actionStatus = "Faulty";
      } 
      ?>
      <td> <span style="font-weight:750;font-family:'lato', sans-serif;color: #030a10;margin-left:-25px;"> <?php   echo $actionStatus;  ?></span> </td>
        <?php if($selected_assets[0]['action_status']==0){?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;"><?php   echo "No action performed on this Asset.";  ?></span></th>
        <?php } ?>
        <?php 
              foreach($selected_installed_transaction as $transaction){
                if($transaction['transaction_type']==1){
         ?>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-50px;">Checked Out from Site:</span></th>
      <?php $fromSiteName = $this->db->get_where('sites',array('id'=>$transaction['checkout_from_site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $fromSiteName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Checked Out for Site:</span></th>
      <?php $forSiteName = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $forSiteName[0]['name'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">In Custody Of:</span></th>
       <?php 
                if($transaction['checkout_user_role']==1)
                {
                  $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
           ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
           <?php } ?>
           <?php 
                if($transaction['checkout_user_role']==2)
                {
                  $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
           ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
           <?php } ?>
           <?php 
                if($transaction['checkout_user_role']==3)
                {
                  $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
           ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
           <?php } ?>           
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Person's Contact:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['person_contact'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Issued:</span></th>
      <?php if($transaction['issuance_type']==1){ ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo 'Pemanent';?></span></td>
                <?php } ?>
      <?php if($transaction['issuance_type']==2){ ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo 'Temporary';?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Asset will Return on:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo date("F j, Y",strtotime($transaction['return_date']));?></span></td>
                <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Check Out By:</span></th>
      <?php
            if($transaction['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Added on:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transaction['action_date']));?> </span> </td>
      <!-- <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Duration</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['warranty_duration'];?></span></td> -->
    </tr>
      <?php } 
      /** Transaction Type 1 END */

      /** Transaction Type 3 START */
            if($transaction['transaction_type']==3){
         ?>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-50px;">Installed at Site:</span></th>
      <?php $installSiteName = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $installSiteName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Insalled Location:</span></th>
      <?php $installLocationName = $this->db->get_where('locations',array('id'=>$transaction['location']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $installLocationName[0]['location'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Installed by Person:</span></th>
      <?php 
                            if($transaction['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
                        ?>
                        <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php   
                            }
                            elseif($transaction['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php 
                            }
                            elseif($transaction['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
                            ?>
                             <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                       <?php
                            }
                            else
                            {
                            ?>
                              <span class="btn-primary btn-xs"><?php echo $transaction['person'] ?></span><br>
                      <?php } ?>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Person's Contact:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['person_contact'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Installing Company:</span></th>
                         <?php    if($transaction['organisation_type']==1)
                               {
                                 $tspName = $this->db->get_where('tsp',array('id'=>$transaction['organisation']))->result_array();?>
                                 <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $tspName[0]['name']?></span></td>
                         <?php } 
                               if($transaction['organisation_type']==2)
                               {
                                 ?>
                                 <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $transaction['organisation']?></span></td>
                         <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Company Address:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['organisation_address'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Added on:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transaction['action_date']));?> </span> </td>           
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Add by:</span></th>
      <?php
            if($transaction['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Installing Comments:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['action_comments'];?></span></td>

      <!-- <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Duration</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['warranty_duration'];?></span></td> -->
    </tr>
      <?php } 
      /** Transaction Type 3 END */
      /** Transaction Type 4 START */
            if($transaction['transaction_type']==4){
         ?>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-5px;">Repairing from Site:</span></th>
      <?php $rprSiteName = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $rprSiteName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing From Location:</span></th>
      <?php $rprLocationName = $this->db->get_where('locations',array('id'=>$transaction['location']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $rprLocationName[0]['location'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing by Person:</span></th>
      <?php 
                            if($transaction['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
                        ?>
                        <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php   
                            }
                            elseif($transaction['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php 
                            }
                            elseif($transaction['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
                            ?>
                             <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                       <?php
                            }
                            else
                            {
                            ?>
                            <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $transaction['person'];?></span></td><br>
                              <!-- <span class="btn-primary btn-xs"><?php echo $transaction['person'] ?></span><br> -->
                      <?php } ?>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Person's Contact:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['person_contact'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Company:</span></th>
                         <?php    if($transaction['organisation_type']==1)
                               {
                                 $tspName = $this->db->get_where('tsp',array('id'=>$transaction['organisation']))->result_array();?>
                                 <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $tspName[0]['name']?></span></td>
                         <?php } 
                               if($transaction['organisation_type']==2)
                               {
                                 ?>
                                 <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $transaction['organisation']?></span></td>
                         <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Company Address:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['organisation_address'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Added on:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transaction['action_date']));?> </span> </td>           
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Add by:</span></th>
      <?php
            if($transaction['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['action_comments'];?></span></td>

      <!-- <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Duration</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['warranty_duration'];?></span></td> -->
    </tr>
      <?php
       } 
       /** Transaction Type 4 END */
      ?>
      
      <?php  
      /** Transaction Type 9 START */
            if($transaction['transaction_type']==9){
         ?>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-50px;">Re Install at Site:</span></th>
      <?php $rinstlSiteName = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $rinstlSiteName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Re Install at Location:</span></th>
      <?php $rinstlLocationName = $this->db->get_where('locations',array('id'=>$transaction['location']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $rinstlLocationName[0]['location'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Reinstall by Person:</span></th>
      <?php 
                            if($transaction['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
                        ?>
                        <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php   
                            }
                            elseif($transaction['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php 
                            }
                            elseif($transaction['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
                            ?>
                             <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                       <?php
                            }
                            else
                            {
                            ?>
                            <td><?php echo $transaction['person'] ?></td>
                              <br>
                      <?php } ?>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Person's Contact:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['person_contact'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Reinstall Company:</span></th>
                         <?php if($transaction['organisation_type']==1)
                               {
                                 $tspName = $this->db->get_where('tsp',array('id'=>$transaction['organisation']))->result_array();?>
                                 <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $tspName[0]['name']?></span></td>
                         <?php } 
                               if($transaction['organisation_type']==2)
                               {
                                 ?>
                                 <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $transaction['organisation']?></span></td>
                         <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Company Address:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['organisation_address'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Complete Date:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo date("F j, Y",strtotime($transaction['return_date']));?></span></td>
    </tr> 
    <tr>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Cost</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $transaction['unit_repairing_cost'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Added on:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transaction['action_date']));?> </span> </td>           
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Add by:</span></th>
      <?php
            if($transaction['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['action_comments'];?></span></td>

      
    </tr>
      <?php 
      }
            /** Transaction Type 9 END */
       ?>
       <?php
              /** Transaction Type 10 START */
            if($transaction['transaction_type']==10){
         ?>
  <tr>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-50px;">Faulty at Site:</span></th>
      <?php $rinstlSiteName = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $rinstlSiteName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Faulty at Location:</span></th>
      <?php $rinstlLocationName = $this->db->get_where('locations',array('id'=>$transaction['location']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $rinstlLocationName[0]['location'];?></span></td>
      <!-- <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Reinstall by Person:</span></th>
      <?php 
                            if($transaction['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
                        ?>
                        <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php   
                            }
                            elseif($transaction['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php 
                            }
                            elseif($transaction['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
                            ?>
                             <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                       <?php
                            }
                            else
                            {
                            ?>
                            <td><?php echo $transaction['person'] ?></td>
                              <br> -->
                      <?php } ?>
                      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Faulty Time OMC:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['faulty_time_omc'];?></span></td>
    </tr> 
     
    <tr>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Estimated Cost</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $transaction['estimated_cost'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Added on:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transaction['action_date']));?> </span> </td>           
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Add by:</span></th>
      <?php
            if($transaction['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Faulty Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['action_comments'];?></span></td>

      
    </tr>
      <?php 
      }
            /** Transaction Type 10 END */
       ?>










            <?php
            /** Transaction Type 2 START */
            if($transaction['transaction_type']==2){
         ?>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-50px;">Checkin at Site:</span></th>
      <?php $checkinSiteName = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $checkinSiteName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Checkout from:</span></th>
      <?php
            $fromSite = $this->db->select('*')->where('asset_id',$transaction['asset_id'])->where('transaction_type',1)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
            $fromSiteName = $this->db->get_where('sites',array('id'=>$fromSite[0]['checkout_from_site']))->result_array(); 
           ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $fromSiteName[0]['name'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Checkin Performed by:</span></th>
      <?php 
                          $lastCheckoutAsset = $this->db->select('*')->where('asset_id',$transaction['asset_id'])->where('transaction_type',1)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
                            if($lastCheckoutAsset[0]['checkout_user_role'] ==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$lastCheckoutAsset[0]['person']))->result_array();
                        ?>
                      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo  $personName[0]['fname']." ".$personName[0]['lname'] ?></span></td>
                      <?php   
                            }
                            elseif($lastCheckoutAsset[0]['checkout_user_role']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$lastCheckoutAsset[0]['person']))->result_array();
                            ?>
                              <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo  $personName[0]['fname']." ".$personName[0]['lname'] ?></span></td>
                      <?php 
                            }
                            elseif($lastCheckoutAsset[0]['checkout_user_role']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$lastCheckoutAsset[0]['person']))->result_array();
                            ?>
                              <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo  $personName[0]['fname']." ".$personName[0]['lname'] ?></span></td>
                       <?php } ?>
                            
                     
     
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Person's Contact:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $lastCheckoutAsset[0]['person_contact'] ?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Checkin Date:</span></th>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transaction['action_date']));?> </span> </td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Checkin by:</span></th>
      <?php
            if($transaction['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
            <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['action_comments'];?></span></td>
    </tr> 
    <tr>
      <!-- <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['action_comments'];?></span></td> -->
    </tr>
      <?php } 
                  /** Transaction Type 2 END */
      ?>
      <?php 
                  /** Transaction Type 6 START */ 
            if($transaction['transaction_type']==6){
         ?>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-50px;">Retire Type:</span></th>
      <?php 
            $retireType ;
            if($transaction['retire_type']==1)
            {
              $retireType = "Damaged";
            }
            if($transaction['retire_type']==2)
            {
              $retireType = "Lost";
            }
            if($transaction['retire_type']==3)
            {
              $retireType = "Gifted";
            }
            if($transaction['retire_type']==4)
            {
              $retireType = "Expired";
            }
            if($transaction['retire_type']==5)
            {
              $retireType = "Consumed";
            }
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $retireType;?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Retire Site:</span></th>
      <!-- <?php
            $fromSite = $this->db->select('*')->where('asset_id',$transaction['asset_id'])->where('transaction_type',1)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
            $fromSiteName = $this->db->get_where('sites',array('id'=>$fromSite[0]['checkout_from_site']))->result_array(); 
           ?> -->
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo "Not added yet! "?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Retire Date:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo date("F j, Y",strtotime($transaction['retire_date'])) ?></span></td>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Date:</span></th>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transaction['action_date']));?> </span> </td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Retire by:</span></th>
      <?php
            if($transaction['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transaction['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transaction['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
            <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:;">Retire Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['action_comments'];?></span></td>
    </tr> 
    <tr>
      <!-- <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['action_comments'];?></span></td> -->
    </tr>
      <?php }
                        /** Transaction Type 6 END */
       } ?>     
  </tbody>
</table>
<br>
<br>
<br>
<br>
                <div class="row ">
                    <div class="col-md-12">
                    <span align='center'><h5 style="color: #030a10; ">Equipment History</h5></span>
                    </div>  
                </div>
          <!-- <div class="table-responsive " style=""> -->
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12 pl-1 pr-1">
                   <table class="table table-bordered dataTable" id="dataTable_SI_history" width="100%" cellspacing="0" role="grid"; aria-describedby="dataTable_info" style="width: 100%; ">
                  <thead align='center'>
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: auto;">#Sr</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width:auto;">Name</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Transaction</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Asset Site</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Transaction Performed by</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Transaction Add Date</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Transaction Added by</th>
                      <!-- <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Action</th> -->
                    </tr>
                  </thead>

                  <?php if($install_transactions) { ?>
                  <tbody align='center'>  
                    <?php $counter=1; ?>
                  <?php foreach($install_transactions as $transaction) { ?>         
                  <tr role="row" class="odd">
                   <td style="width:2%;" valign="middle">
                      <?php echo $counter++ ?> 
                   </td>
                   <td style="width:5%;" valign="middle">
                   <?php
                   $asset = $this->db->get_where('assets',array('id'=>$transaction['asset_id']))->result_array();                   
                   $asset_name = $this->db->get_where('items',array('id'=>$asset[0]['name']))->result_array();
                   echo $asset_name[0]['name'];
                   ?>
                   </td>
                   <td style="width:3%;" valign="middle">
                      <?php
                      if($transaction['transaction_type']==1){
                        echo "Checked Out";
                      }
                      if($transaction['transaction_type']==2){
                        echo "Checked In";
                      }
                      if($transaction['transaction_type']==3){
                        echo "Install";
                      }
                      if($transaction['transaction_type']==4){
                        echo "Started Repairing";
                      }
                      if($transaction['transaction_type']==6){
                        echo "Retired";
                      }
                      if($transaction['transaction_type']==9){
                        echo "Repaired & Reinstalled";
                      }
                      if($transaction['transaction_type']==10){
                        echo "Faulty";
                      }
                      ?>
                   </td>
                   <td >
                     <?php if($transaction['transaction_type']==1){ ?>
                      <?php 
                        $fromSite = $this->db->get_where('sites',array('id'=>$transaction['checkout_from_site']))->result_array();
                        $toSite = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();  
                      ?>                      
                      <span class="btn-primary btn-xs"> <?php echo "from:".$fromSite[0]['name'] ?></span><br>
                      <span class="btn-danger btn-xs"><?php echo "to:".$toSite[0]['name'] ?></span>
                     <?php 
                     }
                     elseif($transaction['transaction_type']==2)
                     { 
                           $fromSite = $this->db->select('*')->where('asset_id',$transaction['asset_id'])->where('transaction_type',1)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
                           $fromSiteName = $this->db->get_where('sites',array('id'=>$fromSite[0]['checkout_from_site']))->result_array();
                           $toSite = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();  
                         ?>                      
                         <span class="btn-primary btn-xs"> <?php echo "Checkout from:".$fromSiteName[0]['name'] ?></span><br>
                         <span class="btn-danger btn-xs"><?php echo "Checkin at:".$toSite[0]['name'] ?></span> 
                      
                      <?php 
                      }
                      elseif($transaction['transaction_type']==6)
                      { 
                          // $Site = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();  
                          ?>                      
                          <span class="btn-danger btn-xs"><?php echo "Retire Site not added yet! by developer."; ?></span> 
                       
                       <?php 
                       }    
                     else 
                     { 
                     $transactionToSite = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();
                     $transactionToLocation = $this->db->get_where('locations',array('id'=>$transaction['location']))->result_array();  
                      ?>                      
                      <span class="btn-primary btn-xs"> <?php echo "Site:".$transactionToSite[0]['name'] ?></span><br>
                      <span class="btn-danger btn-xs"><?php echo "Location:".$transactionToLocation[0]['location'] ?></span>
                <?php } ?>
                   </td>
                  
                   <td style="width:20%;">
                      <?php if($transaction['transaction_type']==3){ ?>
                      <?php    if($transaction['organisation_type']==1)
                               {
                                 $tspName = $this->db->get_where('tsp',array('id'=>$transaction['organisation']))->result_array();?>
                                 <span class="btn-success btn-xs"><?php echo $tspName[0]['name']?></span><br>
                         <?php } 
                               if($transaction['organisation_type']==2)
                               {
                                 ?>
                                 <span class="btn-success btn-xs"><?php echo $transaction['organisation']?></span><br>
                         <?php } ?>
                      <?php 
                            if($transaction['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
                        ?>
                      <span class="btn-primary btn-xs"><?php echo  "Installed by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php   
                            }
                            elseif($transaction['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Installed by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php 
                            }
                            elseif($transaction['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Installed by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                       <?php
                            }
                            else
                            {
                            ?>
                              <span class="btn-primary btn-xs"><?php echo  "Installed by:".$transaction['person'] ?></span><br>
                      <?php } ?>
                      <span class="btn-danger btn-xs"><?php echo $transaction['person_contact'] ?></span>
                    <?php } ?>
                      <?php if($transaction['transaction_type']==4)
                      {
                        if ($transaction['organisation_type']==1)
                        {
                        ?>
                        <?php $tspName = $this->db->get_where('tsp',array('id'=>$transaction['organisation']))->result_array();?>
                      <span class="btn-success btn-xs"><?php echo $tspName[0]['name']?></span><br>
                      <?php 
                            if($transaction['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
                        ?>
                      <span class="btn-primary btn-xs"><?php echo  "Repairing Started by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php   
                            }
                            elseif($transaction['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Repairing Started by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php 
                            }
                            elseif($transaction['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Repairing Started by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                       <?php
                            }
                            else
                            {
                            ?>
                              <span class="btn-primary btn-xs"><?php echo  "Repairing Started by:".$transaction['person'] ?></span><br>
                      <?php } ?>
                      <span class="btn-danger btn-xs"><?php echo $transaction['person_contact'] ?></span>
                      <?php }

                          if ($transaction['organisation_type']==2)
                           {
                            ?>
                           <!-- <?php $tspName = $this->db->get_where('tsp',array('id'=>$transaction['organisation']))->result_array();?> -->
                           <span class="btn-success btn-xs"><?php echo $transaction['organisation']?></span><br>
                           
                                 <span class="btn-primary btn-xs"><?php echo  "Repairing Started by:".$transaction['person'] ?></span><br>
                              
                            
                                  <span class="btn-danger btn-xs"><?php echo $transaction['person_contact'] ?></span>
                                <?php }

                              if($transaction['organisation_type']==3){
                               
                              $ast_mfg = $this->db->get_where('manufacturers',array('id' => $transaction['organisation']))->result_array();
 
                                ?>
 
                               <span class="btn-success btn-xs"><?php echo $ast_mfg[0]['name']?></span><br>

                                <span class="btn-primary btn-xs"><?php echo  "Repairing Started by:".$transaction['person'] ?></span><br>

                                <span class="btn-danger btn-xs"><?php echo $transaction['person_contact'] ?></span>                      
                               <?php 
                                 }


                               } ?>



                      <?php if($transaction['transaction_type']==9){ ?>
                        <?php 
                        if($transaction['organisation_type']==1) {
                          $tspName = $this->db->get_where('tsp',array('id'=>$transaction['organisation']))->result_array();
                          ?>
                      <span class="btn-success btn-xs"><?php echo $transaction['organisation']?></span><br>
                      <?php 
                            if($transaction['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
                        ?>
                      <span class="btn-primary btn-xs"><?php echo  "Repaired/Reinstalled by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php   
                            }
                            elseif($transaction['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Repaired/Reinstalled:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                        <?php 
                            }
                            elseif($transaction['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Repaired/Reinstalled:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                       <?php
                            }
                            else
                            {
                            ?>
                              <span class="btn-primary btn-xs"><?php echo  "Repaired/Reinstalled:".$transaction['person'] ?></span><br>
                      <?php } ?>
                      <span class="btn-danger btn-xs"><?php echo $transaction['person_contact'] ?></span>
                      <?php
                      }

                      if($transaction['organisation_type']==2) {
                        // $tspName = $this->db->get_where('tsp',array('id'=>$transaction['organisation']))->result_array();
                        ?>
                    <span class="btn-success btn-xs"><?php echo $transaction['organisation']?></span><br>
                    
                    <span class="btn-primary btn-xs"><?php echo  "Repaired/Reinstalled by:".$transaction['person'] ?></span><br>
                    
                    <span class="btn-danger btn-xs"><?php echo $transaction['person_contact'] ?></span>
                    <?php
                    }


                    if($transaction['organisation_type']==3) {
                      $mfgName = $this->db->get_where('manufacturers',array('id'=>$transaction['organisation']))->result_array();
                      ?>
                  <span class="btn-success btn-xs"><?php echo $mfgName[0]['name']?></span><br>
                  
                  <span class="btn-primary btn-xs"><?php echo  "Repaired/Reinstalled by:".$transaction['person'];?></span><br>
                 
                  <span class="btn-danger btn-xs"><?php echo $transaction['person_contact'] ?></span>
                  <?php
                  }


                    } 
                    ?>


                       <?php if($transaction['transaction_type']==10){ ?>
                       
                      <span class="btn-primary btn-xs"><?php echo "When item becomes faulty at that time"?></span><br>
                      <span class="btn-success btn-xs"><?php echo "OMC: ".$transaction['faulty_time_omc']?></span><br>
                      <span class="btn-danger btn-xs"><?php echo "Faulty Date: ".date('F j, Y, g:i a',strtotime($transaction['faulty_date']));?></span><br>
                      <?php } ?>

                    


                      <?php if($transaction['transaction_type']==1){ ?>
                      <?php 
                            if($transaction['checkout_user_role']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
                        ?>
                      <span class="btn-primary btn-xs"><?php echo  "Checked Out to:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php   
                            }
                            elseif($transaction['checkout_user_role']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Checked Out to:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                            <?php 
                            }
                            elseif($transaction['checkout_user_role']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Checked Out to:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                       <?php } ?>
                            
                      <span class="btn-danger btn-xs"><?php echo $transaction['person_contact'] ?></span>
                      <?php } ?>
                      <?php if($transaction['transaction_type']==2){  
                          $lastCheckoutAsset = $this->db->select('*')->where('asset_id',$transaction['asset_id'])->where('transaction_type',1)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
                            if($lastCheckoutAsset[0]['checkout_user_role'] ==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$lastCheckoutAsset[0]['person']))->result_array();
                        ?>
                      <span class="btn-primary btn-xs"><?php echo  $personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php   
                            }
                            elseif($lastCheckoutAsset[0]['checkout_user_role']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$lastCheckoutAsset[0]['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Checked Out to:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php 
                            }
                            elseif($lastCheckoutAsset[0]['checkout_user_role']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$lastCheckoutAsset[0]['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Checked Out to:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                       <?php } ?>
                            
                      <span class="btn-danger btn-xs"><?php echo $lastCheckoutAsset[0]['person_contact'] ?></span> 
                      <?php } ?>
                      <?php if($transaction['transaction_type']==6){ ?>
                        
                      <span class="btn-primary btn-xs"><?php echo  $transaction['action_comments']?></span><br>
                      
                      <?php } ?>
                   </td>

                   <td><span class="btn-success btn-xs"><?php echo date('F j, Y, g:i a',strtotime($transaction['action_date'])) ?></span></td>
                   <td style="width:5%;" >
                   <?php 
                          if($transaction['user_type']==1){
                            $adding_person_name = $this->db->get_where('admin',array('id'=>$transaction['added_by']))->result_array();
                            echo $adding_person_name[0]['fname']." ".$adding_person_name[0]['lname'];
                          }
                          if($transaction['user_type']==2){
                            $adding_person_name = $this->db->get_where('tpsupervisor',array('id'=>$transaction['added_by']))->result_array();
                            echo $adding_person_name[0]['fname']." ".$adding_person_name[0]['lname'];
                          }
                          if($transaction['user_type']==3){
                            $adding_person_name = $this->db->get_where('member',array('id'=>$transaction['added_by']))->result_array();
                            echo $adding_person_name[0]['fname']." ".$adding_person_name[0]['lname'];
                          }
                       ?>
                   </td>
                   
                  </tr>
                  <?php } ?>
                   </tbody>
              <?php } ?>
                </table>
                </div><!-- col-sm-12 END -->
             </div><!-- row END -->
             
            </div><!-- dataTable wrapper END -->
          <!-- </div> -->
          <script>
          $(document).ready(function(){
            $('#dataTable_SI_history').DataTable();
          })
          </script>