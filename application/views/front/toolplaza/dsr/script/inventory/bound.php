<?php 
$i = 0; 
foreach($dsr_bound as $b){
	if(isset($b_inventory[$i])){
		$j = 0; 
		foreach($b_inventory[$i] as $inv){
			include('bound/main.php');
			$j++;
		}
	}
	$i++;
}
?>