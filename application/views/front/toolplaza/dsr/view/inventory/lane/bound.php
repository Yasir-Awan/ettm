<?php 
	if(isset($dsr[0]['name_inventory']['lane'])){
		$lane_inventory_number = 0;
		foreach($dsr[0]['name_inventory']['lane'] as $inv){
			?> <tr> <?php 
			include('lane.php');
			if(isset($inv['bound'])){
				$bound_number = 0;  
				foreach($inv['bound'] as $bound){
					if(isset($bound['lane'])){
						$lane_number = 0;
						foreach($bound['lane'] as $lane){
							include('inventory.php');
							$lane_number++;
						}
					}
					
					$bound_number++;   
				} 
			}
			else{
				if(isset($dsr[0]['bound'][0]['lane']) && isset($dsr[0]['bound'][1]['lane'])){ 
					$count = count($dsr[0]['bound'][0]['lane']) + count($dsr[0]['bound'][1]['lane']);
				}elseif(empty($dsr[0]['bound'][0]['lane']) && isset($dsr[0]['bound'][1]['lane'])){ 
					$count = count($dsr[0]['bound'][1]['lane']); 
				}elseif(empty($dsr[0]['bound'][1]['lane']) && isset($dsr[0]['bound'][0]['lane'])){ 
					$count = count($dsr[0]['bound'][0]['lane']); 
				} ?>
					<td colspan = "<?php if(isset($count)){echo $count; } ?>" class="text-center text-danger"><strong>Data for this Inventory is not Present</strong></td> <?php
			}
			?> </tr> <?php 
			$lane_inventory_number++;
		}
	}
	
	else{
		echo '<div class="text-danger">No Bound is found in record</div>';
	}
?> 