<div class="col-md-12 form-group">
	<label for="<?php echo $feat['abr'] ?>-time_from">From:</label>
	<input type="time" name="time_from_<?php echo $feat['abr'] ?>" id="<?php echo $feat['abr'] ?>-time_from" class="form-control" <?php if(isset($dsr['dsr'][0]['s_features'][$s_feature_no]['time_from'])){ echo 'value='.$dsr['dsr'][0]['s_features'][$s_feature_no]['time_from']; } ?> style="border:1px solid #E3E3E3" width="100%">
	<label for="<?php echo $feat['abr'] ?>-time_from">To:</label>
	<input type="time" name="time_to_<?php echo $feat['abr'] ?>" id="<?php echo $feat['abr'] ?>-time_to" class="form-control" <?php if(isset($dsr['dsr'][0]['s_features'][$s_feature_no]['time_to'])){ echo 'value='.$dsr['dsr'][0]['s_features'][$s_feature_no]['time_to']; } ?>  style="border:1px solid #E3E3E3" width="100%">
</div>