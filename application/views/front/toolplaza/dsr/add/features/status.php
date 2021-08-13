<?php $s_feature_no = 0; foreach($s_feature as $feat){  if(isset($feat['option'])){  ?>
<div class='col-md-4 pr-1'>
	<div class="form-group">
		<?php include('status/main.php'); ?>
		<div id="<?php echo $feat['abr'];?>-display" class="<?php if(isset($st[$s_feature_no]['v'])){ if($st[$s_feature_no]['v'] == 0){ echo 'd-none';} } else{ echo 'd-none'; } ?> ">
			<?php include('d_none.php'); ?>
		</div>
	</div>
</div>
<div id="<?php echo $feat['abr'];?>-doc-display" class="<?php if(isset($doc[$s_feature_no]['v'])){ }else{ echo 'd-none';} ?> form-group">
	<div class="row container">
		<?php include('d_none_doc.php'); ?>
	</div>
</div>
<?php } $s_feature_no++;} ?>