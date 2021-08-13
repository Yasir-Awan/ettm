<tr>
	<td class="text-right" width=""><?php if(isset($lane['name'])){ echo $lane['name']; }?></td>
	<?php if(isset($lane['status'])){ ?>
	<?php if($lane['status'] == 0){ ?>
	<td class="text-right bg-success">Open</td>
	<td></td><td></td><td></td><td></td>
	<?php }if($lane['status'] == 1){ ?>
	<td class="text-right bg-danger">Closed</td>
	<td class="text-right"><?php if(isset($lane['closed_by'])){ if($lane['closed_by'] == 1){ echo 'By OMC'; } else{ echo 'Due to Technical Issue';} }; ?></td>
	<td class="text-right"><?php echo $lane['closed_from'];?></td>
	<td class="text-right"><?php echo $lane['closed_to'];?></td>
	<td width="30%" class="text-right"><?php echo $lane['description'];?></td>
	<?php } } ?>
</tr>