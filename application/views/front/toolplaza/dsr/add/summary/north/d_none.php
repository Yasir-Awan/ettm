<?php include('d_none/main.php'); ?>
<div id='expand-div-<?php echo $n['abr'];?>' class="<?php if(empty($dsr['dsr'][0]['bound'][0]['lane'][$counter]['closed_by'])){ echo 'd-none'; } ?> ">
	<?php include('d_none/expand.php'); ?>
</div>