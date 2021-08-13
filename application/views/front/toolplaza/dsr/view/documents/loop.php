<?php 
if(isset($dsr[0]['s_features'])){
	$d_number = 0; 
	foreach($dsr[0]['s_features'] as $feat){
		include('supportrequest/loop.php');
		include('generatorlog/loop.php');
		$d_number++; 
	}
}
?>