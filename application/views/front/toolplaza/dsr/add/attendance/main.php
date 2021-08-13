<div id="<?php echo $s['abr']; ?>-div" class="col-md-6 pr-1 form-group">
	<?php include('main_div.php'); ?>
</div>
<div id="<?php echo $s['abr'] ?>-display" class=" <?php if(isset($dsr['dsr'][0]['staff'][$i]['attendance_status'])){if($dsr['dsr'][0]['staff'][$i]['attendance_status'] == 1){ }else{ echo 'd-none';}}else{ echo 'd-none';} ?> col-md-6 row pr-1">
	<?php include('d_none.php'); ?>
</div>