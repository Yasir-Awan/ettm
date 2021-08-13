<?php $i = 0; foreach($staff as $s){ $j = $i+1;  ?>
	$('#<?php echo $s['abr']; ?>-attendance').change(function(){
		if($('#<?php echo $s['abr']; ?>-attendance').val() == 1){
			<?php include('leave.php'); ?>
		}
		else{
			<?php include('no_leave.php'); ?>
		}
	});
<?php $i++; } ?>