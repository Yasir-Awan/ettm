<?php if(isset($staff)){ ?>
<h6>Attendance of Staff:</h6>
<div class="container">
	<div class='row'>
		<?php $i = 0; foreach($staff as $s){  	?>
			<?php include('attendance/main.php'); ?>
		<?php $i++ ;} ?>
	</div>
</div>
<?php } ?> 