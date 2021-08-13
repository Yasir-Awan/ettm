<?php 
$d_number = 0; 
foreach($dsr[0]['staff'] as $attendee){ 
	echo '<tr>';
	include('name.php');
	include('attendance_status.php');
	
	if(isset($attendee['attendance_status'])){ 	
		if(isset($attendee['leave_from']) && isset($attendee['leave_to'])){
			include('time_from.php');
			include('time_to.php');
		}
		else{
			?> <td colspan="2" class="text-success text-center"><strong>Did not take leave</strong></td> <?php 
		}
	}
	echo '</tr>';
	$d_number++; 
} 
?>