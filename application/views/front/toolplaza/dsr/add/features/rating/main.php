<div class="col-md">
	<label><?php echo $feat['name'].': ';?></label>
</div>
<div class="col-md-12 form-group">
	<input type="hidden" name="id_<?php echo $feat['abr'] ?>" value="<?php echo $feat['id']; ?>">
	<select name="rating_<?php echo $feat['abr'] ?>" type="int" id="<?php echo $feat['abr'] ?>-rating" class="form-control required">
		<option value="">--Current Status--</option>
		<?php $n = 0; foreach($feat['option'] as $options){ ?>
		<option <?php if(isset($dsr['dsr'][0]['r_features'][$i]['val'])){ if($dsr['dsr'][0]['r_features'][$i]['val'] == $options['value']){ echo 'selected'; } }else{} ?> value="<?php echo $options['value'];  ?>"><?php echo $options['name'] ?></option>
		<?php $n++; } ?>
	</select>
</div>