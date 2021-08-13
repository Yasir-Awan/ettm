<?php 
if(isset($inventory_north)){
	$counter = 0; 
	foreach($north as $n){
		$i=0; 
		foreach($inventory_north[$counter] as $inv){ 
			include('north/main.php');
			$i++; 
		} 
		$counter++;
	} 
}
?> 