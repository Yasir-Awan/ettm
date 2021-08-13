<?php 
if(isset($inventory_south)){
	$counter = 0; 
	foreach($south as $s){
		$i = 0;
		foreach($inventory_south[$counter] as $inv){
			include('south/main.php');
			$i++;
		}
		$counter++;
	}
}
?> 