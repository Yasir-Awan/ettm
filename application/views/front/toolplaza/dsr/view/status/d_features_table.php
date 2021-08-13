<?php 
$d_number = 0; 
foreach($dsr[0]['d_features'] as $feat){ 
	echo '<tr>';
	include('name.php');
	include('d_value.php');
	echo '</tr>';
	$d_number++; 
} 
?>