<div class="col-md-6 pr-1">
	<?php echo $s['name'].' : ';?>
</div>
<div class="col-md-6">
	<?php include('status.php'); ?>
</div>
<div id='div-<?php echo $s['abr'] ?>' class="col-md-12 <?php if(isset($dsr['dsr'][0]['bound'][1]['lane'][$counter]['status'])){ if($dsr['dsr'][0]['bound'][1]['lane'][$counter]['status'] == 0){ echo 'd-none'; } ;}else{ echo 'd-none';} ?>">
	<?php include('d_none.php'); ?>
</div>