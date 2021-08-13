
	<div class="row gutter-xs">
		<?php include('dsrpanel/dsr_upperpanel.php'); ?>
	</div>
	<div class="row gutter-xs" id="chartpanel">
		<?php include('dsrpanel/dsr_chartpanel.php'); ?>
	</div>
	<div class="row gutter-xs">
		<?php if(isset($id)){ if($id == 'today' || $id == 'yesterday'){ include('dsrpanel/dsr_today_lower_panel.php'); } else{ include('dsrpanel/dsr_not_today_lower_panel.php'); } } ?>
	</div>
	<div class="row gutter-xs d-none" id="extended">
		<?php if(isset($id)){  include('dsrpanel/dsr_extended.php');  } ?>
	</div>
	<div class="row gutter-xs">
		<?php if(isset($id)){ if($id == 'today'){ include('dsrpanel/dsr_comprehensive.php'); } } ?>
	</div>
	