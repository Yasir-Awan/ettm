
	<div class="row gutter-xs">
		<?php include('dtrpanel/dtr_upperpanel.php'); ?>
	</div>
	<div class="row gutter-xs">
		<?php include('dtrpanel/dtr_chartpanel.php'); ?>
	</div>
	<div class="row gutter-xs">
		<?php if($id == 'today' || $id == 'today-dtr'){include('dtrpanel/dtr_today_lower_panel.php');} 
		else{ include('dtrpanel/dtr_not_today_lower_panel.php');} ?>
	</div>
	<!--<div class="row gutter-xs">
		<?php //include('dtrpanel/dtr_comprehensive.php'); ?>
	</div>-->
