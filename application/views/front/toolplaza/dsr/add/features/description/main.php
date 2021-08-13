<div class="col-md">
	<label><?php echo $feat['name'].': ';?></label>
</div>
<div class="col-md-12 form-group">
	<input type="hidden" name="id_<?php echo $feat['abr'] ?>" value="<?php echo $feat['id']; ?>">
	<input name="value_<?php echo $feat['abr'] ?>" <?php if($feat['name'] == 'Traffic' || $feat['name'] == 'Revenue'){ echo 'type="number" min="0"'; }elseif($feat['name'] == 'Pending MTR'){ echo 'type="text"';}else{ echo 'type="month"';} ?> id="<?php echo $feat['abr'] ?>-value" <?php if(isset($dsr['dsr'][0]['d_features'][$i]['value'])){ echo 'value='.$dsr['dsr'][0]['d_features'][$i]['value']; } ?> class="form-control required">
</div>