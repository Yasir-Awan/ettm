<?php if(isset($s_feature)){ ?>
<h6>Status Check:</h6>
<div class='row'>
	<?php  include('features/status.php'); ?>
</div>
<?php } if(isset($d_feature)){ ?>
<h6>MTR Status:</h6>
<div class="row">
	<?php  include('features/description.php'); ?>
</div>
<?php } if(isset($ds_feature)){ ?>
<div class="row">
	<?php  include('features/descriptions.php');  ?>
</div>
<?php } if(isset($r_feature)){ ?>
<h6>Plaza Condition:</h6>
<div class="row">
	<?php include('features/rating.php'); ?>
</div>
<?php } ?>