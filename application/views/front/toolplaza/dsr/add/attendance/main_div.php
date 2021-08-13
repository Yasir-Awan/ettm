<label><?php echo $s['list_name']; ?></label>
<input type="hidden" name= "id_<?php echo $s['abr']; ?>" value="<?php echo $s['id'];?>" class="form-control">
<select id ="<?php echo $s['abr'] ?>-attendance" name= "attendance_<?php echo $s['abr']; ?>" type= "int" class= "form-control">
	<option <?php if(isset($dsr['dsr'][0]['staff'][$i]['attendance_status'])){ if($dsr['dsr'][0]['staff'][$i]['attendance_status'] == ''){ echo 'selected'; } ;} ?> value="">--Attendance--</option>
	<option <?php if(isset($dsr['dsr'][0]['staff'][$i]['attendance_status'])){ if($dsr['dsr'][0]['staff'][$i]['attendance_status'] == 3){ echo 'selected';} } ; ?> value="3">Present</option>
	<option <?php if(isset($dsr['dsr'][0]['staff'][$i]['attendance_status'])){ if($dsr['dsr'][0]['staff'][$i]['attendance_status'] == 2){ echo 'selected';} } ; ?> value="2">Absent</option>
	<option <?php if(isset($dsr['dsr'][0]['staff'][$i]['attendance_status'])){ if($dsr['dsr'][0]['staff'][$i]['attendance_status'] == 1){ echo 'selected';} } ; ?> value="1">Leave</option>
</select>
	
