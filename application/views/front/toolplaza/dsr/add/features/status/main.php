<div class="col-md">
	<label><?php echo $feat['name'].': ';?></label>
</div>
<div class="col-md-12">
	<input type="hidden" name="id_<?php echo $feat['abr'] ?>" value="<?php echo $feat['id']; ?>">
	<?php $n = 0; foreach($feat['option'] as $options){ ?>
	<input type="radio" id="toggle-<?php echo $feat['abr'].'-'.$options['abr']; ?>" name="status_<?php echo $feat['abr']; ?>"  value="<?php echo $options['value']; ?>" <?php if(isset($st[$s_feature_no]['v'])){ if($st[$s_feature_no]['v'] == 1) { echo 'checked'; }} if($options['value'] == 0){ echo 'checked'; }  ?> >
	<label for="toggle-<?php echo $feat['abr'].'-'.$options['abr']; ; ?>" class="radio"><?php echo $options['name']; ?></label>
	<?php $n++; }  ?>
</div>