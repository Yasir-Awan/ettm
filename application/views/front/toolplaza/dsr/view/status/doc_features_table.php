<?php 
$d_number = 0; 
foreach($dsr[0]['s_features'] as $feat){
	if($feat['detail'] == 3){
		echo '<tr>';
		include('name.php');
		include('s_value.php');
		echo '</tr>';
	}
	if($feat['detail'] == 4){
		echo '<tr>';
		include('name.php');
		include('s_value.php');
		echo '</tr>';
	}
	$d_number++; 
} 
?>