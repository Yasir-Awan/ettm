<?php 
	if(isset($dsr[0]['bound'])){
		$bound_number = 0;
		foreach($dsr[0]['bound'] as $bound){
			if(isset($bound['lane'])){
				$lane_number = 0;
				foreach($bound['lane'] as $lane){
					include('heading.php');
					$lane_number++;
				}
			}
			$bound_number++;
		}
	}
?>
