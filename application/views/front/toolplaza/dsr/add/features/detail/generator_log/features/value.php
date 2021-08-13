<?php $i = 0; foreach($glogv_feature as $feat){ ?> 
<div class="col-md-4">
	<input type="hidden" name="id_<?php echo $feat['abr']; ?>" value="<?php echo $feat['id'] ?>">
	<label for="<?php echo $feat['abr'] ?>-value"><?php echo $feat['name'] ?></label>
	<input name="value_<?php echo $feat['abr']; ?>" class="form-control" id="<?php echo $feat['abr'] ?>-value" type="number" <?php if(isset($dsr['generator_log'][0]['glogv'][$i]['value'])){ echo 'value='.$dsr['generator_log'][0]['glogv'][$i]['value'];} ?> min="0">
</div><br>
<?php $i++; } ?>
