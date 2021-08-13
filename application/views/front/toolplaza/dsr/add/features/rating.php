<?php $i = 0; foreach($r_feature as $feat){ if(isset($feat['option'])){   ?>
<div class='col-md-4 pr-1'>
	<div class="form-group">
		<?php include('rating/main.php'); ?>
	</div>
</div>
<?php } $i++;} ?>