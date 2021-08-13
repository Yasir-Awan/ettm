<div class="container row">
	<div class="col-md-6 pr-1">
		<label><?php echo 'From :';?></label> 
		<input name	='from_<?php echo $s['abr'] ?>' type='time' id= 'from-<?php echo $s['abr'] ?>' <?php if(isset($dsr['dsr'][0]['bound'][1]['lane'][$counter]['closed_from'])){ echo 'value ='.$dsr['dsr'][0]['bound'][1]['lane'][$counter]['closed_from'];} ?>  class='form-control'>
	</div>
	<div class='col-md-6 pr-1'>
		<label><?php echo 'To :';?></label>
		<input name	='to_<?php echo $s['abr'] ?>' type='time', id= 'to-<?php echo $s['abr'] ?>' <?php if(isset($dsr['dsr'][0]['bound'][1]['lane'][$counter]['closed_to'])){ echo 'value ='.$dsr['dsr'][0]['bound'][1]['lane'][$counter]['closed_to'];} ?> class='form-control'>
	</div>
</div>
<div class='container row'>
	<?php echo 'Reason :';?>
	<textarea name= 'description_<?php echo $s['abr'] ?>' id= 'description-<?php echo $s['abr'] ?>' class= 'form-control' style='border:1px solid #E3E3E3' width="100%"><?php if(isset($dsr['dsr'][0]['bound'][1]['lane'][$counter]['description'])){ echo $dsr['dsr'][0]['bound'][1]['lane'][$counter]['description'];} ?> </textarea><br/>
</div><br/>