<?php 
	if(isset($dsr[0]['name_inventory']['bound_inventory'])){
		$bound_number = 0;  
		foreach($dsr[0]['name_inventory']['bound_inventory'] as $bound){
			echo '<tr>';
			include('b_name.php');
			if(isset($bound['bound'])){
				$bound_inventory_number = 0;
				foreach($bound['bound'] as $inv){
					include('inventory.php');
					$bound_inventory_number++;
				}
			}
			else{
				if(isset($dsr[0]['bound'])){ 
					$count = count($dsr[0]['bound']);
				}
				?><td  colspan = "<?php echo $count;?>" class = "text-center text-danger"><strong>Data for this Inventory is not Present</strong></td> <?php
			}
			echo '</tr>';	
			
			$bound_number++;   
		} 
	}
	else{
		echo '<div class="text-danger">No Bound is found in record</div>';
	}
?> 