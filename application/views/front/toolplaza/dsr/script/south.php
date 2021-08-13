<?php 
$counter = 0; 
foreach($south as $s){
	include('south/main.php');
	if(isset($inventory_south[$counter])){
		$i=0; 
		foreach($inventory_south[$counter] as $inv){ 
			include('south/inventory.php');
			$i++; 
		}	
	} 
	$counter++;
} 
?>