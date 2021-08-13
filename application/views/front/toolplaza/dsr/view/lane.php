<?php 
	if(isset($dsr[0]['bound'])){
		$bound_number = 0;  
		foreach($dsr[0]['bound'] as $bound){
			include('lane/bound.php');
			$bound_number++;   
		} 
	}
	else{
		echo '<div class="text-danger">No Bound is found in record</div>';
	}
?> 