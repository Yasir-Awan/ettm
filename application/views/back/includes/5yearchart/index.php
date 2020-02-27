<div  id="5yearchart">
	
	

	<?php if(empty(isset($message))){ ?>
	<div class="row gutter-xs">
		<?php include('upper_panel.php'); ?>
	</div>
	<div class="row gutter-xs">
		<?php include('summary_panel.php'); ?>
	</div>
	<div class="row gutter-xs">
		<?php include('chart_panel.php'); ?>
	</div>
	<div class="row gutter-xs">
		<?php include('class_chart_panel.php'); ?>
	</div>
	<?php }else{ ?>
	<div class="row gutter-xs">
		<?php include('not_uploaded.php'); ?>
	</div>
	<?php } ?>
</div>
	