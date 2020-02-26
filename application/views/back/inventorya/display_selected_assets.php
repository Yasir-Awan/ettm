<div class="table-responsive hide_selected_asset">


  <span align='center'><h4 style="color: #030a10;" class='mb-3 mt-3'>Asset Comprihensive Detail</h4></span>
  <br><br>
<div class"row">
<?php foreach($selected_assets as $asset) {?>

<table class="table table-borderless">
<thead>
<span align='center'><h5 style="color: #030a10; ">Asset Core Information</h5></span>
        <div class="row"> 
        <div class="col-md-6">
        </div>
        <div class="col-md-2">
        <span class="btn btn-success pull-right btn-xs btn-labeled " id="cancel_reason" name="asset_edit" onclick="ajax_html('<?php echo base_url().'inventory/asset_edit/'.$asset['id'];?>','edit_asset_contents');" data-toggle="modal" data-target="#assets-edit" style='margin-right:-260px;'> <i class="fa fa-edit"> </i> &nbsp; Edit</span>
        </div>             
        <div class="col-md-2">
                    <span class="btn btn-danger btn-xs  fas fa-trash-alt" style='margin-left:235px;' onclick="delete_confirm_tab('Really want to delete This','<?php echo base_url().'inventory/assets/delete/'.$asset['id'];?>')"> 
                    Delete</span>
                    </div> 
                    </div> 
                     
</thead>
<tbody>
    <tr>
    
<?php 
// echo "<pre>"; print_r($selected_assets); 

//echo "<pre>"; print_r($selected_asset_history);
?>
        
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Asset Name:</span></th>
      <?php $assetName = $this->db->get_where('items',array('id' => $asset['name']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-20px;"><?php echo $assetName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Asset Description:</span></th>
      <?php $assetName = $this->db->get_where('items',array('id' => $asset['name']))->result_array();?>
      <td style="width:45%"><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $assetName[0]['description'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Product Model No:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-15px ;"><?php echo $asset['product_model_no'];?></span></td>
      
      
    </tr> 
    <tr>
    <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:;">Idendtification Number:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $asset['identification_no'];?></span></td>
    <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Cost Price:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left: ;"><?php echo $asset['cost_price'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Supplier:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $supplierName[0]['name'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Manufecturer:</span></th>
      <?php $manufacturer = $this->db->get_where('manufacturers',array('id' => $asset['manufacturer']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left: ;"><?php echo $manufacturer[0]['name'];?></span></td>

      
    </tr> 
    <tr>
    <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Site:</span></th>
      <?php $site = $this->db->get_where('sites',array('id' => $asset['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $site[0]['name'];?></span></td>
    <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Purchased On:</span></th>
      <?php $site = $this->db->get_where('sites',array('id' => $asset['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo date("F j, Y",strtotime($asset['purchased_on']))?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Type:</span></th>&nbsp
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php  if($asset['warranty_type']==0) { echo " Have no Warranty."; } if($asset['warranty_type']==1) { echo " Replacement Warranty." ; } if($asset['warranty_type']==2) { echo " Repairing Warranty." ; } ?></span> </td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:;">Warranty Duration:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['warranty_duration'];?></span></td>
      
      
    </tr> 
    <tr>
    <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Added by User Type:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php  if($asset['user_type']==1) { echo "Admin"; } if($asset['user_type']==2) { echo "Supervisor" ; } if($asset['user_type']==3) { echo "Member" ; } ?></span> </td>
    <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Added by User Name:</span></th>
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
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php   echo $userName[0]['fname']." ".$userName[0]['lname'];  ?></span> </td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">This asset Added on:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo date('F j, Y, g:i a',$asset['add_date']);?></span></td>
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









    
<br>
<br>
<br>
<br>


<table class="table table-borderless">
<div class="row ">
                    <div class="col-md-9">
                    </div>
                  
                     <div class="col-md-3">
                     <?php foreach($selected_assets as $asset) {?>
                      <a href="#" onclick="show_history('<?php echo base_url().'inventory/asset_history/list/'.$asset['id'];?>','display_asset_history');" class="fa fa-angle-double-left pull-right">View full History</a>
                     <?PHP } ?>
                    </div>
                </div>
<thead>
<!-- <?php foreach($transactions as $transaction){
  echo "<pre>"; print_r($transactions[1]['transaction_type']);  
}  ?> -->
<tr>
    <span align='center'><h5 style="color: #030a10; ">Asset History</h5></span> 
      <!-- <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Type</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php  if($asset['warranty_type']==0) { echo "Have no Warranty."; } if($asset['warranty_type']==1) { echo "Replacement Warranty." ; } if($asset['warranty_type']==2) { echo "Repairing Warranty." ; } ?></span> </td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Duration</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['warranty_duration'];?></span></td> -->
    </tr>            
</thead>
<tbody>
<tr>
<?php 
              if($transactions){
        if($transactions[0]['transaction_type']==1)
        {?><tr><td align="center"><?php echo "It was Brand New Item."; exit; ?></td></tr>  <?php } ?>
     <?php           
         if($transactions[1]['transaction_type']==1){  
       ?>
       
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:;">Checked Out from Site:</span></th>
      <?php $fromSiteName = $this->db->get_where('sites',array('id'=>$transactions[1]['checkout_from_site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $fromSiteName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Checked Out for Site:</span></th>
      <?php $forSiteName = $this->db->get_where('sites',array('id'=>$transactions[1]['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $forSiteName[0]['name'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">In Custody Of:</span></th>
       <?php 
                if($transactions[1]['checkout_user_role']==1)
                {
                  $personName = $this->db->get_where('admin',array('id'=>$transactions[1]['person']))->result_array();
           ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
           <?php } ?>
           <?php 
                if($transactions[1]['checkout_user_role']==2)
                {
                  $personName = $this->db->get_where('member',array('id'=>$transactions[1]['person']))->result_array();
           ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
           <?php } ?>
           <?php 
                if($transactions[1]['checkout_user_role']==3)
                 {
                  $personName = $this->db->get_where('tpsupervisor',array('id'=>$transactions[1]['person']))->result_array();
           ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
           <?php } ?>           
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Person's Contact:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['person_contact'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Issued:</span></th>
      <?php if($transactions[1]['issuance_type']==1){ ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo 'Pemanent';?></span></td>
                <?php } ?>
      <?php if($transactions[1]['issuance_type']==2){ ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo 'Temporary';?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Asset will Return on:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo date("F j, Y",strtotime($transactions[1]['return_date']));?></span></td>
                <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Check Out By:</span></th>
      <?php
            if($transactions[1]['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Added on:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transactions[1]['action_date']));?> </span> </td>
      <!-- <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Duration</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['warranty_duration'];?></span></td> -->
            
    </tr>
            <?php } 
            if($transactions[1]['transaction_type']==3){
         ?>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:;">Installed at Site:</span></th>
      <?php $installSiteName = $this->db->get_where('sites',array('id'=>$transactions[1]['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $installSiteName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Insalled Location:</span></th>
      <?php $installLocationName = $this->db->get_where('locations',array('id'=>$transactions[1]['location']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $installLocationName[0]['location'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Installed by Person:</span></th>
      <?php 
                            if($transactions[1]['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transactions[1]['person']))->result_array();
                        ?>
                        <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php   
                            }
                            elseif($transactions[1]['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction[1]['person']))->result_array();
                            ?>
                              <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php 
                            }
                            elseif($transactions[0]['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transactions[1]['person']))->result_array();
                            ?>
                             <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                       <?php
                            }
                            else
                            {
                            ?>
                              <span class="btn-primary btn-xs"><?php echo $transactions[1]['person'] ?></span><br>
                      <?php } ?>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Person's Contact:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['person_contact'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Installing Company:</span></th>
                         <?php    if($transactions[1]['organisation_type']==1)
                               {
                                 $tspName = $this->db->get_where('tsp',array('id'=>$transactions[1]['organisation']))->result_array();?>
                                 <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $tspName[0]['name']?></span></td>
                         <?php } 
                               if($transactions[1]['organisation_type']==2)
                               {
                                 ?>
                                 <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $transactions[1]['organisation']?></span></td>
                         <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Company Address:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['organisation_address'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Added on:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transactions[1]['action_date']));?> </span> </td>           
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Add by:</span></th>
      <?php
            if($transactions[1]['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Installing Comments:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['action_comments'];?></span></td>

      <!-- <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Duration</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['warranty_duration'];?></span></td> -->
    </tr>
      <?php } 
            if($transactions[1]['transaction_type']==4){
         ?>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:;">Repairing from Site:</span></th>
      <?php $rprSiteName = $this->db->get_where('sites',array('id'=>$transactions[1]['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $rprSiteName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing From Location:</span></th>
      <?php $rprLocationName = $this->db->get_where('locations',array('id'=>$transactions[1]['location']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $rprLocationName[0]['location'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing by Person:</span></th>
      <?php 
                            if($transactions[1]['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transactions[1]['person']))->result_array();
                        ?>
                        <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php   
                            }
                            elseif($transactions[1]['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transactions[1]['person']))->result_array();
                            ?>
                              <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php 
                            }
                            elseif($transactions[1]['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transactions[1]['person']))->result_array();
                            ?>
                             <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                       <?php
                            }
                            else
                            {
                            ?>
                              <span class="btn-primary btn-xs"><?php echo $transactions[1]['person'] ?></span><br>
                      <?php } ?>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Person's Contact:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['person_contact'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Company:</span></th>
                         <?php    if($transactions[1]['organisation_type']==1)
                               {
                                 $tspName = $this->db->get_where('tsp',array('id'=>$transactions[1]['organisation']))->result_array();?>
                                 <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $tspName[0]['name']?></span></td>
                         <?php } 
                               if($transactions[1]['organisation_type']==2)
                               {
                                 ?>
                                 <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $transactions[1]['organisation']?></span></td>
                         <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Company Address:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['organisation_address'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Added on:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transactions[1]['action_date']));?> </span> </td>           
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Add by:</span></th>
      <?php
            if($transactions[1]['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['action_comments'];?></span></td>

      <!-- <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Duration</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['warranty_duration'];?></span></td> -->
    </tr>
      <?php } ?>
      <?php  
            if($transactions[1]['transaction_type']==9){
         ?>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:;">Re Install at Site:</span></th>
      <?php $rinstlSiteName = $this->db->get_where('sites',array('id'=>$transactions[1]['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $rinstlSiteName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Re Install at Location:</span></th>
      <?php $rinstlLocationName = $this->db->get_where('locations',array('id'=>$transactions[1]['location']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $rinstlLocationName[0]['location'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Reinstall by Person:</span></th>
      <?php 
                            if($transactions[1]['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transactions[1]['person']))->result_array();
                        ?>
                        <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php   
                            }
                            elseif($transactions[1]['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transactions[1]['person']))->result_array();
                            ?>
                              <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                      <?php 
                            }
                            elseif($transactions[1]['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transactions[1]['person']))->result_array();
                            ?>
                             <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $personName[0]['fname']." ".$personName[0]['lname'];?></span></td>
                       <?php
                            }
                            else
                            {
                            ?>
                            <td><span class="btn-primary btn-xs"><?php echo $transactions[1]['person'] ?></span></td>
                              <br>
                      <?php } ?>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Person's Contact:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['person_contact'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Reinstall Company:</span></th>
                         <?php if($transactions[1]['organisation_type']==1)
                               {
                                 $tspName = $this->db->get_where('tsp',array('id'=>$transactions[1]['organisation']))->result_array();?>
                                 <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $tspName[0]['name']?></span></td>
                         <?php } 
                               if($transactions[1]['organisation_type']==2)
                               {
                                 ?>
                                 <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $transactions[1]['organisation']?></span></td>
                         <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Company Address:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['organisation_address'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Complete Date:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo date("F j, Y",strtotime($transactions[1]['return_date']));?></span></td>
    </tr> 
    <tr>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Cost</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $transactions[1]['unit_repairing_cost'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Added on:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transactions[1]['action_date']));?> </span> </td>           
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Add by:</span></th>
      <?php
            if($transactions[1]['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['action_comments'];?></span></td>

      
    </tr>
      <?php } ?>


      <?php
              /** Transaction Type 10 START */
            if($transactions[1]['transaction_type']==10){
              echo "<pre>"; print_r($transaction); 
         ?>
  <tr>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-50px;">Faulty at Site:</span></th>
      <?php $rinstlSiteName = $this->db->get_where('sites',array('id'=>$transactions[1]['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $rinstlSiteName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Faulty at Location:</span></th>
      <?php $rinstlLocationName = $this->db->get_where('locations',array('id'=>$transactions[1]['location']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $rinstlLocationName[0]['location'];?></span></td>
     
                      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Faulty Time OMC:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['faulty_time_omc'];?></span></td>
    </tr> 
     
    <tr>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Estimated Cost</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $transactions[1]['estimated_cost'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Added on:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transactions[1]['action_date']));?> </span> </td>           
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Add by:</span></th>
      <?php
            if($transactions[1]['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Faulty Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['action_comments'];?></span></td>

      
    </tr>
      <?php 
      }
            /** Transaction Type 10 END */
       ?>




            <?php  
            if($transactions[1]['transaction_type']==2){
         ?>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:;">Checkin at Site:</span></th>
      <?php $checkinSiteName = $this->db->get_where('sites',array('id'=>$transactions[1]['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $checkinSiteName[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Checkout from:</span></th>
      <?php
            $fromSite = $this->db->select('*')->where('asset_id',$transactions[1]['asset_id'])->where('transaction_type',1)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
            $fromSiteName = $this->db->get_where('sites',array('id'=>$fromSite[0]['checkout_from_site']))->result_array(); 
           ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $fromSiteName[0]['name'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Checkin Performed by:</span></th>
      <?php 
                          $lastCheckoutAsset = $this->db->select('*')->where('asset_id',$transactions[1]['asset_id'])->where('transaction_type',1)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
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
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transactions[1]['action_date']));?> </span> </td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Checkin by:</span></th>
      <?php
            if($transactions[1]['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
            <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['action_comments'];?></span></td>
    </tr> 
    <tr>
      <!-- <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['action_comments'];?></span></td> -->
    </tr>
      <?php } ?>
      <?php  
            if($transactions[1]['transaction_type']==6){
         ?>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-50px;">Retire Type:</span></th>
      <?php 
            $retireType ;
            if($transactions[1]['retire_type']==1)
            {
              $retireType = "Damaged";
            }
            if($transactions[1]['retire_type']==2)
            {
              $retireType = "Lost";
            }
            if($transactions[1]['retire_type']==3)
            {
              $retireType = "Gifted";
            }
            if($transactions[1]['retire_type']==4)
            {
              $retireType = "Expired";
            }
            if($transactions[1]['retire_type']==5)
            {
              $retireType = "Consumed";
            }
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $retireType;?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Retire Site:</span></th>
      <!-- <?php
            $fromSite = $this->db->select('*')->where('asset_id',$transactions[1]['asset_id'])->where('transaction_type',1)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
            $fromSiteName = $this->db->get_where('sites',array('id'=>$fromSite[0]['checkout_from_site']))->result_array(); 
           ?> -->
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo "Not added yet! "?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Retire Date:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo date("F j, Y",strtotime($transactions[1]['retire_date'])) ?></span></td>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Action Date:</span></th>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php echo date("F j, Y",strtotime($transactions[1]['action_date']));?> </span> </td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Retire by:</span></th>
      <?php
            if($transactions[1]['user_type']==1){ 
            $added_by = $this->db->get_where('admin',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==2){ 
            $added_by = $this->db->get_where('tpsupervisor',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
      <?php
            if($transactions[1]['user_type']==3){ 
            $added_by = $this->db->get_where('member',array('id' => $transactions[1]['added_by']))->result_array();
          ?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $added_by[0]['fname']." ".$added_by[0]['lname'];?></span></td>
            <?php } ?>
            <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:;">Retire Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transactions[1]['action_comments'];?></span></td>
    </tr> 
    <tr>
      <!-- <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Repairing Reason:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $transaction['action_comments'];?></span></td> -->
    </tr>
      <?php } ?>
  <?php 
  }
  else
  {?><tr><td align="center"><?php echo "Have No History"; ?></td></tr>  <?php } ?>     

    
  </tbody>
</table>


             <script>
  function show_history(url,id)
{
	var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';	
	var list = $('#'+id);
	$.ajax({
		url: url,
		beforeSend: function() {
			list.html(loading_set);
		},
		success: function(data){
      $('.hide_div').hide();
      $('.hide_selected_asset').toggle();
			$('#display_asset_history').html(data).show('slow');
		},
		error: function(e) {		
			//notify('An error occurred. Please refresh page and try again.','danger','bottom','right');
		}
	});
}
  </script>




  
                   
         

         
        