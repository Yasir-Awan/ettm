<tr>
	<td class="text-right" style=""><strong><?php if(isset($lane['name'])){ echo $lane['name']; }?></strong></td>
	<?php if(isset($lane['status'])){ ?>
	<?php if($lane['status'] == 0){ ?>
	<td class="text-right bg-success">Open</td>
	<td colspan="4" class="text-success text-center"><strong>Lane was not closed</strong></td>
	<?php }if($lane['status'] == 1){ ?>
	<td class="text-right bg-danger">Closed</td>
	<td class="text-right"><?php if(isset($lane['closed_by'])){ if($lane['closed_by'] == 1){ echo 'By OMC'; } else{ echo 'Due to Technical Issue';} }; ?></td>
	<?php if(strpos($lane['closed_from'], ':') == FALSE){ ?> 
		<td class="text-right"><?php if(isset($lane['closed_from'])) {echo $lane['closed_from']; }?></td>
		<td class="text-right"><?php if(isset($lane['closed_to'])) {echo $lane['closed_to']; }?></td>
	<?php }	if(strpos($lane['closed_from'], ':') == TRUE){ ?>
		<td colspan="2" class="text-right"><?php if(isset($lane['duration'])) {echo $lane['duration']; }?></td>
	<?php } ?>
	<td style="width:30%" class="text-right"><?php echo $lane['description'];?></td>
	<?php } } ?>
</tr>