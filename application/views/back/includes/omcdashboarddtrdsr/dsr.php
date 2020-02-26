
	<div class="row gutter-xs">
		<?php include('dsrpanel/dsr_upperpanel.php'); ?>
	</div>
	<div class="row gutter-xs">
		<?php include('dsrpanel/dsr_chartpanel.php'); ?>
	</div>
	<div class="row gutter-xs">
		<?php if(isset($id)){ if($id == 'today'){ include('dsrpanel/dsr_today_lower_panel.php'); } else{ include('dsrpanel/dsr_not_today_lower_panel.php'); } } ?>
	</div>
	<div class="row gutter-xs">
		<?php if(isset($id)){ if($id == 'today'){ include('dsrpanel/dsr_comprehensive.php'); } } ?>
	</div>