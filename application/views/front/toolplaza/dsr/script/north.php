<?php 
$counter = 0; 
foreach($north as $n){
	include('north/main.php');
	if(isset($inventory_south[$counter])){
		$i=0; 
		foreach($inventory_north[$counter] as $inv){
			include('north/inventory.php'); 
			$i++;
		}
	}
	$counter++;
} 
?>