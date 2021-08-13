<div class="col-md-7 pr-1">
	<?php echo $inv['name'].' : ';?>
</div>
<div class="col-md-5">
	<?php include('status.php'); ?>
</div>
<div id='div-<?php echo $inv['abr']; ?>' class="col-md-12 <?php if(isset($dsr['dsr'][0]['bound'][$i]['inventory'][$j]['status'])){ if($dsr['dsr'][0]['bound'][$i]['inventory'][$j]['status'] == 1){ echo 'd-none'; }  }else{ echo 'd-none';} ?>">
	<?php include('d_none.php'); ?>
</div>