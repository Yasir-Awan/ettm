<div class="container row">
	<div class="col-md-6 pr-1">
		<label><?php echo 'From :';?></label> 
		<input name	='from_<?php echo $n['abr'] ?>' type='time' id= 'from-<?php echo $n['abr'] ?>' <?php if(isset($dsr['dsr'][0]['bound'][0]['lane'][$counter]['closed_from'])){ echo 'value='.$dsr['dsr'][0]['bound'][0]['lane'][$counter]['closed_from'];} ?> class='form-control'>
	</div>
	<div class='col-md-6 pr-1'>
		<label><?php echo 'To :';?></label>
		<input name	='to_<?php echo $n['abr'] ?>' type='time', id= 'to-<?php echo $n['abr'] ?>' <?php if(isset($dsr['dsr'][0]['bound'][0]['lane'][$counter]['closed_to'])){ echo 'value='.$dsr['dsr'][0]['bound'][0]['lane'][$counter]['closed_to'];} ?> class='form-control'>
	</div>
</div>
<div class='container row'>
	<?php echo 'Reason :';?>
	<textarea name= 'description_<?php echo $n['abr'] ?>' id= 'description-<?php echo $n['abr'] ?>' value='<?php set_value('description-'.$n['abr'].'');?>' class= 'form-control' style='border:1px solid #E3E3E3' width="100%"><?php if(isset($dsr['dsr'][0]['bound'][0]['lane'][$counter]['description'])){ echo $dsr['dsr'][0]['bound'][0]['lane'][$counter]['description'];} ?></textarea><br/>
</div><br/>