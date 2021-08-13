<?php 
$d_number = 0; 
foreach($dsr[0]['r_features'] as $feat){ 
	echo '<tr>';
	include('name.php');
	include('r_value.php');
	echo '</tr>';
	$d_number++; 
} 
?>