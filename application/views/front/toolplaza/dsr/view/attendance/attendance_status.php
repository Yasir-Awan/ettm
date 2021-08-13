<td class="<?php if(isset($attendee['attendance_status'])){ if($attendee['attendance_status'] == 3){ echo 'bg-success';} if($attendee['attendance_status'] == 2){ echo 'bg-danger';} if($attendee['attendance_status'] == 1){ echo 'bg-info';} } ?>">
	<?php 
	if(isset($attendee['attendance_status'])){ 
		if($attendee['attendance_status'] == 3){ echo 'Present'; }
		if($attendee['attendance_status'] == 2){ echo 'Absent'; }
		if($attendee['attendance_status'] == 1){ echo 'Leave'; }
	} 
	?>
</td>