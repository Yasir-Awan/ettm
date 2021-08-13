<div class="col-md-12 form-group">
	<label for="<?php echo $feat['abr'] ?>-description">Description:</label>
	<textarea name="description_<?php echo $feat['abr'] ?>" type="text" id="<?php echo $feat['abr'] ?>-description" class="form-control" style="border:1px solid #E3E3E3" width="100%"><?php if(isset($dsr['dsr'][0]['s_features'][$s_feature_no]['description'])){ echo $dsr['dsr'][0]['s_features'][$s_feature_no]['description']; } ?></textarea>
</div>