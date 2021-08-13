<div class="card">
	<h4 class="m-b-10 text-center"><strong>Status Report</strong></h4>
	<div class="card-body">
		<div class="row">
			<?php if(empty($dsr[0]['d_features'])){}else{ include('status/d_features.php'); } ?>
			<?php if(empty($dsr[0]['r_features'])){}else{ include('status/r_features.php'); }?>
			<?php if(empty($dsr[0]['s_features'])){}else{ include('status/s_features.php'); }?>
			<?php if(empty($dsr[0]['s_features'])){}else{ include('status/st_features.php'); }?>
			<?php if(empty($dsr[0]['staff'])){}else{include('attendance/attendance.php'); }?>
			<?php if(empty($dsr[0]['s_features'])){}else{ include('status/doc_feature.php'); }?>
		</div>
	</div>
</div>