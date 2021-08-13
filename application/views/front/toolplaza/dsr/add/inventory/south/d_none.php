<div class='container row'>
	<?php echo 'Reason :';?>
	<textarea name= 'description_<?php echo $inv['abr'] ?>' id= 'description-<?php echo $inv['abr'] ?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'><?php if(isset($dsr['dsr'][0]['lane_inventory_south'][$counter][$i]['description'])){ echo $dsr['dsr'][0]['lane_inventory_south'][$counter][$i]['description'];} ?></textarea><br/>
</div><br/>