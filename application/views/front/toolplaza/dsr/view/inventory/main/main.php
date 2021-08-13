<?php 
	if(isset($dsr[0]['name_inventory']['tollplaza'])){
		$bound_inventory_number = 0;
		foreach($dsr[0]['name_inventory']['tollplaza'] as $inv){
			echo '<tr>';
			include('name.php');
			if(isset($inv['status'])){
				include('inventory.php');
			}
			else{
				?><td class="text-center text-danger"><strong>Data for this Inventory is not Present</strong></td> <?php
			}
			echo '</tr>';
			$bound_inventory_number++;
		}
	}
	
?>