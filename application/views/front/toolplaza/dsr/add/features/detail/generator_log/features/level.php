<?php $i = 0; foreach($glogr_feature as $feat){ if(isset($feat['option'])){ ?>
<div class="col-md-4">
	<input type="hidden" name="id_<?php echo $feat['abr']; ?>" value="<?php echo $feat['id'] ?>">
	<label for="<?php echo $feat['abr']; ?>-level"><?php echo $feat['name']; ?></label>
	<select class="form-control" name="level_<?php echo $feat['abr']; ?>" id="<?php echo $feat['abr']; ?>-level">
		<option value="">Select Level</option>
		<?php $n = 0; foreach($feat['option'] as $options){ ?>
		<option <?php if(isset($dsr['generator_log'][0]['glogr'][$i]['level'])){ if($dsr['generator_log'][0]['glogr'][$i]['level'] == $options['value']){ echo 'selected'; } }  ?> value="<?php echo $options['value']; ?>"><?php echo $options['name'] ?></option>
		<?php $n++; } ?>
	</select>
</div><br>
<?php } $i++; } ?>