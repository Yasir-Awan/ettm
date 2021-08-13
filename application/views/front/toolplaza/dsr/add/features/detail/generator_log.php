<div id="generator-log" class="container">
	<p><strong>Generator Log</strong></p>
	<div class="row container">
		<?php include('generator_log/main.php'); ?>
	</div>
	<?php if(isset($glogv_feature)){ ?>
	<div class="row container">
		<?php include('generator_log/features/value.php'); ?>
	</div>
	<?php } ?>
	<?php if(isset($glogr_feature)){ ?>
	<div class="row container">
		<?php include('generator_log/features/level.php'); ?>
	</div>
	<?php } ?>
</div>