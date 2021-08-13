<?php include('d_none/main.php'); ?>
<div id='expand-div-<?php echo $s['abr'];?>' class=" <?php if(empty($dsr['dsr'][0]['bound'][1]['lane'][$counter]['closed_by'])){ echo 'd-none'; } ?> ">
	<?php include('d_none/expand.php'); ?>
</div>