<div class="table-responsive">


  <span align='center'><h4 style="color: #030a10;" class='mb-3 mt-3'>Asset Comprihensive Detail</h4></span>
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
echo "<pre>"; print_r($selected_assets); 

//echo "<pre>"; print_r($selected_asset_history);
?>
        
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Asset Name:</span></th>
      <?php $assetName = $this->db->get_where('items',array('id' => $asset['name']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-60px;"><?php echo $assetName[0]['name'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-80px ;">Product Model No:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-15px ;"><?php echo $asset['product_model_no'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:10px;">Idendtification Number:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-20px;"><?php echo $asset['identification_no'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Cost Price:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-15px ;"><?php echo $asset['cost_price'];?></span></td>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Supplier:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-60px;"><?php echo $supplierName[0]['name'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-80px ;">Manufecturer:</span></th>
      <?php $manufacturer = $this->db->get_where('manufacturers',array('id' => $asset['manufacturer']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-35px ;"><?php echo $manufacturer[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:10px ;">Site:</span></th>
      <?php $site = $this->db->get_where('sites',array('id' => $asset['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-125px;"><?php echo $site[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Purchased On:</span></th>
      <?php $site = $this->db->get_where('sites',array('id' => $asset['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-15px;"><?php echo date("F j, Y",strtotime($asset['purchased_on']))?></span></td>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Type:</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:-70px;"> <?php  if($asset['warranty_type']==0) { echo "Have no Warranty."; } if($asset['warranty_type']==1) { echo "Replacement Warranty." ; } if($asset['warranty_type']==2) { echo "Repairing Warranty." ; } ?></span> </td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-80px;">Warranty Duration:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['warranty_duration'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:10px; ;">Added by User Type:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-55px;"> <?php  if($asset['user_type']==1) { echo "Admin"; } if($asset['user_type']==2) { echo "Supervisor" ; } if($asset['user_type']==3) { echo "Member" ; } ?></span> </td>
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
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-15px;"> <?php   echo $userName[0]['fname']." ".$userName[0]['lname'];  ?></span> </td>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">This asset Added on:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:-20px;"><?php echo date('F j, Y, g:i a',$asset['add_date']);?></span></td>
    </tr> 
  </tbody>
</table>
<?php } ?>        
 </row>
</div>
    
<table class="table table-borderless">
<thead>
<tr>
    <span align='center'><h5 style="color: #030a10; ">Asset Current Status</h5></span>  
</tr>             
</thead>
<tbody>
    <tr>
    <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Current Status</span></th>
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
      ?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php   echo $actionStatus;  ?></span> </td>
        <?php if($selected_assets[0]['action_status']==0){?>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;"><?php   echo "No action performed on this Asset.";  ?></span></th>
        <?php } ?>
        <?php echo "<pre>"; print_r($selected_asset_transaction); ?>
        <?php foreach($selected_asset_transaction as $transaction){ ?>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left:-50px;">Checked Out for Site:</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['product_model_no'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Idendtification Number</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $asset['identification_no'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Cost Price</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['cost_price'];?></span></td>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Supplier</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $supplierName[0]['name'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Manufecturer</span></th>
      <?php $manufacturer = $this->db->get_where('manufacturers',array('id' => $asset['manufacturer']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $manufacturer[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Site</span></th>
      <?php $site = $this->db->get_where('sites',array('id' => $asset['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $site[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Purchased On</span></th>
      <?php $site = $this->db->get_where('sites',array('id' => $asset['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo date("F j, Y",strtotime($asset['purchased_on']))?></span></td>
      
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Type</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php  if($asset['warranty_type']==0) { echo "Have no Warranty."; } if($asset['warranty_type']==1) { echo "Replacement Warranty." ; } if($asset['warranty_type']==2) { echo "Repairing Warranty." ; } ?></span> </td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Duration</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['warranty_duration'];?></span></td>
    </tr>
        <?php }?> 

    
  </tbody>
</table>


<table class="table table-borderless">
<thead>
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
        
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Asset Name</span></th>
      <?php $assetName = $this->db->get_where('items',array('id' => $asset['name']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $assetName[0]['name'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Product Model No</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['product_model_no'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Idendtification Number</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $asset['identification_no'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Cost Price</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['cost_price'];?></span></td>
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Supplier</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $supplierName[0]['name'];?></span></td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Manufecturer</span></th>
      <?php $manufacturer = $this->db->get_where('manufacturers',array('id' => $asset['manufacturer']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $manufacturer[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Site</span></th>
      <?php $site = $this->db->get_where('sites',array('id' => $asset['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo $site[0]['name'];?></span></td>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Purchased On</span></th>
      <?php $site = $this->db->get_where('sites',array('id' => $asset['site']))->result_array();?>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-left:;"><?php echo date("F j, Y",strtotime($asset['purchased_on']))?></span></td>
      
    </tr> 
    <tr>
      <th scope="row"><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Type</span></th>
      <?php $supplierName = $this->db->get_where('suppliers',array('id' => $asset['supplier']))->result_array();?>
      <td> <span style="font-size: 0.80rem;color: #030a10;margin-left:;"> <?php  if($asset['warranty_type']==0) { echo "Have no Warranty."; } if($asset['warranty_type']==1) { echo "Replacement Warranty." ; } if($asset['warranty_type']==2) { echo "Repairing Warranty." ; } ?></span> </td>
      <th><span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: ;">Warranty Duration</span></th>
      <td><span style="font-size: 0.80rem;color: #030a10;margin-right: ;"><?php echo $asset['warranty_duration'];?></span></td>
    </tr> 

    
  </tbody>
</table>







  
                   
         

         
        