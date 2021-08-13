<?php 
$d_number = 0; 
foreach($dsr[0]['s_features'] as $feat){
	if($feat['detail'] == 2){
		echo '<tr>';
		include('name.php');
		include('s_value.php');
		if(isset($feat['val'])){
			if($feat['val'] == 1){
				if(isset($feat['time_from']) && isset($feat['time_to'])){
					include('time_from.php');
					include('time_to.php');
				}
				
			}
			if($feat['val'] == 0){
				?><td colspan="2" class="text-center text-success">Status is Good</td> <?php 
			}
		}
		echo '</tr>';
	}
	$d_number++; 
} 
?>