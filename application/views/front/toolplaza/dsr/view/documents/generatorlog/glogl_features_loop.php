<?php 
$s_feature_number = 0; foreach($dsr[0]['s_features'] as $feat){
	if($feat['detail'] == 4){
		if($feat['val'] == 1){
			if(isset($feat['generator_log'][0]['features'])){
				$glog_feature_number = 0;
				foreach($feat['generator_log'][0]['features'] as $feature){
					if($feature['type'] == 2){
						echo '<tr>';
						include('glog_features_name.php');
						include('glogl_features_level.php');
						echo '</tr>';
					}
					$glog_feature_number++;
				}
			}
		}
	}
	$s_feature_number++;
} 
?>