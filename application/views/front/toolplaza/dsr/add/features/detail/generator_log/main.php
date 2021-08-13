<div class="col-md-4">
	<label for="time-from">From</label>
	<input type="time" id="time-from" class="form-control" <?php if(isset($dsr['generator_log'])){ if(isset($dsr['generator_log'][0]['time_from'])){ echo 'value='.$dsr['generator_log'][0]['time_from'];} }?> name="time_from_<?php echo $feat['abr']; ?>">
</div>
<div class="col-md-4">
	<label for="time-from">To</label>
	<input type="time" id="time-to" class="form-control" <?php if(isset($dsr['generator_log'])){ if(isset($dsr['generator_log'][0]['time_to'])){ echo 'value='.$dsr['generator_log'][0]['time_to'];} }?> name="time_to_<?php echo $feat['abr']; ?>">
</div>
<div class="col-md-4">
	<label for="total-time">Total Time</label>
	<input type="text" id="total-time" class="form-control" <?php if(isset($dsr['generator_log'])){ if(isset($dsr['generator_log'][0]['total_time'])){ echo 'value='.$dsr['generator_log'][0]['total_time'];} }?>  name="total_time_<?php echo $feat['abr']; ?>">
</div>