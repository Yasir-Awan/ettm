<div class="col-md-6 form-group">
	<label for="<?php echo $s['abr']; ?>-leave-from">From:</label>
	<input name= "leave_from_<?php echo $s['abr'] ?>" id="<?php echo $s['abr']; ?>leave-from" <?php if(isset($dsr['dsr'][0]['staff'][$i]['leave_from'])) echo 'value="'.$dsr['dsr'][0]['staff'][$i]['leave_from'].'"';   ?> type= "date" class= "form-control">
</div>
<div class="col-md-6 form-group">
	<label for="<?php echo $s['abr']; ?>-leave-to">To:</label>
	<input name= "leave_to_<?php echo $s['abr'] ?>"  id="<?php echo $s['abr']; ?>leave-to"  <?php if(isset($dsr['dsr'][0]['staff'][$i]['leave_to'])) echo 'value="'.$dsr['dsr'][0]['staff'][$i]['leave_to'].'"';   ?> type= "date" class= "form-control">
</div>